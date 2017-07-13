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
$param["table"] = "nowadays_busy_file";
$param["prk"] = "nowadays_busy_event_seqno";
$param["prkVal"] = $fb->form("nowadays_seqno");
$result = $eventDAO->deleteData($conn, $param);
if (!$result) {

    $check = 2;
}

$param = array();
$param["table"] = "nowadays_busy_event";
$param["prk"] = "nowadays_busy_event_seqno";
$param["prkVal"] = $fb->form("nowadays_seqno");

$result = $eventDAO->deleteData($conn, $param);
if (!$result) {

    $check = 2;
}

echo $check;

$conn->CompleteTrans();
$conn->close();

?>
