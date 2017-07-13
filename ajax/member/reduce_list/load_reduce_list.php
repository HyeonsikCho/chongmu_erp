<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/ReduceListDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/pageLib.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$reduceListDAO = new ReduceListDAO();

//한페이지에 출력할 게시물 갯수
$list_num = $fb->form("showPage"); 

//현재 페이지
$page = $fb->form("page");

//정렬
$sorting = $fb->form("sorting");
$sorting_type = $fb->form("sorting_type");

//리스트 보여주는 갯수 설정
if (!$fb->form("showPage")) {
    $list_num = 30;
}

//블록 갯수
$scrnum = 5; 

// 페이지가 없으면 1 페이지
if (!$page) {
    $page = 1; 
}

$s_num = $list_num * ($page-1);

$from_date = $fb->form("date_from");
$from_time = "";
$to_date = $fb->form("date_to");
$to_time = "";

if ($from_date) {
    $from_time = $fb->form("time_from");
    $from = $from_date . " " . $from_time;
}

if ($to_date) {
    $to_time = " " . $fb->form("time_to") + 1;
    $to =  $to_date . " " . $to_time;
}

$param = array();
$param["s_num"] = $s_num;
$param["list_num"] = $list_num;
$param["sell_site"] = $fb->form("sell_site");
$param["withdraw_dvs"] = $fb->form("withdraw_dvs");
$param["office_nick"] = $fb->form("office_nick");
$param["search_cnd"] = $fb->form("search_cnd");
$param["from"] = $from;
$param["to"] = $to;
$param["sorting"] = $sorting;
$param["sorting_type"] = $sorting_type;

$rs = $reduceListDAO->selectReduceInfo($conn, "SEQ", $param);
$list = makeReduceListHtml($rs, $param);

$count_rs = $reduceListDAO->selectReduceInfo($conn, "COUNT", $param);
$rsCount = $count_rs->fields["cnt"];

$paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage");

$total = "검색결과 ▶ 총 회원 " . $rsCount . "명.";

echo $list . "♪" . $paging . "♪" . $total;
$conn->close();
?>
