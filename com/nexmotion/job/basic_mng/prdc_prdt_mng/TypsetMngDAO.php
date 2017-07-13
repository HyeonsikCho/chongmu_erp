<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/basic_mng/prdc_prdt_mng/TypsetMngHTML.php");

class TypsetMngDAO extends BasicMngCommonDAO {

    function __construct() {

    }
 
    /*
     * 조판 이름 Select 
     * $conn : DB Connection
     * $param : $param["search"] = "검색어"
     * return : resultSet 
     */ 
    function selectTypsetName($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  DISTINCT name";
        $query .= "\n      FROM  typset_format";
        
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            
            $query .= "\n   WHERE  name like '%" . $search_str . "%' ";

        }
        $query .= "\n  ORDER BY typset_format_seqno ASC";
        
        $result = $conn->Execute($query);
        return $result;
    }
 
    /*
     * 조판 파일 이름 Select 
     * $conn : DB Connection
     * $param : $param["search"] = "검색어"
     * return : resultSet 
     */ 
    function selectTypsetFile($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  DISTINCT origin_file_name";
        $query .= "\n      FROM  typset_format_file";
        
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            
            $query .= "\n   WHERE  origin_file_name like '%" . $search_str . "%' ";

        }
        $query .= "\n  ORDER BY typset_format_file_seqno ASC";
        
        $result = $conn->Execute($query);
        return $result;
    }


    /*
     * 조판 정보 Select 
     * $conn : DB Connection
     * $param : $param["name"] = "조판명"
     * $param : $param["affil_fs"] = "46계열"
     * $param : $param["affil_guk"] = "국계열"
     * $param : $param["affil_spc"] = "별계열"
     * $param : $param["file"] = "조판파일명"
     * return : resultSet 
     */ 
    function selectTypsetList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.name";
        $query .= "\n           ,A.affil";
        $query .= "\n           ,A.subpaper";
        $query .= "\n           ,A.wid_size";
        $query .= "\n           ,A.vert_size";
        $query .= "\n           ,A.process_yn";
        $query .= "\n           ,A.dscr";
        $query .= "\n           ,A.typset_format_seqno";
        $query .= "\n           ,B.file_path";
        $query .= "\n           ,B.origin_file_name";
//        $query .= "\n           ,B.size";
//        $query .= "\n           ,B.ext";
        $query .= "\n           ,B.typset_format_file_seqno";
        $query .= "\n      FROM  typset_format A";
        $query .= "\n LEFT JOIN  typset_format_file B";

        $query .= "\n        ON  A.typset_format_seqno = B.typset_format_seqno";
        $query .= "\n     WHERE  1=1";
        
        //조판명
        if ($this->blankParameterCheck($param ,"name")) {

            $query .= "\n        AND A.name =" . $param["name"];
        }
        
        //파일명
        if ($this->blankParameterCheck($param ,"file")) {

            $query .= "\n        AND B.origin_file_name =" . $param["file"];
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

        $query .= "\n  ORDER BY  A.typset_format_seqno ASC";
        
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
 

}
?>
