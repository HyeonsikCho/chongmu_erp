<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/calcul_mng/settle/AdjustRegiHTML.php");

/**
 * @file AdjustRegiDAO.php
 *
 * @brief 정산관리 - 결산 - 조정등록 DAO
 */
class AdjustRegiDAO extends CommonDAO {

    function __construct() {
    }

    /*
     * 조정 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectAdjustList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n  SELECT  cont";
        $query .= "\n         ,deal_date";
        $query .= "\n         ,price";
        $query .= "\n         ,dvs";
        $query .= "\n         ,dvs_detail";
        $query .= "\n         ,adjust_seqno";
        $query .= "\n    FROM  adjust";
        $query .= "\n   WHERE  1=1";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }
 
        //회원일련번호가 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n            AND  member_seqno = ";
            $query .= $param["member_seqno"];

        }

        $query .= "\n  ORDER BY regi_date DESC";
 
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
     * 조정 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countAdjustList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n  SELECT  count(*) AS cnt";
        $query .= "\n    FROM  adjust";
        $query .= "\n   WHERE  1=1";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }
 
        //회원일련번호가 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n            AND  member_seqno = ";
            $query .= $param["member_seqno"];

        }

        $result = $conn->Execute($query);

        return $result;
    }

    /**
     * @brief 회원 예치금 list Select
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet 
     */ 
    function selectMemberPrepay($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  prepay_price";
        $query .= "\n      FROM  member";
        $query .= "\n     WHERE  member_seqno = " . $param["member_seqno"];

        $result = $conn->Execute($query);

        return $result;
    }

    /**
     * @brief 회원 예치금 Update
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet 
     */ 
    function updateMemberPrepay($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    UPDATE  member";
        $query .= "\n       SET  prepay_price = " . $param["prepay_price"];
        $query .= "\n     WHERE  member_seqno = " . $param["member_seqno"];

        $result = $conn->Execute($query);

        if ($result === FALSE) {
            return false;
        } else {
            return true;
        }
    }

}

?>
