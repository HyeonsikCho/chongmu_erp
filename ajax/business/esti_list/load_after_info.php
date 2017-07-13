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
$param["name"] = $fb->form("after_name");
$param["depth1"] = $fb->form("after_depth1");
$param["depth2"] = $fb->form("after_depth2");

//DEPTH1
if ($dvs === "DEPTH1") {
    $rs = $dao->selectCateAftInfo($conn, "DEPTH1", $param);
    $depth1_html = makeOptionHtml($rs, "depth1", "depth1", "Depth1(전체)");

    echo $depth1_html;

//DEPTH2
} else if ($dvs === "DEPTH2") {
    $rs = $dao->selectCateAftInfo($conn, "DEPTH2", $param);
    $depth2_html = makeOptionHtml($rs, "depth2", "depth2", "Depth2(전체)");

    echo $depth2_html;

//DEPTH3
} else if ($dvs === "DEPTH3") {
    $rs = $dao->selectCateAftInfo($conn, "DEPTH3", $param);
    $depth3_html = makeOptionHtml($rs, "depth3", "depth3", "Depth3(전체)");

    echo $depth3_html;
}

$conn->Close();
?>
