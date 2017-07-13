<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/prdc_prdt_mng/PrintListDOC.php");
/* 
 * 인쇄 품목 list grid 생성 
 * $result : $result->fields["top"] = "인쇄 대분류" 
 * $result : $result->fields["name"] = "인쇄명" 
 * $result : $result->fields["affil"] = "계열" 
 * $result : $result->fields["board"] = "면" 
 * $result : $result->fields["wid_size"] = "가로 사이즈" 
 * $result : $result->fields["vert_size"] = "세로 사이즈" 
 * $result : $result->fields["crtr_unit"] = "기준 단위" 
 * $result : $result->fields["output_seqno"] = "출력 일련번호" 
 * $result : $result->fields["brand"] = "브랜드" 
 * $result : $result->fields["manu_name"] = "제조사" 
 * 
 * return : list
 */
function makePrdcPrintList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $top = $result->fields["top"];
        $affil = $result->fields["affil"];
        $name = $result->fields["name"];
        $crtr_tmpt = $result->fields["crtr_tmpt"];
        $wid_size = $result->fields["wid_size"];
        $vert_size = $result->fields["vert_size"];
        $amt = $result->fields["amt"];
        $crtr_unit = $result->fields["crtr_unit"];
        $brand = $result->fields["brand"];
        $manu_name = $result->fields["manu_name"];
        $print_seqno = $result->fields["print_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"print_chk\" value=\"%d\" type=\"checkbox\"></td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadPrintInfo(%d)\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $print_seqno, $manu_name, $brand,
                        $top, $name, $affil, $crtr_tmpt,
                        $wid_size, $vert_size, 
                        $amt, $crtr_unit, $print_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}
?>
