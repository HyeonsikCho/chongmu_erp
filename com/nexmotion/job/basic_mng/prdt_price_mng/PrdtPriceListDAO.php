<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');

class PrdtPriceListDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /**
     * @brief 판매채널에 따른 테이블명을 반환
     *
     * @param $conn    = connection identifier
     * @param $mono_yn = 확정형(0)/계산형(1) 구분
     * @param $seqno   = 회사 일련번호
     *
     * @return 가격 테이블명
     */
    function selectPriceTableName($conn, $mono_yn, $seqno) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $seqno = $this->parameterEscape($conn, $seqno);

        $query  = "\n SELECT price_tb_name";
        $query .= "\n   FROM cpn_admin";
        $query .= "\n  WHERE cpn_admin_seqno = %s";

        $query  = sprintf($query, $seqno);

        $rs = $conn->Execute($query);
        $table_name = explode('|', $rs->fields["price_tb_name"]);

        return $table_name[$mono_yn];
    }

    /**
     * @brief 카테고리 책자형, 계산형, 도수구분 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 책자형 여부
     */
    function selectCateFlatMonoInfo($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  tmpt_dvs";
        $query .= "\n        ,mono_dvs";
        $query .= "\n   FROM  cate";
        $query .= "\n  WHERE  sortcode = %s";

        $query  = sprintf($query, $param["cate_sortcode"]);

        $rs = $conn->Execute($query);

        return $rs;
    }

    /**
     * @brief 카테고리에 해당하는 종이 정보를 반환
     *
     * @detail $dvs에 따라서 가져오는 정보가 틀려진다.
     * $dvs에 들어가는 값은 아래와 같다.
     * name        = 종이명
     * dvs         = 구분
     * color       = 색상
     * basisweight = 평량
     *
     * @param $conn  = connection identifier
     * @param $dvs   = 정보 구분
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectCatePaperHtml($conn, $dvs, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $rs = $this->selectCatePaperInfo($conn, $dvs, $param);

        $str = "";
        if ($dvs === "NAME") {
            $str = "종이명(전체)";
        } else if ($dvs === "DVS") {
            $str = "구분(전체)";
        } else if ($dvs === "COLOR") {
            $str = "색상(전체)";
        } else if ($dvs === "BASISWEIGHT") {
            $str = "평량(전체)";
        }

        return makeOptionHtml($rs, "", strtolower($dvs), $str);
    }

    /**
     * @brief 카테고리에 해당하는 사이즈 정보를 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectCateSizeHtml($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.name";
        $query .= "\n        ,B.mpcode";

        $query .= "\n   FROM  prdt_stan AS A";
        $query .= "\n        ,cate_stan AS B";

        $query .= "\n  WHERE  B.cate_sortcode = %s";
        $query .= "\n    AND  A.prdt_stan_seqno = B.prdt_stan_seqno";

        $query  = sprintf($query, $param["cate_sortcode"]);

        $rs = $conn->Execute($query);

        return makeOptionHtml($rs, "mpcode", "name");
    }

    /**
     * @brief 카테고리에 해당하는 인쇄도수 정보를 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectCateTmptHtml($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT DISTINCT A.name";

        $query .= "\n   FROM  prdt_print AS A";
        $query .= "\n        ,cate_print AS B";

        $query .= "\n  WHERE  A.prdt_print_seqno = B.prdt_print_seqno";
        $query .= "\n    AND  B.cate_sortcode = %s";
        if ($this->blankParameterCheck($param, "side_dvs")) {
            $query .= "\n    AND  A.side_dvs = " . $param["side_dvs"];
        }

        $query  = sprintf($query, $param["cate_sortcode"]);

        $rs = $conn->Execute($query);

        return makeOptionHtml($rs, "", "name", "", "N");
    }

    /**
     * @brief 카테고리와 인쇄도수에 해당하는 인쇄방식 정보를 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectCatePrintPurpHtml($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  DISTINCT A.purp_dvs";

        $query .= "\n   FROM  prdt_print AS A";
        $query .= "\n        ,cate_print AS B";

        $query .= "\n  WHERE  A.prdt_print_seqno = B.prdt_print_seqno";
        $query .= "\n    AND  B.cate_sortcode = %s";

        $query  = sprintf($query, $param["cate_sortcode"]);

        $rs = $conn->Execute($query);

        return makeOptionHtml($rs, "", "purp_dvs", "", "N");
    }

    /**
     * @brief 선택한 인쇄정보로 맵핑코드 검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return 검색결과
     */
    function selectCatePrintMpcode($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  B.mpcode";

        $query .= "\n   FROM  prdt_print AS A";
        $query .= "\n        ,cate_print AS B";

        $query .= "\n  WHERE  A.prdt_print_seqno = B.prdt_print_seqno";
        $query .= "\n    AND  B.cate_sortcode = %s";
        $query .= "\n    AND  A.name = %s";
        if ($this->blankParameterCheck($param, "purp")) {
            $query .= "\n AND  A.purp_dvs = " . $param["purp"];
        }
        if ($this->blankParameterCheck($param, "side_dvs")) {
            $query .= "\n AND  A.side_dvs = " . $param["side_dvs"];
        }

        $query  = sprintf($query, $param["cate_sortcode"]
                                , $param["tmpt"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 합판형 가격 리스트 검색
     *
     * @param $conn       = connection identifier
     * @param $table_name = 가격 테이블명
     * @param $param      = 검색용 파라미터
     * @param $tmpt_dvs   = 도수구분
     *
     * @return 검색결과
     */
    function selectCatePriceList($conn, $table_name, $param, $tmpt_dvs) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array(
            "print_mpcode" => true
        );
        $param = $this->parameterArrayEscape($conn,
                                             $param,
                                             $except_arr);

        $query  = "\n SELECT  A.price_seqno";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.rate";
        $query .= "\n        ,A.aplc_price";
        $query .= "\n        ,A.new_price";
        $query .= "\n        ,B.cate_name";
        $query .= "\n        ,A.page";
        $query .= "\n        ,A.page_dvs";
        $query .= "\n        ,A.page_detail";
        $query .= "\n        ,D.name AS bef_print_name";
        if ($tmpt_dvs === '1') {
            $query .= "\n        ,F.name AS bef_add_print_name";
            $query .= "\n        ,H.name AS aft_print_name";
            $query .= "\n        ,J.name AS aft_add_print_name";
        }
        $query .= "\n        ,L.name AS stan_name";

        $query .= "\n   FROM  %s AS A";
        $query .= "\n        ,cate       AS B";
        // 전면도수
        $query .= "\n        ,cate_print AS C";
        $query .= "\n        ,prdt_print AS D";
        if ($tmpt_dvs === '1') {
            // 전면추가도수
            $query .= "\n        ,cate_print AS E";
            $query .= "\n        ,prdt_print AS F";
            // 후면도수
            $query .= "\n        ,cate_print AS G";
            $query .= "\n        ,prdt_print AS H";
            // 후면추가도수
            $query .= "\n        ,cate_print AS I";
            $query .= "\n        ,prdt_print AS J";
        }
        // 사이즈
        $query .= "\n        ,cate_stan  AS K";
        $query .= "\n        ,prdt_stan  AS L";

        $query .= "\n  WHERE  A.cate_sortcode = B.sortcode";
        // 전면도수
        $query .= "\n    AND  A.cate_beforeside_print_mpcode = C.mpcode";
        $query .= "\n    AND  C.prdt_print_seqno = D.prdt_print_seqno";
        if ($tmpt_dvs === '1') {
            // 전면추가도수
            $query .= "\n    AND  A.cate_beforeside_print_mpcode = E.mpcode";
            $query .= "\n    AND  E.prdt_print_seqno = F.prdt_print_seqno";
            // 후면도수
            $query .= "\n    AND  A.cate_aftside_print_mpcode = G.mpcode";
            $query .= "\n    AND  G.prdt_print_seqno  = H.prdt_print_seqno";
            // 후면추가도수
            $query .= "\n    AND  A.cate_aftside_print_mpcode = I.mpcode";
            $query .= "\n    AND  I.prdt_print_seqno  = J.prdt_print_seqno";
        }
        // 사이즈
        $query .= "\n    AND  A.cate_stan_mpcode  = K.mpcode";
        $query .= "\n    AND  K.prdt_stan_seqno   = L.prdt_stan_seqno";

        $query .= "\n    AND  A.cate_sortcode     = %s";
        $query .= "\n    AND  A.cate_paper_mpcode = %s";
        if ($this->blankParameterCheck($param, "bef_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_print_mpcode IN (";
            $query .= $param["bef_print_mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "aft_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_print_mpcode IN (";
            $query .= $param["aft_print_mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "stan_mpcode")) {
            $query .= "\n    AND  A.cate_stan_mpcode  = ";
            $query .= $param["stan_mpcode"];
        }

        if ($this->blankParameterCheck($param, "amt")) {
            $query .= "\n    AND  A.amt  = ";
            $query .= $param["amt"];
        }

        $query  = sprintf($query, $table_name
                                , $param["cate_sortcode"]
                                , $param["paper_mpcode"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 계산형 가격 리스트 검색
     *
     * @param $conn       = connection identifier
     * @param $table_name = 가격 테이블명
     * @param $param      = 검색용 파라미터
     *
     * @return 검색결과
     */
    function selectCateCalcPriceList($conn, $table_name, $param, $tmpt_dvs) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array(
            "aft_print_mpcode" => true,
            "bef_print_mpcode" => true
        );

        $param = $this->parameterArrayEscape($conn,
                                             $param,
                                             $except_arr);

        $query  = "\n SELECT  A.price_seqno";
        $query .= "\n        ,A.affil";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.paper_price";
        $query .= "\n        ,A.print_price";
        $query .= "\n        ,A.output_price";
        $query .= "\n        ,A.sum_price";
        $query .= "\n        ,B.cate_name";
        $query .= "\n        ,A.page";
        $query .= "\n        ,A.page_dvs";
        $query .= "\n        ,A.page_detail";
        $query .= "\n        ,D.name AS bef_print_name";
        if ($tmpt_dvs === '1') {
            $query .= "\n        ,F.name AS bef_add_print_name";
            $query .= "\n        ,H.name AS aft_print_name";
            $query .= "\n        ,J.name AS aft_add_print_name";
        }
        $query .= "\n        ,L.name AS stan_name";

        $query .= "\n   FROM  %s AS A";
        $query .= "\n        ,cate       AS B";
        // 전면도수
        $query .= "\n        ,cate_print AS C";
        $query .= "\n        ,prdt_print AS D";
        if ($tmpt_dvs === '1') {
            // 전면추가도수
            $query .= "\n        ,cate_print AS E";
            $query .= "\n        ,prdt_print AS F";
            // 후면도수
            $query .= "\n        ,cate_print AS G";
            $query .= "\n        ,prdt_print AS H";
            // 후면추가도수
            $query .= "\n        ,cate_print AS I";
            $query .= "\n        ,prdt_print AS J";
        }
        // 사이즈
        $query .= "\n        ,cate_stan  AS K";
        $query .= "\n        ,prdt_stan  AS L";

        $query .= "\n  WHERE  A.cate_sortcode = B.sortcode";
        // 전면도수
        $query .= "\n    AND  A.cate_beforeside_print_mpcode = C.mpcode";
        $query .= "\n    AND  C.prdt_print_seqno = D.prdt_print_seqno";
        if ($tmpt_dvs === '1') {
            // 전면추가도수
            $query .= "\n    AND  A.cate_beforeside_print_mpcode = E.mpcode";
            $query .= "\n    AND  E.prdt_print_seqno = F.prdt_print_seqno";
            // 후면도수
            $query .= "\n    AND  A.cate_aftside_print_mpcode = G.mpcode";
            $query .= "\n    AND  G.prdt_print_seqno  = H.prdt_print_seqno";
            // 후면추가도수
            $query .= "\n    AND  A.cate_aftside_print_mpcode = I.mpcode";
            $query .= "\n    AND  I.prdt_print_seqno  = J.prdt_print_seqno";
        }
        // 사이즈
        $query .= "\n    AND  A.cate_stan_mpcode  = K.mpcode";
        $query .= "\n    AND  K.prdt_stan_seqno   = L.prdt_stan_seqno";

        $query .= "\n    AND  A.cate_sortcode     = %s";
        $query .= "\n    AND  A.cate_paper_mpcode = %s";
        if ($this->blankParameterCheck($param, "bef_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_print_mpcode IN (";
            $query .= $param["bef_print_mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "aft_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_print_mpcode IN (";
            $query .= $param["aft_print_mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "stan_mpcode")) {
            $query .= "\n    AND  A.cate_stan_mpcode  = ";
            $query .= $param["stan_mpcode"];
        }
        if ($this->blankParameterCheck($param, "affil")) {
            $query .= "\n    AND  A.affil = ";
            $query .= $param["affil"];
        }

        $query  = sprintf($query, $table_name
                                , $param["cate_sortcode"]
                                , $param["paper_mpcode"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 가격과 관련된 테이블(맵핑코드를 가지고 있는 테이블)에서
     * 관련 정보를 반환하는 함수
     *
     * @details 여기서 반환하는 맵핑코드 정보로 가격검색
     * 관련정보는 있되 가격이 없는 것을 엑셀로 생성하기 위함임
     *
     * @param $conn  = 디비 커넥션
     * @param $param = 조건절 파라미터
     *
     * @return 쿼리실행결과
     */
    function selectCatePriceInfoListExcel($conn, $param) {
        if (!$this->connectionCheck($conn)) return false;

        $except_arr = array(
            "print_mpcode" => true
        );

        $param = $this->parameterArrayEscape($conn,
                                             $param,
                                             $except_arr);

        $query .= "\n SELECT  A.cate_name";
        $query .= "\n        ,A.flattyp_yn";
        $query .= "\n        ,C.name     AS stan_name";
        $query .= "\n        ,E.name     AS print_tmpt";
        $query .= "\n        ,E.purp_dvs AS print_purp";
        $query .= "\n        ,B.mpcode AS stan_mpcode";
        $query .= "\n        ,D.mpcode AS print_mpcode";

        $query .= "\n   FROM  cate             AS A";
        $query .= "\n        ,cate_stan        AS B";
        $query .= "\n        ,prdt_stan        AS C";
        $query .= "\n        ,cate_print       AS D";
        $query .= "\n        ,prdt_print       AS E";

        $query .= "\n  WHERE  A.sortcode = %s";
        $query .= "\n    AND  A.sortcode = B.cate_sortcode";
        $query .= "\n    AND  A.sortcode = D.cate_sortcode";
        $query .= "\n    AND  B.prdt_stan_seqno = C.prdt_stan_seqno";
        $query .= "\n    AND  D.prdt_print_seqno = E.prdt_print_seqno";

        if ($this->blankParameterCheck($param, "stan_mpcode")) {
            $query .= "\n    AND  B.mpcode = ";
            $query .= $param["stan_mpcode"];
        }
        if ($this->blankParameterCheck($param, "print_mpcode")) {
            $query .= "\n    AND  D.mpcode IN (";
            $query .= $param["print_mpcode"];
            $query .= ")";
        }
        if ($this->blankParameterCheck($param, "side_dvs")) {
            $query .= "\n    AND  E.side_dvs = ";
            $query .= $param["side_dvs"];
        }

        $query  = sprintf($query, $param["cate_sortcode"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 가격 테이블에서 확정형 가격검색
     *
     * @detail 엑셀 생성과 가격 일괄수정시에 사용한다
     *
     * @param $conn       = connection identifier
     * @param $table_name = 가격 테이블명
     * @param $param      = 검색용 파라미터
     *
     * @return 쿼리실행결과
     */
    function selectCatePriceListExcel($conn, $table_name, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.price_seqno";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.rate";
        $query .= "\n        ,A.aplc_price";
        $query .= "\n        ,A.new_price";
        $query .= "\n        ,A.page";
        $query .= "\n        ,A.page_dvs";
        $query .= "\n        ,A.page_detail";

        $query .= "\n   FROM  %s AS A";

        $query .= "\n  WHERE  1 = 1";

        if ($this->blankParameterCheck($param, "paper_mpcode")) {
            $query .= "\n    AND  A.cate_sortcode = ";
            $query .= $param["cate_sortcode"];
        }
        if ($this->blankParameterCheck($param, "paper_mpcode")) {
            $query .= "\n    AND  A.cate_paper_mpcode = ";
            $query .= $param["paper_mpcode"];
        }
        if ($this->blankParameterCheck($param, "stan_mpcode")) {
            $query .= "\n    AND  A.cate_stan_mpcode = ";
            $query .= $param["stan_mpcode"];
        }
        if ($this->blankParameterCheck($param, "bef_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_print_mpcode = ";
            $query .= $param["bef_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "bef_add_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_add_print_mpcode = ";
            $query .= $param["bef_add_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "aft_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_print_mpcode = ";
            $query .= $param["aft_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "aft_add_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_add_print_mpcode = ";
            $query .= $param["aft_add_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  A.price_seqno = ";
            $query .= $param["price_seqno"];
        }

        $query  = sprintf($query, $table_name);

        return $conn->Execute($query);
    }

    /**
     * @brief 가격 테이블에서 계산형 가격검색
     *
     * @detail 엑셀 생성과 가격 일괄수정시에 사용한다
     *
     * @param $conn       = connection identifier
     * @param $table_name = 가격 테이블명
     * @param $param      = 검색용 파라미터
     *
     * @return 쿼리실행결과
     */
    function selectCateCalcPriceListExcel($conn, $table_name, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.price_seqno";
        $query .= "\n        ,A.affil";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.paper_price";
        $query .= "\n        ,A.print_price";
        $query .= "\n        ,A.output_price";
        $query .= "\n        ,A.sum_price";
        $query .= "\n        ,A.page";
        $query .= "\n        ,A.page_dvs";
        $query .= "\n        ,A.page_detail";

        $query .= "\n   FROM  %s AS A";

        $query .= "\n  WHERE  1 = 1";

        if ($this->blankParameterCheck($param, "affil")) {
            $query .= "\n    AND  A.affil = ";
            $query .= $param["affil"];
        }
        if ($this->blankParameterCheck($param, "paper_mpcode")) {
            $query .= "\n    AND  A.cate_sortcode = ";
            $query .= $param["cate_sortcode"];
        }
        if ($this->blankParameterCheck($param, "paper_mpcode")) {
            $query .= "\n    AND  A.cate_paper_mpcode = ";
            $query .= $param["paper_mpcode"];
        }
        if ($this->blankParameterCheck($param, "stan_mpcode")) {
            $query .= "\n    AND  A.cate_stan_mpcode = ";
            $query .= $param["stan_mpcode"];
        }
        if ($this->blankParameterCheck($param, "bef_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_print_mpcode = ";
            $query .= $param["bef_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "bef_add_print_mpcode")) {
            $query .= "\n    AND  A.cate_beforeside_add_print_mpcode = ";
            $query .= $param["bef_add_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "aft_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_print_mpcode = ";
            $query .= $param["aft_print_mpcode"];
        }
        if ($this->blankParameterCheck($param, "aft_add_print_mpcode")) {
            $query .= "\n    AND  A.cate_aftside_add_print_mpcode = ";
            $query .= $param["aft_add_print_mpcode"];
        }

        $query  = sprintf($query, $table_name);

        return $conn->Execute($query);
    }

    /**
     * @brief 카테고리 수량단위 검색
     *
     * @param $conn          = connection identifier
     * @param $cate_sortcode = 카테고리 분류코드
     *
     * @return 카테고리 수량단위
     */
    function selectCateAmtUnit($conn, $cate_sortcode) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = array();
        $param["col"] = "amt_unit";
        $param["table"] = "cate";
        $param["where"]["sortcode"] = $cate_sortcode;

        $rs = $this->selectData($conn, $param);

        return $rs->fields["amt_unit"];
    }

    /**
     * @brief 가격 수정
     *
     * @param $conn       = connection identifier
     * @param $table_name = 가격 테이블명
     * @param $param      = 조건용 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updateCatePrice($conn, $table_name, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = $table_name;

        $temp["col"]["rate"]       = $param["rate"];
        $temp["col"]["aplc_price"] = $param["aplc_price"];
        $temp["col"]["new_price"]  = $param["new_price"];

        $temp["prk"] = "price_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }

    /**
     * @brief 카테고리 종이 목록 검색
     *
     * @param $conn  = connection identifer
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectPaperInfoAll($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  B.name";
        $query .= "\n        ,B.dvs";
        $query .= "\n        ,B.color";
        $query .= "\n        ,B.basisweight";
        $query .= "\n        ,B.mpcode";
        $query .= "\n        ,A.affil";

        $query .= "\n   FROM  prdt_paper AS A";
        $query .= "\n        ,cate_paper AS B";

        $query .= "\n  WHERE  A.search_check  = ";
        $query .= "CONCAT(B.name, '|', B.dvs, '|', B.color, '|', B.basisweight)";
        $query .= "\n    AND  B.cate_sortcode = %s";

        //종이명
        if ($this->blankParameterCheck($param ,"name")) {
            $query .= "\n   AND  B.name = " . $param["name"];
        }
        //종이구분
        if ($this->blankParameterCheck($param ,"dvs")) {
            $query .= "\n   AND  B.dvs = " . $param["dvs"];
        }
        //종이색상
        if ($this->blankParameterCheck($param ,"color")) {
            $query .= "\n   AND  B.color = " . $param["color"];
        }
        //종이평량
        if ($this->blankParameterCheck($param ,"basisweight")) {
            $query .= "\n   AND  B.basisweight = " . $param["basisweight"];
        }

        $query  = sprintf($query, $param["cate_sortcode"]);

        return $conn->Execute($query);
    }

	/**
     * @brief 상품 확정형 가격 검색
     *
     * @detail $param["cate_sortcode"] = 카테고리 중분류코드
     * $param["paper_mpcode"] = 카테고리 종이 맵핑코드
     * $param["print_mpcode"] = 카테고리 인쇄 맵핑코드
     * $param["stan_mpcode"] = 카테고리 규격 맵핑코드
     * $param["amt"] = 수량
     * $param["table_name"] = 가격 테이블명
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 신규가격
     */
    function selectPrdtPlyPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }
        $temp = array();
        $temp["col"]   = "new_price";
        $temp["table"] = $param["table_name"];
        $temp["where"]["cate_sortcode"]     = $param["cate_sortcode"];
        $temp["where"]["cate_paper_mpcode"] = $param["paper_mpcode"];
        $temp["where"]["cate_print_mpcode"] = $param["print_mpcode"];
        $temp["where"]["cate_stan_mpcode"]  = $param["stan_mpcode"];
        $temp["where"]["amt"]               = $param["amt"];
		$rs = $this->selectData($conn, $temp);
        return $rs->fields["new_price"];
    }
}
?>
