<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();

$param = array();
$param["area"] = $fb->form("area");
$param["gugun"] = $fb->form("gugun");
$param["eup"] = $fb->form("eup");
$param["doro_yn"] = $fb->form("doro_yn");

//읍면에 해당하는 리
$result = $dlvrDAO->selectRi($conn, $param);

$arr = array();
$arr["flag"] = "Y";
$arr["def"] = "-리-";
$arr["def_val"] = "";
$arr["val"] = "ri";
$arr["dvs"] = "ri";

$html = makeSelectOptionHtml($result, $arr);

echo $html;

$conn->close();
?>
