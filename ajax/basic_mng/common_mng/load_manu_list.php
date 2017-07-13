<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$basicDAO = new BasicMngCommonDAO();

//제조사 검색어
$search_str = $fb->form("search_str");
//제조사 판매품목
$pur_prdt = $fb->form("pur_prdt");

$param = Array();
$param["pur_prdt"] = $pur_prdt;
$param["search"] = $search_str;
$result = $basicDAO->selectPrdcManu($conn, $param);

$arr = [];
$arr["col"] = "manu_name";
$arr["val"] = "extnl_etprs_seqno";
$arr["type"] = "manu";

$buff = makeSearchList($result, $arr);

echo $buff;
$conn->close();
?>
