<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/produce/receipt_mng/ReceiptListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new ReceiptListDAO();
$check = 1;

$seqno = $fb->form("seqno");
$seq = intval($fb->form("seq"));

$conn->StartTrans();

//순서 변경으로 인하여 바껴야 되는 컬럼 일련번호 구함
$param = array();
$param["table"] = "order_after_history";
$param["col"] = "order_after_history_seqno";
$param["where"]["order_common_seqno"] = $seqno;
$param["where"]["seq"] = $seq + 1;

$sel_rs = $dao->selectData($conn, $param);

$before_seqno = $sel_rs->fields["order_after_history_seqno"];

//순서변경 할 일련번호 구함
$param = array();
$param["table"] = "order_after_history";
$param["col"] = "order_after_history_seqno";
$param["where"]["order_common_seqno"] = $seqno;
$param["where"]["seq"] = $seq;

$sel_rs = $dao->selectData($conn, $param);

$after_seqno = $sel_rs->fields["order_after_history_seqno"];

//이전 seq(순서) 바꿈
$param = array();
$param["table"] = "order_after_history";
$param["col"]["seq"] = $seq;
$param["prk"] = "order_after_history_seqno";
$param["prkVal"] = $before_seqno;

$rs = $dao->updateData($conn, $param);

if (!$rs) {
    $check = 0;
}

//이벤트가 발생한 seq(순서) 바꿈
$param = array();
$param["table"] = "order_after_history";
$param["col"]["seq"] = $seq + 1;
$param["prk"] = "order_after_history_seqno";
$param["prkVal"] = $after_seqno;

$rs = $dao->updateData($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
