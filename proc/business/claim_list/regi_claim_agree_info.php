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

$param = array();
$param["table"] = "order_claim"; 
$param["col"]["occur_price"] = str_replace(",", "", $fb->form("occur_price"));
$param["col"]["refund_prepay"] = str_replace(",", "", $fb->form("refund_prepay"));
$param["col"]["refund_money"] = str_replace(",", "", $fb->form("refund_money"));
$param["col"]["cust_burden_price"] = str_replace(",", "", $fb->form("cust_burden_price"));
$param["col"]["extnl_etprs_seqno"] = $fb->form("extnl_etprs");
$param["col"]["outsource_burden_price"] = str_replace(",", "", $fb->form("outsource_burden_price"));
$param["col"]["agree_yn"] = "Y";
$param["prk"] = "order_claim_seqno";
$param["prkVal"] = $claim_order_seqno;

$rs = $dao->updateData($conn, $param);

if (!$rs) {
    $check = 0;
}

//정산관리 개발 후 추가 개발 필요

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
