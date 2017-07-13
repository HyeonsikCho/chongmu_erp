<?
/**
 * @file PriceHtmlLib.php
 *
 * @brief 가격 테이블 html을 생성하는 클래스
 */
class PriceHtmlLib {

    var $chunk_col_cnt;
    var $type;
    var $price_sign;

    function __construct() {
    }

    /**
     * @brief 생성자
     *
     * @param $chunk_col_cnt = 항목 단위 열의 개수
     * @param $type          = 가격 구분 행 타입
     * @param $price_sign    = 가격 단위(수량, R, 장, 평량 etc...)
     */
    function initInfo($chunk_col_cnt, $type, $price_sign) {

        $this->chunk_col_cnt = $chunk_col_cnt;
        $this->type = $type;
        $this->price_sign = $price_sign;
    }

    /**
     * @brief 합판가격 colgroup Html 생성
     */
    function getColgroupHtml() {
        $html  = "<colgroup>";
        $html .= "  <col style='width:100px;' />";
        $html .= "  <col span='4' style='width:100px;' />";
        $html .= "  <col span='4' style='width:100px;' />";
        $html .= "  <col span='4' style='width:100px;' />";
        $html .= "</colgroup>";

        return $html;
    }

    /**
     * @brief 가격 구분 th html 생성
     *
     * @detail 기존판매가격 / 요율 / 적용금액 / 신규판매가격 = type 1, 상품가격
     * 기준가격 / 요율 / 적용금액 / 판매가격 = type 2, 계산형 가격 품목 가격
     * 기준가격 / 요율 / 적용금액 / 매입가격 = type 3, 생산 품목 가격
     *
     * @param $type = th html 타입
     *
     * @return th html
     */
    function getPriceDvsThHtml($type) {
        if ($type === 1) {
            $ret  = "<th class='bm2px'>기존 판매가격</th>";
            $ret .= "<th class='bm2px' %s %s>요율</th>";
            $ret .= "<th class='bm2px' %s %s>적용금액</th>";
            $ret .= "<th class='bm2px'>신규 판매가격</th>";
        } else if ($type === 2) {
            $ret  = "<th class='bm2px'>기준가격</th>";
            $ret .= "<th class='bm2px' %s %s>요율</th>";
            $ret .= "<th class='bm2px' %s %s>적용금액</th>";
            $ret .= "<th class='bm2px'>판매가격</th>";
        } else if ($type === 3) {
            $ret  = "<th class='bm2px'>기준가격</th>";
            $ret .= "<th class='bm2px' %s %s>요율</th>";
            $ret .= "<th class='bm2px' %s %s>적용금액</th>";
            $ret .= "<th class='bm2px'>매입가격</th>";
        } else if ($type === 4) {
            $ret  = "<th class='bm2px'>종이가격</th>";
            $ret .= "<th class='bm2px'>인쇄가격</th>";
            $ret .= "<th class='bm2px'>출력가격</th>";
            $ret .= "<th class='bm2px'>판매가격</th>";
        }

        return $ret;
    }

    /**
     * @brief 가격 thead Html 생성
     *
     * @detail 각 배열의 예시는 아래와 같다
     *
     * $title_arr = [$idx$] => "정보1|정보2|정보3..."
     * $title_arr = array(
     *     0 => "코팅명함|아트지 백색 216g|88*54|단면칼라 4도",
     *     1 => "무코팅명함|스노우지 백색 216g|88*54|양면칼라 8도"
     * );
     *
     * $title_idx_arr = [$idx$] => "html에서 쓰일 id 문자열"
     * $title_id_arr = array(
     *     0 => "cate_name",
     *     1 => "paper_info",
     *     2 => "paper_size",
     *     3 => "tmpt"
     * );
     * - 정보를 넣지 않을 경우에는 인덱스 개수는 맞추되 빈값을 입력한다
     *
     * $title_info_arr = [$idx$] => "정보1|정보2|정보3..."
     * $title_info_arr = array(
     *     0 => "001001001|1|2|3",
     *     1 => "001001002|4|5|6"
     * );
     *
     * @param $title_arr      = 제목 배열
     * @param $title_id_arr   = 제목 식별값 배열(html에서 사용)
     * @param $title_info_arr = 제목 정보 배열
     * @param $modi_flag      = 가격정보 수정가능 여부
     * 
     * @return thead html
     */
    function getPriceTheadHtml($title_arr,
                               $title_id_arr,
                               $title_info_arr,
                               $modi_flag = false) {

        $modi_rate_attr = "";
        $modi_aplc_price_attr = "";
        $modi_style = "";

        if ($modi_flag === true) {
            $modi_rate_attr =
                "onclick=\"modiPriceInfo.exec(event, 'R', '%s');\"";
            $modi_aplc_price_attr =
                "onclick=\"modiPriceInfo.exec(event, 'A', '%s');\"";
            $modi_style =
                "style='cursor:pointer;'";
        }

        $thead_base_html  = "<thead>%s</thead>";

        $info_rowspan_html = "<th rowspan='%s'>구분</th>";

        $depth_html_base_id = "<th colspan='4' id='%s' val='%s'>%s</th>";
        $depth_html_base = "<th colspan='4'>%s</th>";

        $price_sign_html = "<th class='bm2px'>%s</th>";
        $price_sign_html = sprintf($price_sign_html, $this->price_sign);

        $price_dvs_base_html = $this->getPriceDvsThHtml($this->type);

        // 여기에 tr별로 생성된 html저장하고 마지막에 붙임
        $title_html_arr = array();

        $title_arr_count = count($title_arr);

        for ($i = 0; $i < $title_arr_count; $i++) {
            $title = $title_arr[$i];
            $title = explode('|', $title);

            $title_info = $title_info_arr[$i];
            $title_info = explode('|', $title_info);

            $rate_attr = sprintf($modi_rate_attr, $i);
            $aplc_attr = sprintf($modi_aplc_price_attr, $i);

            $title_count = count($title);

            if ($i === 0) {
                $info_rowspan_html = sprintf($info_rowspan_html, $title_count);
                $title_html_arr[0] = $info_rowspan_html;
            }

            for ($j = 0; $j < $title_count; $j++) {
                if ($title_html_arr[$j] === null) {
                    $title_html_arr[$j] = "";
                }

                $title_id = $title_id_arr[$j % $this->chunk_col_cnt];

                if (empty($title_id) === true) {
                    $title_html_arr[$j] .= sprintf(
                        $depth_html_base,
                        $title[$j]
                    );
                } else {
                    $id = sprintf("%s_%s", $title_id
                                         , $i);

                    $title_html_arr[$j] .= sprintf(
                        $depth_html_base_id,
                        $id,
                        $title_info[$j],
                        $title[$j]
                    );
                }

            }

            if ($title_html_arr[$title_count] === null) {
                $title_html_arr[$title_count] = "";
            }

            if ($i === 0) {
                $title_html_arr[$title_count] .= $price_sign_html;
            }

            $price_dvs_html = sprintf($price_dvs_base_html, $rate_attr
                                                          , $modi_style
                                                          , $aplc_attr
                                                          , $modi_style);

            $title_html_arr[$title_count] .= $price_dvs_html;
        }

        // 다 사용한 배열 전부 unset
        unset($title_arr);
        unset($title_id_arr);
        unset($title_info_arr);

        $tr_html = "";

        $title_html_arr_count = count($title_html_arr);

        for ($i = 0; $i < $title_html_arr_count; $i++) {
            $tr_html .= sprintf("<tr>%s</tr>", $title_html_arr[$i]);
        }

        $html = sprintf($thead_base_html, $tr_html);

        return $html;
    }

    /**
     * @brief 확장형 가격 tbody Html 생성
     *
     * @detail 각 배열의 예시는 아래와 같다
     *
     * $dvs_arr = [$idx$] => "수량 or 평량 정보"
     * $dvs_arr = array(
     *     0 => "500",
     *     1 => "1000",
     *     2 => "1500"
     * );
     *
     * $price_arr = [$idx$] => [$수량 or 평량$] => "가격 일련번호|기준가격|요율|적용금액|판매가격"
     * $price_arr = array(
     *     0 => array(
     *         "500" => "0|1000|0|0|1000",
     *         "1000" => "1|2000|10|0|2200",
     *         "1500" => "2|3000|0|500|3500"
     *     ),
     *     1 => array(
     *         "500" => "3|1500|0|0|1500",
     *         "1000" => "4|2500|10|0|2750",
     *         "1500" => "5|3500|0|500|4000"
     *     )
     * );
     *
     * @param $title_count = 제목 배열 길이
     * @param $price_arr   = 가격 정보 배열
     * @param $dvs_arr     = 가격 구분 배열(수량, 평량 etc...)
     * @param $modi_flag   = 가격정보 수정가능 여부
     * 
     * @return tbody html
     */
    function getPriceTbodyHtml($title_count,
                               $price_arr,
                               $dvs_arr,
                               $modi_flag = false) {

        $modi_rate_attr = "";
        $modi_aplc_price_attr = "";
        $modi_style_base = "";

        // 가격수정 자바스크립트 함수
        if ($modi_flag === true) {
            $modi_rate_attr =
                "onclick=\"modiPriceInfoEach.exec(event, 'R', '%s');\"";
            $modi_aplc_price_attr =
                "onclick=\"modiPriceInfoEach.exec(event, 'A', '%s');\"";
            $modi_style_base =
                "style='cursor:pointer;'";
        }

        $tr_base_html  = "   <tr %s>";

        // 수량이 포함된 td
        $fst_td_base_html  = "    <td>%s</td>"; // 수량용 td
        $fst_td_base_html .= "    <td>%s</td>";
        $fst_td_base_html .= "    <td class=\"%s\" %s %s>%s</td>";
        $fst_td_base_html .= "    <td class=\"%s\" %s %s>%s</td>";
        $fst_td_base_html .= "    <td class=\"fwb\">%s</td>";

        // 수량이 포함되지 않은 td
        $etc_td_base_html  = "    <td>%s</td>";
        $etc_td_base_html .= "    <td class=\"%s\" %s %s>%s</td>";
        $etc_td_base_html .= "    <td class=\"%s\" %s %s>%s</td>";
        $etc_td_base_html .= "    <td class=\"fwb\">%s</td>";

        $tbody_base_html  = "<tbody>";
        $tbody_base_html .= "   %s";
        $tbody_base_html .= "</tbody>";

        $tr_html = "";

        $dvs_arr_count = count($dvs_arr);

        for ($i = 0; $i < $dvs_arr_count; $i++) {

            $dvs = $dvs_arr[$i];
            $dvs_key = $dvs;

            $tr_class = (($i % 2) === 0) ? "class=\"cellbg\"" : '';

            $tr_html .= sprintf($tr_base_html, $tr_class);

            for ($j = 0; $j < $title_count; $j++) {

                $price = $price_arr[$j][$dvs_key]; 
                $price = explode("|", $price);

                $price_seqno = $price[0];

                // 요율에 소수점이 존재하는지 확인
                $rate = $price[2];
                $rate_point_length = 0;
                if (strcmp($rate, '.') !== 0) {
                    $rate_point_length = strlen(explode('.', $rate)[1]);
                }
                $rate = doubleval($rate);

                // 적용금액에 소수점이 존재하는지 확인
                $aplc_price = $price[3];
                $aple_price_point_length = 0;
                if (strcmp($aplc_price, '.') !== 0) {
                    $aplc_price_point_length = strlen(explode('.', $aplc_price)[1]);
                }
                $aplc_price = doubleval($aplc_price);

                $rate_attr  = "";
                $aplc_attr  = "";
                $modi_style = "";

                if ($price[0] !== "") {
                    $rate_attr  = sprintf($modi_rate_attr,
                                          $price_seqno);
                    $aplc_attr  = sprintf($modi_aplc_price_attr,
                                          $price_seqno);
                    $modi_style = $modi_style_base;

                    $price[1] = number_format(doubleval($price[1]));
                    $price[2] = number_format($rate,
                                              $rate_point_length);
                    $price[3] = number_format($aplc_price,
                                              $aplc_price_point_length);
                    $price[4] = number_format(doubleval($price[4]));
                }

                $rate_class =
                    ($rate < 0.0) ? 'red_text01' : 'blue_text01';
                $aplc_price_class =
                    ($aplc_price < 0.0) ? 'red_text01' : 'blue_text01';

                if (is_numeric($dvs) === true) {
                    /* 구분값에 소수점이 들어간게 있어서 처리했던듯?
                    if (strpos($dvs, '.') === false) {
                        // 소수점이 없는경우
                        $dvs = number_format(doubleval($dvs), 1);
                    } else {*/
                        $dvs = number_format(doubleval($dvs));
                    //}
                }

                if ($j === 0) {
                    // 수량이 들어가는 td일 경우

                    $tr_html .= sprintf($fst_td_base_html, $dvs
                                                         , $price[1]
                                                         , $rate_class
                                                         , $rate_attr
                                                         , $modi_style
                                                         , $price[2]
                                                         , $aplc_price_class
                                                         , $aplc_attr
                                                         , $modi_style
                                                         , $price[3]
                                                         , $price[4]);
                } else {
                    $tr_html .= sprintf($etc_td_base_html, $price[1]
                                                         , $rate_class
                                                         , $rate_attr
                                                         , $modi_style
                                                         , $price[2]
                                                         , $aplc_price_class
                                                         , $aplc_attr
                                                         , $modi_style
                                                         , $price[3]
                                                         , $price[4]);
                } 
            }

            $tr_html .= "</tr>";
        }

        $html = sprintf($tbody_base_html, $tr_html);

        return $html;
    }

    /**
     * @brief 계산형 가격 tbody Html 생성
     *
     * @detail 각 배열의 예시는 아래와 같다
     *
     * $dvs_arr = [$idx$] => "수량 or 평량 정보"
     * $dvs_arr = array(
     *     0 => "500",
     *     1 => "1000",
     *     2 => "1500"
     * );
     *
     * $price_arr = [$idx$] => [$수량 or 평량$] => "가격 일련번호|기준가격|요율|적용금액|판매가격"
     * $price_arr = array(
     *     0 => array(
     *         "500" => "0|1000|0|0|1000",
     *         "1000" => "1|2000|10|0|2200",
     *         "1500" => "2|3000|0|500|3500"
     *     ),
     *     1 => array(
     *         "500" => "3|1500|0|0|1500",
     *         "1000" => "4|2500|10|0|2750",
     *         "1500" => "5|3500|0|500|4000"
     *     )
     * );
     *
     * @param $title_count = 제목 배열 길이
     * @param $price_arr   = 가격 정보 배열
     * @param $dvs_arr     = 가격 구분 배열(수량, 평량 etc...)
     * @param $modi_flag   = 가격정보 수정가능 여부
     * 
     * @return tbody html
     */
    function getCalcPriceTbodyHtml($title_count,
                                   $price_arr,
                                   $dvs_arr) {

        $tr_base_html  = "   <tr %s>";

        // 수량이 포함된 td
        $fst_td_base_html  = "    <td>%s</td>"; // 수량용 td
        $fst_td_base_html .= "    <td>%s</td>";
        $fst_td_base_html .= "    <td>%s</td>";
        $fst_td_base_html .= "    <td>%s</td>";
        $fst_td_base_html .= "    <td class=\"fwb\">%s</td>";

        // 수량이 포함되지 않은 td
        $etc_td_base_html  = "    <td>%s</td>";
        $etc_td_base_html .= "    <td>%s</td>";
        $etc_td_base_html .= "    <td>%s</td>";
        $etc_td_base_html .= "    <td class=\"fwb\">%s</td>";

        $tbody_base_html  = "<tbody>";
        $tbody_base_html .= "   %s";
        $tbody_base_html .= "</tbody>";

        $tr_html = "";

        $dvs_arr_count = count($dvs_arr);

        for ($i = 0; $i < $dvs_arr_count; $i++) {

            $dvs = $dvs_arr[$i];
            $dvs_key = $dvs;

            $tr_class = (($i % 2) === 0) ? "class=\"cellbg\"" : '';

            $tr_html .= sprintf($tr_base_html, $tr_class);

            for ($j = 0; $j < $title_count; $j++) {

                $price = $price_arr[$j][$dvs_key]; 
                $price = explode("|", $price);

                $price_seqno = $price[0];

                if ($price[0] !== "") {
                    $price[1] = number_format(doubleval($price[1]));
                    $price[2] = number_format(doubleval($price[2]));
                    $price[3] = number_format(doubleval($price[3]));
                    $price[4] = number_format(doubleval($price[4]));
                }

                if (is_numeric($dvs) === true) {
                    /* 구분값에 소수점이 들어간게 있어서 처리했던듯?
                    if (strpos($dvs, '.') === false) {
                        // 소수점이 없는경우
                        $dvs = number_format(doubleval($dvs), 1);
                    } else {*/
                        $dvs = number_format(doubleval($dvs));
                    //}
                }

                if ($j === 0) {
                    // 수량이 들어가는 td일 경우

                    $tr_html .= sprintf($fst_td_base_html, $dvs
                                                         , $price[1]
                                                         , $price[2]
                                                         , $price[3]
                                                         , $price[4]);
                } else {
                    $tr_html .= sprintf($etc_td_base_html, $price[1]
                                                         , $price[2]
                                                         , $price[3]
                                                         , $price[4]);
                } 
            }

            $tr_html .= "</tr>";
        }

        $html = sprintf($tbody_base_html, $tr_html);

        return $html;
    }
}
?>
