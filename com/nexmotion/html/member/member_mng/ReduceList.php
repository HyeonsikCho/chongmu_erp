<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ErpCommonUtil.php');

/**
 * @brief 정리화원리스트 HTML
 */
function makeReduceListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"chk\" value=\"%s\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"showMemberDetail('%s');\">보기</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }
 
        $rs_html .= sprintf($html, $class, 
                $rs->fields["member_seqno"],
                $rs->fields["withdraw_dvs"],
                $rs->fields["member_name"],
                number_format($rs->fields["prepay_price"]) . "원",
                $rs->fields["reason"],
                date("Y-m-d", strtotime($rs->fields["withdraw_date"])),
                $rs->fields["member_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
