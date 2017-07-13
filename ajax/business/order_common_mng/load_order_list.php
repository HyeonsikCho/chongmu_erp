<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/order_status.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderCommonMngDAO.php");

$connectionpool = new connectionpool();
$conn = $connectionpool->getpooledconnection();

$fb = new formbean();
$dao = new ordercommonmngdao();
$util = new erpcommonutil();

$tab_dvs    = $fb->form("tab_dvs");

$page       = intval($fb->form("page"));
$list_size  = intval($fb->form("list_size"));

$sell_site     = $fb->form("sell_site");
$cate_sortcode = $fb->form("cate_sortcode");
$office_nick   = $fb->form("office_nick");
$depar_code    = $fb->form("depar_code");
$from_date     = $fb->form("from_date");
$from_time     = $fb->form("from_time");
$to_date       = $fb->form("to_date");
$to_time       = $fb->form("to_time");
$status        = $fb->form("status");
$status_proc   = $fb->form("status_proc");

$from = "";
if ($from_date !== "") {
    $from = sprintf("%s %s:00:00", $from_date, $from_time);
}
$to   = "";
if ($to_date !== "") {
    $to = sprintf("%s %s:00:00", $to_date, $to_time);
}

$status = getOrderStatus($status, $status_proc);
if (is_array($status) === true) {
    $status = $dao->parameterArrayEscape($conn, $status);
    $status = $util->arr2delimStr($status);
}

unset($status_arr);

$param = array();
$param["sell_site"]     = $sell_site;
$param["cate_sortcode"] = $cate_sortcode;
$param["office_nick"]   = $office_nick;
$param["depar_code"]    = $depar_code;
$param["from"]          = $from;
$param["to"]            = $to;
$param["state"]         = $status;

$param["page"]      = $page;
$param["list_size"] = $list_size;

$param["dvs"] = "COUNT";
$count_rs = $dao->selectOrderListCond($conn, $param);;

$param["dvs"] = "TOTAL";
$total_rs = $dao->selectOrderListCond($conn, $param);

$t_sum = $total_rs->fields["basic_sum"] + $total_rs->fields["after_sum"] + $total_rs->fields["opt_sum"];

$param["dvs"] = "";
$html = getOrderListHtml($conn, $dao, $util, $tab_dvs, $param);

if ($html === false) {
    goto NOT_INFO;
}

//차후 부하 걸릴 시 삭제 해야 될 소스
$total = "● 총 건수 : " . $count_rs->fields["cnt"] . 
         "건 &nbsp;&nbsp; 총 주문금액 : " . $t_sum . "원";

$html .= "♪" . $total;

$conn->Close();
echo $html;
exit;

NOT_INFO:
    $conn->Close();
    echo "<tr><td colspan=\"10\">검색된 내용이 없습니다.</td></tr>";
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
