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

$order_common_seqno = $fb->form("order_common_seqno");

$conn->StartTrans();

$param = array();
$param["table"] = "order_detail";
$param["col"] = "order_detail_seqno";
$param["where"]["order_common_seqno"] = $order_common_seqno;

$sel_rs = $dao->selectData($conn, $param);

$order_detail_seqno = $sel_rs->fields["order_detail_seqno"];

$param = array();
$param["table"] = "after_op";
$param["col"]["op_name"] = $fb->form("title");
$param["col"]["seq"] = $fb->form("seq");
$param["col"]["after_name"] = $fb->form("after_name");
$param["col"]["amt"] = $fb->form("amt");
$param["col"]["amt_unit"] = $fb->form("amt_unit_dvs");
$param["col"]["memo"] = $fb->form("memo");
$param["col"]["op_typ"] = $fb->form("op_typ");
$param["col"]["op_typ_detail"] = $fb->form("op_typ_detail");
$param["col"]["basic_yn"] = "N";
$param["col"]["order_detail_seqno"] = $order_detail_seqno;
$param["col"]["order_common_seqno"] = $order_common_seqno;
$param["col"]["order_after_history_seqno"] = $fb->form("after_seqno");
$param["col"]["extnl_etprs_seqno"] = $fb->form("extnl_etprs_seqno");

/*
$param["prk"] = "after_op";
$param["prkVal"] = $after_seqno;
*/

$rs = $dao->insertData($conn, $param);

if (!$rs) {
    $check = 0;
}

$after_op_seqno = $conn->Insert_ID();

//파일 업로드 경로
$param = array();
$param["file_path"] = SITE_DEFAULT_AFTER_OP_WORK_FILE; 
$param["tmp_name"] = $_FILES["upload_file"]["tmp_name"];
$param["origin_file_name"] = $_FILES["upload_file"]["name"];

//파일을 업로드 한 후 저장된 경로를 리턴한다.
$rs = $fileDAO->upLoadFile($param);

$param = array();
$param["table"] = "after_op_work_file";
$param["col"]["after_op_seqno"] = $after_op_seqno;
$param["col"]["origin_file_name"] = $_FILES["upload_file"]["name"];
$param["col"]["save_file_name"] = $rs["save_file_name"];
$param["col"]["file_path"] = $rs["file_path"];
$param["col"]["size"] = $_FILES["upload_file"]["size"];

$rs = $dao->insertData($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
