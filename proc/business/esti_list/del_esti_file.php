<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/esti_mng/EstiListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new EstiListDAO();
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
