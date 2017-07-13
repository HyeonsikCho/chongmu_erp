<?
/* 
 * 금전출납부 list  생성 
 * $result : $result->fields["name"] = "관리자명" 
 * $result : $result->fields["empl_seqno"] = "직원 일련번호" 
 * $result : $result->fields["empl_id"] = "직원 id" 
 * $result : $result->fields["sell_site"] = "판매 채널" 
 * $result : $result->fields["depar_name"] = "부서명" 
 * $result : $result->fields["high_depar_code"] = "상위 부서 코드" 
 * $result : $result->fields["depar_admin_seqno"] = "부서 관리 일련번호" 
 * 
 * return : list
 */
function makeAccTypeList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $regi_date = $result->fields["regi_date"];
        $evid_date = $result->fields["evid_date"];
        $sumup = $result->fields["sumup"];
        $acc_subject = $result->fields["acc_subject"];
        $acc_detail = $result->fields["detail"];
        $income_price = $result->fields["income_price"];
        $expen_price = $result->fields["expen_price"];

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
        $list .= "\n  </tr>";


        $ret .= sprintf($list, $regi_date, $evid_date, $sumup, $acc_subject,
                $acc_detail, $income_price, $expen_price); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/* 
 * 금전출납부 list  생성 
 * $result : $result->fields["name"] = "관리자명" 
 * $result : $result->fields["empl_seqno"] = "직원 일련번호" 
 * $result : $result->fields["empl_id"] = "직원 id" 
 * $result : $result->fields["sell_site"] = "판매 채널" 
 * $result : $result->fields["depar_name"] = "부서명" 
 * $result : $result->fields["high_depar_code"] = "상위 부서 코드" 
 * $result : $result->fields["depar_admin_seqno"] = "부서 관리 일련번호" 
 * 
 * return : list
 */
function makePathTypeList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $regi_date = $result->fields["regi_date"];
        $evid_date = $result->fields["evid_date"];
        $sumup = $result->fields["sumup"];
        $path = $result->fields["depo_withdraw_path"];
        $depo_detail = $result->fields["depo_withdraw_path_detail"];
        $trsf_income_price = $result->fields["trsf_income_price"];
        $trsf_expen_price = $result->fields["trsf_expen_price"];

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
        $list .= "\n  </tr>";


        $ret .= sprintf($list, $regi_date, $evid_date, $sumup,
                $path, $depo_detail, $trsf_income_price, 
                $trsf_expen_price); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}


?>
