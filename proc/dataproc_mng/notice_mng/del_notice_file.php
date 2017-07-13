<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$bulletinDAO = new BulletinMngDAO();
//공지사항 파일 삭제
$param = array();
$param["table"] = "notice_file";
$param["prk"] = "notice_file_seqno";
$param["prkVal"] = $fb->form("file_seq");

$result = $bulletinDAO->deleteData($conn, $param);

if ($result) {

    echo "1";

} else {

    echo "2";
}
$conn->CompleteTrans();
$conn->close();
?>
