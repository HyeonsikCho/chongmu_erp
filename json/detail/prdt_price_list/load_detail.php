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
$mono_yn = $fb->form("mono_yn");

$param = array();
$param["cate_sortcode"] = $cate_sortcode;
$param["mono_yn"] = $mono_yn;

//$conn->debug = 1;

// 카테고리의 낱장형 여부, 계산형 여부 검색
$rs = $dao->selectCateFlatMonoInfo($conn, $param);
$flattyp_yn = $rs->fields["flattyp_yn"];
$mono_dvs = $rs->fields["mono_dvs"];

$ret  = "{";
$ret .= " \"paper\" : \"%s\",";
$ret .= " \"size\"  : \"%s\",";
$ret .= " \"print\" : \"%s\",";
$ret .= " \"mono_dvs\"   : \"%s\",";
$ret .= " \"flattyp_yn\" : \"%s\"";
$ret .= "}";

$paper = $dao->selectCatePaperHtml($conn, "NAME", $param);
$paper = $util->convJsonStr($paper);

$size = $dao->selectCateSizeHtml($conn, $param);
$size = $util->convJsonStr($size);

$print = null;
if ($flattyp_yn === "N") {
    $print = makePrintCondHtmlBooklet($conn, $dao, $param);
} else {
    $print = makePrintCondHtmlSheet($conn, $dao, $param);
}
$print = $util->convJsonStr($print);

echo sprintf($ret, $paper, $size, $print, $mono_dvs, $flattyp_yn);

$conn->Close();
?>
