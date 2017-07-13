<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/PrdtPriceListDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/doc/basic_mng/prdt_price_mng/PrdtPriceListPrintCond.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new PrdtPriceListDAO();
$util = new ErpCommonUtil();

$cate_sortcode = $fb->form("cate_sortcode");

$param = array();
$param["cate_sortcode"] = $cate_sortcode;

$ret  = "{";
$ret .= " \"paper\" : \"%s\"";
$ret .= "}";

$paper = $dao->selectCatePaperHtml($conn, "NAME", $param);
$paper = $util->convJsonStr($paper);

echo sprintf($ret, $paper);
$conn->Close();
?>
