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
$check = 1;

$param = array();
$param["table"] = "oevent_file";
$param["prk"] = "oevent_event_seqno";
$param["prkVal"] = $fb->form("oevent_seqno");
$result = $eventDAO->deleteData($conn, $param);
if (!$result) {

    $check = 2;
}

$param = array();
$param["table"] = "oevent_event";
$param["prk"] = "oevent_event_seqno";
$param["prkVal"] = $fb->form("oevent_seqno");

$result = $eventDAO->deleteData($conn, $param);
if (!$result) {

    $check = 2;
}

echo $check;

$conn->CompleteTrans();
$conn->close();

?>
