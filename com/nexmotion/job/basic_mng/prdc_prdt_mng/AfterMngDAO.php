<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/prdc_prdt_mng/AfterMngHTML.php");

class AfterMngDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /*
     * 후공정 정보 Select 
     * $conn : DB Connection
     * $param : $param["name"] = "후공정명"
     * $param : $param["depth1"] = "depth1명"
     * $param : $param["depth2"] = "depth2명"
     * $param : $param["depth3"] = "depth3명"
     * $param : $param["manu_seqno"] = "외부 업체 일련번호"
     * $param : $param["brand_seqno"] = "브랜드 일련번호"
     * $param : $param["amt"] = "수량"
     * $param : $param["crtr_unit"] = "기준 단위"
     * return : resultSet 
     */ 
    function selectPrdcAfterList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.name";
        $query .= "\n           ,A.depth1";
        $query .= "\n           ,A.depth2";
        $query .= "\n           ,A.depth3";
        $query .= "\n           ,A.amt";
        $query .= "\n           ,A.crtr_unit";
        $query .= "\n           ,A.after_seqno";
        $query .= "\n           ,A.basic_price";
        $query .= "\n           ,A.pur_rate";
        $query .= "\n           ,A.pur_aplc_price";
        $query .= "\n           ,A.pur_price";
        $query .= "\n           ,B.name as brand";
        $query .= "\n           ,C.manu_name";
        $query .= "\n      FROM  after A";
        $query .= "\n           ,extnl_brand B";
        $query .= "\n           ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";

        //후공정 일련번호
        if ($this->blankParameterCheck($param ,"after_seqno")) {

            $query .= "\n        AND A.after_seqno =" . $param["after_seqno"];
        }

        //후공정명
        if ($this->blankParameterCheck($param ,"name")) {

            $query .= "\n        AND A.name =" . $param["name"];
        }
        
        //depth1
        if ($this->blankParameterCheck($param ,"depth1")) {

            $query .= "\n        AND A.depth1 =" . $param["depth1"];
        }
        
        //depth2
        if ($this->blankParameterCheck($param ,"depth2")) {

            $query .= "\n        AND A.depth2 =" . $param["depth2"];
        }
        
        //depth3
        if ($this->blankParameterCheck($param ,"depth3")) {

            $query .= "\n        AND A.depth3 =" . $param["depth3"];
        }

        //브랜드 일련번호
        if ($this->blankParameterCheck($param ,"brand_seqno")) {

            $query .= "\n        AND B.extnl_brand_seqno =" . $param["brand_seqno"];
        }
 
        //제조사 일련번호
        if ($this->blankParameterCheck($param ,"manu_seqno")) {

            $query .= "\n        AND B.extnl_etprs_seqno =" . $param["manu_seqno"];
        }

        //기준 단위
        if ($this->blankParameterCheck($param ,"crtr_unit")) {

            $query .= "\n        AND A.crtr_unit =" . $param["crtr_unit"];
        }

        $query .= "\n  ORDER BY  A.after_seqno";

        //limit 조건
        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param ,"end")) {
 
            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1); 

            $query .= "\n LIMIT " . $param["start"] . ",";
            $query .= $param["end"]; 
        }
    
        $result = $conn->Execute($query);

        return $result;

    }

    /**
     * @brief 후공정 가격검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectPrdcAfterPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array("affil" => true); 

        $param = $this->parameterArrayEscape($conn, $param, $except_arr);

        $query  = "\n SELECT  C.manu_name";
        $query .= "\n        ,B.name AS brand_name";
        $query .= "\n        ,A.name";
        $query .= "\n        ,A.depth1";
        $query .= "\n        ,A.depth2";
        $query .= "\n        ,A.depth3";
        $query .= "\n        ,A.crtr_unit";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.after_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  after       AS A";
        $query .= "\n        ,extnl_brand AS B";
        $query .= "\n        ,extnl_etprs AS C";

        $query .= "\n  WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n    AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        $query .= "\n    AND  A.name = %s";
        if ($this->blankParameterCheck($param, "depth1")) {
            $query .= "\n    AND  A.depth1 = ";
            $query .= $param["depth1"];
        }
        if ($this->blankParameterCheck($param, "depth2")) {
            $query .= "\n    AND  A.depth2 = ";
            $query .= $param["depth2"];
        }
        if ($this->blankParameterCheck($param, "depth3")) {
            $query .= "\n    AND  A.depth3 = ";
            $query .= $param["depth3"];
        }
        if ($this->blankParameterCheck($param, "brand_seqno")) {
            $query .= "\n    AND  A.extnl_brand_seqno = ";
            $query .= $param["brand_seqno"];
        } else if ($this->blankParameterCheck($param, "etprs_seqno")) {
            $query .= "\n    AND  C.extnl_etprs_seqno = ";
            $query .= $param["etprs_seqno"];
        }
        if ($this->blankParameterCheck($param, "affil")) {
            $query .= "\n    AND  A.affil IN (";
            $query .= $param["affil"];
            $query .= ")";
        }

        $query  = sprintf($query, $param["name"]);

        return $conn->Execute($query);
    }

    /**
     * @brief 후공정 가격검색
     *
     * @detail 가격 수정시에 사용
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectPrdcAfterPriceModi($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.after_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  after       AS A";
        $query .= "\n        ,extnl_brand AS B";
        $query .= "\n        ,extnl_etprs AS C";

        $query .= "\n  WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n    AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  A.after_seqno = ";
            $query .= $param["price_seqno"];
        }
        if ($this->blankParameterCheck($param, "name")) {
            $query .= "\n    AND  A.name = ";
            $query .= $param["name"];
        }
        if ($this->blankParameterCheck($param, "depth1")) {
            $query .= "\n    AND  A.depth1 = ";
            $query .= $param["depth1"];
        }
        if ($this->blankParameterCheck($param, "depth2")) {
            $query .= "\n    AND  A.depth2 = ";
            $query .= $param["depth2"];
        }
        if ($this->blankParameterCheck($param, "depth3")) {
            $query .= "\n    AND  A.depth3 = ";
            $query .= $param["depth3"];
        }
        if ($this->blankParameterCheck($param, "brand")) {
            $query .= "\n    AND  B.name = ";
            $query .= $param["brand"];
        }
        if ($this->blankParameterCheck($param, "manu")) {
            $query .= "\n    AND  C.manu_name = ";
            $query .= $param["manu"];
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 후공정 가격검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updatePrdcAfterPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "after";

        $temp["col"]["pur_rate"]       = $param["pur_rate"];
        $temp["col"]["pur_aplc_price"] = $param["pur_aplc_price"];
        $temp["col"]["pur_price"]      = $param["pur_price"];

        $temp["prk"] = "after_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }
}
?>
