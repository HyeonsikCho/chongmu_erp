<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/prdc_prdt_mng/OutputListDOC.php");
/* 
 * 출력 품목 list grid 생성 
 * $result : $result->fields["top"] = "출력 대분류" 
 * $result : $result->fields["name"] = "출력명" 
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
function makePrdcOutputList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $top = $result->fields["top"];
        $affil = $result->fields["affil"];
        $name = $result->fields["name"];
        $board = $result->fields["board"];
        $wid_size = $result->fields["wid_size"];
        $vert_size = $result->fields["vert_size"];
        $amt = $result->fields["amt"];
        $crtr_unit = $result->fields["crtr_unit"];
        $brand = $result->fields["brand"];
        $manu_name = $result->fields["manu_name"];
        $output_seqno = $result->fields["output_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"output_chk\" value=\"%d\" type=\"checkbox\"></td>";
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
        $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadOutputInfo(%d)\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $output_seqno, $manu_name, $brand,
                        $top, $name, $affil, $board,
                        $wid_size, $vert_size, 
                        $amt, $crtr_unit, $output_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}
?>
