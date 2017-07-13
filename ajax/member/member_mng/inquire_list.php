<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/InquireMngDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/pageLib.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$InquireMngDAO = new InquireMngDAO();

//한페이지에 출력할 게시물 갯수
$list_num = $fb->form("showPage"); 

//현재 페이지
$page = $fb->form("page");

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
$param["depar_code"] = $fb->form("depar_code");
$param["office_nick"] = $fb->form("office_nick");
$param["search_cnd"] = $fb->form("search_cnd");
$param["from"] = $from;
$param["to"] = $to;
$param["answ_yn"] = $fb->form("answ_yn");

$info_arr = array();

        
if ($param["search_cnd"] === "regi_date") { 

$rs = $InquireMngDAO->selectInquireList($conn, "SEQ", $param);
$i = 0;
while ($rs && !$rs->EOF) {
    // 1:1 문의 정보
    
    $seqno       = $rs->fields["oto_inq_seqno"];
    $regi_date   = $rs->fields["regi_date"];
    $office_nick = $rs->fields["office_nick"];
    $inq_typ     = $rs->fields["inq_typ"];
    $title       = $rs->fields["title"];
  
    print_r($param);

    if ($rs->fields["answ_yn"] == "Y") {
        $answ_yn     = "답변완료";
    } else if ($rs->fields["answ_yn"] == "N") {
        $answ_yn     = "문의"; 
    } 
    
    // 1:1 문의 답변 정보
    $rs2 = $InquireMngDAO->otoRepl($conn, $seqno);
    $repl_regi_date = $rs2->fields["regi_date"];
    $repl_name = $rs2->fields["name"];
    
    $rs->MoveNext();

    $info_arr[$i]["seqno"] = $seqno;
    $info_arr[$i]["regi_date"] = $regi_date;
    $info_arr[$i]["office_nick"] = $office_nick;
    $info_arr[$i]["inq_typ"] = $inq_typ;
    $info_arr[$i]["title"] = $title;
    $info_arr[$i]["answ_yn"] = $answ_yn;
    $info_arr[$i]["repl_regi_date"] = $repl_regi_date;
    $info_arr[$i++]["repl_name"] = $repl_name;
    }
$list = makeInquireListHtml($conn, $info_arr);

$count_rs = $InquireMngDAO->selectInquireList($conn, "COUNT", $param);
$rsCount = $count_rs->fields["cnt"];

}

if ($param["search_cnd"] === "repl_regi_date") {

$rs = $InquireMngDAO->selectInquireList2($conn, "SEQ", $param);
$i = 0;
while ($rs && !$rs->EOF) {
     // 1:1 문의 정보
    $seqno       = $rs->fields["oto_inq_seqno"];
    $regi_date   = $rs->fields["regi_date"];
    $office_nick = $rs->fields["office_nick"];
    $inq_typ     = $rs->fields["inq_typ"];
    $title       = $rs->fields["title"];
    $answ_yn     = $rs->fields["answ_yn"];
 
    if ($rs->fields["answ_yn"] == "Y") {
        $answ_yn     = "답변완료";
    } else if ($rs->fields["answ_yn"] == "N") {
        $answ_yn     = "문의"; 
    } 
   
    // 1:1 문의 답변 정보
    $rs2 = $InquireMngDAO->otoRepl($conn, $seqno);
    $repl_regi_date = $rs2->fields["regi_date"];
    $repl_name = $rs2->fields["name"];
    
    $rs->MoveNext();

    $info_arr[$i]["seqno"] = $seqno;
    $info_arr[$i]["regi_date"] = $regi_date;
    $info_arr[$i]["office_nick"] = $office_nick;
    $info_arr[$i]["inq_typ"] = $inq_typ;
    $info_arr[$i]["title"] = $title;
    $info_arr[$i]["answ_yn"] = $answ_yn;
    $info_arr[$i]["repl_regi_date"] = $repl_regi_date;
    $info_arr[$i++]["repl_name"] = $repl_name;
    }
$list = makeInquireListHtml($conn, $info_arr);

$count_rs = $InquireMngDAO->selectInquireList2($conn, "COUNT", $param);
$rsCount = $count_rs->fields["cnt"];

}

$paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_num, "movePage");
$total = "검색결과 ▶ 총 1:1문의 수" . $rsCount . "개.";
echo $list . "♪" . $paging . "♪" . $total;
$conn->close();
?>
