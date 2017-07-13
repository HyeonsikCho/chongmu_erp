<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CommonDAO();

$sell_site   = $fb->form("sell_site");
$member_id = $fb->form("search_val");

$param = array();
$param["sell_site"]   = $sell_site;
$param["member_id"]   = $member_id;

$rs = $dao->selectMemberId($conn, $param);

$arr = array();
$arr["col"]  = "member_id";
$arr["val"]  = "member_id";
$arr["type"] = "id";

echo makeSearchList($rs, $arr);
$conn->Close();
?>
