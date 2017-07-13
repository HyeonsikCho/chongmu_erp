<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ErpCommonUtil.php');

/**
 * @brief 회원 통합리스트 HTML
 */
function makeMemberCommonListHtml($conn, $dao, $rs, $param) {
  
    if (!$rs) {
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
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"showDetail('%s');\">보기</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $param = array();
        $param["table"] = "member_grade_policy";
        $param["col"] = "grade_name";
        $param["where"]["grade"] = $rs->fields["grade"];

        $sel_rs = $dao->selectData($conn, $param);

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["member_name"],
                $rs->fields["nick"],
                $rs->fields["tel_num"],
                $rs->fields["member_typ"],
                $sel_rs->fields["grade_name"],
                $rs->fields["office_member_grade"],
                date("Y-m-d", strtotime($rs->fields["first_join_date"])),
                date("Y-m-d", strtotime($rs->fields["final_order_date"])),
                date("Y-m-d", strtotime($rs->fields["final_login_date"])),
                $rs->fields["member_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원명 검색 팝업 리스트 HTML
 */
function makePopMemberNameListHtml($rs) {
  
    if (!$rs) {
        return false;
    }

    $rs_html  = "\n  <ul style=\"ofh\">";
    $html .= "\n    <li onclick=\"selectResult('%s');\" style=\"cursor: pointer;\">%s(%s)</li>";

    while ($rs && !$rs->EOF) {

        $rs_html .= sprintf($html,
                $rs->fields["office_nick"],
                $rs->fields["office_nick"],
                $rs->fields["member_name"]);
        $rs->moveNext();
    }

    $rs_html .= "\n  </ul>";

    return $rs_html;
}

/**
 * @brief 회원 정보 담당자 리스트 HTML
 */
function makeMemberMngDetailHtml($rs) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["member_name"],
                $rs->fields["member_id"],
                $rs->fields["tel_num"],
                $rs->fields["cell_num"],
                $rs->fields["mail"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 정보 회계 담당자 리스트 HTML
 */
function makeMemberAcctingMngDetailHtml($rs) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["name"],
                $rs->fields["tel_num"],
                $rs->fields["cell_num"],
                $rs->fields["mail"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 정보 관리사업자 리스트 HTML
 */
function makeMemberidminLicenseeregiDetailHtml($rs) {
  
    if (!$rs) {
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
    $html .= "\n  </tr>";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["crn"],
                $rs->fields["crop_name"],
                $rs->fields["repre_name"],
                $rs->fields["tel_num"],
                $rs->fields["cell_num"],
                $rs->fields["addr"],
                $rs->fields["addr_detail"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 배송관리 HTML
 */
function makeMemberDlvrHtml($rs) {
  
    if (!$rs) {
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"regiMyDlvr('%s', '%s');\">수정</button></td>";
    $html .= "\n  </tr>";
    $i = 1;

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["dlvr_name"],
                $rs->fields["recei"],
                $rs->fields["addr"] . " " . $rs->fields["addr_detail"],
                $rs->fields["tel_num"],
                date("Y-m-d", strtotime($rs->fields["regi_date"])),
                $rs->fields["member_seqno"],
                $rs->fields["member_dlvr_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 등급 리스트 HTML
 */
function makeMemberGradeListHtml($rs, $grade_arr) {
  
    if (!$rs) {
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
 //   $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";

    $i = 1;
    $state = "";
    $exist_grade = "";
    $new_grade = "";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        if ($rs->fields["state"] == 1) {
            $state = "<span class=\"blue_text01\">[승인대기]</span>";
        } else if ($rs->fields["state"] == 2) {
            $state = "<span class=\"red_text01\">[승인거절]</span>";
        } else if ($rs->fields["state"] == 3) {
            $state = "[승인완료]";
        }

        $exist_grade = $grade_arr[$rs->fields["exist_grade"]];
        $new_grade = $grade_arr[$rs->fields["new_grade"]];

        $rs_html .= sprintf($html, $class, 
                $i,
                $exist_grade,
                $new_grade,
                $rs->fields["req_empl_name"],
                $rs->fields["aprvl_empl_name"],
                $rs->fields["reason"],
 //               date("Y-m-d", strtotime($rs->fields["regi_date"])),
                $state);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 매출정보리스트 HTML
 */
function makeMemberSalesListHtml($rs, $param) {

    $util = new ErpCommonUtil();
  
    if (!$rs) {
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
    $html .= "\n    <td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width40\" onclick=\"showOrderDetail('%s');\">보기</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $order_state = $util->statusCode2status($rs->fields["order_state"]);

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["order_num"],
                $rs->fields["title"],
                $rs->fields["order_detail"],
                $rs->fields["amt"] . "(" . $rs->fields["count"] . ")",
                number_format($rs->fields["pay_price"]) . "원",
                $rs->fields["order_regi_date"],
                $order_state,
                $rs->fields["order_common_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 포인트 지급내역 리스트 HTML
 */
function makeMemberPointReqListHtml($rs, $param) {
  
    if (!$rs) {
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
    $html .= "\n  </tr>";

    $i = 1 + $param["s_num"];
    $state = "";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        if ($rs->fields["state"] == 1) {
            $state = "<span class=\"blue_text01\">[승인대기]</span>";
        } else if ($rs->fields["state"] == 2) {
            $state = "<span class=\"red_text01\">[승인거절]</span>";
        } else if ($rs->fields["state"] == 3) {
            $state = "[승인완료]";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["point_name"],
                $rs->fields["point"],
                $rs->fields["req_empl_name"],
                $rs->fields["aprvl_empl_name"],
                $rs->fields["reason"],
                $state);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원포인트정보리스트 HTML
 */
function makeMemberPointListHtml($rs, $param) {
  
    if (!$rs) {
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
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];
    $save = "";
    $use = "";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        if ($rs->fields["dvs"] == "2") {
            $save = "";
            $use = $rs->fields["point"];
        } else if ($rs->fields["dvs"] == "1") {
            $save = $rs->fields["point"];
            $use = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                date("Y-m-d", strtotime($rs->fields["regi_date"])),
                $rs->fields["point_name"],
                $save,
                $use,
                $rs->fields["rest_point"],
                number_format($rs->fields["order_price"]) . "원",
                $rs->fields["note"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원 쿠폰정보리스트 HTML
 */
function makeMemberCouponListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n    <td><span class=\"%s\">%s</span></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];
    $save = "";
    $use = "";
    $public_deadline_day = "";
    $max_sale_price = "";
    $min_order_price = "";
    $state = "";
    $today = date("Y-m-d", mktime(0,0,0,date("m")  , date("d"), date("Y")));
    $state_class = "";

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $plus_day = "+" . $rs->fields["public_deadline_day"] . " days";

        $public_deadline_day = date("Y-m-d", strtotime($rs->fields["regi_date"] . $plus_day));
 
        if ($rs->fields["max_sale_price"]) {
            $max_sale_price = "최대 할인 금액 " . $rs->fields["max_sale_price"]. "원";
        }
 
        if ($rs->fields["min_order_price"]) {
            $min_order_price = ", 최소 주문 금액" . $rs->fields["min_order_price"] . "원";
        }

        if ($today < $public_deadline_day) {
            $state = "사용가능";
            $state_class = "";
        } else {
            $state = "기간만료";
            $state_class = "grey_text01";
        }

        $rs_html .= sprintf($html, $class, 
                $state_class,
                $i,
                $state_class,
                $rs->fields["cp_name"],
                $state_class,
                $rs->fields["val"] . $rs->fields["unit"],
                $state_class,
                $max_sale_price . "" . $min_order_price,
                $state_class,
                date("Y-m-d", strtotime($rs->fields["regi_date"])),
                $state_class,
                $public_deadline_day . "까지",
                $state_class,
                $state);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 회원이벤트정보리스트 HTML
 */
function makeMemberEventListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["event_typ"],
                $rs->fields["prdt_name"],
                $rs->fields["bnf"],
                date("Y-m-d", strtotime($rs->fields["regi_date"])));
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
