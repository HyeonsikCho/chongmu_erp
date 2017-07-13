<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/esti_mng/EstiListDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new EstiListDAO();
$fileDAO = new FileAttachDAO();
$check = 1;

$conn->StartTrans();
$esti_seqno = $fb->form("seqno");

if ($fb->form("upload_yn") == "Y") {

    //파일 업로드 경로
    $param = array();
    $param["file_path"] = SITE_DEFAULT_ESTI_FILE;
    $param["tmp_name"] = $_FILES["upload_file"]["tmp_name"];
    $param["origin_file_name"] = $_FILES["upload_file"]["name"];

    //파일을 업로드 한 후 저장된 경로를 리턴한다.
    $rs = $fileDAO->upLoadFile($param);

    $param = array();
    $param["table"] = "admin_esti_file";
    $param["col"]["origin_file_name"] = $_FILES["upload_file"]["name"];
    $param["col"]["save_file_name"] = $rs["save_file_name"];
    $param["col"]["file_path"] = $rs["file_path"];
    $param["col"]["esti_seqno"] = $esti_seqno;

    $rs = $dao->insertData($conn,$param);

    if (!$rs) {
        $check = 0;
    }
}

//견적 등록
$param = array();
$param["esti_seqno"] = $esti_seqno;
$param["memo"] = $fb->form("memo");
$param["answ_cont"] = $fb->form("answ_cont");
$param["supply_price"] = str_replace(",", "", $fb->form("supply_price"));
$param["vat"] = str_replace(",", "", $fb->form("vat"));
$param["sale_price"] = str_replace(",", "", $fb->form("sale_price"));
$param["esti_price"] = str_replace(",", "", $fb->form("esti_price"));
$param["expec_order_date"] = $fb->form("expec_order_date");
$param["etc_cont"] = $fb->form("etc_cont");
$param["state"] = "견적완료";

$rs = $dao->updateEstiList($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
