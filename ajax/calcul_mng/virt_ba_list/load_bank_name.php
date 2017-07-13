<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/virt_ba_mng/VirtBaListDAO.php");
$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$virtDAO = new VirtBaListDAO();

//판매채널
$sell_site = $fb->form("sell_site");
$param = array();
$param["cpn_admin_seqno"] = $sell_site;

$result = $virtDAO->selectBankNameList($conn, $param);

$param = array();
$param["flag"] = "N";
$param["val"] = "bank_name";
$param["dvs"] = "bank_name";

$buff = makeSelectOptionHtml($result, $param);

echo $buff;
$conn->close();
?>
