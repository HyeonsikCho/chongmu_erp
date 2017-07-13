<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/calcul_mng/cashbook/CashbookListHTML.php");

/**
 * @file CashbookListDAO.php
 *
 * @brief 정산관리 - 금전출납부 - 급전출납리스트 DAO
 */
class CashbookListDAO extends CommonDAO {

    function __construct() {
    }

    /*
     * 금전출납부 계정/날짜별 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectAccTypeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n  SELECT  T1.*";
        $query .= "\n         ,C.name       AS acc_subject";
        $query .= "\n         ,D.name       AS detail";
        $query .= "\n         ,D.acc_subject_seqno";
        $query .= "\n    FROM (";
        $query .= "\n          SELECT  evid_date";
        $query .= "\n                 ,regi_date";
        $query .= "\n                 ,sumup";
        $query .= "\n                 ,dvs";
        $query .= "\n                 ,income_price";
        $query .= "\n                 ,expen_price";
        $query .= "\n                 ,trsf_income_price";
        $query .= "\n                 ,trsf_expen_price";
        $query .= "\n                 ,depo_withdraw_path";
        $query .= "\n                 ,depo_withdraw_path_detail";
        $query .= "\n                 ,acc_detail_seqno";
        $query .= "\n                 ,cashbook_seqno";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  (dvs = 'income'";
        $query .= "\n             OR   dvs = 'expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
 
        //계정과목이 있을때
        if ($this->blankParameterCheck($param ,"acc_subject_seqno")) {

            $query .= "\n    WHERE  C.acc_subject_seqno = ";
            $query .= $param["acc_subject_seqno"];

        }

        $query .= "\n  ORDER BY T1.cashbook_seqno DESC";
 
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
     * 금전출납부 계정/날짜별 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countAccTypeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n  SELECT  count(*) AS cnt";
        $query .= "\n    FROM (";
        $query .= "\n          SELECT  acc_detail_seqno";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  (dvs = 'income'";
        $query .= "\n             OR   dvs = 'expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
 
        //계정과목이 있을때
        if ($this->blankParameterCheck($param ,"acc_subject_seqno")) {

            $query .= "\n    WHERE  C.acc_subject_seqno = ";
            $query .= $param["acc_subject_seqno"];

        }


        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 금전출납부 경로별 list Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectPathTypeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n    SELECT  evid_date";
        $query .= "\n           ,regi_date";
        $query .= "\n           ,sumup";
        $query .= "\n           ,trsf_income_price";
        $query .= "\n           ,trsf_expen_price";
        $query .= "\n           ,depo_withdraw_path";
        $query .= "\n           ,depo_withdraw_path_detail";
        $query .= "\n      FROM  cashbook";
        $query .= "\n     WHERE  (dvs = 'trsf_income'";
        $query .= "\n        OR   dvs = 'trsf_expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_path_detail")) {

            $query .= "\n            AND  depo_withdraw_path_detail = ";
            $query .= $param["depo_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }

        $query .= "\n  ORDER BY cashbook_seqno DESC";
 
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
     * 금전출납부 경로별 list Count
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function countPathTypeList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\n  SELECT  count(*) AS cnt";
        $query .= "\n    FROM  cashbook";
        $query .= "\n   WHERE  (dvs = 'trsf_income'";
        $query .= "\n      OR   dvs = 'trsf_expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_withdraw_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_withdraw_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_withdraw_path_detail")) {

            $query .= "\n            AND  depo_withdraw_path_detail = ";
            $query .= $param["depo_withdraw_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }
 
        $result = $conn->Execute($query);

        return $result;
    }


    /*
     * 수입,지출 합계 가져오기 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectSumPrice($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1,-1);

        $query .= "\n  SELECT";
        $query .= "\n            SUM(T1.income_price)  AS income";
        $query .= "\n           ,SUM(T1.expen_price)   AS expen";
        $query .= "\n    FROM (";
        $query .= "\n          SELECT  income_price";
        $query .= "\n                 ,expen_price";
        $query .= "\n                 ,acc_detail_seqno";
        $query .= "\n                 ,cashbook_seqno";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  (dvs = 'income'";
        $query .= "\n             OR   dvs = 'expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
 
        //계정과목이 있을때
        if ($this->blankParameterCheck($param ,"acc_subject_seqno")) {

            $query .= "\n    WHERE  C.acc_subject_seqno = ";
            $query .= $param["acc_subject_seqno"];

        }

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 이체수입,이체지출 합계 가져오기 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectTrsfSumPrice($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1,-1);

        $query  = "\n    SELECT";
        $query .= "\n            SUM(trsf_income_price)  AS trsf_income";
        $query .= "\n           ,SUM(trsf_expen_price)   AS trsf_expen";
        $query .= "\n      FROM  cashbook";
        $query .= "\n     WHERE  (dvs = 'trsf_income'";
        $query .= "\n        OR   dvs = 'trsf_expen')";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //적요가 있을때
        if ($this->blankParameterCheck($param, "sumup")) {
            $query .= "\n       AND sumup LIKE '%";
            $query .= substr($param["sumup"], 1,-1) . "%'";
        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_path"];

        }

        //입출금경로 상세가 있을때
        if ($this->blankParameterCheck($param ,"depo_path_detail")) {

            $query .= "\n            AND  depo_withdraw_path_detail = ";
            $query .= $param["depo_path_detail"];

        }

        //시작날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_from")) {

            $query .= "\n           AND  regi_date >= " . $param["date_from"];

        }

        //종료날짜가 있을때
        if ($this->blankParameterCheck($param ,"date_to")) {

            $query .= "\n           AND  regi_date <= " . $param["date_to"];

        }

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
