<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CommonDAO();

$sell_site   = $fb->form("sell_site");
$office_nick = $fb->form("search_val");

$param = array();
$param["sell_site"]   = 1;
$param["office_nick"] = $office_nick;

$rs = $dao->selectOfficeName($conn, $param);










$arr = array();
$arr["col"]  = "full_name";
$arr["val"]  = "office_nick";
$arr["type"] = "name";

echo makeSearchList($rs, $arr);
$conn->Close();
?>
