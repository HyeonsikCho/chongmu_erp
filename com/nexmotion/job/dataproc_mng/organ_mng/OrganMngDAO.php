<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/dataproc_mng/organ_mng/OrganMngHTML.php");

class OrganMngDAO extends CommonDAO {

    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /*
     * 부서 관리 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectDeparAdminList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.depar_name";
        $query .= "\n           ,A.depar_admin_seqno";
        $query .= "\n           ,A.high_depar_code";
        $query .= "\n           ,A.cpn_admin_seqno";
        $query .= "\n           ,B.sell_site";
        $query .= "\n      FROM  depar_admin A";
        $query .= "\n           ,cpn_admin B";
        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";
        $query .= "\n       AND  A.depar_level='2'";


        $query .= "\n  ORDER BY  B.cpn_admin_seqno, A.depar_admin_seqno";

        $result = $conn->Execute($query);

        return $result;

    }

    //부서 코드 생성 
    function getDeparCode($conn, $param) {

        if (!$this->connectionCheck($conn)) return false;
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT max(depar_code) as depar_code";
        $query .= "\n      FROM depar_admin";
        $query .= "\n     WHERE high_depar_code=" . $param["high_depar_code"];
        $query .= "\n       AND cpn_admin_seqno=" . $param["cpn_admin_seqno"];

        $rs = $conn->Execute($query);
        
        $depar_code = $rs->fields["depar_code"];

        //신규 카테고리 일 경우
        if ($depar_code == NULL) { 

            $high_depar_code = substr($param["high_depar_code"], 1, -1);
            $depar_code = $high_depar_code . "000";
        }

        $rs = str_pad($depar_code+1, 6, "0", STR_PAD_LEFT);

        return $rs;
    }

    /*
     * 관리자 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectMngList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.name";
        $query .= "\n           ,A.empl_seqno";
        $query .= "\n           ,A.empl_id";
        $query .= "\n           ,A.empl_code";
        $query .= "\n           ,A.admin_auth";
        $query .= "\n           ,A.enter_date";
        $query .= "\n           ,A.cpn_admin_seqno";
        $query .= "\n           ,A.job_code";
        $query .= "\n           ,A.depar_code";
        $query .= "\n           ,A.posi_code";
        $query .= "\n           ,B.sell_site";
        $query .= "\n           ,C.depar_name";
        $query .= "\n           ,D.job_name";
        $query .= "\n      FROM  empl A";
        $query .= "\n           ,cpn_admin B";
        $query .= "\n           ,depar_admin C";
        $query .= "\n           ,job_admin D";
        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";

        //관리자 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"empl_seqno")) {

            $query .= "\n      AND  A.empl_seqno = " . $param["empl_seqno"];

        }
 
        $query .= "\n       AND  A.depar_code = C.depar_code";
        $query .= "\n       AND  A.cpn_admin_seqno = C.cpn_admin_seqno";
        $query .= "\n       AND  A.job_code = D.job_code";
        $query .= "\n       AND  A.resign_yn = 'N'";
        $query .= "\n  ORDER BY  A.empl_seqno";

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
     * 관리자 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countMngList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  count(*) as cnt";
        $query .= "\n      FROM  empl A";
        $query .= "\n           ,cpn_admin B";
        $query .= "\n           ,depar_admin C";
        $query .= "\n           ,job_admin D";
        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";
        $query .= "\n       AND  A.depar_code = C.depar_code";
        $query .= "\n       AND  A.cpn_admin_seqno = C.cpn_admin_seqno";
        $query .= "\n       AND  A.job_code = D.job_code";
        $query .= "\n       AND  A.resign_yn = 'N'";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 관리자 권한 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectMngAuthList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  A.name";
        $query .= "\n           ,A.empl_seqno";
        $query .= "\n           ,A.empl_id";
        $query .= "\n           ,B.sell_site";
        $query .= "\n           ,B.cpn_admin_seqno";
        $query .= "\n           ,C.depar_name";
        $query .= "\n      FROM  empl A";
        $query .= "\n           ,cpn_admin B";
        $query .= "\n           ,depar_admin C";
        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";

        //관리자 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"empl_seqno")) {

            $query .= "\n       AND  A.empl_seqno = " . $param["empl_seqno"];

        }
 
        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n       AND  A.cpn_admin_seqno = " . $param["cpn_admin_seqno"];

        }
 
        $query .= "\n       AND  A.depar_code = C.depar_code";
        $query .= "\n       AND  A.cpn_admin_seqno = C.cpn_admin_seqno";
        //퇴사여부에 따라 넣을지 결정
        $query .= "\n       AND  A.resign_yn = 'N'";
        $query .= "\n  ORDER BY  A.empl_seqno";

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
     * 관리자 권한 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countMngAuthList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  count(*) as cnt";
        $query .= "\n      FROM  empl A";
        $query .= "\n           ,cpn_admin B";
        $query .= "\n           ,depar_admin C";

        $query .= "\n     WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno";

        //관리자 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"empl_seqno")) {

            $query .= "\n       AND  A.empl_seqno = " . $param["empl_seqno"];

        }
 
        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n       AND  A.cpn_admin_seqno = " . $param["cpn_admin_seqno"];

        }

        $query .= "\n       AND  A.depar_code = C.depar_code";
        $query .= "\n       AND  A.cpn_admin_seqno = C.cpn_admin_seqno";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 직원 이름 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectEmplNameList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  name, empl_seqno";
        $query .= "\n      FROM  empl";
        $query .= "\n     WHERE  1=1";

        //검색어 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n     AND  cpn_admin_seqno = " . $param["cpn_admin_seqno"];

        }
 
        //검색어 있을때
        if ($this->blankParameterCheck($param ,"search")) {

            $search_str = substr($param["search"], 1, -1); 
            
            $query .= "\n    AND  name like '%" . $search_str . "%' ";

        }
 
        $result = $conn->Execute($query);

        return $result;

    }








}


?>
