<?
include_once(dirname(__FILE__) . '/ExcelUtil.php');

class OutputPriceExcelUtil extends ExcelUtil {
    function __construct() {
    }

    /**
     * @brief 금액정보 배열 중 INFO를 seqno로 변경하고<br/>
     * 금액 테이블에서 변경할 seqno를 가지고 있는 row를 삭제한 뒤<br/>
     * 결과배열을 출력 테이블에 입력한다<br/>
     *
     * @details [INFO] => 수량|-|제조사|브랜드|대분류|출력명|판구분|계열|사이즈|기준단위<br/>
     * [PRICE] => 기준가격|요율|적용금액|매입가격
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
                $output_price_info = $info_arr[$j];

                $output_info = $output_price_info["INFO"];
                $price_info = $output_price_info["PRICE"];

                $output_info_arr = explode("|", $output_info);

                $board_amt = $output_info_arr[0];
                $manu      = $output_info_arr[2];
                $brand     = $output_info_arr[3];
                $top       = $output_info_arr[4];
                $name      = $output_info_arr[5];
                $board     = $output_info_arr[6];
                $affil     = $output_info_arr[7];
                $size      = $output_info_arr[8];
                $crtr_unit = $output_info_arr[9];

                // 브랜드 일련번호 검색
                $extnl_etprs_seqno = $priceDAO->selectExtnlEtprsSeqno($conn,
                                                                      $manu);
                $param["extnl_etprs_seqno"] = $extnl_etprs_seqno;
                $param["brand"] = $brand;
                $extnl_brand_seqno = $priceDAO->selectExtnlBrandSeqno($conn,
                                                                      $param);
                // 사이즈 정보 추출
                $size_arr  = explode('*', $size);
                $size_width = $size_arr[0];
                $size_vert  = $size_arr[1];
                // 검색정보 생성
                $info = sprintf("%s|%s|%s", $name, $board, $size);

                unset($param);

                $param["extnl_brand_seqno"] = $extnl_brand_seqno;
                $param["top"]               = $top;
                $param["search_check"]      = $info;
                $param["wid_size"]          = $size_width;
                $param["vert_size"]         = $size_vert;
                $param["crtr_unit"]         = $crtr_unit;
                $param["amt"]               = $amt;

                // 엑셀파일에 존재하는 정보로 seqno 검색
                $rs = $priceDAO->selectOutputSeqno($conn, $param);

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

                $ret_arr[$k++] = array( "seqno"             => $seqno
                                       ,"extnl_brand_seqno" => $extnl_brand_seqno
                                       ,"top"               => $top
                                       ,"name"              => $name
                                       ,"board"             => $board
                                       ,"wid_size"          => $size_width
                                       ,"vert_size"         => $size_vert
                                       ,"affil"             => $affil
                                       ,"search_check"      => $info
                                       ,"board_amt"      => $board_amt
                                       ,"basic_price"    => $price_info_arr[0]
                                       ,"pur_rate"       => $price_info_arr[1]
                                       ,"pur_aplc_price" => $price_info_arr[2]
                                       ,"pur_price"      => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) {
                continue;
            }

            //print_r($ret_arr); exit;

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "output",
                                                 "output_seqno",
                                                 $ret_arr,
                                                 "seqno");

            if (!$delete_ret) return "FAIL";

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertOutputPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }

    /**
     * @brief 금액정보 배열 중 INFO를 mpcode로 변경하고<br/>
     * 금액 테이블에서 변경할 mpcode를 가지고 있는 row를 전부 삭제한 뒤<br/>
     * 결과배열을 상품_규격_금액 테이블에 입력한다<br/>
     *
	 * @details [INFO] => 수량|[[맵핑코드][-]]|판매채널|출력명|판구분|사이즈|기준단위<br/>
     * [PRICE] => 기준가격|요율|적용금액|판매금액
     *
     * @param $conn     = 디비 커넥션
     * @param $priceDAO = 쿼리를 수행할 dao 객체
     *
     * @return 쿼리실행 성공여부
     */
    function insertSellPriceInfo($conn, $priceDAO) {

        $ret = "";

        $dup_chk_info = "%s/%s";

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
                $output_price_info = $info_arr[$j];

                $output_info = $output_price_info["INFO"];
                $price_info = $output_price_info["PRICE"];

                $output_info_arr = explode("|", $output_info);

                $mpcode = null;

                $board_amt = $output_info_arr[0];
                $mpcode    = $output_info_arr[1];
                $sell_site = $output_info_arr[2];

                $cpn_admin_seqno = $priceDAO->selectCpnAdminSeqno($conn,
                                                                  $sell_site);
                // 판매채널이 존재하지 않을경우
                if ($cpn_admin_seqno === null) {
                    continue;
                }

                // 엑셀에 맵핑코드가 없을 경우
                // 엑셀파일에 존재하는 정보로 맵핑코드 검색
                if ($mpcode === "-") {
                    $name      = $output_info_arr[3];
                    $board     = $output_info_arr[4];
                    $size      = $output_info_arr[5];
                    $crtr_unit = $output_info_arr[6];

                    $param = array();
                    $param["name"]      = $name;
                    $param["board"]     = $board;
                    $param["size"]      = $size;
                    $param["crtr_unit"] = $size;

                    $rs = $priceDAO->selectPrdtOutputMpcode($conn, $param);

                    if ($rs->EOF) {
                        // 정보에 해당하는 mpcode가 없는경우
                        continue;
                    }

                    $mpcode = $rs->fields["mpcode"];
                }

                $dup_info = sprintf($dup_chk_info, $mpcode
                                                 , $board_amt);

                if ($dup_check[$dup_info] !== null) {
                    // 이미 입력한 정보가 들어왔을 경우
                    continue;
                }

                $dup_check[$dup_info] = true;

                $price_info_arr = explode('|', $price_info);

                $ret_arr[$k++] = array( "mpcode"          => $mpcode
                                       ,"cpn_admin_seqno" => $cpn_admin_seqno
                                       ,"board_amt"       => $board_amt
                                       ,"basic_price"     => $price_info_arr[0]
                                       ,"sell_rate"       => $price_info_arr[1]
                                       ,"sell_aplc_price" => $price_info_arr[2]
                                       ,"sell_price"      => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) continue;

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "prdt_stan_price",
                                                 "prdt_output_info_mpcode",
                                                 $ret_arr);

            if (!$delete_ret) return "FAIL";

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertPrdtOutputPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }
}
?>
