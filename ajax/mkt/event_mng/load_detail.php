<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/PrdtPriceListDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/doc/basic_mng/prdt_price_mng/PrdtPriceListPrintCond.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/mkt/mkt_mng/EventMngHTML.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new PrdtPriceListDAO();
$util = new ErpCommonUtil();

$cate_sortcode = $fb->form("cate_sortcode");

$param = array();
$param["cate_sortcode"] = $cate_sortcode;

$ret  = "{";
$ret .= " \"paper\" : \"%s\",";
$ret .= " \"size\"  : \"%s\",";
$ret .= " \"print\" : \"%s\"";
$ret .= "}";

$paper = $dao->selectCatePaperHtml($conn, "NAME", $param);
$paper = $util->convJsonStr($paper);

$size = $dao->selectCateSizeHtml($conn, $param);
$size = $util->convJsonStr($size);

$print = null;
$print = makePrintTmptHtmlSheet($conn, $dao, $param);

$print = $util->convJsonStr($print);

echo sprintf($ret, $paper, $size, $print);

$conn->Close();
?>
