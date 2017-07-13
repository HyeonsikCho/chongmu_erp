<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/EventMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$eventDAO = new EventMngDAO();

$param = array();
$param["table"] = "overto_event";
//골라담기 이벤트명
$param["col"]["name"] = $fb->form("event_name");
//사용 여부
$param["col"]["use_yn"] = $fb->form("use_yn");
//전체 주문 금액
$param["col"]["tot_order_price"] = $fb->form("order_price");
//할인 요율
$param["col"]["sale_rate"] = $fb->form("sale_rate");
//판매채널 일련번호
$param["col"]["cpn_admin_seqno"] = $fb->form("sell_site");

//골라담기 이벤트 그룹 수정
if ($fb->form("overto_seqno")) {

    //골라담기 이벤트 그룹 일련번호
    $overto_seqno = $fb->form("overto_seqno");
    $param["prk"] = "overto_event_seqno";
    $param["prkVal"] = $overto_seqno;
    
    $result = $eventDAO->updateData($conn, $param);

//골라담기 이벤트 그룹 추가
} else {

    $result = $eventDAO->insertData($conn, $param);
    //골라담기 이벤트 그룹 일련번호
    $overto_seqno = $conn->insert_ID();

}

if ($result) {

    echo "1" . "♪♥♭" . $overto_seqno;

} else {

    echo "2" . "♪♥♭" . "";

}
$conn->CompleteTrans();
$conn->close();
?>
