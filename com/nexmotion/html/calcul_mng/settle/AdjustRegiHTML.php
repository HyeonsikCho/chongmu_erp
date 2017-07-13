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

        $cont = $result->fields["cont"];
        $deal_date = $result->fields["deal_date"];
        $price = $result->fields["price"];
        $dvs = $result->fields["dvs"];
        $dvs_detail = $result->fields["dvs_detail"];
        $adjust_seqno = $result->fields["adjust_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td class='tar'>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button class=\"bgreen btn_pu btn fix_height20";
        $list .= "\n fix_width40\" onclick=\"loadAdjustDetail('%s', '%s',";
        $list .= "\n '%s', '%s', '%s')\">보기</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $deal_date, $cont, $price,
                $dvs . "-" . $dvs_detail, $cont, $dvs,
                $dvs_detail, $deal_date, $price); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}


?>
