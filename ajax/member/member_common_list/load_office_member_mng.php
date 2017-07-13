<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/Template.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/MemberCommonListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$template = new Template();
$memberCommonListDAO = new MemberCommonListDAO();

$param = array();
$param["table"] = "empl";
$param["col"] = "empl_seqno, name";
$param["where"]["depar_code"] = $fb->form("depar_code");
$param["where"]["cpn_admin_seqno"] = $fb->form("sell_site");

$rs = $memberCommonListDAO->selectData($conn, $param);

$arr = [];
$arr["flag"] = "N";
$arr["def"] = "";
$arr["dvs"] = "name";
$arr["val"] = "empl_seqno";

echo makeSelectOptionHtml($rs, $arr);
$conn->close();
?>
