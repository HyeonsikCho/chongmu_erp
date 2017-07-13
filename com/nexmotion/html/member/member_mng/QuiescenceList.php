<?
/**
 * @brief 휴면 대상 회원 리스트 HTML
 */
function makeQuiescenceListHtml($conn, $dao, $rs, $param) {
  
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

        $param = array();
        $param["table"] = "member_cp";
        $param["col"] = "COUNT(member_cp_seqno) AS cp_cnt";
        $param["where"]["member_seqno"] = $rs->fields["member_seqno"];

        $cp_rs = $dao->selectData($conn, $param);

        $rs_html .= sprintf($html, $class, 
                $rs->fields["member_seqno"],
                $rs->fields["member_name"],
                date("Y-m-d", strtotime($rs->fields["first_join_date"])),
                $rs->fields["own_point"],
                $cp_rs->fields["cp_cnt"],
                number_format($rs->fields["prepay_price"]). "원",
                $rs->fields["tel_num"],
                $rs->fields["mail"],
                $rs->fields["cell_num"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
