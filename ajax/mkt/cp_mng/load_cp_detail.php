<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cpDAO = new CpMngDAO();

//등록 or 수정
$type = $fb->form("type");

//카테고리 중분류 쿼리 실행
$param = array();
$param["table"] = "cate";
$param["col"] = "cate_name, sortcode";
$param["where"]["cate_level"] = "2";

$result = $cpDAO->selectData($conn, $param);
//카테고리 중분류 라디오박스 셋팅
$cate_mid = makeCateMidList($result);

$amt_dspl = "style=\"display:none\"";

//수정모드 일때
if ($type == "edit") {

    //쿠폰 일련번호
    $cp_seqno = $fb->form("cp_seqno");

    //파일 셋팅
    $param = array();
    $param["table"] = "cp_file";
    $param["col"] = "origin_file_name, file_path, cp_file_seqno";
    $param["where"]["cp_seqno"] = $cp_seqno;

    $f_result = $cpDAO->selectData($conn, $param);
    $param["file_name"] = $f_result->fields["origin_file_name"];
    $param["file_seqno"] = $f_result->fields["cp_file_seqno"];

    if ($param["file_name"]) {

        $file_html = getFileHtml($param);

    }

    $param = array();
    $param["cp_seqno"] = $cp_seqno;

    //쿠폰 정보 가져오기
    $result = $cpDAO->selectCpList($conn, $param);

    $param = array();
    $param["cp_seqno"] = $cp_seqno;
    $param["file_html"] = $file_html;
    $param["cp_name"] = $result->fields["cp_name"];

    $object_yn = $result->fields["object_appoint_yn"];
    //사용중일때
    if ($object_yn == "Y") {

        $param["object_y"] = "checked";
        $param["object_n"] = "";


    //미사용일때
    } else {

        $param["object_n"] = "checked";
        $param["object_y"] = "";

        $param["public_amt"] = $result->fields["public_amt"];
        $amt_dspl = "";

    }

    $unit = $result->fields["unit"];
    //할인 요율 일때
    if ($unit == "%") {

        $per_check="checked";
        $won_check="";

        $param["per_val"] = $result->fields["val"];
        $param["max_sale_price"] = $result->fields["max_sale_price"];

        //할인 금액 일때
    } else {

        $won_check="checked";
        $per_check="";

        $param["won_val"] = $result->fields["val"];
        $param["min_order_price"] = $result->fields["min_order_price"];

    }
    $param["won_check"] = $won_check;
    $param["per_check"] = $per_check;

    $limit_yn = $result->fields["period_limit_yn"];
    //기간제 일때
    if ($limit_yn == "Y") {

        $param["limit_y"] = "checked";
        $param["public_start_date"] = $result->fields["public_start_date"];
        $param["public_end_date"] = $result->fields["public_end_date"];

        //발행제 일때
    } else {

        $param["limit_n"] = "checked";
        $param["public_deadline_day"] = $result->fields["public_deadline_day"];
        $param["public_extinct_date"] = $result->fields["public_extinct_date"];

    }

    $hour_yn = $result->fields["hour_limit_yn"];
    //시간제한이 있을때
    if ($hour_yn == "Y") {

        $param["hour_y"] = "checked";
        $param["hour_n"] = "";

        $use_start_hour = $result->fields["use_start_hour"];
        $start_info = explode(":", $use_start_hour);
        $start_hour = $start_info[0];
        $start_min = $start_info[1];

        $use_end_hour = $result->fields["use_end_hour"];
        $end_info = explode(":", $use_end_hour);
        $end_hour = $end_info[0];
        $end_min = $end_info[1];

    } else {

        $param["hour_n"] = "checked";
        $param["hour_y"] = "";

        //기본값 셋팅
        $start_hour = "00";
        $start_min = "00";
        $end_hour = "00";
        $end_min = "00";
    }
    $use_yn = $result->fields["use_yn"];

    //사용중일때
    if ($use_yn == "Y") {

        $param["use_y"] = "checked";
        $param["use_n"] = "";

        //미사용일때
    } else {

        $param["use_n"] = "checked";
        $param["use_y"] = "";

    }
}

$param["amt_dspl"] = $amt_dspl;
//수량 html
$param["amt_html"] = getAmtHtml($param);
//카테고리 중분류
$param["cate_mid"] = $cate_mid;
$param["sell_site"] = $cpDAO->selectSellSite($conn);
//시간 콤보박스 셋팅
$param["hour_list"] = makeOptionTimeHtml(0,23);
//분 콤보박스 셋팅
$param["min_list"] = makeOptionTimeHtml(0,59);

$html = getCpView($param);

$select_box_val = $result->fields["cpn_admin_seqno"] . "♪♡♭" . 
                  $result->fields["sortcode"] . "♪♡♭" . 
                  $start_hour . "♪♡♭" . $start_min . "♪♡♭" . 
                  $end_hour . "♪♡♭" . $end_min;

echo $html . "♪♥♭" . $select_box_val;

$conn->close();
?>
