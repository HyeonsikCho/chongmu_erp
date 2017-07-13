<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$organDAO = new OrganMngDAO();

//관리자 일련번호
$empl_seqno = $fb->form("mng_seq");
//판매채널 일련번호
//$cpn_admin_seqno = $fb->form("cpn_admin_seqno");
$cpn_admin_seqno = $fb->form("cpn_admin_seq");

//판매채널
$param = array();
$param["table"] = "cpn_admin";
$param["col"] = "sell_site, cpn_admin_seqno";
$sell_rs = $organDAO->selectData($conn, $param);

//직책
$param = array();
$param["table"] = "job_admin";
$param["col"] = "job_name, job_code";
$param["order"] = "job_name";
$job_rs = $organDAO->selectData($conn, $param);

//직급
$param = array();
$param["table"] = "posi_admin";
$param["col"] = "posi_name, posi_code";
$param["order"] = "posi_name";
$posi_rs = $organDAO->selectData($conn, $param);

//보안등급
$param = array();
$param["table"] = "empl";
$param["col"] = "DISTINCT admin_auth";
$param["order"] = "admin_auth";
$auth_rs = $organDAO->selectData($conn, $param);

$d_param = array();
//수정 모드 일때
if ($empl_seqno) {

    $param = array();
    $param["empl_seqno"] = $empl_seqno;
    $result = $organDAO->selectMngList($conn, $param);

    $depar_code = $result->fields["depar_code"];
    $job_code = $result->fields["job_code"];
    $posi_code = $result->fields["posi_code"];
    $admin_auth = $result->fields["admin_auth"];
    $d_param["mng_name"] = $result->fields["name"];
    $d_param["empl_code"] = $result->fields["empl_code"];
    $d_param["empl_id"] = $result->fields["empl_id"];
    $d_param["enter_date"] = $result->fields["enter_date"];
    $d_param["empl_seqno"] = $empl_seqno;

    $d_param["sell_site_html"] = makeSelectedOptionHtml($sell_rs, 
            $cpn_admin_seqno, "sell_site", "cpn_admin_seqno");
    
    //선택 된 부서
    $param = array();
    $param["table"] = "depar_admin";
    $param["col"] = "depar_name, depar_code";
    $param["where"]["depar_level"] = "2";
    $param["where"]["cpn_admin_seqno"] = $cpn_admin_seqno;
    $param["order"] = "depar_name";
    $depar_rs = $organDAO->selectData($conn, $param);

    //관리자에 해당하는 부서코드 선택
    $d_param["depar_name_html"] = makeSelectedOptionHtml($depar_rs, 
            $depar_code, "depar_name", "depar_code");
    //관리자에 해당하는 보안등급 선택
    $d_param["admin_auth_html"] = makeSelectedOptionHtml($auth_rs, 
            $admin_auth, "admin_auth", "admin_auth");
    //관리자에 해당하는 직책 선택
    $d_param["job_name_html"] = makeSelectedOptionHtml($job_rs, 
            $job_code, "job_name", "job_code");
    //관리자에 해당하는 직급 선택
    $d_param["posi_name_html"] = makeSelectedOptionHtml($posi_rs, 
            $posi_code, "posi_name", "posi_code");

 
} else {

    $d_param["empl_seqno"] = "";

    //판매사이트 기본셋팅
    $d_param["sell_site_html"] = makeSelectedOptionHtml($sell_rs, 
            "", "sell_site", "cpn_admin_seqno");

    //보안등급 기본셋팅
    $d_param["admin_auth_html"] = makeSelectedOptionHtml($auth_rs, 
            "", "admin_auth", "admin_auth");

    //직책 기본셋팅
    $d_param["job_name_html"] = makeSelectedOptionHtml($job_rs, 
            "", "job_name", "job_code");

    //직급 기본셋팅
    $d_param["posi_name_html"] = makeSelectedOptionHtml($posi_rs, 
            "", "posi_name", "posi_code");

}


$html = getMngHtml($d_param);

echo $html;

$conn->close();
?>
