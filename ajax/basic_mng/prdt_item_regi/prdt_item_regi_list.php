<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_mng/PrdtItemRegiDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/pageLib.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$prdtItemRegiDAO = new PrdtItemRegiDAO();

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
$param["cate_sortcode"] = $fb->form("cate_sortcode");

//종이 일경우
if ($select_el == "paper") {

    $fields = array();
    $fields[0] = "prdt_paper_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "dvs";
    $fields[4] = "color";
    $fields[5] = "basisweight";
    $fields[6] = "basisweight_unit";

    $paper_rs = $prdtItemRegiDAO->selectPaperInfo($conn, "SEQ", $param);
    $list = makePaperListHtml($paper_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectPaperInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "paper");
   
    echo $list . "♪" . $paging;

//구성아이템 종이 일경우
} else if ($select_el == "cate_paper") {
 
    $fields = array();
    $fields[0] = "cate_paper_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "dvs";
    $fields[4] = "color";
    $fields[5] = "basisweight";

    $paper_rs = $prdtItemRegiDAO->selectCatePaperInfo($conn, "SEQ", $param);
    $list = makePaperListHtml($paper_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectCatePaperInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "cateMovePage", "cate_paper");
   
    echo $list . "♪" . $paging;

//사이즈 일경우
} else if ($select_el == "size") {
  
    $fields = array();
    $fields[0] = "prdt_stan_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "typ";
    $fields[4] = "work_wid_size";
    $fields[5] = "work_vert_size";
    $fields[6] = "cut_wid_size";
    $fields[7] = "cut_vert_size";
    $fields[8] = "design_wid_size";
    $fields[9] = "design_vert_size";
    $fields[10] = "tomson_wid_size";
    $fields[11] = "tomson_vert_size";

    $size_rs = $prdtItemRegiDAO->selectSizeInfo($conn, "SEQ", $param);
    $list = makeSizeListHtml($size_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectSizeInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "size");
   
    echo $list . "♪" . $paging;

//구성아이템 사이즈 일경우
} else if ($select_el == "cate_size") {
  
    $fields = array();
    $fields[0] = "cate_stan_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "typ";
    $fields[4] = "work_wid_size";
    $fields[5] = "work_vert_size";
    $fields[6] = "cut_wid_size";
    $fields[7] = "cut_vert_size";
    $fields[8] = "design_wid_size";
    $fields[9] = "design_vert_size";
    $fields[10] = "tomson_wid_size";
    $fields[11] = "tomson_vert_size";

    $size_rs = $prdtItemRegiDAO->selectCateSizeInfo($conn, "SEQ", $param);
    $list = makeSizeListHtml($size_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectCateSizeInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "cateMovePage", "cate_size");
   
    echo $list . "♪" . $paging;

//인쇄도수 일경우
} else if ($select_el == "tmpt") {
  
    $fields = array();
    $fields[0] = "prdt_print_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "side_dvs";
    $fields[4] = "beforeside_tmpt";
    $fields[5] = "aftside_tmpt";
    $fields[6] = "add_tmpt";
    $fields[7] = "tot_tmpt";

    $tmpt_rs = $prdtItemRegiDAO->selectTmptInfo($conn, "SEQ", $param);
    $list = makeTmptListHtml($tmpt_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectTmptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "tmpt");
   
    echo $list . "♪" . $paging;

//구성아이템 인쇄도수 일경우
} else if ($select_el == "cate_tmpt") {
  
    $fields = array();
    $fields[0] = "cate_print_seqno";
    $fields[1] = "sort";
    $fields[2] = "name";
    $fields[3] = "side_dvs";
    $fields[4] = "beforeside_tmpt";
    $fields[5] = "aftside_tmpt";
    $fields[6] = "add_tmpt";
    $fields[7] = "tot_tmpt";

    $tmpt_rs = $prdtItemRegiDAO->selectCateTmptInfo($conn, "SEQ", $param);
    $list = makeTmptListHtml($tmpt_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectCateTmptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "cateMovePage", "cate_tmpt");
   
    echo $list . "♪" . $paging;

//후공정 일경우
} else if ($select_el == "after") {
  
    $fields = array();
    $fields[0] = "prdt_after_seqno";
    $fields[1] = "after_name";
    $fields[2] = "depth1";
    $fields[3] = "depth2";
    $fields[4] = "depth3";
    $fields[5] = "crtr_unit";

    $after_rs = $prdtItemRegiDAO->selectAfterInfo($conn, "SEQ", $param);
    $list = makeAfterListHtml($after_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectAfterInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "after");
   
    echo $list . "♪" . $paging;

//구성아이템 후공정 일경우
} else if ($select_el == "cate_after") {
  
    $param["after_name"] = $select_name;
    $param["basic_yn"] = $select_sort;

    $fields = array();
    $fields[0] = "cate_after_seqno";
    $fields[1] = "after_name";
    $fields[2] = "depth1";
    $fields[3] = "depth2";
    $fields[4] = "depth3";
    $fields[5] = "crtr_unit";
    $fields[6] = "basic_yn";

    $after_rs = $prdtItemRegiDAO->selectCateAftInfo($conn, "SEQ", $param);
    $list = makeAfterListHtml($after_rs, $param, $fields, $select_el, TRUE);
  
    $count_rs = $prdtItemRegiDAO->selectCateAftInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "cateMovePage", "cate_after");
   
    echo $list . "♪" . $paging;

//옵션 일경우
} else if ($select_el == "opt") {
  
    $fields = array();
    $fields[0] = "prdt_opt_seqno";
    $fields[1] = "opt_name";
    $fields[2] = "depth1";
    $fields[3] = "depth2";
    $fields[4] = "depth3";

    $opt_rs = $prdtItemRegiDAO->selectOptInfo($conn, "SEQ", $param);
    $list = makeOptListHtml($opt_rs, $param, $fields, $select_el);
  
    $count_rs = $prdtItemRegiDAO->selectOptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage", "opt");
   
    echo $list . "♪" . $paging;

//구성아이템 옵션 일경우
} else if ($select_el == "cate_opt") {
  
    $param["opt_name"] = $select_name;
    $param["basic_yn"] = $select_sort;

    $fields = array();
    $fields[0] = "cate_opt_seqno";
    $fields[1] = "opt_name";
    $fields[2] = "depth1";
    $fields[3] = "depth2";
    $fields[4] = "depth3";
    $fields[5] = "basic_yn";

    $opt_rs = $prdtItemRegiDAO->selectCateOptInfo($conn, "SEQ", $param);
    $list = makeOptListHtml($opt_rs, $param, $fields, $select_el, TRUE);
  
    $count_rs = $prdtItemRegiDAO->selectCateOptInfo($conn, "COUNT", $param);
    $rsCount = $count_rs->fields["cnt"];

    $paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "cateMovePage", "cate_opt");
   
    echo $list . "♪" . $paging;
}

$conn->close();
?>
