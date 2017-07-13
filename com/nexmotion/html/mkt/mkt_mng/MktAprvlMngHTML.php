<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/mkt/mkt_mng/MktAprvlMngDOC.php");

/* 
 * 마케팅 등급 승인 list  생성 
 * $result : $result->fields["exist_grade"] = "이전 등급" 
 * $result : $result->fields["new_grade"] = "새로운 등급" 
 * $result : $result->fields["req_empl_name"] = "요청 직원 이름" 
 * $result : $result->fields["reason"] = "이유"
 * $result : $result->fields["state"] = "승인 상태"
 * $result : $result->fields["regi_date"] = "신청 일자" 
 * $result : $result->fields["office_nick"] = "사내 닉네임" 
 * $result : $result->fields["member_seqno"] = "회원 일련번호" 
 * $result : $result->fields["grade_req_seqno"] = "등급 요청 일련번호" 
 * 
 * return : list
 */
function makeGradeAprvlList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $exist_grade = $result->fields["exist_grade"];
        $new_grade = $result->fields["new_grade"];
        $req_empl_name = $result->fields["req_empl_name"];
        $reason = $result->fields["reason"];
        $state = $result->fields["state"];
        $office_nick = $result->fields["office_nick"];
        $regi_date = $result->fields["regi_date"];
        $grade_req_seqno = $result->fields["grade_req_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";

        if ($state == 1) {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인대기</button></td>";
        } else if ($state == 2) {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인완료</button></td>";

        } else {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인거절</button></td>";

        }

		$list .= "\n    <td><button type=\"button\" onclick=\"gradeAprvlView(%d);\" class=\"green btn_pu btn fix_height20 fix_width50\">보기</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $office_nick, $regi_date,
                        $exist_grade, $new_grade,
                        $req_empl_name, $reason, $grade_req_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}

/* 
 * 마케팅 포인트 승인 list  생성 
 * $result : $result->fields["point_name"] = "포인트명" 
 * $result : $result->fields["point"] = "포인트" 
 * $result : $result->fields["req_empl_name"] = "요청 직원 이름" 
 * $result : $result->fields["reason"] = "이유"
 * $result : $result->fields["state"] = "승인 상태"
 * $result : $result->fields["regi_date"] = "신청 일자" 
 * $result : $result->fields["office_nick"] = "사내 닉네임" 
 * $result : $result->fields["member_seqno"] = "회원 일련번호" 
 * $result : $result->fields["member_point_req_seqno"] = "포인트 요청 일련번호" 
 * 
 * return : list
 */
function makePointAprvlList($conn, $result, $list_count) {

    $ret = "";

    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $point_name = $result->fields["point_name"];
        $point = $result->fields["point"];
        $req_empl_name = $result->fields["req_empl_name"];
        $reason = $result->fields["reason"];
        $state = $result->fields["state"];
        $office_nick = $result->fields["office_nick"];
        $regi_date = $result->fields["regi_date"];
        $point_req_seqno = $result->fields["member_point_req_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";

        if ($state == 1) {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인대기</button></td>";
        } else if ($state == 2) {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인완료</button></td>";

        } else {

		    $list .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width55\">승인거절</button></td>";

        }

		$list .= "\n    <td><button type=\"button\" onclick=\"pointAprvlView(%d);\" class=\"green btn_pu btn fix_height20 fix_width50\">보기</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $office_nick, $regi_date,
                        $point_name, $point,
                        $req_empl_name, $reason, $point_req_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}



?>
