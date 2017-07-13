<?
include_once(dirname(__FILE__) . '/ExcelUtil.php');

class PaperPriceExcelUtil extends ExcelUtil {
    function __construct() {
    }

    /**
     * @brief 종이 금액정보 배열 중 INFO를 seqno로 변경하고<br/>
     * 금액 테이블에서 변경할 seqno를 가지고 있는 row를 삭제한 뒤<br/>
     * 결과배열을 종이 테이블에 입력한다<br/>
     *
     * @details [INFO]  => 평량|-|제조사|브랜드|종이분류|종이정보|계열|사이즈|기준단위<br/>
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

			// 중복정보 체크
            $dup_check = array();

            $k = 0;
            for ($j = 0; $j < $info_arr_count; $j++) {

                $paper_price_info = $info_arr[$j];

                $paper_info = $paper_price_info["INFO"];
                $price_info = $paper_price_info["PRICE"];

                $paper_info_arr = explode("|", $paper_info);

                $basisweight = $paper_info_arr[0];
                $manu        = $paper_info_arr[2];
                $brand       = $paper_info_arr[3];
                $sort        = $paper_info_arr[4];
                $paper_info  = $paper_info_arr[5];
                $affil       = $paper_info_arr[6];
                $size_arr    = explode('*', $paper_info_arr[7]);
                $crtr_unit   = $paper_info_arr[8];

                // 평량 단위 추출
                $temp = strval(intval($basisweight));
                $basisweight_unit = substr($basisweight, strlen($temp));
                $basisweight = $temp;
                // 브랜드 일련번호 검색
                $extnl_etprs_seqno = $priceDAO->selectExtnlEtprsSeqno($conn,
                                                                      $manu);
                $param["extnl_etprs_seqno"] = $extnl_etprs_seqno;
                $param["brand"] = $brand;
                $extnl_brand_seqno = $priceDAO->selectExtnlBrandSeqno($conn,
                                                                      $param);
                // 종이 검색정보 생성
                $temp_arr    = explode("!", $paper_info);
                $info        = preg_replace("/!/", "|", $paper_info);
                $info       .= '|' . $basisweight . $basisweight_unit;
                $name        = $temp_arr[0];
                $dvs         = $temp_arr[1];
                $color       = $temp_arr[2];
                // 사이즈 정보 추출
                $size_width  = $size_arr[0];
                $size_vert   = $size_arr[1];

                unset($param);

                $param["extnl_brand_seqno"] = $extnl_brand_seqno;
                $param["search_check"]      = $info;
                $param["sort"]              = $sort;
                $param["affil"]             = $affil;
                $param["crtr_unit"]         = $crtr_unit;

                // 엑셀파일에 존재하는 정보로 맵핑코드 검색
                $rs = $priceDAO->selectPaperSeqno($conn, $param);

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
                                       ,"sort"              => $sort
                                       ,"name"              => $name
                                       ,"dvs"               => $dvs
                                       ,"color"             => $color
                                       ,"basisweight"       => $basisweight
                                       ,"basisweight_unit"  => $basisweight_unit
                                       ,"wid_size"          => $size_width
                                       ,"vert_size"         => $size_vert
                                       ,"affil"             => $affil
                                       ,"crtr_unit"         => $crtr_unit
                                       ,"search_check"      => $info
                                       ,"basic_price"     => $price_info_arr[0]
                                       ,"pur_rate"        => $price_info_arr[1]
                                       ,"pur_aplc_price"  => $price_info_arr[2]
                                       ,"pur_price"       => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) {
                continue;
            }

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "paper",
                                                 "paper_seqno",
                                                 $ret_arr,
                                                 "seqno");

            if (!$delete_ret) {
                return "FAIL";
            }

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertPaperPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }

    /**
     * @brief 종이 금액정보 배열 중 INFO를 mpcode로 변경하고<br/>
     * 금액 테이블에서 변경할 prdt_paper_seqno를 가지고 있는 row를 삭제한 뒤<br/>
     * 결과배열을 상품_종이_금액 테이블에 입력한다<br/>
     *
     * @details [INFO]  => 평량|-|판매채널|종이분류|종이정보|계열|사이즈|기준단위<br/>
     * [PRICE] => 기준가격|요율|적용금액|판매금액
     *
     * @param $conn     = 디비 커넥션
     * @param $priceDAO = 쿼리를 수행할 dao 객체
     *
     * @return 쿼리실행 성공여부
     */
    function insertSellPriceInfo($conn, $priceDAO) {

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
                $paper_price_info = $info_arr[$j];

                $paper_info = $paper_price_info["INFO"];
                $price_info = $paper_price_info["PRICE"];

                $paper_info_arr = explode("|", $paper_info);

                $mpcode = null;

                $basisweight = $paper_info_arr[0];
                $sell_site   = $paper_info_arr[2];
                $sort        = $paper_info_arr[3];
                $info        = preg_replace("/!/", "|", $paper_info_arr[4]);
                $info       .= '|' . $basisweight;
                $affil       = $paper_info_arr[5];
                //$size        = $paper_info_arr[6];
                $crtr_unit   = $paper_info_arr[7];

                $cpn_admin_seqno = $priceDAO->selectCpnAdminSeqno($conn,
                                                                  $sell_site);
                // 판매채널이 존재하지 않을경우
                if ($cpn_admin_seqno === null) {
                    continue;
                }

                $param["sort"]      = $sort;
                $param["info"]      = $info;
                $param["affil"]     = $affil;
                $param["crtr_unit"] = $crtr_unit;

                // 엑셀파일에 존재하는 정보로 맵핑코드 검색
                $rs = $priceDAO->selectPrdtPaperMpcode($conn, $param);

                if (!$rs || $rs->EOF) {
                    // 정보에 해당하는 맵핑코드가 없는경우
                    continue;
                } else {
                    $mpcode = $rs->fields["mpcode"];

                    if ($dup_check[$mpcode] !== NULL) {
                        // 이미 입력한 정보가 들어왔을 경우
                        continue;
                    }

                    $dup_check[$mpcode] = true;
                }

                $price_info_arr = explode('|', $price_info);

                $ret_arr[$k++] = array( "mpcode"          => $mpcode
                                       ,"cpn_admin_seqno" => $cpn_admin_seqno
                                       ,"basic_price"     => $price_info_arr[0]
                                       ,"sell_rate"       => $price_info_arr[1]
                                       ,"sell_aplc_price" => $price_info_arr[2]
                                       ,"sell_price"      => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) {
                continue;
            }

            $delete_ret = $priceDAO->deletePrice($conn,
                                                 "prdt_paper_price",
                                                 "prdt_paper_mpcode",
                                                 $ret_arr);

            if (!$delete_ret) {
                return "FAIL";
            }

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertPrdtPaperPrice($conn, $ret_arr);
            $ret .= '!';
        }

        return $ret;        
    }
}
?>
