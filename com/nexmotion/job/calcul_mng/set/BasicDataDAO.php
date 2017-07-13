<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/calcul_mng/set/BasicDataHTML.php");

/**
 * @file BasicDataDAO.php
 *
 * @brief 정산관리 - 설정 - 기초데이터 DAO
 */
class BasicDataDAO extends CommonDAO {

    function __construct() {
    }

    /*
     * 계정 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectAccList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.note";
        $query .= "\n           ,A.name      AS acc_detail";
        $query .= "\n           ,A.acc_detail_seqno";
        $query .= "\n           ,B.name      AS acc_subject";
        $query .= "\n           ,B.acc_subject_seqno";
        $query .= "\n      FROM  acc_detail A";
        $query .= "\n           ,acc_subject B";
        $query .= "\n     WHERE A.acc_subject_seqno = B.acc_subject_seqno";
        $query .= "\n  ORDER BY B.name DESC";

        //limit 조건
        if ($this->blankParameterCheck($param ,"start") 
                && $this->blankParameterCheck($param ,"end")) {
 
            $param["start"] = substr($param["start"], 1, -1);
            $param["end"] = substr($param["end"], 1, -1); 

            $query .= "\n LIMIT " . $param["start"] . ",";
            $query .= $param["end"]; 
        }

        $result = $conn->Execute($query);

        return $result;

    }

    /*
     * 계정 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countAccList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);


        $query  = "\n    SELECT  count(*) AS cnt";
        $query .= "\n      FROM  acc_detail A";
        $query .= "\n           ,acc_subject B";
        $query .= "\n     WHERE A.acc_subject_seqno = B.acc_subject_seqno";

        $result = $conn->Execute($query);

        return $result;

    }

}

?>
