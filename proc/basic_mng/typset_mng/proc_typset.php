<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/TypsetMngDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();

$typsetDAO = new TypsetMngDAO();
$fileDAO = new FileAttachDAO();
$check = 1;
$conn->StartTrans();

$param = array();
$param["table"] = "typset_format";
//조판명
$param["col"]["name"] = $fb->form("pop_typset_name");
//계열
$param["col"]["affil"] = $fb->form("affil");
//절수
$param["col"]["subpaper"] = $fb->form("subpaper");
//가로 사이즈
$param["col"]["wid_size"] = $fb->form("wid_size");
//세로 사이즈
$param["col"]["vert_size"] = $fb->form("vert_size");
//설명
$param["col"]["dscr"] = $fb->form("dscr");
//배송판
$param["col"]["dlvrboard"] = $fb->form("dlvrboard");
//용도
$param["col"]["purp"] = $fb->form("purp");
//홍각기여부
$param["col"]["honggak_yn"] = $fb->form("honggak_yn");
//외부업체 일련번호
$param["col"]["extnl_etprs_seqno"] = $fb->form("extnl_etprs_seqno");
//카테고리 분류코드
$param["col"]["cate_sortcode"] = $fb->form("cate_bot");
//공정여부
$param["col"]["process_yn"] = "N";

//조판 추가
if ($fb->form("add_yn") == "Y") {

    $result = $typsetDAO->insertData($conn, $param);
    if (!$result) {

        $check = 0;
    }
    //조판 일련번호
    $typset_seqno = $conn->insert_ID();

    if ($fb->form("upload_file")) {

        //파일 업로드 경로
        $param =  array();
        $param["file_path"] = SITE_DEFAULT_TYPSET_FILE;
        $param["tmp_name"] = $_FILES["upload_btn"]["tmp_name"];
        $param["origin_file_name"] = $_FILES["upload_btn"]["name"];

        //파일을 업로드 한 후 저장된 경로를 리턴한다.
        $result= $fileDAO->upLoadFile($param);

        $ext = explode(".", $_FILES["upload_btn"]["name"]);

        //조판 파일 추가
        $param = array();
        $param["table"] = "typset_format_file";
        $param["col"]["typset_format_seqno"] = $typset_seqno;

        //조판 파일
        $param["col"]["origin_file_name"] = $_FILES["upload_btn"]["name"];
        $param["col"]["size"] = $_FILES["upload_btn"]["size"];
        $param["col"]["save_file_name"] = $result["save_file_name"];
        $param["col"]["file_path"] = $result["file_path"];
        $param["col"]["ext"] = $ext[1];

        //조판 파일 입력
        $result = $typsetDAO->insertData($conn,$param);

        if (!$result) {

            $check = 0;
        }
    }
//조판 수정
} else {

    $param["prk"] = "typset_format_seqno";
    $param["prkVal"] = $fb->form("typset_seqno");

    $result = $typsetDAO->updateData($conn, $param);

    //파일을 새로 올렸을때
    if ($fb->form("upload_file")) {

        //조판 파일 삭제
        $param = array();
        $param["table"] = "typset_format_file";
        $param["prk"] = "typset_format_seqno";
        $param["prkVal"] = $fb->form("typset_seqno");

        $result = $typsetDAO->deleteData($conn, $param);
        if (!$result) {

            $check = 0;
        }

        //파일 업로드 경로
        $param =  array();
        $param["file_path"] = SITE_DEFAULT_TYPSET_FILE;
        $param["tmp_name"] = $_FILES["upload_btn"]["tmp_name"];
        $param["origin_file_name"] = $_FILES["upload_btn"]["name"];

        //파일을 업로드 한 후 저장된 경로를 리턴한다.
        $result= $fileDAO->upLoadFile($param);

        //조판 파일 수정
        $param = array();
        $param["table"] = "typset_format_file";
        $param["col"]["typset_format_seqno"] = $fb->form("typset_seqno");

        $ext = explode(".", $_FILES["upload_btn"]["name"]);

        //조판 파일
        $param["col"]["origin_file_name"] = $_FILES["upload_btn"]["name"];
        $param["col"]["size"] = $_FILES["upload_btn"]["size"];
        $param["col"]["save_file_name"] = $result["save_file_name"];
        $param["col"]["file_path"] = $result["file_path"];
        $param["col"]["ext"] = $ext[1];

        $result = $typsetDAO->insertData($conn, $param);

    }

    if (!$result) {

        $check = 0;
    }
}

if ($check == 1) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>

