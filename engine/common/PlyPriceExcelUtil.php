<?
include_once(dirname(__FILE__) . '/ExcelUtil.php');

class PlyPriceExcelUtil extends ExcelUtil {
    function __construct() {
    }

    /**
     * @brief 합판 금액정보 배열 중 INFO를 카테고리 분류코드와 맵핑코드로 변경하고<br/>
     * 금액 테이블에서 변경할 row를 전부 삭제한 뒤<br/>
     * 결과배열을 합판_금액_판매채널 테이블에 입력한다<br/>
     *
     * @details [INFO]  => 수량|-|카테고리|종이정보|사이즈|인쇄도수|기준단위<br/>
     * [PRICE] => 기준금액|매입요율|매입적용금액|매입금액
     *
     * @param $conn       = 디비 커넥션
     * @param $table_name = 합판 가격테이블명
     * @param $priceDAO   = 쿼리를 수행할 dao 객체
     *
     * @return 쿼리실행 성공여부
     */
    function insertSellPriceInfo($conn, $table_name, $priceDAO) {

        $ret = "";

        $dup_chk_info = "%s/%s/%s/%s/%s";

        $sheet_count = $this->sheet_count;

        for ($i = 0; $i < $sheet_count ; $i++) {
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

                $seqno = "";

                $amt        = $paper_info_arr[0];
                $cate       = $paper_info_arr[2];
                $paper_info = $paper_info_arr[3];
                $size       = $paper_info_arr[4];
                $tmpt       = $paper_info_arr[5];

                $param["cate"]       = $cate;
                $param["paper_info"] = explode('!', $paper_info);
                $param["size"]       = $size;
                $param["tmpt"]       = $tmpt;

                // 엑셀파일에 존재하는 정보로 맵핑코드 검색
                $mpcode_arr = $priceDAO->selectPlyMpcode($conn, $param);

                if ($mpcode_arr === false) {
                    // 정보에 해당하는 mpcode가 없는경우
                    continue;
                }

                $dup_info = sprintf($dup_chk_info, $amt
                                                 , $mpcode_arr["CATE"]
                                                 , $mpcode_arr["PAPER"]
                                                 , $mpcode_arr["STAN"]
                                                 , $mpcode_arr["PRINT"]);

                if ($dup_check[$dup_info] !== null) {
                    // 이미 입력한 정보가 들어왔을 경우
                    continue;
                }

                $dup_check[$dup_info] = true;

                $price_info_arr = explode('|', $price_info);

                $ret_arr[$k++] = array("amt"               => $amt,
                                       "cate_sortcode"     => $mpcode_arr["CATE"],
                                       "cate_paper_mpcode" => $mpcode_arr["PAPER"],
                                       "cate_stan_mpcode"  => $mpcode_arr["STAN"],
                                       "cate_print_mpcode" => $mpcode_arr["PRINT"],
                                       "basic_price"       => $price_info_arr[0],
                                       "rate"              => $price_info_arr[1],
                                       "aplc_price"        => $price_info_arr[2],
                                       "new_price"         => $price_info_arr[3]);
            }

            if (count($ret_arr) === 0) {
                continue;
            }

            $delete_ret = $priceDAO->deletePlyPrice($conn,
                                                    $table_name,
                                                    $ret_arr);

            if (!$delete_ret) return "FAIL";

            /***************************
             에러 났을 경우 어떻게 해야될지 협의필요
             */
            $ret .= $priceDAO->insertPlyPrice($conn, $table_name, $ret_arr);
            $ret .= '!';
        }

        return $ret;
    }
}
?>
