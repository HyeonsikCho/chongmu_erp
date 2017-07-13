<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/BasicMngCommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new BasicMngCommonDAO();
$commonDAO = $dao;

$dvs = $fb->form("dvs");

$param = array();
$param["cate_sortcode"] = $fb->form("cate_sortcode");
$param["name"] = $fb->form("print_name");

//인쇄명
if ($dvs === "NAME") {

    if ($fb->form("cate_sortcode") == "") {
        echo "<option value=\"\">인쇄명(전체)</option>"
        . "♪" . "<option value=\"\">용도구분(전체)</option>";

    } else {
        $rs = $dao->selectPrintInfo($conn, "NAME", $param);
        $name_html = makeOptionHtml($rs, "print_name", "print_name", "인쇄명(전체)");

        $rs = $dao->selectPrintInfo($conn, "PURP", $param);
        $purp_html = makeOptionHtml($rs, "purp_dvs", "purp_dvs", "용도구분(전체)");

        echo $name_html . "♪" . $purp_html;
    }

//인쇄용도
} else if ($dvs === "PURP") {
  
    $rs = $dao->selectPrintInfo($conn, "PURP", $param);
    $purp_html = makeOptionHtml($rs, "purp_dvs", "purp_dvs", "용도구분(전체)");

    echo $purp_html;
}

$conn->Close();
?>
