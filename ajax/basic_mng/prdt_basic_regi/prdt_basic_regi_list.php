<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_mng/PrdtBasicRegiDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/pageLib.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$prdtBasicRegiDAO = new PrdtBasicRegiDAO();

//한페이지에 출력할 게시물 갯수
$list_num = $fb->form("showPage"); 

//현재 페이지
$page = $fb->form("page");

//선택된 탭
$select_el = $fb->form("selectEl");

//검색할 단어
$search_txt = $fb->form("searchTxt");

//검색할 대분류
$select_sort = $fb->form("select_sort");

//검색할 이름
$select_name = $fb->form("select_name");

//정렬
$sorting = $fb->form("sorting");
$sorting_type = $fb->form("sorting_type");

//문자열 정렬
if ($sorting == "basisweight") {
    $sorting = "CONVERT(basisweight, UNSIGNED)";
}

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
 
//검색조건
$param = array();
$param["s_num"] = $s_num;
$param["list_num"] = $list_num;
$param["search_txt"] = $search_txt;
$param["sort"] = $select_sort;
$param["name"] = $select_name;
$param["sorting"] = $sorting;
$param["sorting_type"] = $sorting_type;

//종이 일경우
if ($select_el == "paper") {

    $paper_rs = $prdtBasicRegiDAO->selectPaperInfo($conn, "SEQ", $param);
    $list = makePaperListHtml($paper_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectPaperInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "paper");
   
    echo $list . "♪" . $paging;

//출력정보 일경우
} else if ($select_el == "output") {
 
    $output_rs = $prdtBasicRegiDAO->selectOutputInfo($conn, "SEQ", $param);
    $list = makeOutputListHtml($output_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectOutputInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "output");
   
    echo $list . "♪" . $paging;

//사이즈 일경우
} else if ($select_el == "size") {
 
    $size_rs = $prdtBasicRegiDAO->selectSizeInfo($conn, "SEQ", $param);
    $list = makeSizeListHtml($size_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectSizeInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "size");
   
    echo $list . "♪" . $paging;

//인쇄정보 일경우
} else if ($select_el == "print") {
 
    $print_rs = $prdtBasicRegiDAO->selectPrintInfo($conn, "SEQ", $param);
    $list = makePrintListHtml($print_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectPrintInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "print");
   
    echo $list . "♪" . $paging;

//인쇄도수 일경우
} else if ($select_el == "tmpt") {
 
    $tmpt_rs = $prdtBasicRegiDAO->selectTmptInfo($conn, "SEQ", $param);
    $list = makeTmptListHtml($tmpt_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectTmptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "tmpt");
   
    echo $list . "♪" . $paging;

//후공정 일경우
} else if ($select_el == "after") {
 
    $after_rs = $prdtBasicRegiDAO->selectAfterInfo($conn, "SEQ", $param);
    $list = makeAfterListHtml($after_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectAfterInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "after");
   
    echo $list . "♪" . $paging;

//옵션 일경우
} else if ($select_el == "opt") {
 
    $opt_rs = $prdtBasicRegiDAO->selectOptInfo($conn, "SEQ", $param);
    $list = makeOptListHtml($opt_rs, $param);
  
    $count_rs = $prdtBasicRegiDAO->selectOptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "opt");
   
    echo $list . "♪" . $paging;
}

$conn->close();
?>
