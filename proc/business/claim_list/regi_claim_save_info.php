<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/claim_mng/ClaimListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new ClaimListDAO();
$check = 1;

$conn->StartTrans();
$claim_order_seqno = $fb->form("seqno");

//로그인 개발후 수정 필요
$param = array();
$param["table"] = "order_claim"; 
$param["col"]["empl_seqno"] = $fb->session("empl_seqno");
$param["col"]["dvs"] = $fb->form("dvs");
$param["col"]["dvs_detail"] = $fb->form("dvs_detail");
$param["col"]["mng_cont"] = $fb->form("mng_cont");
$param["prk"] = "order_claim_seqno";
$param["prkVal"] = $claim_order_seqno;

$rs = $dao->updateData($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
