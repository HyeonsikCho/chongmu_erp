<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/prdc_prdt_mng/OptListDOC.php");
/* 
 * 옵션 품목 list grid 생성 
 * $result : $result->fields["name"] = "옵션명" 
 * $result : $result->fields["depth1"] = "depth1명" 
 * $result : $result->fields["depth2"] = "depth2명" 
 * $result : $result->fields["depth3"] = "depth3명" 
 * $result : $result->fields["amt"] = "수량" 
 * $result : $result->fields["crtr_unit"] = "기준 단위" 
 * $result : $result->fields["opt_seqno"] = "옵션 일련번호" 
 * 
 * return : list
 */
function makePrdcOptList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $depth1 = $result->fields["depth1"];
        $depth2 = $result->fields["depth2"];
        $depth3 = $result->fields["depth3"];
        $amt = $result->fields["amt"];
        $crtr_unit = $result->fields["crtr_unit"];
        $opt_seqno = $result->fields["opt_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"opt_chk\" value=\"%d\" type=\"checkbox\"></td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadOptInfo(%d)\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $opt_seqno,
                        $name, $depth1, $depth2, $depth3,
                        $amt, $crtr_unit, $opt_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}
?>
