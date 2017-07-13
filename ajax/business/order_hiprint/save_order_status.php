<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderCommonMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new OrderCommonMngDAO();

$seqno = $fb->form("seqno");
$prd_status = $fb->form("prd_status");
$order_prdlist_seq = $fb->form("order_prdlist_seq");

if($dao->updateOrderStatusHtml($conn, $prd_status, $order_prdlist_seq))
	echo 1;
else
	echo 0;
?>
