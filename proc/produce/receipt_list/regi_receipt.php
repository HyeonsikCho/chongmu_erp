<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/produce/receipt_mng/ReceiptListDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$fileDAO = new FileAttachDAO();
$dao = new ReceiptListDAO();
$check = 1;

$conn->StartTrans();

$param = array();
$param["seqno"] = $fb->form("seqno");
$param["receipt_mng"] = $fb->session["name"];
$param["order_state"] = "410";

$rs = $dao->updateReceipt($conn, $param);

if (!$rs) {
    $check = 0;
}

/* 업로드 오면 개발
//주문상세 일련번호 조회
$param = array();
$param["table"] = "order_detail";
$param["col"] = "order_detail_seqno";
$param["where"]["order_common_seqno"] = $order_common_seqno;

$sel_rs = $dao->selectData($conn, $param);

$order_detail_seqno = $sel_rs->fields["order_detail_seqno"];

//파일 업로드 경로
$param = array();
$param["file_path"] = SITE_DEFAULT_ORDER_DETAIL_PRINT_FILE; 
$param["tmp_name"] = $_FILES["upload_file"]["tmp_name"];
$param["origin_file_name"] = $_FILES["upload_file"]["name"];

//파일을 업로드 한 후 저장된 경로를 리턴한다.
$rs = $fileDAO->upLoadFile($param);

$param = array();
$param["table"] = "order_detail_print_file";
$param["col"]["order_detail_seqno"] = $order_detail_seqno;
$param["col"]["origin_file_name"] = $_FILES["upload_file"]["name"];
$param["col"]["save_file_name"] = $rs["save_file_name"];
$param["col"]["file_path"] = $rs["file_path"];
$param["col"]["size"] = $_FILES["upload_file"]["size"];

$rs = $dao->insertData($conn, $param);

if (!$rs) {
    $check = 0;
}
*/

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
