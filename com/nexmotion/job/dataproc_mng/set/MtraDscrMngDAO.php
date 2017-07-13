<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/dataproc_mng/set/MtraDscrMngHTML.php");

class MtraDscrMngDAO extends CommonDAO {

    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /*
     * 종이설명 list Select 
     * $conn : db connection
     * $param["paper_name"] : 종이명
     * return : resultset 
     */ 
    function selectPaperDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   name";
        $query .= "\n            ,dvs";
        $query .= "\n            ,paper_sense";
        $query .= "\n            ,paper_dscr_seqno";
        $query .= "\n      FROM   paper_dscr";

        //종이명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $query .= "\n  ORDER BY paper_dscr_seqno";

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

    /*
     * 종이설명 list Count
     * $conn : db connection
     * $param["paper_name"] : 종이명
     * return : resultset 
     */ 
    function countPaperDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   count(*) cnt";
        $query .= "\n      FROM   paper_dscr";

        //종이명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 후공정설명 list Select 
     * $conn : db connection
     * $param["after_name"] : 후공정명
     * return : resultset 
     */ 
    function selectAfterDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   name";
        $query .= "\n            ,dscr";
        $query .= "\n            ,after_dscr_seqno";
        $query .= "\n      FROM   after_dscr";

        //후공정명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $query .= "\n  ORDER BY after_dscr_seqno";

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

    /*
     * 후공정설명 list Count
     * $conn : db connection
     * $param["after_name"] : 후공정명
     * return : resultset 
     */ 
    function countAfterDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   count(*) cnt";
        $query .= "\n      FROM   after_dscr";

        //후공정명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 옵션설명 list Select 
     * $conn : db connection
     * $param["opt_name"] : 옵션명
     * return : resultset 
     */ 
    function selectOptDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   name";
        $query .= "\n            ,dscr";
        $query .= "\n            ,opt_dscr_seqno";
        $query .= "\n      FROM   opt_dscr";

        //옵션명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $query .= "\n  ORDER BY opt_dscr_seqno";

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

    /*
     * 옵션설명 list Count
     * $conn : db connection
     * $param["opt_name"] : 종이명
     * return : resultset 
     */ 
    function countOptDscrList($conn, $param) {

        if (!$this->connectioncheck($conn)) return false; 
        $param = $this->parameterarrayescape($conn, $param);
        $query  = "\n    SELECT   count(*) cnt";
        $query .= "\n      FROM   opt_dscr";

        //옵션명 검색 있을때
        if ($this->blankParameterCheck($param ,"search_str")) {

            $search_str = substr($param["search_str"], 1, -1); 

            $query .= "\n      WHERE  name LIKE '%" . $search_str . "%' ";
        }

        $result = $conn->Execute($query);

        return $result;
    }






}
?>
