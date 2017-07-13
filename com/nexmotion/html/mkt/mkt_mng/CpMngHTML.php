<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/mkt/mkt_mng/CpListDOC.php");
/* 
 * 쿠폰 list  생성 
 * $result : $result->fields["cp_name"] = "쿠폰명" 
 * $result : $result->fields["unit"] = "할인 단위" 
 * $result : $result->fields["val"] = "할인 되는 값" 
 * $result : $result->fields["max_sale_price"] = "최대 할인 금액" 
 * $result : $result->fields["min_order_price"] = "최소 주문 금액" 
 * $result : $result->fields["regi_date"] = "등록일자" 
 * $result : $result->fields["public_extinct_date"] = "발행 소멸 일자" 
 * $result : $result->fields["object_appoint_yn"] = "대상 지정 방법" 
 * $result : $result->fields["use_yn"] = "사용여부" 
 * $result : $result->fields["cp_seqno"] = "쿠폰 일련번호" 
 * $result : $result->fields["sell_site"] = "판매 사이트" 
 * $result : $result->fields["cpn_admin_seqno"] = "판매 사이트 일련번호" 
 * 
 * return : list
 */
function makeCpList($result) {

    $ret = "";

    $i = 1;

    while ($result && !$result->EOF) {

        $name = $result->fields["cp_name"];
        $unit = $result->fields["unit"];
        $cate_name = $result->fields["cate_name"];

        $cpn_seqno = $result->fields["cpn_admin_seqno"];

        $sale_cont = "";
        //할인요율 할인일때
        if ($unit == "%") {

            $val = $result->fields["val"];
            $max_sale_price = $result->fields["max_sale_price"];

            $sale_cont = $cate_name . "/할인요율 " . $val .
                            "%/최대" . $max_sale_price . "원 할인";
            
        //할익금액 할인일때
        } else {

            $val = $result->fields["val"];
            $min_order_price = $result->fields["min_order_price"];

            $sale_cont = $cate_name . "/할인금액 " . $val . "원" .
                            "/최소" . $min_order_price . "원 이상 구매시";

        }
        $regi_date = $result->fields["regi_date"];
        $extinct_date = $result->fields["public_extinct_date"];
        $object = $result->fields["object_appoint_yn"];
        $object_style = "";

        if ($object == "Y") {
            $object = "지정";
            $object_style = "style=\"margin-left:5px;\"";
        } else {
            $object = "미지정";
            $object_style = "style=\"display:none;\"";
        }

        $use_yn = $result->fields["use_yn"];
        if ($use_yn == "Y") {
            $use_yn = "사용";
        } else {

            $use_yn = "미사용";
        }
        $cp_seqno = $result->fields["cp_seqno"];
        $sell_site = $result->fields["sell_site"];

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
        $list .= "\n    <td>%s</td>";
        $list .= "\n   <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"loadCpDetail(event, %d)\">발행</button><button type=\"button\" %s class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"loadObjectAppoint(event, %d, %d)\">대상</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $sell_site, $name, 
                        $sale_cont, $regi_date, $extinct_date,
                        $object, $use_yn, $cp_seqno, 
                        $object_style, $cp_seqno, $cpn_seqno); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}

/* 
 * 카테고리 중분류 list  생성 
 * $result : $result->fields["cate_name"] = "카테고리명" 
 * $result : $result->fields["sortcode"] = "카테고리 분류코드" 
 * 
 * return : list
 */
function makeCateMidList($result) {

    $ret = "";
    $i = 0;

    while ($result && !$result->EOF) {

        $name = $result->fields["cate_name"];
        $sortcode = $result->fields["sortcode"];

        if ($i == 0 ){

            $list  = "\n   <label class=\"control-label cp\"><input type=\"radio\" class=\"radio_box\" value=\"%s\" name=\"cate_sortcode\">%s</label>
                        <br />";

        } else {

            $list = "\n  <label class=\"fix_width100\"> </label>
                        <label class=\"control-label cp\"><input type=\"radio\" class=\"radio_box\" value=\"%s\" name=\"cate_sortcode\">%s</label>
                        <br />";
        }

        $ret .= sprintf($list, $sortcode, $name); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/* 
 * 멤버 list  생성 
 * $result : $result->fields["cp_name"] = "쿠폰명" 
 * $result : $result->fields["unit"] = "할인 단위" 
 * $result : $result->fields["val"] = "할인 되는 값" 
 * $result : $result->fields["max_sale_price"] = "최대 할인 금액" 
 * $result : $result->fields["min_order_price"] = "최소 주문 금액" 
 * 
 * return : list
 */
function makeMemberInfoList($result) {

    $ret = "";

    $i = 1;

    while ($result && !$result->EOF) {

        $office_nick = $result->fields["office_nick"];
        $grade = $result->fields["grade"];
        $member_typ = $result->fields["member_typ"];
        $cell_num = $result->fields["cell_num"];
        $member_seqno = $result->fields["member_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"member_chk\" value=\"%d@%s\" type=\"checkbox\" class=\"check_box\"></td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $member_seqno, $office_nick, $office_nick, $grade, 
                        $member_typ, $member_typ, $cell_num); 

        $result->moveNext();
        $i++; 
    }

    return $ret;
}


/* 
 * 대상 지정 회원 list  생성 
 * $result : $result->fields["nick"] = "사내 닉네임" 
 * $result : $result->fields["seqno"] = "할인 되는 값" 
 * 
 * return : list
 */
function makeAppointMemberList($result) {

    $ret = "";
    $i = 0;

    while ($result && !$result->EOF) {

        $seqno = $result->fields["member_seqno"];
        $nick = $result->fields["office_nick"];
        $cp_num = $result->fields["cp_num"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td><input name=\"appoint_chk\" value=\"%d@%s\" type=\"checkbox\" class=\"check_box\"></td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $seqno, $nick, $nick, $cp_num);
        
        $result->moveNext();
        $i++; 

    }

    return $ret;
}



?>
