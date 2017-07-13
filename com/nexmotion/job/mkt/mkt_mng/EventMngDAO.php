<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/MktCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/mkt/mkt_mng/EventMngHTML.php");

class EventMngDAO extends MktCommonDAO {

    function __construct() {
    }

    /*
     * 낱장형 카테고리 list select 
     * $conn : db connection
     * return : resultset 
     */ 
    function selectFlatCateList($conn) {

        if (!$this->connectioncheck($conn)) return false; 
        $query  = "\n    SELECT   sortcode";
        $query .= "\n            ,cate_name";
        $query .= "\n      FROM   cate";
        $query .= "\n     WHERE   cate_level = '1'";
        $query .= "\n       AND   flattyp_yn = 'Y'";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 오특이 이벤트 list select 
     * $conn : db connection
     * return : resultset 
     */ 
    function selectOeventList($conn) {

        if (!$this->connectioncheck($conn)) return false; 
        $query  = "\n    SELECT   A.name";
        $query .= "\n            ,A.event_date";
        $query .= "\n            ,A.start_hour";
        $query .= "\n            ,A.end_hour";
        $query .= "\n            ,A.dsply_yn";
        $query .= "\n            ,A.oevent_event_seqno";
        $query .= "\n            ,B.cate_name";
        $query .= "\n            ,C.sell_site";
        $query .= "\n      FROM   oevent_event A";
        $query .= "\n            ,cate B";
        $query .= "\n            ,cpn_admin C";
        $query .= "\n     WHERE   A.cate_sortcode = B.sortcode";
        $query .= "\n       AND   A.cpn_admin_seqno = C.cpn_admin_seqno";

        $result = $conn->Execute($query);

        return $result;
    }

    /**
     * @brief 카테고리 검색
     *
     * @param $conn = connection identifier
     * @param $sortcode = connection identifier
     *
     * @return 검색결과
     */
    function selectMktCateList($conn, $sortcode = null) {
        $param = array();
        $param["col"]   = "sortcode, cate_name";
        $param["table"] = "cate";
        if ($sortcode === null) {
            $param["where"]["cate_level"] = "1";
        } else {
            $param["where"]["high_sortcode"] = $sortcode;
        }

        $rs = $this->selectData($conn, $param);

        return $rs;
    }

    /**
     * @brief 카테고리에 해당하는 사이즈 정보를 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectMktCateSize($conn, $param) {
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

        return $rs = $conn->Execute($query);

    }


    /**
     * @brief 카테고리에 해당하는 인쇄 도수 정보를 반환
     *
     * @param $conn  = connection identifier
     * @param $param = 검색용 파라미터
     *
     * @return option html
     */
    function selectMktPrintTmpt($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT DISTINCT A.name";

        $query .= "\n   FROM  prdt_print AS A";
        $query .= "\n        ,cate_print AS B";

        $query .= "\n  WHERE  A.prdt_print_seqno = B.prdt_print_seqno";
        $query .= "\n    AND  B.cate_sortcode = %s";

        $query  = sprintf($query, $param["cate_sortcode"]);

        return $rs = $conn->Execute($query);

    }

    /*
     * 요즘바빠요 이벤트 list select 
     * $conn : db connection
     * return : resultset 
     */ 
    function selectNowadaysList($conn) {

        if (!$this->connectioncheck($conn)) return false; 
        $query  = "\n    SELECT   A.name";
        $query .= "\n            ,A.dsply_yn";
        $query .= "\n            ,A.nowadays_busy_event_seqno";
        $query .= "\n            ,B.cate_name";
        $query .= "\n            ,C.sell_site";
        $query .= "\n      FROM   nowadays_busy_event A";
        $query .= "\n            ,cate B";
        $query .= "\n            ,cpn_admin C";
        $query .= "\n     WHERE   A.cate_sortcode = B.sortcode";
        $query .= "\n       AND   A.cpn_admin_seqno = C.cpn_admin_seqno";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 골라담기 이벤트 list select 
     * $conn : db connection
     * return : resultset 
     */ 
    function selectOvertoList($conn) {

        if (!$this->connectioncheck($conn)) return false; 
        $query  = "\n    SELECT   A.name";
        $query .= "\n            ,A.use_yn";
        $query .= "\n            ,A.overto_event_seqno";
        $query .= "\n            ,A.tot_order_price";
        $query .= "\n            ,A.sale_rate";
        $query .= "\n            ,B.sell_site";
        $query .= "\n      FROM   overto_event A";
        $query .= "\n            ,cpn_admin B";
        $query .= "\n     WHERE   A.cpn_admin_seqno = B.cpn_admin_seqno";

        $result = $conn->execute($query);

        return $result;
    }

    /*
     * 오특이 이벤트 정보 list select 
     * $conn : db connection
     * $param["oevent_seqno"] : 오특이 이벤트 일련번호
     * return : resultset 
     */ 
    function selectOeventInfoList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    SELECT   A.name";
        $query .= "\n            ,A.cate_sortcode";
        $query .= "\n            ,A.cate_paper_mpcode";
        $query .= "\n            ,A.cate_print_mpcode";
        $query .= "\n            ,A.cate_stan_mpcode";
        $query .= "\n            ,C.name as paper_name";
        $query .= "\n            ,C.dvs as paper_dvs";
        $query .= "\n            ,C.color as paper_color";
        $query .= "\n            ,C.basisweight as paper_basisweight";
        $query .= "\n            ,E.name as print_name";
        $query .= "\n            ,A.dsply_yn";
        $query .= "\n            ,A.start_hour";
        $query .= "\n            ,A.end_hour";
        $query .= "\n            ,A.amt";
        $query .= "\n            ,A.amt_unit";
        $query .= "\n            ,A.sum_price";
        $query .= "\n            ,A.sale_price";
        $query .= "\n            ,A.event_date";
        $query .= "\n            ,B.cpn_admin_seqno";
        $query .= "\n      FROM   oevent_event A";
        $query .= "\n            ,cpn_admin B";
        $query .= "\n            ,cate_paper C";
        $query .= "\n            ,cate_print D";
        $query .= "\n            ,prdt_print E";
        $query .= "\n     WHERE   A.oevent_event_seqno = " . $param["oevent_seqno"];
        $query .= "\n       AND   A.cpn_admin_seqno = B.cpn_admin_seqno";
        $query .= "\n       AND   A.cate_paper_mpcode = C.mpcode";
        $query .= "\n       AND   A.cate_print_mpcode = D.mpcode";
        $query .= "\n       AND   D.prdt_print_seqno = E.prdt_print_seqno";

        $result = $conn->execute($query);

        return $result;
    }

    /*
     * 요즘바빠요 이벤트 정보 list select 
     * $conn : db connection
     * $param["nowadays_seqno"] : 요즘바빠요 이벤트 일련번호
     * return : resultset 
     */ 
    function selectNowadaysInfoList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    SELECT   A.name";
        $query .= "\n            ,A.cate_sortcode";
        $query .= "\n            ,A.cate_paper_mpcode";
        $query .= "\n            ,A.cate_print_mpcode";
        $query .= "\n            ,A.cate_stan_mpcode";
        $query .= "\n            ,C.name as paper_name";
        $query .= "\n            ,C.dvs as paper_dvs";
        $query .= "\n            ,C.color as paper_color";
        $query .= "\n            ,C.basisweight as paper_basisweight";
        $query .= "\n            ,E.name as print_name";
        $query .= "\n            ,A.dsply_yn";
        $query .= "\n            ,A.amt";
        $query .= "\n            ,A.amt_unit";
        $query .= "\n            ,A.sum_price";
        $query .= "\n            ,A.sale_price";
        $query .= "\n            ,B.cpn_admin_seqno";
        $query .= "\n      FROM   nowadays_busy_event A";
        $query .= "\n            ,cpn_admin B";
        $query .= "\n            ,cate_paper C";
        $query .= "\n            ,cate_print D";
        $query .= "\n            ,prdt_print E";
        $query .= "\n     WHERE   A.nowadays_busy_event_seqno = " . $param["nowadays_seqno"];
        $query .= "\n       AND   A.cpn_admin_seqno = B.cpn_admin_seqno";
        $query .= "\n       AND   A.cate_paper_mpcode = C.mpcode";
        $query .= "\n       AND   A.cate_print_mpcode = D.mpcode";
        $query .= "\n       AND   D.prdt_print_seqno = E.prdt_print_seqno";

        $result = $conn->execute($query);

        return $result;
    }

    /*
     * 골라담기 이벤트 상세 일련번호 select
     * $conn : db connection
     * $param["seqno"] : 골라담기 이벤트 일련번호
     * return : resultset 
     */ 
    function selectOvertoDetailSeq($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    SELECT   B.overto_event_detail_seqno";
        $query .= "\n      FROM   overto_event A";
        $query .= "\n            ,overto_event_detail B";
        $query .= "\n     WHERE   A.overto_event_seqno = " . $param["seqno"];
        $query .= "\n       AND   A.overto_event_seqno = B.overto_event_seqno";

        $result = $conn->execute($query);

        return $result;
    }


    /*
     * 골라담기 이벤트 상세 list
     * $conn : db connection
     * $param["seqno"] : 골라담기 이벤트 일련번호
     * return : resultset 
     */ 
    function selectOvertoDetailList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);

        $query  = "\n    SELECT   B.cate_sortcode";
        $query .= "\n            ,B.cate_paper_mpcode";
        $query .= "\n            ,B.cate_print_mpcode";
        $query .= "\n            ,B.cate_stan_mpcode";
        $query .= "\n            ,B.overto_event_detail_seqno";
        $query .= "\n            ,D.name as paper_name";
        $query .= "\n            ,D.dvs as paper_dvs";
        $query .= "\n            ,D.color as paper_color";
        $query .= "\n            ,D.basisweight as paper_basisweight";
        $query .= "\n            ,F.name as print_name";
        $query .= "\n            ,A.cpn_admin_seqno";
        $query .= "\n            ,H.name as output_size";
        $query .= "\n            ,I.cate_name";
        $query .= "\n      FROM   overto_event A";
        $query .= "\n            ,overto_event_detail B";
        $query .= "\n            ,cate_paper D";
        $query .= "\n            ,cate_print E";
        $query .= "\n            ,prdt_print F";
        $query .= "\n            ,cate_stan G";
        $query .= "\n            ,prdt_stan H";
        $query .= "\n            ,cate I";
        $query .= "\n     WHERE   A.overto_event_seqno = " . $param["overto_seqno"];

        //골라담기 이벤트 상세를 선택했을때
        if ($this->blankParameterCheck($param ,"overto_detail_seqno")) {

            $query .= "\n       AND   B.overto_event_detail_seqno =" . $param["overto_detail_seqno"];
        }

        $query .= "\n       AND   A.overto_event_seqno = B.overto_event_seqno";
        $query .= "\n       AND   B.cate_paper_mpcode = D.mpcode";
        $query .= "\n       AND   B.cate_print_mpcode = E.mpcode";
        $query .= "\n       AND   E.prdt_print_seqno = F.prdt_print_seqno";
        $query .= "\n       AND   B.cate_stan_mpcode = G.mpcode";
        $query .= "\n       AND   G.prdt_stan_seqno = H.prdt_stan_seqno";
        $query .= "\n       AND   B.cate_sortcode = I.sortcode";

        $result = $conn->execute($query);

        return $result;
    }
}

?>
