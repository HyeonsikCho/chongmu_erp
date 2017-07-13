<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/produce/receipt_mng/ReceiptListDOC.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/produce/receipt_mng/ReceiptListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new ReceiptListDAO();

$seqno = $fb->form("seqno");
$state = $fb->form("state");

$param = array();
$param["order_common_seqno"] = $seqno;

$rs = $dao->selectReceiptView($conn, $param);

$param = array();
$param["table"] = "order_after_history";
$param["col"] = "max(seq) AS maxseq";
$param["where"]["order_common_seqno"] = $seqno;

$after_rs = $dao->selectData($conn, $param);

$maxseq = $after_rs->fields["maxseq"];

$param = array();
$param["table"] = "order_after_history";
$param["col"] = "basic_yn, after_name, depth1, depth2, depth3, seq, order_after_history_seqno";
$param["where"]["order_common_seqno"] = $seqno;
$param["order"] = "seq ASC";

$after_rs = $dao->selectData($conn, $param);

//후공정 요약 html
$html  = "\n<tr>";
$html .= "\n  <td class=\"fwb\">%s</td>";
$html .= "\n  <td>%s</td>";
$html .= "\n  <td>%s</td>";
$html .= "\n<tr>";
$i = 1;

//추가 후공정일 경우 버튼html
$button_html  = "\n<button class=\"btn btn_pu fix_width40 fix_height20 orge fs11\" onclick=\"getSeqDown('%s', '%s');\" %s>▼</button>";
$button_html .= "\n<button class=\"btn btn_pu fix_width40 fix_height20 orge fs11\" onclick=\"getSeqUp('%s', '%s');\" %s>▲</button>";
$button_html .= "\n<button class=\"bgreen btn_pu btn fix_height20 fix_width40\" onclick=\"getAfterPop('%s', '%s');\">등록</button>";

while ($after_rs && !$after_rs->EOF) {

    $subject = "";
    if ($i === 1) {
        $subject = "후공정";
    }

    $seq_up_dis = "";
    $seq_down_dis = "";
    if ($after_rs->fields["seq"] == 1) {
        $seq_up_dis = "disabled=\"disabled\"";
    }

    if ($after_rs->fields["seq"] == $maxseq) {
        $seq_down_dis = "disabled=\"disabled\"";
    }

    //기본후공정 여부가 N일때(추가 후공정일경우)
    if ($after_rs->fields["basic_yn"] === "N") {
        $button = sprintf($button_html,
                          $seqno,
                          $after_rs->fields["seq"],
                          $seq_down_dis,
                          $seqno,
                          $after_rs->fields["seq"],
                          $seq_up_dis,
                          $seqno,
                          $after_rs->fields["order_after_history_seqno"]);
    }

    $after_name = "";
    if ($after_rs->fields["after_name"]) {
        $after_name .= $after_rs->fields["after_name"];
    }
    if ($after_rs->fields["depth1"]) {
        $after_name .= "-". $after_rs->fields["depth1"];
    }
    if ($after_rs->fields["depth2"]) {
        $after_name .= "-". $after_rs->fields["depth2"];
    }
    if ($after_rs->fields["depth3"]) {
        $after_name .= "-". $after_rs->fields["depth3"];
    }

    $after_html .= sprintf($html, $subject,
                           $after_name,
                           $button);
    $i++;
    $after_rs->moveNext();
}

$stor_release_y = "";
$stor_release_n = "";
if ($rs->fields["stor_release_yn"] === "Y") {
    $stor_release_y = "checked=\"checked\"";
} else {
    $stor_release_n = "checked=\"checked\"";
}

$param = array();
$param["table"] = "order_file";
$param["col"] = "order_file_seqno, origin_file_name";
$param["where"]["order_common_seqno"] = $seqno;

$order_file_rs = $dao->selectData($conn, $param);

$html  = "<label class=\"control-label fix_width75 tar\">원본파일</label>";
$html .= "<label class=\"fix_width20 fs14 tac\">:</label>";
$html .= "<label class=\"control-label\"><a href=\"/common/order_file_down.php?seqno=%s\">%s</a></label><br />";

$html2  = "<label class=\"control-label fix_width96 tar\"></label>";
$html2 .= "<label class=\"control-label\"><a href=\"/common/order_file_down.php?seqno=%s\">%s</a></label><br />";
$i = 1;

$order_file_html  = "<label class=\"control-label fix_width75 tar\">원본파일</label>";
$order_file_html .= "<label class=\"fix_width20 fs14 tac\">:</label><br />";

while ($order_file_rs && !$order_file_rs->EOF) {

    if ($i === 1) {
        $order_file_html  = sprintf($html,
                          $order_file_rs->fileds["order_file_seqno"],
                          $order_file_rs->fileds["origin_file_name"]);
    } else {
        $order_file_html .= sprintf($html2,
                          $order_file_rs->fileds["order_file_seqno"],
                          $order_file_rs->fileds["origin_file_name"]);

    }
    $i++;
    $order_file_rs->moveNext();
}

$param = array();
$param["order_common_seqno"] = $seqno;

$order_dlvr_rs = $dao->selectOrderDlvr($conn, $param);

$param = array();
$param["table"] = "order_opt_history";
$param["col"] = "opt_name";
$param["where"]["order_common_seqno"] = $seqno;

$opt_rs = $dao->selectData($conn, $param);

$opt_name = "";
while ($opt_rs && !$opt_rs->EOF) {

    $opt_name .= " !". $opt_rs->fields["opt_name"];
    $opt_rs->moveNext();
}

$conn->StartTrans();

//차후 옵션명이 명확해지면 수정 해야됨
$order_state = "";
if ($opt_rs->fields["opt_name"] === "교정") {
    $order_state = "330";
} else {
    $order_state = "320";
}

//접수 상태 변경 (중, 교정)
$param = array();
$param["seqno"] = $seqno;
$param["order_state"] = $order_state;
$param["receipt_mng"] = $fb->session("name");

$dao->updateReceipt($conn, $param);

$conn->CompleteTrans();

$param = array();
$param["order_num"] = $rs->fields["order_num"];
$param["member_name"] = $rs->fields["member_name"];
$param["office_nick"] = $rs->fields["office_nick"];
$param["title"] = $rs->fields["title"];
$param["cate_name"] = $rs->fields["cate_name"];
$param["amt"] = $rs->fields["amt"];
$param["amt_unit_dvs"] = $rs->fields["amt_unit_dvs"];
$param["order_detail"] = $rs->fields["order_detail"];
$param["stan_name"] = $rs->fields["stan_name"];
$param["print_tmpt_name"] = $rs->fields["print_tmpt_name"];
$param["after_html"] = $after_html;
$param["stor_release_y"] = $stor_release_y;
$param["stor_release_n"] = $stor_release_n;
$param["memo"] = $rs->fields["memo"];
$param["count"] = $rs->fields["count"];
$param["order_file_html"] = $order_file_html;
$param["order_dlvr"] = $order_dlvr_rs->fields["addr"] . " " . 
                       $order_dlvr_rs->fields["name"];
$param["opt_name"] = $opt_name;
$param["seqno"] = $seqno;
$param["state"] = $state;

echo receiptPopup($param);
$conn->close();
?>
