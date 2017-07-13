<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/dataproc_mng/set/MtraDscrMngDOC.php");

/* 
 * 종이 설명 list  생성 
 * $result : $result->fields["name"] = "종이명" 
 * $result : $result->fields["dvs"] = "구분" 
 * $result : $result->fields["paper_sense"] = "느낌" 
 * $result : $result->fields["paper_dscr_seqno"] = "종이 설명 일련번호" 
 * 
 * return : list
 */
function makePaperDscrList($conn, $result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $dvs = $result->fields["dvs"];
        $sense = $result->fields["paper_sense"];
        $paper_dscr_seqno = $result->fields["paper_dscr_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>"; 
        $list .= "\n    <td><button type=\"button\" onclick=\"popPaperDscr(%d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">수정</button></td>";

        $ret .= sprintf($list, $i, $name, $dvs, $sense, $paper_dscr_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/* 
 * 후공정 설명 list  생성 
 * $result : $result->fields["name"] = "후공정명" 
 * $result : $result->fields["dscr"] = "설명" 
 * $result : $result->fields["after_dscr_seqno"] = "후공정 설명 일련번호" 
 * 
 * return : list
 */
function makeAfterDscrList($conn, $result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $dscr = $result->fields["dscr"];
        $after_dscr_seqno = $result->fields["after_dscr_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>"; 
        $list .= "\n    <td><button type=\"button\" onclick=\"popAfterDscr(%d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">수정</button></td>";

        $ret .= sprintf($list, $i, $name, $dscr, $after_dscr_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/* 
 * 옵션 설명 list  생성 
 * $result : $result->fields["name"] = "옵션명" 
 * $result : $result->fields["dscr"] = "설명" 
 * $result : $result->fields["opt_dscr_seqno"] = "옵션 설명 일련번호" 
 * 
 * return : list
 */
function makeOptDscrList($conn, $result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $dscr = $result->fields["dscr"];
        $opt_dscr_seqno = $result->fields["opt_dscr_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>"; 
        $list .= "\n    <td><button type=\"button\" onclick=\"popOptDscr(%d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">수정</button></td>";

        $ret .= sprintf($list, $i, $name, $dscr, $opt_dscr_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}





?>
