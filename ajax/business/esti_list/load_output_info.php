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
$param["name"] = $fb->form("output_name");
$param["board_dvs"] = $fb->form("output_board");

//출력판
if ($dvs === "BOARD") {

    if ($fb->form("output_name") == "") {
        echo "<option value=\"\">출력판(전체)</option>"
        . "♪" . "<option value=\"\">사이즈(전체)</option>";

    } else {
        $rs = $dao->selectOutputInfo($conn, "BOARD", $param);
        $board_html = makeOptionHtml($rs, "output_board_dvs", "output_board_dvs", "출력판(전체)");

        $rs = $dao->selectOutputInfo($conn, "SIZE", $param);
        $size_html = makeOptionHtml($rs, "size", "size", "사이즈(전체)");

        echo $board_html . "♪" . $size_html;
    }

//사이즈
} else if ($dvs === "SIZE") {
 
    $rs = $dao->selectOutputInfo($conn, "SIZE", $param);
    $size_html = makeOptionHtml($rs, "size", "size", "사이즈(전체)");

    echo $size_html;
}

$conn->Close();
?>
