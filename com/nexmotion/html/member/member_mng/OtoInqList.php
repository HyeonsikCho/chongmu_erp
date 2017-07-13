<?
/**
 * @brief 1:1문의 리스트 HTML
 */
function makeOtoInquireListHtml($rs, $param) {

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
    $html .= "\n    <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"getInq.exec('%s');\">수정</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $answ_yn = "";
        if ($rs->fields["answ_yn"] == "Y") {
            $answ_yn = "답변완료";
        } else {
            $answ_yn = "답변대기";
        }

        $inq_date = "";
        if ($rs->fields["inq_date"]) {
            $inq_date = date("Y-m-d", strtotime($rs->fields["inq_date"]));
        }

        $reply_date = "";
        if ($rs->fields["reply_date"]) {
            $reply_date = date("Y-m-d", strtotime($rs->fields["reply_date"]));
        }

        $rs_html .= sprintf($html, $class,
                $i,
                $inq_date,
                $rs->fields["user_nm"],
                $rs->fields["inq_typ"],
                $rs->fields["title"],
                $reply_date,
                $rs->fields["name"],
                $answ_yn,
                $rs->fields["oto_inq_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
