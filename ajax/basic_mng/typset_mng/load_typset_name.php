<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/TypsetMngDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/pageLib.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$typsetDAO = new TypsetMngDAO();

//검색어
$search = $fb->form("search_str");

$param = array();
$param["search"] = $search;

$result = $typsetDAO->selectTypsetName($conn, $param);

$arr = [];
$arr["col"] = "name";
$arr["val"] = "name";
$arr["type"] = "name";

$buff = makeSearchList($result, $arr);

echo $buff;
$conn->close();
?>
