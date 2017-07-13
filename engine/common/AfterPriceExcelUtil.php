<?
include_once(dirname(__FILE__) . '/ExcelUtil.php');

class AfterPriceExcelUtil extends ExcelUtil {
    function __construct() {
    }

    /**
     * @brief 금액정보 배열 중 INFO를 seqno로 변경하고<br/>
     * 금액 테이블에서 변경할 seqno를 가지고 있는 row를 삭제한 뒤<br/>
     * 결과배열을 금액 테이블에 입력한다<br/>
     *
     * @details [INFO] => 수량|-|제조사|브랜드|후공정명|Depth1|Depth2|Depth3|기준단위<br/>
     * [PRICE] => 기준가격/요율/적용금액/매입가격
     *
     * @param $conn     = 디비 커넥션
     * @param $priceDAO = 쿼리를 수행할 dao 객체
     *
     * @return 쿼리실행 성공여부
     */
    function insertPurPriceInfo($conn, $priceDAO) {

        $ret = "";

        for ($i = 0; $i < $this->sheet_count; $i++) {
            $sheet = $this->obj_PHPExcel->getSheet($i);
            $info_arr = $this->makePriceInfo($sheet);

            $info_arr_count = count($info_arr);
            $param = array();

            $ret_arr = array();

            $price_arr = array();

            // DB 셀렉트 줄이는 용도로 사용
            $dup_check = array();

            $k = 0;
            for ($j = 0; $j < $info_arr_count; $j++) {
                $after_price_info = $info_arr[$j];

                $after_info = $after_price_info["INFO"];
                $price_info = $after_price_info["PRICE"];

                $after_info_arr = explode("|", $after_info);

                $amt       = $after_info_arr[0];
                $manu      = $after_info_arr[2];
                $brand     = $after_info_arr[3];
                $name      = $after_info_arr[4];
                $depth1    = $after_info_arr[5];
                $depth2    = $after_info_arr[6];
                $depth3    = $after_info_arr[7];
                $crtr_unit = $after_info_arr[8];

                // 브랜드 일련번호 검색
                $extnl_etprs_seqno = $priceDAO->selectExtnlEtprsSeqno($conn,
                                                                      $manu);
                $param["extnl_etprs_seqno"] = $extnl_etprs_seqno;
                $param["brand"] = $brand;
                $extnl_brand_seqno = $priceDAO->selectExtnlBrandSeqno($conn,
                                                                      $param);
                $param["extnl_brand_seqno"] = $extnl_brand_seqno;
                $param["name"]              = $name;
                $param["depth1"]            = $depth1;
                $param["depth2"]            = $depth2;
                $param["depth3"]            = $depth3;
                $param["crtr_unit"]         = $crtr_unit;
                $param["amt"]               = $amt;

                // 엑셀파일에 존재하는 정보로 seqno 검색
                $rs = $priceDAO->selectAfterSeqno($conn, $param);

                $seqno = $rs->fields["seqno"];

                if ($rs->EOF) {
                    $seqno = false;
                }

                if ($seqno !== false && $dup_check[$seqno] !== null) {
                    // 이미 입력한 정보가 들어왔을 경우
                    continue;
                }

                $dup_check[$seqno] = true;

                $price_info_arr = explode('|', $price_info);

                $ret_arr[$k++] = array( "seqno"          => $seqno
                                       ,"amt"            => $amt
                                       ,"basic_price"    => $price_info_arr[0]
                                       ,"pur_rate"       => $price_info_arr[1]
                                       ,"pur_aplc_price" => $price_info_arr[2]
                                       ,"pur_price"      => $price_info_arr[3]
                                       ,"extnl_brand_seqno" => $extnl_brand_seqno
                                       ,"name"              => $name
                                       ,"depth1"            => $depth1
                                       ,"depth2"            => $depth2
                                       ,"depth3"            => $depth3
                                       ,"crtr_unit"         => $crtr_unit);
            }

            if (count($ret_arr) === 0) continue;

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "after",
                                                 "after_seqno",
                                                 $ret_arr,
                                                 "seqno");

            if (!$delete_ret) return "FAIL";

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertAfterPurPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }

    /**
     * @brief 후공정 금액정보 배열 중 INFO를 cate_after_price_seqno로 변경하고<br/>
     * 금액 테이블에서 변경할 cate_after_price_seqno를 가지고 있는 row를 전부 삭제한 뒤<br/>
     * 결과배열을 카테고리_후공정_가격 테이블에 입력한다<br/>
     *
     * @details [INFO]  => 수량|[[맵핑코드][-]]|판매채널|카테고리|후공정명|Depth1|Depth2|Depth3|기준단위<br/>
     * [PRICE] => 기준가격|요율|적용금액|매입가격
     *
     * @param $conn     = 디비 커넥션
     * @param $priceDAO = 쿼리를 수행할 dao 객체
     *
     * @return 쿼리실행 성공여부
     */
    function insertSellPriceInfo($conn, $priceDAO) {

        $ret = "";

        $dup_check_form = "%s/%s";

        for ($i = 0; $i < $this->sheet_count; $i++) {
            $sheet = $this->obj_PHPExcel->getSheet($i);
            $info_arr = $this->makePriceInfo($sheet);

            $info_arr_count = count($info_arr);

            $ret_arr = array();

            $price_arr = array();

            // DB 셀렉트 줄이는 용도로 사용
            $dup_check = array();

            $k = 0;
            for ($j = 0; $j < $info_arr_count; $j++) {
                $after_price_info = $info_arr[$j];

                $after_info = $after_price_info["INFO"];
                $price_info = $after_price_info["PRICE"];

                $after_info_arr = explode("|", $after_info);

                $seqno = "";

                $amt       = $after_info_arr[0];
                $mpcode    = $after_info_arr[1];
                $sell_site = $after_info_arr[2];
                $cpn_admin_seqno = $priceDAO->selectCpnAdminSeqno($conn,
                                                                  $sell_site);

                // 판매채널이 존재하지 않을경우
                if ($cpn_admin_seqno === null) {
                    continue;
                }

                // 엑셀에 맵핑코드가 없을 경우
                // 엑셀파일에 존재하는 정보로 맵핑코드 검색
                if ($mpcode === "-") {
                    $cate_name = $after_info_arr[3];
                    $name      = $after_info_arr[4];
                    $depth1    = $after_info_arr[5];
                    $depth2    = $after_info_arr[6];
                    $depth3    = $after_info_arr[7];
                    $crtr_unit = $after_info_arr[8];

                    $cate_sortcode = $priceDAO->selectCateSortcode($conn,
                                                                   $cate_name);
                    $param = array();
                    $param["cate_sortcode"] = $cate_sortcode;
                    $param["name"]          = $name;
                    $param["depth1"]        = $depth1;
                    $param["depth2"]        = $depth2;
                    $param["depth3"]        = $depth3;
                    $param["crtr_unit"]     = $crtr_unit;

                    $rs = $priceDAO->selectCateAfterMpcode($conn, $param);
                    if ($rs->EOF) {
                        // 정보에 해당하는 mpcode가 없는경우
                        continue;
                    }

                    $mpcode = $rs->fields["mpcode"];
                }

                $dup_check_val = sprintf($dup_check_form, $amt, $mpcode);

                if ($dup_check[$dup_check_val] !== null) {
                    // 이미 입력한 정보가 들어왔을 경우
                    continue;
                }

                $dup_check[$dup_check_val] = true;

                $price_info_arr = explode('|', $price_info);

                $ret_arr[$k++] = array( "mpcode"          => $mpcode
                                       ,"cpn_admin_seqno" => $cpn_admin_seqno
                                       ,"amt"             => $amt
                                       ,"basic_price"     => $price_info_arr[0]
                                       ,"sell_rate"       => $price_info_arr[1]
                                       ,"sell_aplc_price" => $price_info_arr[2]
                                       ,"sell_price"      => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) {
                continue;
            }

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "cate_after_price",
                                                 "cate_after_mpcode",
                                                 $ret_arr);

            if (!$delete_ret) return "FAIL";


            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertCateAfterPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }
}
?>
