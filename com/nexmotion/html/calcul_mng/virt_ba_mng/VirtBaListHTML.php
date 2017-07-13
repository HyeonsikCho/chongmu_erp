<?
/*
 * 검색 list 생성
 *
 * @param $result->fields["manu_name"] = "외부업체 이름"
 * @param $result->fields["extnl_etprs_seqno"] = "외부업체 일련번호"
 *
 * return : list
 */
function makeSearchCndList($result, $func) {

    $buff = "";


    while ($result && !$result->EOF) {

        if ($func == "ba") {

            $data = $result->fields["ba_num"]; 
            $data_val = $result->fields["ba_num"]; 

        } else {

            $data = $result->fields["member_name"]; 
            $data_val = $result->fields["member_seqno"]; 

        }

        $opt_arr[$data] = $data_val; 
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" . $func;
            $buff .= "Click('" . $val . "', '" . $key;
            $buff .= "')\"><li>" . $key . "</li></a>";

        }
    }

    return $buff;
}

/* 
 * 가상계좌 list  생성 
 * $result : $result->fields["ba_num"] = "계좌번호" 
 * $result : $result->fields["state"] = "상태" 
 * $result : $result->fields["member_seqno"] = "회원일련번호" 
 * $result : $result->fields["member_name"] = "회원명" 
 * $result : $result->fields["bank_name"] = "은행이름" 
 * $result : $result->fields["ba_seqno"] = "계좌 일련번호" 
 * 
 * return : list
 */
function makeVirtBaList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $ba_num = $result->fields["ba_num"];
        $state = $result->fields["state"];
        $bank_name = $result->fields["bank_name"];
        $member_seqno = $result->fields["member_seqno"];
        $member_name = $result->fields["member_name"];
        $ba_seqno = $result->fields["virt_ba_admin_seqno"];
        $cpn_admin_seqno = $result->fields["cpn_admin_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button onclick=\"loadVirtBaDetail";
        $list .= "(%d, %d, '%s','%s', '%s', '%s')\" class=\"bgreen btn_pu btn";
        $list .= " fix_height20 fix_width40\">수정</button>";
        $list .= " <button onclick=\"removeMemberVirtBa(%d)\"";
        $list .= " class=\"bgreen btn_pu btn fix_height20 fix_width40\">";
        $list .= "삭제</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $bank_name, $member_name, $ba_num, 
                        $ba_seqno, $cpn_admin_seqno, $bank_name, 
                        $member_seqno, $member_name, $ba_num, $ba_seqno);

        $result->moveNext();
        $i++;
    }

    return $ret;
}


?>
