<?
/**
 * @brief 클레임 리스트 HTML
 */
function makeClaimListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $today = date("Y-m-d");

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width75\" onclick=\"getClaim.exec('%s');\">관리</button></td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                date("Y-m-d", strtotime($rs->fields["regi_date"])),
                $rs->fields["office_nick"],
                $rs->fields["order_num"],
                $rs->fields["title"],
                $rs->fields["dvs"],
                $rs->fields["state"],
                $rs->fields["order_claim_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @param 주문정보 html 생성
 *
 * @detail $param에는 주문 공통 테이블에 저장되어있는
 * 기본정보(basic_info)
 * 추가정보(add_info)
 * 가격정보(price_info)
 * 결제정보(pay_info)
 * html이 넘어온다
 *
 * @param $param = 정보 배열 
 * 
 * @return 팝업 html
 */
function makeOrderInfoNonePopHtml($param) {
    $basic_info = $param["prdt_basic_info"];
    $add_info   = $param["prdt_add_info"];
    $price_info = $param["prdt_price_info"];
    $pay_info   = $param["prdt_pay_info"];

    $html = <<<html
        <div class="form-group">
          $basic_info
          $add_info
          $price_info
          $pay_info
        </div>  
html;

    return $html;
}
?>
