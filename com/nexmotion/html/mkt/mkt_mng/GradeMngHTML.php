<?
/* 
 * 회원 관리 list 생성 
 * $result : $result->fields["grade_name"] = "등급 이름" 
 * $result : $result->fields["grade_dscr"] = "등급 설명" 
 * $result : $result->fields["sales_start_price"] = "매출 최소 가격" 
 * $result : $result->fields["sales_end_price"] = "매출 최대 가격" 
 * $result : $result->fields["sales_sale_rate"] = "매출 할인 비율" 
 * $result : $result->fields["grade"] = "등급" 
 * $result : $result->fields["sales_give_point"] = "매출 혜택 포인트" 
 * $result : $result->fields["member_grade_policy_seqno"] 
 *                                          = "회원 등급 정책 일련번호" 
 * 
 * return : list
 */
function makeGradeMngList($result) {

    $ret = "";

    $i = 1;

    while ($result && !$result->EOF) {

        $name = $result->fields["grade_name"];
        $grade = $result->fields["grade"];
        $start_price = $result->fields["sales_start_price"];
        $end_price = $result->fields["sales_end_price"];
        $sale_rate = $result->fields["sales_sale_rate"];
        $give_point = $result->fields["sales_give_point"];
        $dsrc = $result->fields["grade_dscr"];
        $grade_seqno = $result->fields["member_grade_policy_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <input type=\"hidden\" name=\"grade_set%d\" value=\"%d\">";
        $list .= "\n    <td><input type=\"text\" name=\"grade_name%d\" class=\"input_co2 fix_width75\" value=\"%s\"></td>";
        $list .= "\n    <td><input type=\"text\" class=\"input_co2 fix_width20\" value=\"%s\" disabled></td>";
        $list .= "\n    <td><input type=\"text\" name=\"start_price%d\" class=\"input_co2 fix_width100\" value=\"%d\"> ~ ";
        $list .= "\n    <input type=\"text\" name=\"end_price%d\" class=\"input_co2 fix_width100\" value=\"%d\"></td>";
        $list .= "\n    <td><input type=\"text\" name=\"sale_rate%d\" class=\"input_co2 fix_width40\" value=\"%s\">%%</td>";
        $list .= "\n    <td><input type=\"text\" name=\"give_point%d\" class=\"input_co2 fix_width40\" value=\"%s\">P</td>";
        $list .= "\n    <td><input type=\"text\" name=\"dscr%d\" class=\"input_co2 fix_width400\" value=\"%s\"></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, 
                        $grade_seqno, $grade_seqno, $grade_seqno, $name, 
                        $grade, $grade_seqno, $start_price,
                        $grade_seqno, $end_price, $grade_seqno, $sale_rate, 
                        $grade_seqno, $give_point, $grade_seqno, $dsrc); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}

/* 
 * 날짜 list 생성 
 * $select_day : 선택된 날짜
 * 
 * return : list
 */
function makeDaySelectList($select_day) {

    for ($i=1; $i<32; $i++) {

        $selected = "";
        //선택된 날짜가 같으면
        if ($i == $select_day) {
            
            $selected = "selected=\"selected\"";
        }
    
        $html = "\n            <option value=\"%d\" %s>%d</option>";

        $ret .= sprintf($html, $i, $selected, $i);
    }

    return $ret;
}
?>
