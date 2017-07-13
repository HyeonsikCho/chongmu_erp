<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CommonDAO();

$search_cnd = $fb->form("search_cnd");
$search_txt = $fb->form("search_txt");

$param = array();
$param["search_cnd"] = $search_cnd;
$param["search_txt"] = $search_txt;

if ($search_cnd == "title" || $search_cnd == "order_num") {
    $rs = $dao->selectMemberId($conn, $param);
} else {
    $rs = $dao->selectMemberId($conn, $param);
}

$arr = array();
$arr["col"]  = $search_cnd;
$arr["val"]  = $search_cnd;
$arr["type"] = "cnd";

echo makeSearchList($rs, $arr);
$conn->Close();
?>
