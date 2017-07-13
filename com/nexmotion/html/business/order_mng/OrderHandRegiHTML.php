<?
/**
 * @brief 상품종이 리스트 HTML
 */
function makeMemberListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width75\" onclick=\"webLogin('%s')\">웹로그인</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["group_name"],
                $rs->fields["office_nick"],
                $rs->fields["member_name"],
                $rs->fields["member_id"],
                $rs->fields["tel_num"],
                $rs->fields["cell_num"],
                $rs->fields["member_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
