<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/EventMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();
$eventDAO = new EventMngDAO();
$prdt_list = "";

if ($fb->form("overto_seqno")) {
    
    //골라담기 상품 리스트 그리기
    $param = array();
    $param["overto_seqno"] = $fb->form("overto_seqno");
    $result = $eventDAO->selectOvertoDetailList($conn, $param);
    $prdt_list = makeOvertoDetailList($result);

    //골라담기 상품 그룹 정보
    $param = array();
    $param["table"] = "overto_event";
    $param["col"] = "name, use_yn, tot_order_price, 
                     sale_rate, cpn_admin_seqno";
    $param["where"]["overto_event_seqno"] = $fb->form("overto_seqno");
    $result = $eventDAO->selectData($conn, $param);

    $param = array();
    //이벤트 이름
    $param["event_name"] = $result->fields["name"];
    $use_yn = $result->fields["use_yn"];

    //사용 여부
    if ($use_yn == "Y") {

        $param["use_y"] = "checked=\"checked\"";
        $param["use_n"] = "";

    } else {

        $param["use_n"] = "checked=\"checked\"";
        $param["use_y"] = "";

    }

    //전체 사용 금액
    $param["tot_order_price"] = $result->fields["tot_order_price"];
    //할인 요율
    $param["sale_rate"] = $result->fields["sale_rate"];
    $sell_site = $result->fields["cpn_admin_seqno"];

} else {

    $param = array();
    $param["dis_btn"] = "disabled=\"disabled\"";
    $param["use_n"] = "checked=\"checked\"";
    $sell_site = "";

}

if (!$prdt_list) {

    $prdt_list = "<tr><td colspan='6'>검색된 내용이 없습니다.</td></tr>";

}

$param["prdt_list"] = $prdt_list;

//판매채널 콤보박스 셋팅
$param["sell_site"] = $eventDAO->selectSellSite($conn);
//카테고리 대분류 콤보박스 셋팅
$result = $eventDAO->selectFlatCateList($conn);
$arr = [];
$arr["flag"] = "Y";
$arr["def"] = "대분류";
$arr["dvs"] = "cate_name";
$arr["val"] = "sortcode";
$param["cate_top"] = makeSelectOptionHtml($result, $arr);

$html = getOvertoView($param);

echo $html . "♪♥♭" . $sell_site;

$conn->close();
?>
