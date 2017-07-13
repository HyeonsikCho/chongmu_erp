<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/CalculPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CalculPriceListDAO();

$dvs = $fb->form("dvs");
$cate_sortcode = $fb->form("cate_sortcode");
$print_name = $fb->form("print_name");

$param = array();
$param["cate_sortcode"] = $cate_sortcode;
$param["name"] = $print_name;

echo $dao->selectPrdtPrintInfoHtml($conn, $dvs, $param);
?>
