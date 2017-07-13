<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');

class CalculPriceListDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    //////////////////////////////////////////////////////// 이하 종이

    /**
     * @brief 상품 종이 검색해서 option html 반환
     *
     * @param $conn = connection identifer
     * @param $dvs  = 가져올 필드 정보 구분값
     * @param $param = 검색 파라미터
     *
     * @return option html
     */
    function selectPrdtPaperInfoHtml($conn, $dvs, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $rs = $this->selectPaperInfo($conn, $dvs, $param);

        return makeOptionHtml($rs, "", strtolower($dvs));
    }

    /**
     * @brief 상품 종이 맵핑코드 검색
     * 엑셀 생성시에는 정보배열용 컬럼까지 반환함
     *
     * @param $conn       = connection identifer
     * @param $param      = 검색 파라미터
     * @param $excel_flag = 엑셀 생성인지 구분
     *
     * @return 검색결과
     */
    function selectPrdtPaperMpcode($conn, $param, $excel_flag = false) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $paper_search = substr($param["paper_search"], 1, -1);

        $query  = "\n SELECT  mpcode";
        if ($excel_flag === true) {
            $query .= "\n       ,sort";
            $query .= "\n       ,name";
            $query .= "\n       ,dvs";
            $query .= "\n       ,color";
            $query .= "\n       ,CONCAT(basisweight, basisweight_unit) AS basisweight";
            $query .= "\n       ,affil";
            $query .= "\n       ,size";
            $query .= "\n       ,crtr_unit";
        }

        $query .= "\n   FROM prdt_paper";

        $query .= "\n  WHERE search_check LIKE '%s%%'";

        if ($this->blankParameterCheck($param ,"affil")) {
            $query .= "\n    AND affil = " . $param["affil"];
        }
        if ($this->blankParameterCheck($param ,"size")) {
            $query .= "\n    AND size = " . $param["size"];
        }

        $query  = sprintf($query, $paper_search);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 종이 가격 검색
     *
     * @detail $param["mpcode"] 같은 경우는 배열 혹은 문자열이 넘어온다
     *
     * @param $conn  = connection identifer
     * @param $param = 검색조건
     *
     * @return 검색결과
     */
    function selectPrdtPaperPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.sort";
        $query .= "\n        ,A.name";
        $query .= "\n        ,A.dvs";
        $query .= "\n        ,A.color";
        $query .= "\n        ,A.affil";
        $query .= "\n        ,A.size";
        $query .= "\n        ,CONCAT(A.basisweight, A.basisweight_unit) AS basisweight";
        $query .= "\n        ,A.crtr_unit";
        $query .= "\n        ,B.prdt_paper_price_seqno AS price_seqno";
        $query .= "\n        ,B.basic_price";
        $query .= "\n        ,B.sell_rate";
        $query .= "\n        ,B.sell_aplc_price";
        $query .= "\n        ,B.sell_price";

        $query .= "\n   FROM  prdt_paper       AS A";
        $query .= "\n        ,prdt_paper_price AS B";

        $query .= "\n  WHERE  A.mpcode = B.prdt_paper_mpcode";
        $query .= "\n    AND  A.mpcode = %s";
        $query .= "\n    AND  B.cpn_admin_seqno = %s";

        $query  = sprintf($query, $param["mpcode"]
                                , $param["sell_site"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 종이 가격 검색
     *
     * @detail 가격 수정시에도 사용됨
     *
     * @param $conn  = connection identifer
     * @param $param = 검색 파라미터
     *
     * @return 검색결과
     */
    function selectPrdtPaperPriceExcel($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array("mpcode" => true);

        $param = $this->parameterArrayEscape($conn, $param, $except_arr);

        $query  = "\n SELECT  prdt_paper_price_seqno AS price_seqno";
        $query .= "\n        ,basic_price";
        $query .= "\n        ,sell_rate";
        $query .= "\n        ,sell_aplc_price";
        $query .= "\n        ,sell_price";

        $query .= "\n   FROM  prdt_paper_price";

        $query .= "\n  WHERE  1 = 1";
        if ($this->blankParameterCheck($param, "mpcode")) {
            $query .= "\n    AND  prdt_paper_mpcode IN (";
            $query .= $param["mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "sell_site")) {
            $query .= "\n    AND  cpn_admin_seqno   = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  prdt_paper_price_seqno = ";
            $query .= $param["price_seqno"];
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 종이 가격 수정
     *
     * @param $conn  = connection identifier
     * @param $param = 조건용 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updatePrdtPaperPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "prdt_paper_price";

        $temp["col"]["sell_rate"]       = $param["sell_rate"];
        $temp["col"]["sell_aplc_price"] = $param["sell_aplc_price"];
        $temp["col"]["sell_price"]      = $param["sell_price"];

        $temp["prk"] = "prdt_paper_price_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }

    //////////////////////////////////////////////////////// 이하 출력

    /**
     * @brief 상품 출력 검색해서 option html 반환
     *
     * @param $conn  = connection identifer
     * @param $dvs   = 가져올 필드 정보 구분값
     * @param $param = 검색 파라미터
     *
     * @return option html
     */
    function selectPrdtOutputInfoHtml($conn, $dvs, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $rs = $this->selectOutputInfo($conn, $dvs, $param);

        if ($dvs === "NAME") {
            $dvs = "output_name";
        } else if ($dvs === "BOARD") {
            $dvs = "output_board_dvs";
        }

        return makeOptionHtml($rs, "", $dvs);
    }

    /**
     * @brief 상품 출력 맵핑코드 검색
     * 엑셀 생성시에는 정보배열용 컬럼까지 반환함
     *
     * @param $conn       = connection identifer
     * @param $param      = 검색 파라미터
     * @param $excel_flag = 엑셀 생성인지 구분
     *
     * @return 검색결과
     */
    function selectPrdtOutputMpcode($conn, $param, $excel_flag = false) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  mpcode";
        if ($excel_flag === true) {
            $query .= "\n        ,output_name";
            $query .= "\n        ,output_board_dvs";
            $query .= "\n        ,size";
        }
        $query .= "\n  FROM  prdt_output_info";

        $query .= "\n WHERE  output_name = %s";

        if ($this->blankParameterCheck($param, "output_board_dvs")) {
            $query .= "\n    AND output_board_dvs = ";
            $query .= $param["output_board_dvs"];
        }
        if ($this->blankParameterCheck($param, "output_board_affil")) {
            $query .= "\n    AND affil = ";
            $query .= $param["output_board_affil"];
        }
        if ($this->blankParameterCheck($param, "output_board_size")) {
            $query .= "\n    AND size = ";
            $query .= $param["output_board_size"];
        }

        $query  = sprintf($query, $param["output_name"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 출력 가격검색
     *
     * @param $conn  = connection identifer
     * @param $param = 검색 파라미터
     *
     * @return 검색결과
     */
    function selectPrdtOutputPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n SELECT  A.output_name";
        $query .= "\n        ,A.output_board_dvs";
        $query .= "\n        ,A.size";
        $query .= "\n        ,B.prdt_stan_price_seqno AS price_seqno";
        $query .= "\n        ,B.board_amt";
        $query .= "\n        ,B.basic_price";
        $query .= "\n        ,B.sell_rate";
        $query .= "\n        ,B.sell_aplc_price";
        $query .= "\n        ,B.sell_price";

        $query .= "\n   FROM  prdt_output_info AS A";
        $query .= "\n        ,prdt_stan_price  AS B";

        $query .= "\n  WHERE  A.mpcode = B.prdt_output_info_mpcode";
        $query .= "\n    AND  A.mpcode = %s";
        $query .= "\n    AND  B.cpn_admin_seqno = %s";

        $query  = sprintf($query, $param["mpcode"]
                                , $param["sell_site"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 출력 가격검색
     *
     * @param $conn  = connection identifer
     * @param $param = 검색 파라미터
     *
     * @return 검색결과
     */
    function selectPrdtOutputPriceExcel($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  prdt_stan_price_seqno AS price_seqno";
        $query .= "\n        ,board_amt";
        $query .= "\n        ,basic_price";
        $query .= "\n        ,sell_rate";
        $query .= "\n        ,sell_aplc_price";
        $query .= "\n        ,sell_price";

        $query .= "\n   FROM  prdt_stan_price";

        $query .= "\n  WHERE  1 = 1";

        if ($this->blankParameterCheck($param, "mpcode")) {
            $query .= "\n    AND  prdt_output_info_mpcode = ";
            $query .= $param["mpcode"];
        }
        if ($this->blankParameterCheck($param, "sell_site")) {
            $query .= "\n    AND  cpn_admin_seqno         = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  prdt_stan_price_seqno = ";
            $query .= $param["price_seqno"];
        }

        $query  = sprintf($query, $param["mpcode"]
                                , $param["sell_site"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 출력 가격 수정
     *
     * @param $conn  = connection identifier
     * @param $param = 조건용 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updatePrdtOutputPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "prdt_stan_price";

        $temp["col"]["sell_rate"]       = $param["sell_rate"];
        $temp["col"]["sell_aplc_price"] = $param["sell_aplc_price"];
        $temp["col"]["sell_price"]      = $param["sell_price"];

        $temp["prk"] = "prdt_stan_price_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }

    //////////////////////////////////////////////////////// 이하 인쇄

    /**
     * @brief 상품 인쇄 검색해서 option html 반환
     *
     * @param $conn  = connection identifer
     * @param $dvs   = 가져올 필드 정보 구분값
     * @param $param = 검색 파라미터
     *
     * @return option html
     */
    function selectPrdtPrintInfoHtml($conn, $dvs, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $rs = $this->selectPrintInfo($conn, $dvs, $param);

        if ($dvs === "NAME") {
            $dvs = "print_name";
        } else if ($dvs === "PURP") {
            $dvs = "purp_dvs";
        }

        return makeOptionHtml($rs, "", $dvs);
    }

    /**
     * @brief 상품 인쇄 맵핑코드 검색
     * 엑셀 생성시에는 정보배열용 컬럼까지 반환함
     *
     * @param $conn       = connection identifer
     * @param $param      = 검색 파라미터
     * @param $excel_flag = 엑셀 생성인지 구분
     *
     * @return 검색결과
     */
    function selectPrdtPrintMpcode($conn, $param, $excel_flag = false) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.mpcode";
        if ($excel_flag === true) {
            $query .= "\n        ,B.cate_name";
            $query .= "\n        ,A.print_name";
            $query .= "\n        ,A.purp_dvs";
            $query .= "\n        ,A.affil";
            $query .= "\n        ,A.crtr_unit";
        }
        $query .= "\n  FROM  prdt_print_info AS A";
        if ($excel_flag === true) {
            $query .= "\n       ,cate AS B";
        }

        $query .= "\n WHERE  1 = 1";

        if ($this->blankParameterCheck($param, "print_name")) {
            $query .= "\n    AND  A.print_name = ";
            $query .= $param["print_name"];
        }
        if ($this->blankParameterCheck($param, "purp_dvs")) {
            $query .= "\n    AND  A.purp_dvs = ";
            $query .= $param["print_purp_dvs"];
        }
        if ($this->blankParameterCheck($param, "print_affil")) {
            $query .= "\n    AND  A.affil = ";
            $query .= $param["output_board_affil"];
        }
        if ($this->blankParameterCheck($param, "cate_sortcode")) {
            $cate_sortcode = substr($param["cate_sortcode"], 1, -1);

            $query .= "\n    AND  A.cate_sortcode LIKE '";
            $query .= $cate_sortcode;
            $query .= "%%'";
        }
        if ($excel_flag === true) {
            $query .= "\n    AND  A.cate_sortcode = B.sortcode";
        }

        $query  = sprintf($query, $param["print_name"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 인쇄 가격검색
     *
     * @param $conn  = connection identifer
     * @param $param = 검색 파라미터
     *
     * @return 검색결과
     */
    function selectPrdtPrintPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  C.cate_name";
        $query .= "\n        ,A.print_name";
        $query .= "\n        ,A.purp_dvs";
        $query .= "\n        ,A.crtr_unit";
        $query .= "\n        ,B.prdt_print_price_seqno AS price_seqno";
        $query .= "\n        ,B.amt";
        $query .= "\n        ,B.basic_price";
        $query .= "\n        ,B.sell_rate";
        $query .= "\n        ,B.sell_aplc_price";
        $query .= "\n        ,B.sell_price";

        $query .= "\n   FROM  prdt_print_info  AS A";
        $query .= "\n        ,prdt_print_price AS B";
        $query .= "\n        ,cate             AS C";

        $query .= "\n  WHERE  A.mpcode = B.prdt_print_info_mpcode";
        $query .= "\n    AND  A.cate_sortcode = C.sortcode";
        $query .= "\n    AND  A.mpcode = %s";
        $query .= "\n    AND  B.cpn_admin_seqno = %s";

        $query  = sprintf($query, $param["mpcode"]
                                , $param["sell_site"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 상품 출력 가격검색
     *
     * @param $conn  = connection identifer
     * @param $param = 검색 파라미터
     *
     * @return 검색결과
     */
    function selectPrdtPrintPriceExcel($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  prdt_print_price_seqno AS price_seqno";
        $query .= "\n        ,amt";
        $query .= "\n        ,basic_price";
        $query .= "\n        ,sell_rate";
        $query .= "\n        ,sell_aplc_price";
        $query .= "\n        ,sell_price";

        $query .= "\n   FROM  prdt_print_price";

        $query .= "\n  WHERE  1 = 1";

        if ($this->blankParameterCheck($param, "mpcode")) {
            $query .= "\n    AND  prdt_print_info_mpcode = ";
            $query .= $param["mpcode"];
        }
        if ($this->blankParameterCheck($param, "sell_site")) {
            $query .= "\n    AND  cpn_admin_seqno        = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  prdt_print_price_seqno = ";
            $query .= $param["price_seqno"];
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 인쇄 가격 수정
     *
     * @param $conn  = connection identifier
     * @param $param = 조건용 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updatePrdtPrintPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "prdt_print_price";

        $temp["col"]["sell_rate"]       = $param["sell_rate"];
        $temp["col"]["sell_aplc_price"] = $param["sell_aplc_price"];
        $temp["col"]["sell_price"]      = $param["sell_price"];

        $temp["prk"] = "prdt_print_price_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }
}
?>
