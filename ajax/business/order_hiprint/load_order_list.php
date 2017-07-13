<?
/********************************************************************
***** 프로 젝트 : 총무팀
***** 개  발  자 : 조현식
***** 수  정  일 : 2016.05.25
********************************************************************/

/********************************************************************
***** 라이브러리 인클루드
********************************************************************/

include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/order_status.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderCommonMngDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/pageLib.php');
header('Content-Type: application/json');


/********************************************************************
***** 클래스 선언
********************************************************************/

$connectionpool = new connectionpool();
$conn = $connectionpool->getpooledconnection();
$fb = new formbean();
$dao = new ordercommonmngdao();
$util = new erpcommonutil();


/********************************************************************
***** form변수 가져오기
********************************************************************/

$tab_dvs    = $fb->form("tab_dvs");                 //memb
$list_size  = intval($fb->form("list_size"));       //30
$sell_site     = $fb->form("sell_site");            //1
$cate_sortcode = $fb->form("cate_sortcode");        //001001001
$office_nick   = $fb->form("office_nick");          //디프린팅테스트
$depar_code    = $fb->form("depar_code");           //
$from_date     = $fb->form("from_date");            //2016-03-01
$from_time     = $fb->form("from_time");            //0
$to_date       = $fb->form("to_date");              //2016-03-27
$to_time       = $fb->form("to_time");              //12
$status        = $fb->form("status");               //
$status_proc   = $fb->form("status_proc");          //
//한페이지에 출력할 게시물 갯수
$list_num = $fb->form("listSize");

//리스트 보여주는 갯수 설정
if ($list_size <= 0) {
    $list_size = 20;
}
//$conn->debug = 1;
//현재 페이지
$page = intval($fb->form("page"));

// 페이지가 없으면 1 페이지
if ($page <= 0) {
    $page = 1;
}

//블록 갯수
$scrnum = 5;
$s_num = $list_num * ($page-1);

$from = "";
if ($from_date !== "") {
    $from = sprintf("%s %s:00:00", $from_date, $from_time);
}
$to   = "";
if ($to_date !== "") {
    $to = sprintf("%s %s:59:59", $to_date, $to_time);
}


/********************************************************************
***** 쿼리에 이용할 파라미터 선언
********************************************************************/


$param = array();
$param["sell_site"]     = 1;                //주총은 1로 fix
$param["cate_sortcode"] = $cate_sortcode;
$param["office_nick"]   = $office_nick;
$param["depar_code"]    = $depar_code;      //주총에서 사용안함
$param["from"]          = $from;
$param["to"]            = $to;
$param["state"]         = $status;          //사용안함

$param["page"]      = $page;
$param["list_size"] = $list_size;

$param["dvs"] = "COUNT";
$param["limit_from"] = intval($list_size * ($page-1));


/********************************************************************
***** 페이지리스트 불러오기
********************************************************************/

$count_rs = $dao->selectOrderListCond($conn, $param);;        //페이지 리스트

$rsCount = $count_rs->fields["cnt"];  // 게시물 수

$paging = mkDotAjaxPage($rsCount, $page, $scrnum, $list_size, "movePage"); // 페이징처리 html
$html = getOrderListHtml($conn, $dao, $util, $tab_dvs, $param); // 페이지 리스트 html문으로

if ($html === false) {
    goto NOT_INFO;
}

//차후 부하 걸릴 시 삭제 해야 될 소스
//$total = "● 총 건수 : " . $count_rs->fields["cnt"] ."건 &nbsp;&nbsp; 총 주문금액 : " . $t_sum . "원";

$rtval['html'] = $html;
$rtval['paging'] = $paging;


echo json_encode($rtval);

$conn->Close();
exit;

NOT_INFO:
    $conn->Close();
	$rtval['html'] = "<tr><td colspan=\"10\">검색된 내용이 없습니다.</td></tr>";
	$rtval['paging'] = $paging;
    echo json_encode($rtval);
    exit;

/*******************************************************************************
                                 함수 영역
 ******************************************************************************/

/**
 * @brief 주문 상태에 따란 코드값 반환
 *
 * @param $status      = 상태값
 * @param $status_proc = 상태진행값
 *
 * @return 상태진행 코드값 배열
 */
function getOrderStatus($status, $status_proc) {
    if ($status === '') {
        return '';
    }

    if ($status_proc !== '') {
        return $status_proc;
    }

    $proc_arr = OrderStatus::STATUS_PROC[$status];
    $temp_arr = array();
    $i = 0;
    foreach ($proc_arr as $status => $code) {
        $temp_arr[$i++] = $code;
    }

    return $temp_arr;
}

/**
 * @brief 회원별 검색일 때는 판매채널을 제외한 조건
 * 팀 별 검색일 때는 모든 검색조건 중 하나라도 넘어온 경우에는
 * 검색조건 쿼리, 빈 조건일 경우에는 대용량 쿼리로 구분지어서
 * 실행하는 함수
 *
 * @param $conn  = connection identifier
 * @param $dao   = 쿼리를 수행할 dao객체
 * @param $util  = 유틸 객체
 * @param $param = 검색조건 파라미터
 *
 * @return 주문리스트 html
 */
function getOrderListHtml($conn, $dao, $util, $tab_dvs, $param) {
    $ret = "";
    $flag = false;

    $list_size = $param["list_size"];
    $page      = $param["page"];

    // 이하 검색조건 값이 하나라도 있는경우 무조건
    // 일반검색 쿼리로 실행하기 위한 조건문들
    if ($dao->blankParameterCheck($param ,"state")) {
        $flag = true;
    }
    if ($dao->blankParameterCheck($param ,"from")) {
        $flag = true;
    }
    if ($dao->blankParameterCheck($param ,"to")) {
        $flag = true;
    }

    if ($tab_dvs === "memb") {
        if ($dao->blankParameterCheck($param ,"cate_sortcode")) {
            $flag = true;
        }
        if ($dao->blankParameterCheck($param ,"office_nick")) {
            $flag = true;
        }
    } else {
        if ($dao->blankParameterCheck($param ,"depar_code")) {
            $flag = true;
        }
    }

    if ($flag === true) {
        // 페이징 계산
        $param["limit_block"] = $list_size * ($page - 1);

        $ret = $dao->selectOrderListCondHtml($conn, $param);
    } else {
        // seqno 범위 계산
        $last_seqno = $dao->selectLastOrderSeqno($conn);

        $seqno_range = $util->calcSeqnoRange($last_seqno,
                                             $list_size,
                                             $page);
        if ($seqno_range === false) {
            return false;
        }

        $param["start_seqno"] = $seqno_range["start"];
        $param["end_seqno"]   = $seqno_range["end"];

        $ret = $dao->selectOrderListHtml($conn, $param);
    }

    return $ret;
}
?>
