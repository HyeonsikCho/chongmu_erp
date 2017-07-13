<?
/* 
 * 조정 list  생성 
 * $result : $result->fields["cont"] = "내용" 
 * $result : $result->fields["deal_date"] = "거래일자" 
 * $result : $result->fields["price"] = "금액" 
 * $result : $result->fields["dvs"] = "입력구분" 
 * $result : $result->fields["dvs_detail"] = "입력구분상세" 
 * $result : $result->fields["adjust_seqno"] = "조정 일련번호" 
 * 
 * return : list
 */
function makeAdjustList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $office_nick = $result->fields["office_nick"];
        $deal_date = $result->fields["deal_date"];
        $price = $result->fields["price"];
        $name = $result->fields["name"];
        $cont = $result->fields["cont"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td class='tar'>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $office_nick, $deal_date, $price,
                $name, $cont); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}




?>
