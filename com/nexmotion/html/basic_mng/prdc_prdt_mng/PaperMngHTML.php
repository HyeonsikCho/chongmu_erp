<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/prdc_prdt_mng/PaperListDOC.php");
/* 
 * 종이 품목 list grid 생성 
 * $result : $result->fields["sort"] = "종이대분류" 
 * $result : $result->fields["affil"] = "계열" 
 * $result : $result->fields["name"] = "종이명" 
 * $result : $result->fields["dvs"] = "구분" 
 * $result : $result->fields["color"] = "색상" 
 * $result : $result->fields["basisweight"] = "평량" 
 * $result : $result->fields["wid_size"] = "가로 사이즈" 
 * $result : $result->fields["vert_size"] = "세로 사이즈" 
 * $result : $result->fields["crtr_unit"] = "기준 단위" 
 * $result : $result->fields["paper_seqno"] = "종이 일련번호" 
 * $result : $result->fields["brand"] = "브랜드" 
 * $result : $result->fields["manu_name"] = "제조사" 
 * 
 * return : list
 */
function makePrdcPaperList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $sort = $result->fields["sort"];
        $affil = $result->fields["affil"];
        $name = $result->fields["name"];
        $dvs = $result->fields["dvs"];
        $color = $result->fields["color"];
        $basisweight = $result->fields["basisweight"];
        $basisweight_unit = $result->fields["basisweight_unit"];
        $wid_size = $result->fields["wid_size"];
        $vert_size = $result->fields["vert_size"];
        $crtr_unit = $result->fields["crtr_unit"];
        $brand = $result->fields["brand"];
        $manu_name = $result->fields["manu_name"];
        $paper_seqno = $result->fields["paper_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"paper_chk\" value=\"%d\" type=\"checkbox\"></td>";
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
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadPaperInfo(%d)\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $paper_seqno, $manu_name, $brand,
                        $sort, $affil, $name, $dvs, $color,
                        $basisweight . $basisweight_unit, $wid_size, $vert_size, 
                        $crtr_unit, $paper_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}
?>
