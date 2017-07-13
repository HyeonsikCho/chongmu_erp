<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/calcul_mng/cashbook/CashbookRegiDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cashbookDAO = new CashbookRegiDAO();

//검색어
$search = $fb->form("search_str");
//클릭시 실행되는 함수명
$func = $fb->form("func");

$param = array();
$param["table"] = "extnl_etprs";
$param["col"] = "manu_name, extnl_etprs_seqno";
$param["like"]["manu_name"] = $search;

$result = $cashbookDAO->selectData($conn, $param);

$buff = makeSearchEtprsList($result, $func);

echo $buff;
$conn->close();
?>
