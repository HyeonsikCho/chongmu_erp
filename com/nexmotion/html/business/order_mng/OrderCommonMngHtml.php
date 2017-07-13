<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/product_info_class.php");
/**
 * @brief 주문 리스트 html 생성
 *
 * @param $conn = connection identifier
 * @param $dao  = 후공정, 옵션 가격 검색을 위한 dao
 * @param $rs   = 주문 리스트 검색결과
 *
 * @return 결과 배열(마지막 seqno랑 주문리스트 html 반환)
 */
function makeOrderListHtml($conn, $dao, $rs) {
	$status_arr = ProductInfoClass::ORDER_STATUS_ARR;
    $html_base  = "<tr %s>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td>%s</td>";
    $html_base  .= "<td><button type=\"button\" class=\"green btn_pu btn fix_height20 fix_width60\" onclick=\"showProductContent('%s');\">상품정보</button></td>";
    $html_base  .= "</tr>";

    $util = new ErpCommonUtil();

    $html = "";
    $first_seq = "";
    $last_seq = "";
    $i = 0;
    while ($rs && !$rs->EOF) {

        $seqno  = $rs->fields["order_prdlist_seq"];
		$status = $status_arr[$rs->fields['prd_status']];
       // $status = "-"; ///////////////////////////////////////////////////////////$util->statusCode2status($rs->fields["order_state"]); 상태값을 입력합니다.
        //$basic_price = intval($rs->fields["basic_price"]);
        //$after_price = intval($dao->selectOrderAfterPrice($conn, $seqno));
        //$opt_price   = intval($dao->selectOrderOptPrice($conn, $seqno));
        //$after_price = intval($rs->fields["add_after_price"]);
        //$opt_price   = intval($rs->fields["add_opt_price"]);

        //$order_price = $basic_price + $after_price + $opt_price;

        $tr_class = (($i++ % 2) === 0) ? "class=\"cellbg\"" : '';

        $html .= sprintf($html_base, $tr_class
            , date("Y-m-d", strtotime($rs->fields["order_stime"]))
            , $rs->fields["order_no"]
            , $rs->fields["user_nm"]
            , $rs->fields["mysec_id"]
            , $rs->fields["title"]
            , $rs->fields["cate_name"]
            , $status
            , $seqno, $seqno);
        $rs->MoveNext();
    }
    return $html;
}
?>
