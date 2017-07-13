<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();

$param = array();
$param["table"] = $fb->form("area") . "_zipcode";
$param["col"] = "DISTINCT gugun";

$result = $dlvrDAO->selectData($conn, $param);

$arr = array();
$arr["flag"] = "Y";
$arr["def"] = "-구/군-";
$arr["def_val"] = "";
$arr["val"] = "gugun";
$arr["dvs"] = "gugun";

$html = makeNullExceptOptionHtml($result, $arr);

echo $html;

$conn->close();
?>
