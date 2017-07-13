<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/TypsetMngDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/pageLib.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$typsetDAO = new TypsetMngDAO();

//페이징
$list_num = $fb->form("list_num"); //한페이지에 출력할 게시물 개수
if (!$fb->form("list_num")) $list_num = 30;

$scrnum = 5; //블록 개수
$page = $fb->form("page");

if (!$page) $page = 1; // 페이지가 없으면 1 페이지

//조판 테이블
$param = array();

$param["name"] = $fb->form("name");
$param["affil_fs"] = $fb->form("affil_fs");
$param["affil_guk"] = $fb->form("affil_guk");
$param["affil_spc"] = $fb->form("affil_spc");
$param["file"] = $fb->form("file");

//페이징
$param["start"] = $list_num * ($page-1);
$param["end"] = $list_num;

//결과 값을 가져옴
$result = $typsetDAO->selectTypsetList($conn, $param);

$param["start"] = "";
$param["end"] = "";

$count_rs = $typsetDAO->selectTypsetList($conn, $param);
$total_count = $count_rs->recordCount(); //페이징할 총 글수

$ret = mkDotAjaxPage($total_count, $page, $scrnum, $list_num, "searchResult");

//조판 테이블 그리기

$list = makeTypsetList($conn, $result, $list_num * ($page-1));

echo $list . "★" . $ret;
$conn->close();
?>
