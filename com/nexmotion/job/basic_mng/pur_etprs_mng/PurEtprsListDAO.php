<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/pur_etprs_mng/PurCommonHTML.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/pur_etprs_mng/PurEtprsListHTML.php");
//include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/basic_mng/pur/pur_etprs_list/PurMngDOC.php");

class PurEtprsListDAO extends BasicMngCommonDAO {

    function __construct() {
    }

    /*
     * 제조사 Select 
     * $conn : DB Connection
     * $param : $param["pur_prdt"] = "매입품목"
     * return : resultSet 
     */ 
    function selectPurManu($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  manu_name";
        $query .= "\n           ,extnl_etprs_seqno";
        $query .= "\n      FROM  extnl_etprs";
        $query .= "\n     WHERE  pur_prdt=" . $param["pur_prdt"];

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 브랜드 Select 
     * $conn : DB Connection
     * $param : $param["extnl_etprs_seqno"] = "매입업체 일련번호"
     * return : resultSet 
     */ 
    function selectPurBrand($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  name";
        $query .= "\n           ,extnl_brand_seqno";
        $query .= "\n      FROM  extnl_brand";
        $query .= "\n     WHERE  extnl_etprs_seqno=" . $param["extnl_etprs_seqno"];

        $result = $conn->Execute($query);
        return $result;
    }
 
    /*
     * 매입업체 Select 
     * $conn : DB Connection
     * $param : $param["pur_prdt"] = "매입품목"
     * $param : $param["pur_manu"] = "제조사"
     * $param : $param["pur_brand"] = "브랜드"
     * return : resultSet 
     */ 
    function selectExtnlEtprs($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.manu_name";
        $query .= "\n           ,A.tel_num";
        $query .= "\n           ,A.fax";
        $query .= "\n           ,A.addr_front";
        $query .= "\n           ,A.addr_rear";
        $query .= "\n           ,A.extnl_etprs_seqno";
        $query .= "\n           ,B.cell_num";
        $query .= "\n           ,B.name as mng_name";
        $query .= "\n      FROM  extnl_etprs A";
        $query .= "\n           ,extnl_mng B";
        $query .= "\n     WHERE  A.extnl_etprs_seqno = B.extnl_etprs_seqno";
        $query .= "\n       AND  B.dvs='매입업체'";

        if ($this->blankParameterCheck($param ,"pur_prdt")) {

            $query .= "\n       AND A.pur_prdt =" . $param["pur_prdt"]; 
        }

        if ($this->blankParameterCheck($param ,"etprs_seqno")) {

            $query .= "\n       AND A.extnl_etprs_seqno =" . $param["etprs_seqno"]; 
        }

        $result = $conn->Execute($query);

        return $result;

    }
 
    /*
     * 매입업체 관리자 Select 상세 VIEW 
     * $conn : DB Connection
     * $param : $param["extnl_etprs_seqno"] = "외부 업체 일련번호"
     * return : resultSet 
     */ 
    function selectViewPurMng($conn, $param) {
        
        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  B.name";
        $query .= "\n           ,B.tel_num";
        $query .= "\n           ,B.mail";
        $query .= "\n           ,B.job";
        $query .= "\n           ,B.depar";
        $query .= "\n           ,B.exten_num";
        $query .= "\n           ,B.cell_num";
        $query .= "\n      FROM  extnl_etprs A";
        $query .= "\n           ,extnl_mng B";
        $query .= "\n     WHERE  A.extnl_etprs_seqno = B.extnl_etprs_seqno";
        $query .= "\n       AND  A.extnl_etprs_seqno =" . $param["seqno"]; 
        $query .= "\n       AND  B.dvs ='매입업체'";

        $result = $conn->Execute($query);

        return $result;
    }
   

    /*
     * 회계 관리자 Select 상세 VIEW 
     * $conn : DB Connection
     * $param : $param["extnl_etprs_seqno"] = "외부 업체 일련번호"
     * return : resultSet 
     */ 
    function selectViewAcctMng($conn, $param) {
        
        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  B.name";
        $query .= "\n           ,B.tel_num";
        $query .= "\n           ,B.mail";
        $query .= "\n           ,B.job";
        $query .= "\n           ,B.depar";
        $query .= "\n           ,B.exten_num";
        $query .= "\n           ,B.cell_num";
        $query .= "\n      FROM  extnl_etprs A";
        $query .= "\n           ,extnl_mng B";
        $query .= "\n     WHERE  A.extnl_etprs_seqno = B.extnl_etprs_seqno";
        $query .= "\n       AND  A.extnl_etprs_seqno =" . $param["seqno"]; 
        $query .= "\n       AND  B.dvs ='회계'";

        $result = $conn->Execute($query);
        
        return $result;
    }
    
    /*
     * 매입업체, 사업자등록증 Select 상세 VIEW 
     * $conn : DB Connection
     * $param : $param["extnl_etprs_seqno"] = "외부 업체 일련번호"
     * return : resultSet 
     */ 
    function selectViewPurEtprs($conn, $param) {
        
        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.manu_name";
        $query .= "\n           ,A.pur_prdt";
        $query .= "\n           ,A.cpn_name";
        $query .= "\n           ,A.hp";
        $query .= "\n           ,A.tel_num";
        $query .= "\n           ,A.fax";
        $query .= "\n           ,A.mail";
        $query .= "\n           ,A.zipcode";
        $query .= "\n           ,A.addr_front";
        $query .= "\n           ,A.addr_rear";
        $query .= "\n           ,A.doro_yn";
        $query .= "\n           ,A.deal_yn";
        $query .= "\n           ,B.cpn_name as bls_cpn_name";
        $query .= "\n           ,B.repre_name";
        $query .= "\n           ,B.crn";
        $query .= "\n           ,B.tob";
        $query .= "\n           ,B.zipcode as bls_zipcode";
        $query .= "\n           ,B.bc";
        $query .= "\n           ,B.addr_front as bls_addr_front";
        $query .= "\n           ,B.addr_rear as bls_addr_rear";
        $query .= "\n           ,B.doro_yn as bls_doro_yn";
        $query .= "\n           ,B.bank_name";
        $query .= "\n           ,B.ba_num";
        $query .= "\n           ,B.add_items";
        $query .= "\n      FROM  extnl_etprs A ";
        $query .= "\n      LEFT  JOIN  extnl_etprs_bls_info B";
        $query .= "\n        ON  A.extnl_etprs_seqno = B.extnl_etprs_seqno";
        $query .= "\n      WHERE  A.extnl_etprs_seqno =" . $param["seqno"]; 

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 종이 품목 List Select 
     * $conn : DB Connection
     * $param["seqno"] : 제조사 일련번호
     * return : resultSet 
     */ 
    function selectPurPaperList($conn, $param, $type) {
        
        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.affil";
        $query .= "\n           ,A.wid_size";
        $query .= "\n           ,A.vert_size";
        $query .= "\n           ,A.crtr_unit";
        $query .= "\n           ,A.sort";
        $query .= "\n           ,A.dvs";
        $query .= "\n           ,A.name";
        $query .= "\n           ,A.color";
        $query .= "\n           ,A.basisweight";
        $query .= "\n           ,A.paper_seqno";
        $query .= "\n           ,A.basic_price";
        $query .= "\n           ,A.pur_rate";
        $query .= "\n           ,A.pur_aplc_price";
        $query .= "\n           ,A.pur_price";
        $query .= "\n           ,B.name as brand";
        $query .= "\n           ,C.manu_name";
        $query .= "\n      FROM  paper A";
        $query .= "\n           ,extnl_brand B";
        $query .= "\n           ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        
        if ($this->blankParameterCheck($param ,"seqno")) {

            $query .= "\n       AND  C.extnl_etprs_seqno =" . $param["seqno"];
        }

        if ($this->blankParameterCheck($param ,"brand")) {

            $query .= "\n       AND  B.extnl_brand_seqno =" . $param["brand"];
        }

        if ($type == "2") {

            $query .= "\n        AND A.paper_seqno=" . $param["paper_seqno"];

        }

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 

            if ($param["sort"] == "name") {

                $query .= "\n  ORDER BY  A." . $param["sort"] . " " . $param["sort_type"];

            } else if ($param["sort"] == "brand") {

                $query .= "\n  ORDER BY  B.name " . $param["sort_type"];

            }

        } else {

            $query .= "\n  ORDER BY  A.name, A.basisweight ASC";
        }
        

        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param,"end")) {

            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1);

             $query .= "\n LIMIT " . $param["start"] . ",";
             $query .= $param["end"]; 
         }
        
        $result = $conn->Execute($query);

        return $result;
    }

     /*
     * 출력 품목 List Select 
     * $conn : DB Connection
     * $param["seqno"] : 제조사 일련번호
     * return : resultSet 
     */ 
    function selectPurOutputList($conn, $param, $type) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT   A.affil";
        $query .= "\n            ,A.wid_size";
        $query .= "\n            ,A.vert_size";
        $query .= "\n            ,A.crtr_unit";
        $query .= "\n            ,A.output_seqno";
        $query .= "\n            ,A.name";
        $query .= "\n            ,A.board";
        $query .= "\n            ,A.top";
        $query .= "\n            ,A.basic_price";
        $query .= "\n            ,A.pur_rate";
        $query .= "\n            ,A.pur_aplc_price";
        $query .= "\n            ,A.pur_price";
        $query .= "\n            ,B.name as brand";
        $query .= "\n            ,C.manu_name";
        $query .= "\n      FROM   output A";
        $query .= "\n            ,extnl_brand B";
        $query .= "\n            ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";
        
        if ($this->blankParameterCheck($param ,"seqno")) {

            $query .= "\n       AND  C.extnl_etprs_seqno =" . $param["seqno"];
        }
        
        if ($this->blankParameterCheck($param ,"brand")) {

            $query .= "\n       AND  B.extnl_brand_seqno =" . $param["brand"];
        }

        if ($type == "2") {

            $query .= "\n        AND A.output_seqno=" . $param["output_seqno"];
        }

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 

            if ($param["sort"] == "name") {

                $query .= "\n  ORDER BY  A." . $param["sort"] . " " . $param["sort_type"];

            } else if ($param["sort"] == "brand") {

                $query .= "\n  ORDER BY  B.name " . $param["sort_type"];

            }

        } else {

            $query .= "\n  ORDER BY  A.name ASC";
        }
        

        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param,"end")) {

            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1);

             $query .= "\n LIMIT " . $param["start"] . ",";
             $query .= $param["end"]; 
         }
        
        $result = $conn->Execute($query);
        return $result;
    }


     /*
     * 인쇄 품목 List Select 
     * $conn : DB Connection
     * $param["seqno"] : 제조사 일련번호
     * return : resultSet 
     */ 
    function selectPurPrintList($conn, $param, $type) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT   A.affil";
        $query .= "\n            ,A.name";
        $query .= "\n            ,A.wid_size";
        $query .= "\n            ,A.vert_size";
        $query .= "\n            ,A.crtr_unit";
        $query .= "\n            ,A.crtr_tmpt";
        $query .= "\n            ,A.basic_price";
        $query .= "\n            ,A.pur_rate";
        $query .= "\n            ,A.pur_aplc_price";
        $query .= "\n            ,A.pur_price";
        $query .= "\n            ,A.print_seqno";
        $query .= "\n            ,B.name as brand";
        $query .= "\n            ,A.top";
        $query .= "\n            ,C.manu_name";
        $query .= "\n      FROM   print A";
        $query .= "\n            ,extnl_brand B";
        $query .= "\n            ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";

        if ($this->blankParameterCheck($param ,"seqno")) {

            $query .= "\n       AND  C.extnl_etprs_seqno =" . $param["seqno"];
        }
 
        if ($this->blankParameterCheck($param ,"brand")) {

            $query .= "\n       AND  B.extnl_brand_seqno =" . $param["brand"];
        }

        if ($type == "2") {

            $query .= "\n        AND A.print_seqno=" . $param["print_seqno"];

        }

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 

            if ($param["sort"] == "name") {

                $query .= "\n  ORDER BY  A." . $param["sort"] . " " . $param["sort_type"];

            } else if ($param["sort"] == "brand") {

                $query .= "\n  ORDER BY  B.name " . $param["sort_type"];

            }

        } else {

            $query .= "\n  ORDER BY  A.name ASC";
        }
        

        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param,"end")) {

            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1);

             $query .= "\n LIMIT " . $param["start"] . ",";
             $query .= $param["end"]; 
         }
        
        $result = $conn->Execute($query);

        return $result;
    }
    
    /*
     * 후공정 품목 List Select 
     * $conn : DB Connection
     * $param["seqno"] : 제조사 일련번호
     * return : resultSet 
     */ 
    function selectPurAfterOptList($conn, $param, $type) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT   A.depth1";
        $query .= "\n            ,A.depth2";
        $query .= "\n            ,A.depth3";
        $query .= "\n            ,A.amt";
        $query .= "\n            ,A.crtr_unit";
        $query .= "\n            ,A.basic_price";
        $query .= "\n            ,A.pur_rate";
        $query .= "\n            ,A.pur_aplc_price";
        $query .= "\n            ,A.pur_price";
        $query .= "\n            ,A.name";
        $query .= "\n            ,A.after_seqno as seqno";
        $query .= "\n            ,B.name as brand";
        $query .= "\n            ,C.manu_name";
        $query .= "\n            ,C.pur_prdt";
        $query .= "\n      FROM   after A";
        $query .= "\n            ,extnl_brand B";
        $query .= "\n            ,extnl_etprs C";
        $query .= "\n     WHERE  A.extnl_brand_seqno = B.extnl_brand_seqno";
        $query .= "\n       AND  B.extnl_etprs_seqno = C.extnl_etprs_seqno";

        if ($this->blankParameterCheck($param ,"seqno")) {

            $query .= "\n       AND  C.extnl_etprs_seqno =" . $param["seqno"];
        }

        if ($this->blankParameterCheck($param ,"brand")) {

            $query .= "\n       AND  B.extnl_brand_seqno =" . $param["brand"];
        }

        if ($type == "2") {

            $query .= "\n        AND A.after_seqno=" . $param["after_seqno"];

        }

        if ($this->blankParameterCheck($param ,"sort") && $this->blankParameterCheck($param,"sort_type")) {
    
            $param["sort"] = substr($param["sort"], 1, -1);
            $param["sort_type"] = substr($param["sort_type"], 1, -1); 

            if ($param["sort"] == "name") {

                $query .= "\n  ORDER BY  A.name " . $param["sort_type"];

            } else if ($param["sort"] == "brand") {

                $query .= "\n  ORDER BY  B.name " . $param["sort_type"];

            }

        } else {

            $query .= "\n  ORDER BY  A.name ASC";
        }

        if ($this->blankParameterCheck($param ,"start") && $this->blankParameterCheck($param,"end")) {

            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1);

             $query .= "\n LIMIT " . $param["start"] . ",";
             $query .= $param["end"]; 
         }
        
        $result = $conn->Execute($query);

        return $result;
    }



}
?>
