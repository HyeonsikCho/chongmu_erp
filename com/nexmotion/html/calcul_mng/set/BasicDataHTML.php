<?
/* 
 * 계정 list 생성 
 * $result : $result->fields["acc_subject"] = "계정과목" 
 * $result : $result->fields["acc_detail"] = "계정상세" 
 * $result : $result->fields["note"] = "메모" 
 * 
 * return : list
 */
function makeAccList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $acc = $result->fields["acc_subject"];
        $acc_detail = $result->fields["acc_detail"];
        $note = $result->fields["note"];
        $acc_seqno = $result->fields["acc_subject_seqno"];
        $acc_detail_seqno = $result->fields["acc_detail_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button onclick=\"editAccDetail(%d, '%s', '%s', '%s');\" class=\"bgreen btn_pu btn fix_height20 fix_width40\">보기</button></td>";
        $list .= "\n  </tr>";


        $ret .= sprintf($list, $i, $acc, $acc_detail,
                $note, $acc_detail_seqno, $acc_seqno, $acc_detail, $note); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}





?>
