<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/calcul_mng/settle/IncomeDataHTML.php");

/**
 * @file IncomeDataDAO.php
 *
 * @brief 정산관리 - 결산 - 수입자료 DAO
 */
class IncomeDataDAO extends CommonDAO {

    function __construct() {
    }

    /*
     * 금전출납부 수입자료 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectIncomeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  A.evid_date";
        $query .= "\n           ,A.regi_date";
        $query .= "\n           ,A.income_price";
        $query .= "\n           ,A.trsf_income_price";
        $query .= "\n           ,A.depo_withdraw_path";
        $query .= "\n           ,A.depo_withdraw_path_detail";
        $query .= "\n           ,B.office_nick";
        $query .= "\n      FROM  cashbook A";
        $query .= "\n      LEFT OUTER JOIN member B";
        $query .= "\n        ON  A.member_seqno = B.member_seqno";
        $query .= "\n     WHERE  (dvs = 'income'";
        $query .= "\n        OR   dvs = 'trsf_income')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  A.cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //회원 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  A.member_seqno = ";
            $query .= $param["member_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_path")) {

            $query .= "\n            AND  A.depo_withdraw_path = ";
            $query .= $param["depo_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_path_detail")) {

            $query .= "\n            AND  A.depo_withdraw_path_detail = ";
            $query .= $param["depo_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  A.regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  A.regi_date <= " . $param["date_to"];

        }

        $query .= "\n  ORDER BY A.regi_date DESC";
 
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
     * 금전출납부 수입자료 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countIncomeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  count(*) cnt";
        $query .= "\n      FROM  cashbook A";
        $query .= "\n      LEFT OUTER JOIN member B";
        $query .= "\n        ON  A.member_seqno = B.member_seqno";
        $query .= "\n     WHERE  (dvs = 'income'";
        $query .= "\n        OR   dvs = 'trsf_income')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  A.cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //회원 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  A.member_seqno = ";
            $query .= $param["member_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_path")) {

            $query .= "\n            AND  A.depo_withdraw_path = ";
            $query .= $param["depo_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_path_detail")) {

            $query .= "\n            AND  A.depo_withdraw_path_detail = ";
            $query .= $param["depo_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  A.regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  A.regi_date <= " . $param["date_to"];

        }
        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 이체수입,이체지출 합계 가져오기 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectIncomeSumPrice($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1,-1);

        $query  = "\n    SELECT";
        $query .= "\n            SUM(income_price)  AS income";
        $query .= "\n           ,SUM(trsf_income_price)   AS trsf_income";
        $query .= "\n      FROM  cashbook A";
        $query .= "\n      LEFT OUTER JOIN member B";
        $query .= "\n        ON  A.member_seqno = B.member_seqno";
        $query .= "\n     WHERE  (dvs = 'income'";
        $query .= "\n        OR   dvs = 'trsf_income')";

        if ($this->blankParameterCheck($param ,"sum_dvs")) {

            $query .= "\n       AND  A.depo_withdraw_path = ";
            $query .= $param["sum_dvs"];

        }

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  A.cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //회원 일련번호가 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  A.member_seqno = ";
            $query .= $param["member_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_path")) {

            $query .= "\n            AND  A.depo_withdraw_path = ";
            $query .= $param["depo_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_path_detail")) {

            $query .= "\n            AND  A.depo_withdraw_path_detail = ";
            $query .= $param["depo_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  A.regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  A.regi_date <= " . $param["date_to"];

        }

        $result = $conn->Execute($query);

        return $result;
        $result = $conn->Execute($query);

        return $result;
    }


    /*
     * 입출금 상세 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectPathDetail($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  B.name";
        $query .= "\n      FROM  depo_withdraw_path A";
        $query .= "\n           ,depo_withdraw_path_detail B";
        $query .= "\n     WHERE  A.depo_withdraw_path_seqno = ";
        $query .= "B.depo_withdraw_path_seqno";

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param, "path")) {
            $query .= "\n       AND A.name = " . $param["path"];
        }

        $result = $conn->Execute($query);

        return $result;
    }



}
?>
