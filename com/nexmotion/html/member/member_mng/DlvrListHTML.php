<?

/**
 * @brief 옵션 html 생성
 *
 * @param $rs   = 검색결과
 * @param $arr["flag"]  = "기본 값 존재여부"
 * @param $arr["def"]  = "기본 값(ex:전체)"
 * @param $arr["def_val"]  = "기본 값의 option value"
 * @param $arr["val"]  = "option value에 들어갈 필드 값"
 *
 */
function makeNullExceptOptionHtml($rs, $arr) {

    if ($arr["flag"] == "Y") {

        $html = "\n  <option value=\"" . $arr["def_val"] . "\">" . $arr["def"] . "</option>";


    } else {
        $html = "";
    }

    while ($rs && !$rs->EOF) {

        $fields = $rs->fields[$arr["dvs"]]; 

        //만약 $val 빈값이면
        if ($arr["val"] === "" || $arr["val"] === NULL) {
            $value = $fields;
        } else {
			$value = $rs->fields[$arr["val"]];
        }

        if ($fields != "") {

            $html .= "\n  <option value=\"" . $value . "\">" . $fields . "</option>";
        }


        $rs->MoveNext();
    }

    return $html;
}

/**
 * @brief 읍/면/동 옵션 html 생성
 *
 * @param $rs   = 검색결과
 *
 */
function makeDoroDongOptionHtml($rs, $doro_yn) {


    if ($doro_yn == "Y") {

        $html = "\n  <option value=\"\">-도로명-</option>";

    } else {

        $html = "\n  <option value=\"\">-읍/면/동-</option>";

    }

    $i = 0;
    $arr = array();
    while ($rs && !$rs->EOF) {
        
        //도로명 주소 일때
        if ($doro_yn == "Y") {

            $fields = $rs->fields["doro"]; 

            if ($fields != "") {

                $html .= "\n  <option value=\"" . $fields . "\">" . $fields . "</option>";
            }

        //지번 주소일때
        } else {

            //읍
            if ($rs->fields["eup"]) {

                $fields = $rs->fields["eup"];

            //동
            } else {

                $fields = $rs->fields["dong"];

            }

            if ($fields != "") {

                $arr[$i] = $fields;
                $check = 0;

                //배열 안에 같은 필드가 있나 체크
                for($j = 0; $j < count($arr); $j++) {

                    if ($arr[$j] == $fields) {

                        $check = 1;

                    }
                }

                //없으면 추가
                if ($check == 0) {

                    $html .= "\n  <option value=\"" . $fields . "\">" . $fields . "</option>";
                }
            }

        }

        $rs->MoveNext();

        $i++;
    }

    return $html;
}



/*
 * 배송 친구 list html 생성
 * $result : SQL Result 
 *
 * return : html list
 */
function makeDlvrFriend($result) {

    $ret = "";
    $i=1;

    while ($result && !$result->EOF) {

        $regi_date = $result->fields["regi_date"];
        $addr = $result->fields["addr"];
        $addr_detail = $result->fields["addr_detail"];
        $tel_num = $result->fields["tel_num"];
        $nick = $result->fields["office_nick"];
        $main_yn = $result->fields["dlvr_friend_main"];

        //메인 여부
        if ($main_yn == "Y") {

            $type="Main";

        } else {

            $type="Sub";

        }

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td><button onclick=\"popMemberPage();\" class=\"green btn_pu btn fix_height20 fix_width40\">view</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $regi_date, $type, $nick
                       ,$addr . " " . $addr_detail, $tel_num
                       ,"1");

        $result->moveNext();
        $i++;
    }

    return $ret; 
}

/*
 * 배송 친구 메인 요청 list html 생성
 * $result : SQL Result 
 *
 * return : html list
 */
function makeMainReqList($result) {

    $ret = "";
    $i=1;

    while ($result && !$result->EOF) {

        $seqno = $result->fields["member_seqno"];
        $main_seqno = $result->fields["dlvr_friend_main_seqno"];
        $regi_date = $result->fields["regi_date"];
        $addr = $result->fields["addr"];
        $addr_detail = $result->fields["addr_detail"];
        $tel_num = $result->fields["tel_num"];
        $nick = $result->fields["office_nick"];
        $main_yn = $result->fields["dlvr_friend_main"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }

        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td><button onclick=\"popMemberPage();\" class=\"green btn_pu btn fix_height20 fix_width40\">view</button></td>";
        $list .= "\n      <td><button onclick=\"mainReqList(%d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">edit</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $regi_date,  $nick
                       ,$addr . " " . $addr_detail, $tel_num
                       ,$main_seqno);

        $result->moveNext();
        $i++;
    }

    return $ret; 
}

/*
 * 배송 친구 서브 요청 list html 생성
 * $result : SQL Result 
 *
 * return : html list
 */
function makeSubReqList($result) {

    $ret = "";
    $i=1;

    while ($result && !$result->EOF) {

        $sub_date = $result->fields["sub_date"];
        $sub_seqno = $result->fields["dlvr_friend_sub_seqno"];
        $sub_nick = $result->fields["sub_nick"];
        $sub_addr = $result->fields["sub_addr"];
        $sub_detail = $result->fields["sub_detail"];
        $sub_tel = $result->fields["sub_tel"];
        $main_seqno = $result->fields["dlvr_friend_main_seqno"];
        $main_member_seqno = $result->fields["main_member_seqno"];
        $main_nick = $result->fields["main_nick"];
        $main_addr = $result->fields["main_addr"];
        $main_detail = $result->fields["main_detail"];
        $main_tel = $result->fields["main_tel"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td><button onclick=\"popMemberPage();\" class=\"green btn_pu btn fix_height20 fix_width40\">view</button></td>";
        $list .= "\n      <td><button onclick=\"subReqList(%d, %d, %d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">edit</button></button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $sub_date, $sub_nick
                       ,$sub_addr . " " . $sub_detail, $sub_tel, $main_nick
                       ,$main_addr . " " . $main_detail, $main_tel
                       ,$main_member_seqno, $main_seqno, $sub_seqno);

        $result->moveNext();
        $i++;
    }

    return $ret; 
}

/*
 * 배송 친구 메인 요청 list html 생성
 * $result : SQL Result 
 *
 * return : html list
 */
function makeDlvrMainList($result) {

    $ret = "";
    $i=1;

    while ($result && !$result->EOF) {

        $office_nick = $result->fields["office_nick"];
        $addr = $result->fields["addr"];
        $addr_detail = $result->fields["addr_detail"];
        $tel_num = $result->fields["tel_num"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $office_nick, $addr . " " .  $addr_detail
                       ,$tel_num);

        $result->moveNext();
        $i++;
    }

    return $ret; 
}

/*
 * 배송 친구 메인 list html 생성
 * $result : SQL Result 
 *
 * return : html list
 */
function makeDlvrMainSelectList($result, $main_seqno) {

    $ret = "";
    $i=1;

    while ($result && !$result->EOF) {

        $office_nick = $result->fields["office_nick"];
        $member_seqno = $result->fields["member_seqno"];
        $addr = $result->fields["addr"];
        $addr_detail = $result->fields["addr_detail"];
        $tel_num = $result->fields["tel_num"];

        $checked = "";
        if ($main_seqno == $member_seqno) {

            $checked = "checked=\"checked\"";

        } 

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n      <td><input name=\"main_radio\" value=\"%d\" type=\"radio\" %s/></td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n      <td>%s</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $member_seqno, $checked, $office_nick
                       ,$addr . " " .  $addr_detail, $tel_num);

        $result->moveNext();
        $i++;
    }

    return $ret; 
}



?>
