<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ErpCommonUtil.php');
/**
 * @brief 접수 리스트 HTML
 */
function makeReceiptListHtml($conn, $dao, $rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $util = new ErpCommonUtil();

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s건</td>";
    $html .= "\n    <td>%s%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showReceiptPop('%s', '%s');\" %s>%s</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $param = array();
        $param["table"] = "depar_admin";
        $param["col"] = "depar_name";
        $param["where"]["depar_code"] = $rs->fields["deparcode"];

        $sel_rs = $dao->selectData($conn, $param);

        $order_state = "";
        $btn_dis = "";
        if ($rs->fields["order_state"] == "310") {
            $order_state = "대기";
        } else if ($rs->fields["order_state"] == "410") {
            $order_state = "완료";
            $btn_dis = "disabled=\"disabled\"";
        }
        
        $rs_html .= sprintf($html, $class, 
                $i,
                $sel_rs->fields["depar_name"],
                $rs->fields["order_num"],
                $rs->fields["member_name"],
                $rs->fields["title"],
                $rs->fields["cate_name"],
                $rs->fields["order_detail"],
                $rs->fields["stan_name"],
                $rs->fields["print_tmpt_name"],
                date("Y-m-d", strtotime($rs->fields["order_regi_date"])),
                $rs->fields["count"],
                $rs->fields["amt"],
                $rs->fields["amt_unit_dvs"],
                $rs->fields["order_common_seqno"],
                $rs->fields["order_state"],
                $btn_dis,
                $order_state);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상태변경관리 접수 리스트 HTML
 */
function makeStatusReceiptListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $util = new ErpCommonUtil();

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {
        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $seqno = $rs->fields["order_common_seqno"];
        $button = "";
        if ($rs->fields["order_state"] === "310") {
            $rs_html .= "";
        } else {
            if ($rs->fields["order_state"] === "320") {
                $button = "<button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"changeStatus('$seqno', '310', 'N');\">대기</button>";
            } else if ($rs->fields["order_state"] === "330") {
                $button  = "<button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"changeStatus('$seqno', '340', 'N');\">보류</button>";
                $button .= "\n<button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"changeStatus('$seqno', '410', 'N');\">완료</button>";
            } else if ($rs->fields["order_state"] === "340") {
                $button  = "<button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"changeStatus('$seqno', '310', 'N');\">대기</button>";
                $button .= "\n<button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"changeStatus('$seqno', '410', 'N');\">완료</button>";
            }

            $rs_html .= sprintf($html, $class, 
                    $rs->fields["order_num"],
                    $rs->fields["member_name"],
                    $rs->fields["title"],
                    $rs->fields["cate_name"],
                    $rs->fields["receipt_mng"],
                    $util->statusCode2status($rs->fields["order_state"]),
                    $button);
        }
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
