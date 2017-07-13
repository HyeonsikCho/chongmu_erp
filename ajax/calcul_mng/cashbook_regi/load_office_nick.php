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
//판매채널
$sell_site = $fb->form("sell_site");
//클릭시 실행되는 함수명
$func = $fb->form("func");

$param = array();
$param["sell_site"] = $sell_site;
$param["search"] = $search;

$result = $cashbookDAO->selectOfficeNickList($conn, $param);

$buff = makeSearchNickList($result, $func);

echo $buff;
$conn->close();
?>
