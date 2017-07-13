<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/file/FileAttachDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$cpDAO = new CpMngDAO();
$fileDAO = new FileAttachDAO();

$check = 1;

$param = array();
$param["table"] = "cp";
//쿠폰명
$param["col"]["cp_name"] = $fb->form("pop_cp_name");
//판매 사이트
$param["col"]["cpn_admin_seqno"] = $fb->form("pop_sell_site");
//할인 구분
$param["col"]["unit"] = $fb->form("sale_dvs");

//할인 구분 요율 일때
if ($fb->form("sale_dvs") == "%") {

    //값
    $param["col"]["val"] = $fb->form("per_val");
    //최대 할인 금액
    $param["col"]["max_sale_price"] = $fb->form("max_sale_price");


//할인 구분 원 일때
} else {

    //값
    $param["col"]["val"] = $fb->form("won_val");
    //최대 할인 금액
    $param["col"]["min_order_price"] = $fb->form("min_order_price");

}

//기간제 여부
$param["col"]["period_limit_yn"] = $fb->form("period_limit");

//기간제일때
if ($fb->form("period_limit") == "Y") {
    
    $param["col"]["public_start_date"] = $fb->form("public_start_date");
    $param["col"]["public_end_date"] = $fb->form("public_end_date");

    $end_date = explode("-", $fb->form("public_end_date"));

    $param["col"]["public_extinct_date"] =  
         date("Y-m-d", mktime(0,0,0, date($end_date[1]), 
                     date($end_date[2]+1), date($end_date[0])));

//발행제일때
} else {

    $param["col"]["public_deadline_day"] = $fb->form("public_deadline_day");
    $param["col"]["public_extinct_date"] = $fb->form("public_extinct_date");

}

//시간제 여부
$param["col"]["hour_limit_yn"] = $fb->form("hour_limit");

//시간제 일때
if ($fb->form("hour_limit") == "Y") {

    $param["col"]["use_start_hour"] = $fb->form("start_hour") . ":" .
                                      $fb->form("start_min") . ":" . "00";


    $param["col"]["use_end_hour"] = $fb->form("end_hour") . ":" .
                                    $fb->form("end_min") . ":" . "00";

//시간 제한이 없을때
} else {

    $param["col"]["use_start_hour"] = "00:00:00";
    $param["col"]["use_end_hour"] = "23:59:59";

}

//대상 지정 여부
$param["col"]["object_appoint_yn"] = $fb->form("object_appoint");
//대상 미지정일때 발행매수 설정
if ($fb->form("object_appoint") == "N") {

    $param["col"]["public_amt"] = $fb->form("public_amt");

}
//쿠폰 사용여부
$param["col"]["use_yn"] = $fb->form("use_yn");
//카테고리 중분류
$param["col"]["cate_sortcode"] = $fb->form("cate_sortcode");

//쿠폰 수정
if ($fb->form("cp_seqno")) {

    $param["prk"] = "cp_seqno";
    $param["prkVal"] = $fb->form("cp_seqno");

    $result = $cpDAO->updateData($conn, $param);

    if (!$result) {

        $check = 0;
    }

    if ($fb->form("upload_file")) {

        //쿠폰 파일 삭제
        $param = array();
        $param["table"] = "cp_file";
        $param["prk"] = "cp_seqno";
        $param["prkVal"] = $fb->form("cp_seqno");

        $result = $cpDAO->deleteData($conn, $param);
        if (!$result) {

            $check = 0;
        }

        //파일 업로드 경로
        $param =  array();
        $param["file_path"] = SITE_DEFAULT_CP_FILE;
        $param["tmp_name"] = $_FILES["upload_btn"]["tmp_name"];
        $param["origin_file_name"] = $_FILES["upload_btn"]["name"];

        //파일을 업로드 한 후 저장된 경로를 리턴한다.
        $result= $fileDAO->upLoadFile($param);

        //쿠폰 파일 추가
        $param = array();
        $param["table"] = "cp_file";
        $param["col"]["cp_seqno"] = $fb->form("cp_seqno");
        $param["col"]["origin_file_name"] = $_FILES["upload_btn"]["name"];
        $param["col"]["save_file_name"] = $result["save_file_name"];
        $param["col"]["file_path"] = $result["file_path"];

        $result = $cpDAO->insertData($conn,$param);

        if (!$result) {

            $check = 0;
        }

    }

//쿠폰 추가
} else {

    $param["col"]["regi_date"] = date("Y-m-d H:i:s",time());
    $result = $cpDAO->insertData($conn, $param);
    $cp_seqno = $conn->insert_ID();

    if ($fb->form("upload_file")) {

        //파일 업로드 경로
        $param =  array();
        $param["file_path"] = SITE_DEFAULT_CP_FILE;
        $param["tmp_name"] = $_FILES["upload_btn"]["tmp_name"];
        $param["origin_file_name"] = $_FILES["upload_btn"]["name"];

        //파일을 업로드 한 후 저장된 경로를 리턴한다.
        $result= $fileDAO->upLoadFile($param);

        //쿠폰 파일 추가
        $param = array();
        $param["table"] = "cp_file";
        $param["col"]["origin_file_name"] = $_FILES["upload_btn"]["name"];
        $param["col"]["save_file_name"] = $result["save_file_name"];
        $param["col"]["file_path"] = $result["file_path"];
        $param["col"]["cp_seqno"] = $cp_seqno;

        $result = $cpDAO->insertData($conn, $param);

        if (!$result) {

            $check = 0;
        }
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

