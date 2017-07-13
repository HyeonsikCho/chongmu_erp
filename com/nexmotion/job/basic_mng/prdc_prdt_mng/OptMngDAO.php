<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/prdc_prdt_mng/OptMngHTML.php");

class OptMngDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /*
     * 옵션 정보 Select 
     * $conn : DB Connection
     * $param : $param["name"] = "옵션명"
     * $param : $param["depth1"] = "depth1명"
     * $param : $param["depth2"] = "depth2명"
     * $param : $param["depth3"] = "depth3명"
     * $param : $param["amt"] = "수량"
     * $param : $param["crtr_unit"] = "기준 단위"
     * return : resultSet 
     */ 
    function selectPrdcOptList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  name";
        $query .= "\n           ,depth1";
        $query .= "\n           ,depth2";
        $query .= "\n           ,depth3";
        $query .= "\n           ,amt";
        $query .= "\n           ,crtr_unit";
        $query .= "\n           ,opt_seqno";
        $query .= "\n           ,basic_price";
        $query .= "\n           ,pur_rate";
        $query .= "\n           ,pur_aplc_price";
        $query .= "\n           ,pur_price";
        $query .= "\n      FROM  opt";
        $query .= "\n     WHERE  1=1";

        //옵션 일련번호
        if ($this->blankParameterCheck($param ,"opt_seqno")) {

            $query .= "\n        AND opt_seqno =" . $param["opt_seqno"];
        }

        //옵션명
        if ($this->blankParameterCheck($param ,"name")) {

            $query .= "\n        AND name =" . $param["name"];
        }
        
        //depth1
        if ($this->blankParameterCheck($param ,"depth1")) {

            $query .= "\n        AND depth1 =" . $param["depth1"];
        }
        
        //depth2
        if ($this->blankParameterCheck($param ,"depth2")) {

            $query .= "\n        AND depth2 =" . $param["depth2"];
        }
        
        //depth3
        if ($this->blankParameterCheck($param ,"depth3")) {

            $query .= "\n        AND depth3 =" . $param["depth3"];
        }

        //기준 단위
        if ($this->blankParameterCheck($param ,"crtr_unit")) {

            $query .= "\n        AND crtr_unit =" . $param["crtr_unit"];
        }

        $query .= "\n  ORDER BY  opt_seqno";

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
    function selectPrdcOptPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array("affil" => true); 

        $param = $this->parameterArrayEscape($conn, $param, $except_arr);

        $query  = "\n SELECT  A.name";
        $query .= "\n        ,A.depth1";
        $query .= "\n        ,A.depth2";
        $query .= "\n        ,A.depth3";
        $query .= "\n        ,A.crtr_unit";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.opt_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  opt         AS A";

        $query .= "\n  WHERE  A.name = %s";
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
    function selectPrdcOptPriceModi($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.opt_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  opt         AS A";

        $query .= "\n  WHERE  1 = 1";
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  A.opt_seqno = ";
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
    function updatePrdcOptPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "opt";

        $temp["col"]["pur_rate"]       = $param["pur_rate"];
        $temp["col"]["pur_aplc_price"] = $param["pur_aplc_price"];
        $temp["col"]["pur_price"]      = $param["pur_price"];

        $temp["prk"] = "opt_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }
}
?>
