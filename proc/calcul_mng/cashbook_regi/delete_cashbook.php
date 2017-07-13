<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/cashbook/CashbookRegiDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();

$cashbookDAO = new CashbookRegiDAO();
$conn->StartTrans();

//금전출납부 삭제
$param = array();
$param["table"] = "cashbook";
$param["prk"] = "cashbook_seqno";
$param["prkVal"] = $fb->form("cashbook_seqno"); 
$result = $cashbookDAO->deleteData($conn, $param);

echo $result;

$conn->CompleteTrans();
$conn->close();
?>
