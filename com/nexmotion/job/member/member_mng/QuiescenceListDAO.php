<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/MemberCommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/member/member_mng/QuiescenceList.php");

/**
 * @file QuiescenceListDAO.php
 *
 * @brief 회원 - 회원관리 - 휴면대상회원리스트 DAO
 */
class QuiescenceListDAO extends MemberCommonDAO {

    function __construct() {
    }
 
    /**
     * @brief 휴면 대상 회원 리스트
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectQuiescenceMemberInfo($conn, $dvs, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "NAME") {
            $query  ="\nSELECT  A.member_name ";
        } else if ($dvs == "SEQ") {
            $query .= "\nSELECT  A.member_seqno ";
            $query .= "\n       ,A.member_name ";
            $query .= "\n       ,A.final_login_date ";
            $query .= "\n       ,A.tel_num ";
            $query .= "\n       ,A.mail ";
            $query .= "\n       ,A.cell_num ";
            $query .= "\n       ,A.own_point ";
            $query .= "\n       ,A.prepay_price ";
        }

        $query .="\n  FROM  member A ";
        $query .="\n WHERE  withdraw_dvs = 1 ";
        $query .="\n   AND  A.final_login_date <= '". date("Y-m-d",strtotime("-1 year", time())) . "'";

        //판매채널
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .="\n   AND  A.cpn_admin_seqno = $param[sell_site] ";
        }
        //최근로인일자, 최초가입일, 최근주문일
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .="\n   AND  A.$val > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .="\n   AND  A.$val <= $param[to] ";
        }
        if ($this->blankParameterCheck($param ,"search_txt")) {
            $val = substr($param["search_txt"], 1, -1);
            $query .= "\n   AND  A.member_name LIKE '%" . $val . "%'";
        }

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);
 
        if ($this->blankParameterCheck($param ,"sorting")) {
            $sorting = substr($param["sorting"], 1, -1);
            $query .= "\n ORDER BY " . $sorting;

            if ($this->blankParameterCheck($param ,"sorting_type")) {
                $sorting_type = substr($param["sorting_type"], 1, -1);
                $query .= " " . $sorting_type;
            }
        }

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 회원 휴면 처리
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateMemberQuiescence($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param["final_modi_date"] = date("Y-m-d H:i:s");

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
        $seqno = substr($param["seqno"], 1, -1);
  
        $query  = "\n    UPDATE  member ";
        $query .= "\n       SET  withdraw_dvs = %s ";
        $query .= "\n           ,final_modi_date = %s ";
        $query .= "\n           ,own_point = NULL ";
        $query .= "\n     WHERE  member_seqno in (%s) ";

        $query = sprintf($query, 2,
                         $param["final_modi_date"],
                         $seqno);
        $resultSet = $conn->Execute($query);
 
        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
?>
