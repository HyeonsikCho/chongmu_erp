<?
/**
 * @file AftOptPriceCommonLib.php
 * 
 * @brief 기초관리 - 상품 등록/수정 - 상품 가격등록/수정<br/>
 * 메뉴에서 후공정 가격과 옵션 가격을 가져올 때 공통으로<br/>
 * 사용될 수 있는 로직을 모아놓은 파일<br/>
 */

/**
 * @brief 맵핑코드/정보 배열을 생성해주는 함수<br/>
 * 여기서 생성된 배열은 테이블 제목부분에서 사용된다
 *
 * @param $rs = 쿼리실행결과
 *
 * @return 맵핑코드/정보 배열
 */
function getMpcodeArr($rs) {
    $ret = array();

    $i = 0;
    while ($rs && !$rs->EOF) {
        $mpcode   = $rs->fields["mpcode"];
        $tot_name = $rs->fields["tot_name"];

        $ret["MPCODE"][$i] = $mpcode;
        $ret["INFO"][$i++] = $tot_name;

        $rs->MoveNext();
    }

    return $ret;
}

/**
 * @brief 카테고리 후공정/옵션 테이블에서 가격검색<br/>
 * <br/>
 * 반환 필드 목록<br/>
 *  - 수량 /  신규가격 / 요율 /  적용금액  /   기준가격<br/>
 *  - amt  / new_price / rate / aplc_price / basic_price<br/>
 *
 * @param $conn     = 디비 커넥션
 * @param $dvs      = 후공정(AFT)/옵션(OPT) 구분
 * @param $info_arr = 맵핑코드/정보 배열
 * @param $dao      = 쿼리 실행용 dao 객체
 *
 * @return 가격정보 배열
 */
function getAftOptPriceInfo($conn, $dvs, $info_arr, $dao) {
    $mpcode_arr = $info_arr["MPCODE"];
    $info_arr = $info_arr["INFO"];

    $price_info_arr = array();
    $amt_arr = array();
    $title_arr = array();
    $price_arr = array();
    $param = array();

    $price_base = "%s|%s|%s|%s";

    $mpcode_arr_count = count($mpcode_arr);
    //$conn->debug = 1;

    $j = 0;
    for ($i = 0; $i < $mpcode_arr_count; $i++) {
        $mpcode = $mpcode_arr[$i]; // 가격 검색에서 사용
        $info   = $info_arr[$i];   // 테이블 제목 정보

        $param["mpcode"] = $mpcode;

        $rs = $dao->selectAftOptPrice($conn, $dvs, $param);

        if ($rs->EOF) {
            continue; // 가격이 없는경우 건너뜀
        }

        while ($rs && !$rs->EOF) {
            $amt = $rs->fields["amt"];
            $amt_arr[$amt] = $amt;

            // ex) 2500/0/0/2500
            $price = sprintf($price_base, $rs->fields["basic_price"]
                                        , $rs->fields["sell_rate"]
                                        , $rs->fields["sell_aplc_price"]
                                        , $rs->fields["sell_price"]);
            $title_arr[$info] = $info;
            $price_arr[$info][$amt] = $price;

            $rs->MoveNext();
        }

        // 만들어진 $title_arr을 차례대로 정리함
        // 해당하는 제목의 가격도 같이 정리함
        foreach ($title_arr as $key => $val) {
            $title = $title_arr[$key];
            $price_arr_temp = $price_arr[$key];

            $price_info_arr["TITLE"][$j] = $title; // 종이정보
            $price_info_arr["TITLE_INFO"][$j] = $mpcode; // 가격 식별값
            $price_info_arr["PRICE"][$j++] = $price_arr_temp; // 가격정보
        }

        unset($title_arr);
        unset($price_arr);
    }

    if (count($price_info_arr) !== 0) {
        $price_info_arr["AMT"] = $amt_arr;
    }

    return $price_info_arr;
}
?>
