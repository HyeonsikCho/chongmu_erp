<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/calcul_mng/cashbook/CashbookRegiHTML.php");

/**
 * @file CashbookRegiDAO.php
 *
 * @brief 정산관리 - 금전출납부 - 급전출납등록 DAO
 */
class CashbookRegiDAO extends CommonDAO {

    function __construct() {
    }

    /**
     * @brief 금전출납부 list Select 
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet 
     */ 
    function selectCashbookList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\n  SELECT  T1.*";
        $query .= "\n         ,C.name       AS acc_subject";
        $query .= "\n         ,C.acc_subject_seqno";
        $query .= "\n         ,D.name       AS detail";
        $query .= "\n         ,D.acc_subject_seqno";
        $query .= "\n         ,E.office_nick      AS member_name";
        $query .= "\n         ,E.member_seqno";
        $query .= "\n         ,F.manu_name        AS manu_name";
        $query .= "\n         ,F.extnl_etprs_seqno";
        $query .= "\n    FROM (";
        $query .= "\n          SELECT  evid_date";
        $query .= "\n                 ,regi_date";
        $query .= "\n                 ,cashbook_seqno";
        $query .= "\n                 ,sumup";
        $query .= "\n                 ,dvs";
        $query .= "\n                 ,income_price";
        $query .= "\n                 ,expen_price";
        $query .= "\n                 ,trsf_income_price";
        $query .= "\n                 ,trsf_expen_price";
        $query .= "\n                 ,depo_withdraw_path";
        $query .= "\n                 ,depo_withdraw_path_detail";
        $query .= "\n                 ,extnl_etprs_seqno";
        $query .= "\n                 ,member_seqno";
        $query .= "\n                 ,acc_detail_seqno";
        $query .= "\n                 ,cpn_admin_seqno";
        $query .= "\n                 ,card_cpn";
        $query .= "\n                 ,card_num";
        $query .= "\n                 ,mip_mon";
        $query .= "\n                 ,aprvl_num";
        $query .= "\n                 ,aprvl_date";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  1=1";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //수입지출 구분이 있을때
        if ($this->blankParameterCheck($param ,"dvs")) {

            $query .= "\n            AND  dvs = ";
            $query .= $param["dvs"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_withdraw_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_withdraw_path"];

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
 
        //제조사명이 있을때
        if ($this->blankParameterCheck($param ,"extnl_etprs_seqno")) {

            $query .= "\n           AND  extnl_etprs_seqno = ";
            $query .= $param["extnl_etprs_seqno"];

        }

        //회원명이 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  member_seqno = ";
            $query .= $param["member_seqno"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
        $query .= "\n LEFT JOIN  member E";
        $query .= "\n        ON  T1.member_seqno = E.member_seqno";
        $query .= "\n LEFT JOIN  extnl_etprs F";
        $query .= "\n        ON  T1.extnl_etprs_seqno = ";
        $query .=  "F.extnl_etprs_seqno";
 
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

    /**
     * @brief 금전출납부 list Count
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet 
     */ 
    function countCashbookList($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);


        $query  = "\n  SELECT  count(*) AS cnt";
        $query .= "\n    FROM (";
        $query .= "\n          SELECT  extnl_etprs_seqno";
        $query .= "\n                 ,member_seqno";
        $query .= "\n                 ,acc_detail_seqno";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  1=1";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //수입지출 구분이 있을때
        if ($this->blankParameterCheck($param ,"dvs")) {

            $query .= "\n            AND  dvs = ";
            $query .= $param["dvs"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_withdraw_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_withdraw_path"];

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

        //제조사명이 있을때
        if ($this->blankParameterCheck($param ,"extnl_etprs_seqno")) {

            $query .= "\n           AND  extnl_etprs_seqno = ";
            $query .= $param["extnl_etprs_seqno"];

        }

        //회원명이 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  member_seqno = ";
            $query .= $param["member_seqno"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
        $query .= "\n LEFT JOIN  member E";
        $query .= "\n        ON  T1.member_seqno = E.member_seqno";
        $query .= "\n LEFT JOIN  extnl_etprs F";
        $query .= "\n        ON  T1.extnl_etprs_seqno = ";
        $query .=  "F.extnl_etprs_seqno";
 
        //계정과목이 있을때
        if ($this->blankParameterCheck($param ,"acc_subject_seqno")) {

            $query .= "\n    WHERE  C.acc_subject_seqno = ";
            $query .= $param["acc_subject_seqno"];

        }
 
        $result = $conn->Execute($query);

        return $result;

    }

    /**
     * @brief 입출금 상세 list Select
     *
     * @param $conn  = connection identifier
     * @param $param = 검색 조건 파라미터
     *
     * @return : resultSet 
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

    /*
     * 일마감 날짜 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectCloseDate($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  date";
        $query .= "\n      FROM  day_close";
        $query .= "\n     WHERE  close_yn = 'Y'";
        $query .= "\n  ORDER BY  date DESC";
        $query .= "\n     LIMIT  1";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 잔액 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectBalance($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $query  = "\n    SELECT  bal";
        $query .= "\n      FROM  cashbook";
        $query .= "\n  ORDER BY  cashbook_seqno DESC";
        $query .= "\n     LIMIT  1";

        $result = $conn->Execute($query);

        return $result;
    }

    /*
     * 전체 합계 가져오기 Select 
     * $conn : DB Connection
     * return : resultSet 
     */ 
    function selectSumPrice($conn, $param) {

        if (!$this->connectionCheck($conn)) return false; 
        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1,-1);


        $query .= "\n  SELECT";

        if ($dvs == "")  {

            $query .= "\n            SUM(T1.income_price)  AS income";
            $query .= "\n           ,SUM(T1.expen_price)   AS expen";
            $query .= "\n           ,SUM(T1.trsf_income_price) AS trsf_income";
            $query .= "\n           ,SUM(T1.trsf_expen_price)  AS trsf_expen";

        } else if ($dvs == "income") {

            $query .= "\n             SUM(T1.income_price)  AS income";

        } else if ($dvs == "expen") {

            $query .= "\n             SUM(T1.expen_price)   AS expen";

        } else if ($dvs == "trsf_income") {

            $query .= "\n             SUM(T1.trsf_income_price) AS trsf_income";

            
        } else if ($dvs == "trsf_expen") {

            $query .= "\n             SUM(T1.trsf_expen_price)  AS trsf_expen";

        }


        $query .= "\n    FROM (";
        $query .= "\n          SELECT  income_price";
        $query .= "\n                 ,expen_price";
        $query .= "\n                 ,trsf_income_price";
        $query .= "\n                 ,trsf_expen_price";
        $query .= "\n                 ,extnl_etprs_seqno";
        $query .= "\n                 ,member_seqno";
        $query .= "\n                 ,acc_detail_seqno";
        $query .= "\n                 ,cpn_admin_seqno";
        $query .= "\n           FROM  cashbook";
        $query .= "\n          WHERE  1=1";

        //판매채널이 있을때
        if ($this->blankParameterCheck($param ,"cpn_admin_seqno")) {

            $query .= "\n            AND  cpn_admin_seqno = ";
            $query .= $param["cpn_admin_seqno"];

        }

        //수입지출 구분이 있을때
        if ($this->blankParameterCheck($param ,"dvs")) {

            $query .= "\n            AND  dvs = ";
            $query .= $param["dvs"];

        }
 
        //계정과목 상세가 있을때
        if ($this->blankParameterCheck($param ,"acc_detail_seqno")) {

            $query .= "\n            AND  acc_detail_seqno = ";
            $query .= $param["acc_detail_seqno"];

        }

        //입출금경로가 있을때
        if ($this->blankParameterCheck($param ,"depo_withdraw_path")) {

            $query .= "\n            AND  depo_withdraw_path = ";
            $query .= $param["depo_withdraw_path"];

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
 
        //제조사명이 있을때
        if ($this->blankParameterCheck($param ,"extnl_etprs_seqno")) {

            $query .= "\n           AND  extnl_etprs_seqno = ";
            $query .= $param["extnl_etprs_seqno"];

        }

        //회원명이 있을때
        if ($this->blankParameterCheck($param ,"member_seqno")) {

            $query .= "\n           AND  member_seqno = ";
            $query .= $param["member_seqno"];

        }

        $query .= "\n           ) T1";
        $query .= "\n LEFT JOIN  acc_detail D";
        $query .= "\n        ON  T1.acc_detail_seqno = D.acc_detail_seqno";
        $query .= "\n LEFT JOIN  acc_subject C";
        $query .= "\n        ON  D.acc_subject_seqno = C.acc_subject_seqno";
        $query .= "\n LEFT JOIN  member E";
        $query .= "\n        ON  T1.member_seqno = E.member_seqno";
        $query .= "\n LEFT JOIN  extnl_etprs F";
        $query .= "\n        ON  T1.extnl_etprs_seqno = ";
        $query .=  "F.extnl_etprs_seqno";
 
        //계정과목이 있을때
        if ($this->blankParameterCheck($param ,"acc_subject_seqno")) {

            $query .= "\n    WHERE  C.acc_subject_seqno = ";
            $query .= $param["acc_subject_seqno"];

        }

        $result = $conn->Execute($query);

        return $result;
    }
}
?>
