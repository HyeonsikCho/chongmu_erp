<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/prdc_prdt_mng/PrintMngHTML.php");

class PrintMngDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /*
     * 인쇄 이름 Select 
     * $conn : DB Connection
     * $param : $param["search"] = "검색어"
     * return : resultSet 
     */ 
    function selectPrdcPrintName($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  DISTINCT name";
        $query .= "\n      FROM  print";
        
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            
            $query .= "\n   WHERE  name like '%" . $search_str . "%' ";

        }
        
        $result = $conn->Execute($query);
        return $result;
    }

    /*
     * 인쇄 정보 Select 
     * $conn : DB Connection
     * $param : $param["name"] = "인쇄명"
     * $param : $param["manu_seqno"] = "외부 업체 일련번호"
     * $param : $param["brand_seqno"] = "브랜드 일련번호"
     * $param : $param["affil_fs"] = "46계열"
     * $param : $param["affil_guk"] = "국계열"
     * $param : $param["affil_spc"] = "별계열"
     * $param : $param["crtr_unit"] = "기준 단위"
     * return : resultSet 
     */ 
    function selectPrdcPrintList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.top";
        $query .= "\n           ,A.name";
        $query .= "\n           ,A.affil";
        $query .= "\n           ,A.wid_size";
        $query .= "\n           ,A.vert_size";
        $query .= "\n           ,A.crtr_tmpt";
        $query .= "\n           ,A.crtr_unit";
        $query .= "\n           ,A.amt";
        $query .= "\n           ,A.print_seqno";
        $query .= "\n           ,A.basic_price";
        $query .= "\n           ,A.pur_rate";
        $query .= "\n           ,A.pur_aplc_price";
        $query .= "\n           ,A.pur_price";
        $query .= "\n           ,B.name as brand";
        $query .= "\n           ,C.manu_name";
        $query .= "\n      FROM  print A";
        $query .= "\n           ,extnl_brand B";
        $query .= "\n           ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";

        //인쇄 일련번호
        if ($this->blankParameterCheck($param ,"print_seqno")) {

            $query .= "\n        AND A.print_seqno =" . $param["print_seqno"];
        }

        //인쇄명
        if ($this->blankParameterCheck($param ,"name")) {

            $query .= "\n        AND A.name =" . $param["name"];
        }
        
        //브랜드 일련번호
        if ($this->blankParameterCheck($param ,"brand_seqno")) {

            $query .= "\n        AND B.extnl_brand_seqno =" . $param["brand_seqno"];
        }
 
        //제조사 일련번호
        if ($this->blankParameterCheck($param ,"manu_seqno")) {

            $query .= "\n        AND B.extnl_etprs_seqno =" . $param["manu_seqno"];
        }

        //46계열
        if ($this->blankParameterCheck($param ,"affil_fs")) {

            $query .= "\n        AND (A.affil =" . $param["affil_fs"];

            //국계열
            if ($this->blankParameterCheck($param ,"affil_guk")) {

                $query .= "\n       OR A.affil=" . $param["affil_guk"];
            }

            //별규격계열
            if ($this->blankParameterCheck($param ,"affil_spc")) {
            
                $query .= "\n       OR A.affil=" . $param["affil_spc"];
            }

            $query .= "\n       )";

        //국계열
        } else if ($this->blankParameterCheck($param ,"affil_guk")) {

            $query .= "\n        AND (A.affil =" . $param["affil_guk"];

            //별규격 계열
            if ($this->blankParameterCheck($param ,"affil_spc")) {
            
                $query .= "\n       OR A.affil=" . $param["affil_spc"];
            }

            $query .= "\n       )";

        //별규격계열
        } else if ($this->blankParameterCheck($param ,"affil_spc")) {

            $query .= "\n        AND A.affil =" . $param["affil_spc"];

        }
        
        //기준 단위
        if ($this->blankParameterCheck($param ,"crtr_unit")) {

            $query .= "\n        AND A.crtr_unit =" . $param["crtr_unit"];
        }
 

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 

            $query .= "\n  ORDER BY  A." . $param["sort"] . " " . $param["sort_type"];

        } else {


            $query .= "\n  ORDER BY  A.print_seqno";


        }
        
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
     * @brief 인쇄 가격검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectPrdcPrintPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $except_arr = array("affil" => true); 

        $param = $this->parameterArrayEscape($conn, $param, $except_arr);

        $query  = "\n SELECT  C.manu_name";
        $query .= "\n        ,B.name AS brand_name";
        $query .= "\n        ,A.top";
        $query .= "\n        ,A.name";
        $query .= "\n        ,A.affil";
        $query .= "\n        ,CONCAT(A.wid_size, '*', A.vert_size) AS size";
        $query .= "\n        ,A.crtr_tmpt";
        $query .= "\n        ,A.crtr_unit";
        $query .= "\n        ,A.amt";
        $query .= "\n        ,A.print_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  print       AS A";
        $query .= "\n        ,extnl_brand AS B";
        $query .= "\n        ,extnl_etprs AS C";

        $query .= "\n  WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n    AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        $query .= "\n    AND  A.name = %s";
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
     * @brief 인쇄 가격검색
     *
     * @detail 가격 수정시에 사용
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectPrdcPrintPriceModi($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n SELECT  A.print_seqno AS price_seqno";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.pur_rate";
        $query .= "\n        ,A.pur_aplc_price";
        $query .= "\n        ,A.pur_price";

        $query .= "\n   FROM  print       AS A";
        $query .= "\n        ,extnl_brand AS B";
        $query .= "\n        ,extnl_etprs AS C";

        $query .= "\n  WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n    AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        if ($this->blankParameterCheck($param, "price_seqno")) {
            $query .= "\n    AND  A.print_seqno = ";
            $query .= $param["price_seqno"];
        }
        if ($this->blankParameterCheck($param, "top")) {
            $query .= "\n    AND  A.top = ";
            $query .= $param["top"];
        }
        if ($this->blankParameterCheck($param, "name")) {
            $query .= "\n    AND  A.name = ";
            $query .= $param["name"];
        }
        if ($this->blankParameterCheck($param, "affil")) {
            $query .= "\n    AND  A.affil = ";
            $query .= $param["affil"];
        }
        if ($this->blankParameterCheck($param, "crtr_tmpt")) {
            $query .= "\n    AND  A.crtr_tmpt = ";
            $query .= $param["crtr_tmpt"];
        }
        if ($this->blankParameterCheck($param, "crtr_unit")) {
            $query .= "\n    AND  A.crtr_unit = ";
            $query .= $param["crtr_unit"];
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
     * @brief 인쇄 가격검색
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 쿼리 성공여부
     */
    function updatePrdcPrintPrice($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();

        $temp["table"] = "print";

        $temp["col"]["pur_rate"]       = $param["pur_rate"];
        $temp["col"]["pur_aplc_price"] = $param["pur_aplc_price"];
        $temp["col"]["pur_price"]      = $param["pur_price"];

        $temp["prk"] = "print_seqno";
        $temp["prkVal"] = $param["price_seqno"];

        return $this->updateData($conn, $temp);
    }
}
?>
