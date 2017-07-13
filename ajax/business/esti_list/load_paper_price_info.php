<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/BasicMngCommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new BasicMngCommonDAO();
$commonDAO = $dao;

$param = array();
$param["table"] = "prdt_paper";
$param["col"] = "mpcode";
$param["where"]["name"] = $fb->form("paper_name");
$param["where"]["dvs"] = $fb->form("paper_dvs");
$param["where"]["color"] = $fb->form("paper_color");
$param["where"]["basisweight"] = substr($fb->form("paper_basisweight") , 0, -1);
$param["where"]["crtr_unit"] = $fb->form("paper_unit");

$rs = $dao->selectData($conn, $param);

$mpcode = $rs->fields["mpcode"];

$param = array();
$param["table"] = "prdt_paper_price";
$param["col"] = "sell_price";
$param["where"]["prdt_paper_mpcode"] = $mpcode;

$rs = $dao->selectData($conn, $param);

echo $rs->fields["sell_price"];
$conn->Close();
?>
