<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/FileDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new FileDAO();
$check = 1;

$param = array();
$param["seqno"] = $fb->form("seqno");

$rs = $dao->deleteOrderImage($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->Close();
echo $check;
?>
