<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/business/order_mng/OrderHandRegiHTML.php');

/**
 * @file MemberCommonListDAO.php
 *
 * @brief 영업 - 주문관리 - 주문수기등록 DAO
 */
class OrderHandRegiDAO extends BusinessCommonDAO {
    
    function __construct() {
    }
 
    /**
     * @brief 수기등록을 위한 회원 리스트 조건검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectMemberListCond($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1, -1);

        if ($dvs == "COUNT") {
            $query  = "\n SELECT  COUNT(member_seqno) AS cnt";
        } else {
            $query  = "\n SELECT  group_name ";
            $query .= "\n        ,office_nick ";
            $query .= "\n        ,member_name ";
            $query .= "\n        ,member_id ";
            $query .= "\n        ,tel_num ";
            $query .= "\n        ,cell_num ";
            $query .= "\n        ,member_seqno ";
        }
        $query .= "\n   FROM  member ";

        $query .= "\n  WHERE  1 = 1";
        if ($this->blankParameterCheck($param ,"member_seqno")) {
            $query .= "\n    AND  member_seqno = ";
            $query .= $param["member_seqno"];
        }
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .= "\n    AND  cpn_admin_seqno = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .= "\n    AND  office_nick     = ";
            $query .= $param["office_nick"];
        }
        if ($this->blankParameterCheck($param ,"member_id")) {
            $query .= "\n    AND  member_id     = ";
            $query .= $param["member_id"];
        }
 
        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if (!$dvs) { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }
}
?>
