<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/AfterPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new AfterPriceListDAO();

$cate_sortcode = $fb->form("cate_sortcode");
$depth    = $fb->form("depth");
$after_name = $fb->form("after_name");
$dep1_val   = $fb->form("dep1_val");
$dep2_val   = $fb->form("dep2_val");

$param = array();
$param["cate_sortcode"] = $cate_sortcode;
$param["after_name"] = $after_name;
$param["depth1"]     = $dep1_val;
$param["depth2"]     = $dep2_val;

$dvs = "AFTER_NAME";
if ($depth === '0') {
    $dvs = "DEPTH1";
} else if ($depth === '1') {
    $dvs = "DEPTH2";
}

echo $dao->selectCateAftHtml($conn, $dvs, $param);
?>
