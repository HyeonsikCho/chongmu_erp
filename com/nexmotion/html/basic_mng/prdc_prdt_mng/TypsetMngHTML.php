<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/prdc_prdt_mng/TypsetListDOC.php");
/* 
 * 조판 품목 list grid 생성 
 * $result : $result->fields["name"] = "조판 이름" 
 * $result : $result->fields["affil"] = "계열" 
 * $result : $result->fields["subpaper"] = "절수" 
 * $result : $result->fields["wid_size"] = "가로 사이즈" 
 * $result : $result->fields["vert_size"] = "세로 사이즈" 
 * $result : $result->fields["dscr"] = "조판 설명" 
 * $result : $result->fields["typset_format_seqno"] = "조판 일련번호" 
 * $result : $result->fields["file_path"] = "파일 경로" 
 * $result : $result->fields["origin_file_name"] = "원본 파일이름" 
 * $result : $result->fields["size"] = "사이즈" 
 * $result : $result->fields["ext"] = "확장자" 
 * $result : $result->fields["typset_format_file_seqno"] = "파일 일련번호" 

 * 
 * return : list
 */
function makeTypsetList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $affil = $result->fields["affil"];
        $subpaper = $result->fields["subpaper"];
        $wid_size = $result->fields["wid_size"];
        $vert_size = $result->fields["vert_size"];
        $dscr = $result->fields["dscr"];
        $typset_seqno = $result->fields["typset_format_seqno"];
        //$file_path = $result->fields["file_path"];
        $origin_file_name = $result->fields["origin_file_name"];
        $process_yn = $result->fields["process_yn"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"typset_chk\" value=\"%d\" type=\"checkbox\"></td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadTypsetInfo(%d)\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $typset_seqno, $name, $affil,
                        $subpaper, $origin_file_name,
                        $wid_size . "*" . $vert_size, $dscr, 
                        $process_yn, $typset_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}

?>

