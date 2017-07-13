<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$bulletinDAO = new BulletinMngDAO();
$check = 1;

//공지사항 파일 삭제
$param = array();
$param["table"] = "notice_file";
$param["prk"] = "notice_seqno";
$param["prkVal"] = $fb->form("notice_seq");

$result = $bulletinDAO->deleteData($conn, $param);
if (!$result) $check = 0;

//공지사항 삭제
$param = array();
$param["table"] = "board_notice";
$param["prk"] = "seq_no";
$param["prkVal"] = $fb->form("notice_seq");

$result = $bulletinDAO->deleteData($conn, $param);
if (!$result) $check = 0;

echo $check;

$conn->CompleteTrans();
$conn->close();
?>
