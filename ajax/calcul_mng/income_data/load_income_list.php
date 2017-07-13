<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/calcul_mng/settle/IncomeDataDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/pageLib.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$incomeDAO = new IncomeDataDAO();


//페이징
$list_num = $fb->form("list_num"); //한페이지에 출력할 게시물 개수
if (!$fb->form("list_num")) $list_num = 30;

$scrnum = 5; //블록 개수
$page = $fb->form("page");

if (!$page) $page = 1; // 페이지가 없으면 1 페이지

$param = array();
//판매채널 일련번호
$param["cpn_admin_seqno"] = $fb->form("sell_site");
//회원 일련번호
$param["member_seqno"] = $fb->form("member_seqno");
//입출금경로 일련번호
$param["depo_path"] = $fb->form("path");
//입출금경로상세 일련번호
$param["depo_path_detail"] = $fb->form("path_detail");
//등록 시작 일자
$param["date_from"] = $fb->form("date_from");
//등록 종료 일자
$param["date_to"] = $fb->form("date_to");

//페이징
$param["start"] = $list_num * ($page-1);
$param["end"] = $list_num;

//수입 리스트
$result = $incomeDAO->selectIncomeList($conn, $param);
$count_rs = $incomeDAO->countIncomeList($conn, $param);

$total_count = $count_rs->fields["cnt"]; //페이징할 총 글수

$ret = "";
$ret = mkDotAjaxPage($total_count, $page, $scrnum, $list_num, "searchResult");

//수입 테이블 그리기
$list = "";
$list = makeIncomeList($result, $list_num * ($page-1));

$param["sum_dvs"] = "";

$cash = "0";
$param["sum_dvs"] = "현금";
$result = $incomeDAO->selectIncomeSumPrice($conn, $param);
//현금합계가 있을때
if ($result->fields["income"] || $result->fields["trsf_income"]) {

    $cash = $result->fields["income"] + $result->fields["trsf_income"];

}

$bankbook = "0";
$param["sum_dvs"] = "가상계좌";
$result = $incomeDAO->selectIncomeSumPrice($conn, $param);
//가상계좌(통장) 합계가 있을때
if ($result->fields["income"] || $result->fields["trsf_income"]) {

    $bankbook = $result->fields["income"] + $result->fields["trsf_income"];

}

$card = "0";
$param["sum_dvs"] = "카드";
$result = $incomeDAO->selectIncomeSumPrice($conn, $param);
//가상계좌(통장) 합계가 있을때
if ($result->fields["income"] || $result->fields["trsf_income"]) {

    $card = $result->fields["income"] + $result->fields["trsf_income"];

}

$etc = "0";
$param["sum_dvs"] = "기타";
$result = $incomeDAO->selectIncomeSumPrice($conn, $param);
//기타 합계가 있을때
if ($result->fields["income"] || $result->fields["trsf_income"]) {

    $etc = $result->fields["income"] + $result->fields["trsf_income"];

}

echo $list . "♪♭@" . $ret . "♪♭@" . $cash . "원♪♭@" . 
     $bankbook . "원♪♭@" .  $card . "원♪♭@" . $etc . "원";

$conn->close();


?>
