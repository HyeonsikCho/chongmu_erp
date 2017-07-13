<?
/* 
 * 금전출납부 이체자료 list  생성 
 * $result : $result->fields["regi_date"] = "등록일자" 
 * $result : $result->fields["evid_date"] = "증빙일자" 
 * $result : $result->fields["depo_withdraw_path"] = "입출금경로" 
 * $result : $result->fields["depo_withdraw_path_detail"] = "입출금경로상세" 
 * $result : $result->fields["income_price"] = "수입 금액" 
 * $result : $result->fields["trsf_income_price"] = "이체 수입 금액" 
 * 
 * return : list
 */
function makeIncomeList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $member_name = $result->fields["member_name"];
        $regi_date = $result->fields["regi_date"];
        $evid_date = $result->fields["evid_date"];
        $path = $result->fields["depo_withdraw_path"];
        $path_detail = $result->fields["depo_withdraw_path_detail"];
        $income_price = $result->fields["income_price"];
        $trsf_income_price = $result->fields["trsf_income_price"];

        $price = $income_price;
        if ($price == "") {

            $price = $trsf_income_price;
        }

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
        $list .= "\n  </tr>";


        $ret .= sprintf($list, $member_name, $price, $path,
                $path_detail, $evid_date, $regi_date); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}
?>
