<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/cashbook/CashbookRegiDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();

$cashbookDAO = new CashbookRegiDAO();
$conn->StartTrans();

//증빙일자
$evid_date = $fb->form("evid_date");
//마감일자 확인
$result = $cashbookDAO->selectCloseDate($conn, $param);
$close_date = $result->fields["date"];

//마감일자가 증빙일자보다 크면
if ($close_date > $evid_date) {

    echo "3";
    exit;
}

//지출수입 구분
$dvs = $fb->form("dvs");

//금전출납부
$param = array();
$param["table"] = "cashbook";
//회사 관리 일련번호
$param["col"]["cpn_admin_seqno"] = $fb->form("sell_site");
//이체 지출 구분
$param["col"]["dvs"] = $fb->form("dvs");
//적요
$param["col"]["sumup"] = $fb->form("sumup");
//입출금경로
$param["col"]["depo_withdraw_path"] = $fb->form("path");
//입출금경로상세
$param["col"]["depo_withdraw_path_detail"] = $fb->form("path_detail");
//증빙일자
$param["col"]["evid_date"] = $fb->form("evid_date");
//금액부분 초기화
$param["col"]["income_price"] = NULL;
$param["col"]["expen_price"] = NULL;
$param["col"]["trsf_income_price"] = NULL;
$param["col"]["trsf_expen_price"] = NULL;
//금액
$param["col"][$fb->form("dvs") . "_price"] = $fb->form("price");
//회원 일련번호
$param["col"]["member_seqno"] = $fb->form("member_seqno");
//제조사 일련번호
$param["col"]["extnl_etprs_seqno"] = $fb->form("etprs_seqno");
//카드사
$param["col"]["card_cpn"] = $fb->form("card_cpn");
//카드번호
$param["col"]["card_num"] = $fb->form("card_num");
//할부월수
if ($fb->form("mip_mon") == "") {

    $param["col"]["mip_mon"] = NULL;

} else {

    $param["col"]["mip_mon"] = $fb->form("mip_mon");

}

//승인번호
$param["col"]["aprvl_num"] = $fb->form("aprvl_num");
//승인일수
if ($fb->form("aprvl_date") == "") {

    $param["col"]["aprvl_date"] = NULL;

} else {

    $param["col"]["aprvl_date"] = $fb->form("aprvl_date");
}

//계정 상세 일련번호
if ($fb->form("acc_subject_detail")) {

    $param["col"]["acc_detail_seqno"] = $fb->form("acc_subject_detail");

} else {

    $param["col"]["acc_detail_seqno"] = NULL;

}

if ($fb->form("cashbook_seqno")) {

    $param["prk"] = "cashbook_seqno";
    $param["prkVal"] = $fb->form("cashbook_seqno");

    $result = $cashbookDAO->updateData($conn, $param);

} else {

    //등록일자
    $param["col"]["regi_date"] = date("Y-m-d", time());

    $result = $cashbookDAO->insertData($conn, $param);

}

echo $result;

$conn->CompleteTrans();
$conn->close();
?>
