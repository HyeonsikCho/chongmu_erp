<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/produce/receipt_mng/ReceiptListDOC.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/produce/receipt_mng/ReceiptListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new ReceiptListDAO();

//주문통합리스트 일련번호
$seqno = $fb->form("seqno");

//주문 후공정 내역 일련번호
$after_seqno = $fb->form("after_seqno");

//주문
$param = array();
$param["order_common_seqno"] = $seqno;

$order_rs = $dao->selectReceiptView($conn, $param);

//후공정 
$param = array();
$param["table"] = "order_after_history";
$param["col"] = "after_name, depth1, depth2, depth3, seq";
$param["where"]["order_after_history_seqno"] = $after_seqno;

$after_rs = $dao->selectData($conn, $param);

$after_name = "";
if ($after_rs->fields["after_name"]) {
    $after_name .= $after_rs->fields["after_name"];
}
if ($after_rs->fields["depth1"]) {
    $after_name .= "-". $after_rs->fields["depth1"];
}
if ($after_rs->fields["depth2"]) {
    $after_name .= "-". $after_rs->fields["depth2"];
}
if ($after_rs->fields["depth3"]) {
    $after_name .= "-". $after_rs->fields["depth3"];
}

$title = $order_rs->fields["title"] . " ";
if ($after_rs->fields["after_name"]) {
    $title .= $after_rs->fields["after_name"];
}
if ($after_rs->fields["depth1"]) {
    $title .= " ". $after_rs->fields["depth1"];
}
if ($after_rs->fields["depth2"]) {
    $title .= " ". $after_rs->fields["depth2"];
}
if ($after_rs->fields["depth3"]) {
    $title .= " ". $after_rs->fields["depth3"];
}

$param = array();
$param["table"] = "extnl_etprs";
$param["col"] = "manu_name, extnl_etprs_seqno";
$param["where"]["pur_prdt"] = "후공정";
$param["order"] = "manu_name";

$etprs_rs = $dao->selectData($conn, $param);
$etprs_html = makeOptionHtml($etprs_rs, "extnl_etprs_seqno", "manu_name", "", "N");

$param = array();
$param["title"] = $title;
$param["amt"] = $order_rs->fields["amt"];
$param["amt_unit_dvs"] = $order_rs->fields["amt_unit_dvs"];
$param["seq"] = $after_rs->fields["seq"];
$param["after_name"] = $after_name;
$param["order_common_seqno"] = $seqno;
$param["after_seqno"] = $after_seqno;
$param["etprs_html"] = $etprs_html;

echo receiptAfterPopup($param);
$conn->close();
?>
