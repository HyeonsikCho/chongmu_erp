<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsListDAO();

$member_list = "";
if ($fb->form("type") == "edit") {
    
    $param = array();
    //매입업체 일련번호
    $param["table"] = "extnl_etprs_member";
    $param["col"] = "mng, extnl_etprs_seqno, id, access_code,
                 tel_num, cell_num, mail, resp_task, extnl_etprs_member_seqno";
    $param["where"]["extnl_etprs_seqno"] = $fb->form("etprs_seqno");

    //매입업체 회원 결과리스트를 가져옴
    $result = $purDAO->selectData($conn, $param);
    $member_list = makeExtnlMemberList($result);
}

$param = array();
//매입업체 일련번호
$param["seqno"] = $fb->form("etprs_seqno");

//매입업체 담당자 결과값을 가져옴
$mng_result = $purDAO->selectViewPurMng($conn, $param);
$acct_result = $purDAO->selectViewAcctMng($conn, $param);

//view 팝업일때
if ($fb->form("type") == "view") {

    $etprs_mng_list = makePurMngList($mng_result, "etprs", "Y");
    $acct_mng_list = makePurMngList($acct_result, "acct", "Y");

//edit 팝업일때
} else if ($fb->form("type") == "edit") {

    $etprs_mng_list = makePurMngList($mng_result, "etprs", "N");
    $acct_mng_list = makePurMngList($acct_result, "acct", "N");
}

$result = "";
//매입업체와 매입업체 사업자등록증 결과값을 가져옴
$result = $purDAO->selectViewPurEtprs($conn, $param);

//매입품목
$pur_prdt = $result->fields["pur_prdt"];

//매입업체 결과를 담을 파라미터
$param = array();
//매입업체 일련번호
$param["etprs_seqno"] = $fb->form("etprs_seqno");
//매입업체 이름
$param["manu_name"] = $result->fields["manu_name"];
//판매 품목
$param["pur_prdt"] = $pur_prdt;
//active할 판매 품목
$param[$pur_prdt] = "active";
//회사 이름
$param["cpn_name"] = $result->fields["cpn_name"];
//홈페이지
$param["hp"] = $result->fields["hp"];
//전화 번호
$param["tel_num"] = $result->fields["tel_num"];
//팩스 번호
$param["fax"] = $result->fields["fax"];
//이메일
$param["mail"] = $result->fields["mail"];
//우편번호
$param["zipcode"] = $result->fields["zipcode"];
//주소 앞
$param["addr_front"] = $result->fields["addr_front"];
//주소 뒤
$param["addr_rear"] = $result->fields["addr_rear"];
//도로명 여부
$doro_yn = $result->fields["doro_yn"];

if ($doro_yn == "N") {
    
    $param["addr_jibun"] = "checked";
    $param["addr_doro"] = "";

} else {

    $param["addr_jibun"] = "";
    $param["addr_doro"] = "checked";
}

//거래 여부
$deal_yn = $result->fields["deal_yn"];

if ($deal_yn == "Y") {
    
    $param["deal_y"] = "checked";
    $param["deal_n"] = "";

} else {

    $param["deal_y"] = "";
    $param["deal_n"] = "checked";
}

//매입업체 담당자 리스트
$param["etprs_mng_list"] = $etprs_mng_list;
//매입업체 회계 담당자 리스트
$param["acct_mng_list"] = $acct_mng_list;
//사업자 회사 이름
$param["bls_cpn_name"] = $result->fields["bls_cpn_name"];
//사업자 대표 이름
$param["repre_name"] = $result->fields["repre_name"];
//사업자 등록증 번호
$crn = $result->fields["crn"];
$param["crn_first"] = substr($crn, 0, 3);
$param["crn_scd"] = substr($crn, 3, 2);
$param["crn_thd"] = substr($crn, 5, 5);
//사업자 업태
$param["tob"] = $result->fields["tob"];
//사업자 우편번호
$param["bls_zipcode"] = $result->fields["bls_zipcode"];
//업종
$param["bc"] = $result->fields["bc"];
//사업자 주소 앞
$param["bls_addr_front"] = $result->fields["bls_addr_front"];
//사업자 주소 뒤
$param["bls_addr_rear"] = $result->fields["bls_addr_rear"];
//사업자 주소 타입
$bls_doro_yn = $result->fields["bls_doro_yn"];

if ($bls_doro_yn == "N") {
    
    $param["bls_addr_jibun"] = "checked";
    $param["bls_addr_doro"] = "";

} else {

    $param["bls_addr_jibun"] = "";
    $param["bls_addr_doro"] = "checked";
}

//은행 이름
$param["bank_name"] = $result->fields["bank_name"];
//계좌 번호
$param["ba_num"] = $result->fields["ba_num"];
//추가 사항
$param["add_items"] = $result->fields["add_items"];

//매입업체 회원 리스트
$param["extnl_member"] = $member_list;

if ($fb->form("type") == "view") {

    //매입품목 뷰 팝업창 그리기
    $list = getPurEtprsView($param);
    echo $list;

} else if ($fb->form("type") == "edit"){

    //매입품목 수정 팝업창 그리기
    $list = getPurEtprsEdit($param);
    echo $list . "★" . $pur_prdt . "★" . $param["bank_name"];

}

$conn->close();
?>
