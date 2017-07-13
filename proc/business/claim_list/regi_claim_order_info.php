<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/claim_mng/ClaimListDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new ClaimListDAO();
$fileDAO = new FileAttachDAO();
$check = 1;

$conn->StartTrans();
$claim_order_seqno = $fb->form("seqno");

//파일 업로드 경로
$param = array();
$param["file_path"] = SITE_DEFAULT_CLAIM_ORDER_FILE; 
$param["tmp_name"] = $_FILES["upload_file"]["tmp_name"];
$param["origin_file_name"] = $_FILES["upload_file"]["name"];

//파일을 업로드 한 후 저장된 경로를 리턴한다.
$rs = $fileDAO->upLoadFile($param);

$param = array();
$param["table"] = "order_claim_file";
$param["col"]["origin_file_name"] = $_FILES["upload_file"]["name"];
$param["col"]["save_file_name"] = $rs["save_file_name"];
$param["col"]["file_path"] = $rs["file_path"];
$param["col"]["order_claim_seqno"] = $claim_order_seqno;

$rs = $dao->insertData($conn,$param);

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "order_claim";
$param["col"]["count"] = $fb->form("count");
$param["col"]["order_yn"] = "Y";
$param["prk"] = "order_claim_seqno";
$param["prkVal"] = $claim_order_seqno;

$rs = $dao->updateData($conn,$param);

if (!$rs) {
    $check = 0;
}

//생산 개발후 추가개발 필요

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
