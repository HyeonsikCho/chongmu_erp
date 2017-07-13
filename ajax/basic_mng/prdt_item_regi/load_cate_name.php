<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_mng/PrdtItemRegiDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$prdtItemRegiDAO = new PrdtItemRegiDAO();

$param = array();
$param["table"] = "cate";
$param["col"] = "cate_name";
$param["where"]["sortcode"] = $fb->form("cate_sortcode");

$rs = $prdtItemRegiDAO->selectData($conn, $param);

echo $rs->fields["cate_name"];
$conn->close();
?>
