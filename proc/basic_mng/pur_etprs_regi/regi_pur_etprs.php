<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsRegiDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsRegiDAO();

$conn->StartTrans();

$check = 1;

$param = array();
$param["table"] = "extnl_etprs";
$param["col"] = "manu_name";
$param["where"]["manu_name"] = $fb->form("manu_name");
$param["where"]["pur_prdt"] = $fb->form("pur_prdt");

$result = $purDAO->selectData($conn, $param);
$cnt = $result->recordCount();

if ($cnt > 0) {

    echo "2";
    exit;

}

//외부 업체 테이블
$param = array();
$param["table"] = "extnl_etprs";
//제조사
$param["col"]["manu_name"] = $fb->form("manu_name");
//매입품별
$param["col"]["pur_prdt"] = $fb->form("pur_prdt");
//회사 이름
$param["col"]["cpn_name"] = $fb->form("cpn_name");
//홈페이지
$param["col"]["hp"] = $fb->form("hp");
//전화번호
$param["col"]["tel_num"] = $fb->form("tel_num");
//팩스
$param["col"]["fax"] = $fb->form("fax");
//이메일
$param["col"]["mail"] = $fb->form("email");
//우편번호
$param["col"]["zipcode"] = $fb->form("zip");
//주소_앞
$param["col"]["addr_front"] = $fb->form("addr_front");
//주소_뒤
$param["col"]["addr_rear"] = $fb->form("addr_rear");
//주소 타입
$param["col"]["doro_yn"] = $fb->form("doro_yn");
//거래 여부
$param["col"]["deal_yn"] = $fb->form("deal_yn");

$result = $purDAO->insertData($conn, $param);
if (!$result) $check = 0;
$extnl_etprs_seqno = $conn->insert_ID();

//외부 업체 담당자 테이블
$param = array();
$param["table"] = "extnl_mng";
$param["col"]["dvs"] = "매입업체";
//매입업체 담당자
$param["col"]["name"] = $fb->form("etprs_mng_name");
//부서
$param["col"]["depar"] = $fb->form("etprs_depar");
//직책
$param["col"]["job"] = $fb->form("etprs_job");
//담당자 전화번호
$param["col"]["tel_num"] = $fb->form("etprs_tel_num");
//담당자 내선
$param["col"]["exten_num"] = $fb->form("etprs_exten");
//담당자 핸드폰번호
$param["col"]["cell_num"] = $fb->form("etprs_cell_num");
//담당자 이메일
$param["col"]["mail"] = $fb->form("etprs_email");
//외부 업체 일련번호
$param["col"]["extnl_etprs_seqno"] = $extnl_etprs_seqno;

$result = $purDAO->insertData($conn, $param);
if (!$result) $check = 0;

//외부 업체 회계 담당자 테이블
$param = array();
$param["table"] = "extnl_mng";
$param["col"]["dvs"] = "회계";
//회계 담당자
$param["col"]["name"] = $fb->form("accting_mng_name");
//회계 부서
$param["col"]["depar"] = $fb->form("accting_depar");
//회계 직책
$param["col"]["job"] = $fb->form("accting_job");
//회계 전화 번호
$param["col"]["tel_num"] = $fb->form("accting_tel_num");
//회계 내선
$param["col"]["exten_num"] = $fb->form("accting_exten");
//회계 핸드폰 번호
$param["col"]["cell_num"] = $fb->form("accting_cell_num");
//회계 이메일
$param["col"]["mail"] = $fb->form("accting_email");
//외부 업체 일련번호
$param["col"]["extnl_etprs_seqno"] = $extnl_etprs_seqno;

$result = $purDAO->insertData($conn, $param);
if (!$result) $check = 0;

//외부 업체 사업자등록증 정보
$param = array();
$param["table"] = "extnl_etprs_bls_info";
//사업자 회사이름
$param["col"]["cpn_name"] = $fb->form("bls_cpn_name");
//사업자 대표 이름
$param["col"]["repre_name"] = $fb->form("bls_repre_name");
//사업자 등록 번호
$param["col"]["crn"] = $fb->form("bls_crn_first") . $fb->form("bls_crn_scd") . $fb->form("bls_crn_thd");
//업태
$param["col"]["bc"] = $fb->form("bls_bc");
//업종
$param["col"]["tob"] = $fb->form("bls_tob");
//사업자 우편번호
$param["col"]["zipcode"] = $fb->form("bls_zip");
//사업자 주소 앞
$param["col"]["addr_front"] = $fb->form("bls_addr_front");
//사업자 주소 뒤
$param["col"]["addr_rear"] = $fb->form("bls_addr_rear");
//사업자 주소 타입
$param["col"]["doro_yn"] = $fb->form("bls_doro_yn");
//사업자 은행
$param["col"]["bank_name"] = $fb->form("bls_bank_name");
//사업자 은행 계좌 번호
$param["col"]["ba_num"] = $fb->form("bls_ba_num");
//사업자 참고 사항
$param["col"]["add_items"] = $fb->form("bls_add_items");
//외부 업체 일련번호
$param["col"]["extnl_etprs_seqno"] = $extnl_etprs_seqno;

$result = $purDAO->insertData($conn, $param);
if (!$result) $check = 0;

if ($check == 1) {
    
    echo "1";

} else {

    echo "3";
}

$conn->CompleteTrans();
$conn->close();
?>
