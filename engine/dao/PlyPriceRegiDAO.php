<?
include_once(dirname(__FILE__) . '/CommonDAO.php');

class PlyPriceRegiDAO extends CommonDAO {
    function __construct() {
    }

    /**
     * @brief 판매채널에 해당하는 합판가격 테이블명 반환
     *
     * @param $conn      = 디비 커넥션
     * @param $sell_site = 판매채널명
     *
     * @return 쿼리 실행결과
     */
    function selectPlyPriceTableName($conn, $sell_site) {
        if (!$this->connectionCheck($conn)) return false;

        $temp = array();
        $temp["col"] = "price_tb_name";
        $temp["table"] = "cpn_admin";
        $temp["where"]["cpn_admin_seqno"] = $sell_site;

        return $this->selectData($conn, $temp);
    }

    /**
     * @brief 카테고리 분류코드, 종이, 규격, 인쇄 맵핑코드 검색
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 맵핑코드를 얻어야되는 항목 정보
     *
     * @return 쿼리 실행결과
     */
    function selectPlyMpcode($conn, $param) {
        if (!$this->connectionCheck($conn)) return false;

        $param = $this->parameterArrayEscape($conn, $param);

        // 카테고리 분류코드 검색
        $query = "SELECT sortcode FROM cate WHERE cate_name = %s";
        $query = sprintf($query, $param["cate"]);

        $rs = $conn->Execute($query);
        if ($rs->EOF) return false;

        $paper_info = $param["paper_info"];
        $cate_sortcode = $rs->fields["sortcode"];

        // 종이 맵핑코드 검색
        $query  = "\n SELECT mpcode";
        $query .= "\n   FROM cate_paper";
        $query .= "\n  WHERE name          = %s";
        $query .= "\n    AND dvs           = %s";
        $query .= "\n    AND color         = %s";
        $query .= "\n    AND basisweight   = %s";
        $query .= "\n    AND cate_sortcode = %s";
        $query  = sprintf($query, $paper_info[0]
                                , $paper_info[1]
                                , $paper_info[2]
                                , $paper_info[3]
                                , $cate_sortcode);

        $rs = $conn->Execute($query);
        if ($rs->EOF) return false;

        $paper_mpcode = $rs->fields["mpcode"];

        // 규격 맵핑코드 검색
        $query  = "\n SELECT B.mpcode";
        $query .= "\n   FROM prdt_stan AS A, cate_stan AS B";
        $query .= "\n  WHERE A.prdt_stan_seqno = B.prdt_stan_seqno";
        $query .= "\n    AND A.name            = %s";
        $query .= "\n    AND B.cate_sortcode   = %s";
        $query  = sprintf($query, $param["size"]
                                , $cate_sortcode);

        $rs = $conn->Execute($query);
        if ($rs->EOF) return false;

        $stan_mpcode = $rs->fields["mpcode"];

        // 인쇄도수 맵핑코드 검색
        $tmpt = $param["tmpt"];

        $query_base  = "\n SELECT B.mpcode";
        $query_base .= "\n   FROM prdt_print AS A, cate_print AS B";
        $query_base .= "\n  WHERE A.prdt_print_seqno = B.prdt_print_seqno";
        $query_base .= "\n    AND A.name             = %s";
        $query_base .= "\n    AND B.cate_sortcode    = %s";

        // 전면
        $query  = sprintf($query, $tmpt["bef"]
                                , $cate_sortcode);
        $rs = $conn->Execute($query);
        if ($rs->EOF) return false;
        $bef_print_mpcode = $rs->fields["mpcode"];
        // 전면추가
        $bef_add_print_mpcode = '0';
        if ($tmpt["bef_add"] !== "'-'") {
            $query  = sprintf($query_base, $tmpt["bef_add"]
                                         , $cate_sortcode);
            $rs = $conn->Execute($query);
            if ($rs->EOF) return false;
            $bef_add_print_mpcode = $rs->fields["mpcode"];
        }
        // 후면
        $aft_print_mpcode = '0';
        if ($tmpt["aft"] !== "'-'") {
            $query  = sprintf($query_base, $tmpt["aft"]
                                         , $cate_sortcode);
            $rs = $conn->Execute($query);
            if ($rs->EOF) return false;
            $aft_print_mpcode = $rs->fields["mpcode"];
        }
        // 후면추가
        $aft_add_print_mpcode = '0';
        if ($tmpt["aft_add"] !== "'-'") {
            $query  = sprintf($query_base, $tmpt["aft_add"]
                                         , $cate_sortcode);
            $rs = $conn->Execute($query);
            if ($rs->EOF) return false;
            $aft_add_print_mpcode = $rs->fields["mpcode"];
        }

        return array("CATE"          => $cate_sortcode,
                     "PAPER"         => $paper_mpcode,
                     "STAN"          => $stan_mpcode,
                     "BEF_PRINT"     => $bef_print_mpcode,
                     "BEF_ADD_PRINT" => $bef_add_print_mpcode,
                     "AFT_PRINT"     => $aft_print_mpcode,
                     "AFT_ADD_PRINT" => $aft_add_print_mpcode);
    }

    /**
     * @brief 합판 가격 테이블에서 조건에 해당하는 가격 전부 삭제
     *
     * @param $conn       = 디비 커넥션
     * @param $table_name = 가격 테이블명
     * @param $param      = 정보 파라미터
     *
     * @return 작업실행 성공여부
     */
    function deletePlyPrice($conn, $table_name, $param_arr) {
        if (!$this->connectionCheck($conn)) return false;

        $query_base  = "\n DELETE FROM %s";
        $query_base .= "\n  WHERE cate_sortcode     = %s";
        $query_base .= "\n    AND cate_paper_mpcode = %s";
        $query_base .= "\n    AND cate_stan_mpcode  = %s";
        $query_base .= "\n    AND cate_beforeside_print_mpcode     = %s";
        $query_base .= "\n    AND cate_beforeside_add_print_mpcode = %s";
        $query_base .= "\n    AND cate_aftside_print_mpcode        = %s";
        $query_base .= "\n    AND cate_aftside_add_print_mpcode    = %s";

        $param_arr_count = count($param_arr);
        $dup_check = array();
        $info_arr = array();

        $loop_count = ceil(($param_arr_count / 500));

        $dup_chk_info = "%s/%s/%s/%s/%s/%s/%s";

        $j = 0;
        for ($i = 0; $i < $loop_count; $i++) {
            $k = 0;
            for ($j; $j < $param_arr_count; $j++) {
                if ($j !== 0 && $j % 500 === 0) break;

                $param = $this->parameterArrayEscape($conn, $param_arr[$j]);

                $cate_sortcode     = $param["cate_sortcode"];
                $cate_paper_mpcode = $param["cate_paper_mpcode"];
                $cate_stan_mpcode  = $param["cate_stan_mpcode"];
                $cate_beforeside_print_mpcode     = $param["cate_beforeside_print_mpcode"];
                $cate_beforeside_add_print_mpcode = $param["cate_beforeside_add_print_mpcode"];
                $cate_aftside_print_mpcode        = $param["cate_aftside_print_mpcode"];
                $cate_aftside_add_print_mpcode    = $param["cate_aftside_add_print_mpcode"];

                $dup_info = sprintf($dup_chk_info, $cate_sortcode
                                                 , $cate_paper_mpcode
                                                 , $cate_stan_mpcode
                                                 , $cate_beforeside_print_mpcode
                                                 , $cate_beforeside_add_print_mpcode
                                                 , $cate_aftside_print_mpcode
                                                 , $cate_aftside_add_print_mpcode);

                if ($dup_check[$dup_info] !== NULL) {
                    continue;
                } else {
                    $dup_check[$dup_info] = true;
                    $mpcode_arr[$i][$k++] = $dup_info;
                }
            }
        }

        unset($param);
        unset($dup_check);

        for ($i = 0; $i < $loop_count; $i++) {
            $mpcode = $mpcode_arr[$i];
            $mpcode_count = count($mpcode);

            $conn->StartTrans();

            for ($j = 0; $j < $mpcode_count; $j++) {
                $temp = explode('/', $mpcode[$j]);

                $query = sprintf($query_base, $table_name
                                            , $temp[0]
                                            , $temp[1]
                                            , $temp[2]
                                            , $temp[3]
                                            , $temp[4]
                                            , $temp[5]
                                            , $temp[6]);
                $ret = $conn->Execute($query);

                if (!$ret) {
                    return false;
                }
            }

            $conn->CompleteTrans();
        }

        return true;
    }

    /**
     * @brief 합판 판매가격을 입력
     *
     * @param $conn      = 디비 커넥션
     * @param $param_arr = 정보 파라미터 배열
     *
     * @return 쿼리 실행결과
     */
    function insertPlyPrice($conn, $table_name, $param_arr) {
        if (!$this->connectionCheck($conn)) return false;

        $query  = "\n INSERT INTO %s ( amt";
        $query .= "\n                 ,basic_price";
        $query .= "\n                 ,rate";
        $query .= "\n                 ,aplc_price";
        $query .= "\n                 ,new_price";
        $query .= "\n                 ,cate_sortcode";
        $query .= "\n                 ,cate_paper_mpcode";
        $query .= "\n                 ,cate_beforeside_print_mpcode";
        $query .= "\n                 ,cate_beforeside_add_print_mpcode";
        $query .= "\n                 ,cate_aftside_print_mpcode";
        $query .= "\n                 ,cate_aftside_add_print_mpcode";
        $query .= "\n                 ,cate_stan_mpcode";
        $query .= "\n                 ,page";
        $query .= "\n                 ,page_dvs";
        $query .= "\n                 ,page_detail) VALUES ";
        $query  = sprintf($query, $table_name);

        $param_arr_count = count($param_arr);

        $values_base  = "\n (%s, %s, %s, %s, %s, %s, %s, ";
        $values_base .= "%s, %s, %s, %s, %s, %s, %s, %s)";

        for ($i = 0; $i < $param_arr_count; $i++) {
            $param = $param_arr[$i];

            $param = $this->parameterArrayEscape($conn, $param);

            $query .= sprintf($values_base, $param["amt"]
                                          , $param["basic_price"]
                                          , $param["rate"]
                                          , $param["aplc_price"]
                                          , $param["new_price"]
                                          , $param["cate_sortcode"]
                                          , $param["cate_paper_mpcode"]
                                          , $param["cate_beforeside_print_mpcode"]
                                          , $param["cate_beforeside_add_print_mpcode"]
                                          , $param["cate_aftside_print_mpcode"]
                                          , $param["cate_aftside_add_print_mpcode"]
                                          , $param["cate_stan_mpcode"]
                                          , $param["page"]
                                          , $param["page_dvs"]
                                          , $param["page_detail"]);

            if ($i + 1 < $param_arr_count) {
                $query .= ", ";
            }
        }

        $conn->StartTrans();

        $ret = $conn->Execute($query);

        $conn->CompleteTrans();

        if ($ret) {
            return "SUCCESS";
        } else {
            return "FAIL";
        }
    }
}
?>
