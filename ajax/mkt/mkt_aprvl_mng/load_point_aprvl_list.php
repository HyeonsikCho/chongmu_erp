<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/MktAprvlMngDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/pageLib.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();
$mktDAO = new MktAprvlMngDAO();

//페이징
$list_num = $fb->form("list_num"); //한페이지에 출력할 게시물 개수
if (!$fb->form("list_num")) $list_num = 30;

$scrnum = 5; //블록 개수
$page = $fb->form("page");

if (!$page) $page = 1; // 페이지가 없으면 1 페이지

//포인트 승인 테이블
$param = array();
$param["cpn_seqno"] = $fb->form("sell_site");
$param["office_nick"] = $fb->form("office_nick");
$param["date_from"] = $fb->form("date_from");
$param["date_to"] = $fb->form("date_to");
$param["date_dvs"] = $fb->form("date_dvs");
$param["aprvl_type"] = $fb->form("aprvl_type");

//페이징
$param["start"] = $list_num * ($page-1);
$param["end"] = $list_num;

//결과 값을 가져옴
$result = $mktDAO->selectPointAprvlList($conn, $param);

$param["start"] = "";
$param["end"] = "";

$count_rs = $mktDAO->countPointAprvlList($conn, $param);
$total_count = $count_rs->fields["cnt"]; //페이징할 총 글수

$ret = "";
$ret = mkDotAjaxPage($total_count, $page, $scrnum, $list_num, "searchResult");

//후공정 테이블 그리기
$list = "";
$list = makePointAprvlList($conn, $result, $list_num * ($page-1));

echo $list . "★" . $ret;
$conn->close();
?>
