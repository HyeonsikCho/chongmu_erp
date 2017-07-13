<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ErpCommonUtil.php');
/**
 * @brief 1:1문의 리스트 HTML
 */
function makeInquireListHtml($conn, $info_arr) {

    //print_r($info_arr);

    if (count($info_arr) === 0) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"showDetail('%s');\">수정</button></td>";
    $html .= "\n  </tr>";

    $info_arr_count = count($info_arr);

    for ($i = 0; $i < $info_arr_count; $i++) {

        $info = $info_arr[$i];

        $class = "";
        if ($i % 2 == 0) {
            $class = "cellbg";
        }

        /*
        $param = array();
        $param["table"] = "member_cp";
        $param["col"] = "COUNT(member_cp_seqno) AS cp_cnt";
        $param["where"]["member_seqno"] = $rs->fields["member_seqno"];

        $cp_rs = $dao->selectData($conn, $param);
        */

        $rs_html .= sprintf($html, $class
                                 , $info["seqno"]
                                 , $info["regi_date"]
                                 , $info["office_nick"]
                                 , $info["inq_typ"]
                                 , $info["title"]
                                 , $info["repl_regi_date"]
                                 , $info["repl_name"]
                                 , $info["answ_yn"]
                                 , $info["seqno"]);
    }

    return $rs_html;
}
?>
