<?
/*
 * 검색 list 생성
 *
 * @param $result->fields["manu_name"] = "외부업체 이름"
 * @param $result->fields["extnl_etprs_seqno"] = "외부업체 일련번호"
 *
 * return : list
 */
function makeSearchEtprsList($result, $func) {

    $buff = "";


    while ($result && !$result->EOF) {

        $data = $result->fields["manu_name"]; 
        $data_val = $result->fields["extnl_etprs_seqno"]; 

        $opt_arr[$data_val] = $data; 
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" . $func;
            $buff .= "Click('" . $key . "', '" . $val;
            $buff .= "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}

/*
 * 검색 list 생성
 *
 * @param $result->fields["office_nick"] = "사내 닉네임"
 * @param $result->fields["member_seqno"] = "회원 일련번호"
 *
 * return : list
 */
function makeSearchNickList($result, $func) {

    $buff = "";


    while ($result && !$result->EOF) {

        $data = $result->fields["office_nick"]; 
        $data_val = $result->fields["member_seqno"]; 

        $opt_arr[$data_val] = $data; 
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" . $func;
            $buff .=  "Click('" . $key . "', '" . $val;
            $buff .= "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}

/* 
 * 금전출납부 list  생성 
 * $result : $result->fields["name"] = "관리자명" 
 * $result : $result->fields["empl_seqno"] = "직원 일련번호" 
 * $result : $result->fields["empl_id"] = "직원 id" 
 * $result : $result->fields["sell_site"] = "판매 채널" 
 * 
 * return : list
 */
function makeCashbookList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $cashbook_seqno = $result->fields["cashbook_seqno"];
        $regi_date = $result->fields["regi_date"];
        $evid_date = $result->fields["evid_date"];
        $sumup = $result->fields["sumup"];
        $dvs = $result->fields["dvs"];

        $income_price = $result->fields["income_price"];
        $expen_price = $result->fields["expen_price"];
        $trsf_income_price = $result->fields["trsf_income_price"];
        $trsf_expen_price = $result->fields["trsf_expen_price"];

        $price = "";
        if ($income_price) {

            $price = $income_price;

        } else if ($expen_price) {

            $price = $expen_price;

        } else if ($trsf_income_price) {

            $price = $trsf_income_price;

        } else if ($trsf_expen_price) {

            $price = $trsf_expen_price;

        }

        $depo_path = $result->fields["depo_withdraw_path"];
        $depo_path_detail = $result->fields["depo_withdraw_path_detail"];
        $member_seqno = $result->fields["member_seqno"];
        $member_name = $result->fields["member_name"];
        $manu_seqno = $result->fields["extnl_etprs_seqno"];
        $manu_name = $result->fields["manu_name"];

        $name = "";
        if ($member_name) {

            $name = $member_name;

        } else if ($manu_name) {

            $name = $manu_name;

        }

        $acc_subject = $result->fields["acc_subject"];
        $acc_detail = $result->fields["detail"];
        $acc_subject_seqno = $result->fields["acc_subject_seqno"];
        $acc_detail_seqno = $result->fields["acc_detail_seqno"];
        $cpn_admin_seqno = $result->fields["cpn_admin_seqno"];

        $path = "";
        if ($depo_path != "") {

            $path = $depo_path . "-" . $depo_path_detail;

        }

        $card_cpn = $result->fields["card_cpn"];
        $card_num = $result->fields["card_num"];
        $mip_mon = $result->fields["mip_mon"];
        $aprvl_num = $result->fields["aprvl_num"];
        $aprvl_date = $result->fields["aprvl_date"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }

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
	    $list .= "\n   <td><button onclick=\"editCashbook(%d, %d, '%s', ";
        $list .= "'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',";
        $list .= "'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');\"";
        $list .= "class=\"bgreen btn_pu btn fix_height20 fix_width40\">보기</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $regi_date, $evid_date, $name, $acc_subject, 
                $acc_detail, $sumup, $income_price, $expen_price, 
                $trsf_income_price, $trsf_expen_price, $path,
                $cashbook_seqno, $cpn_admin_seqno, $dvs, $price,
                $sumup, $acc_subject_seqno, $acc_detail_seqno, 
                $regi_date, $evid_date, $depo_path, $depo_path_detail, 
                $member_seqno, $member_name, $manu_seqno, $manu_name,
                $card_cpn, $card_num, $mip_mon, $aprvl_num, $aprvl_date); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

?>
