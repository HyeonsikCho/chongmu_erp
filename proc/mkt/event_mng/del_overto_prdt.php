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
$param["table"] = "overto_detail_file";
$param["prk"] = "overto_event_detail_seqno";
$param["prkVal"] = $fb->form("overto_detail_seqno");
$result = $eventDAO->deleteData($conn, $param);
if (!$result) $check = 2;

$param = array();
$param["table"] = "overto_event_detail";
$param["prk"] = "overto_event_detail_seqno";
$param["prkVal"] = $fb->form("overto_detail_seqno");
$result = $eventDAO->deleteData($conn, $param);
if (!$result) $check = 2;

echo $check;

$conn->CompleteTrans();
$conn->close();

?>
