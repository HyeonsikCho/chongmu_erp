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

    //기본후공정 여부가 N일때(추가 후공정일경우)
    if ($after_rs->fields["basic_yn"] === "N") {

        $seq_up_dis = "";
        $seq_down_dis = "";
        if ($after_rs->fields["seq"] == 1) {
            $seq_up_dis = "disabled=\"disabled\"";
        }

        if ($after_rs->fields["seq"] == $maxseq) {
            $seq_down_dis = "disabled=\"disabled\"";
        }

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

echo $after_html;
$conn->close();
?>
