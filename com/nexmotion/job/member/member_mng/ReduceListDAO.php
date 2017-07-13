<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/MemberCommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/member/member_mng/ReduceList.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/member/member_mng/ReduceList.php");

/**
 * @file ReduceListDAO.php
 *
 * @brief 회원 - 회원관리 - 정리회원리스트 DAO
 */
class ReduceListDAO extends MemberCommonDAO {

    function __construct() {
    }
  
    /**
     * @brief 정리회원리스트
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectReduceInfo($conn, $dvs, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "SEQ") {
            $query  = "\nSELECT  B.member_seqno ";
            $query .= "\n       ,B.member_name ";
            $query .= "\n       ,B.prepay_price ";
            $query .= "\n       ,A.reason ";
            $query .= "\n       ,A.withdraw_date ";
            $query .= "\n       ,A.withdraw_dvs ";
        }

        $query .= "\n  FROM  member_withdraw AS A ";
        $query .= "\n       ,member AS B ";
        $query .= "\n WHERE  A.member_seqno = B.member_seqno ";
        $query .= "\n   AND  B.withdraw_dvs in(2,3,4) ";

        //카테고리 분류코드 빈값 체크
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .="\n   AND  B.cpn_admin_seqno = $param[sell_site] ";
        }
        //탈퇴구분
        if ($this->blankParameterCheck($param ,"withdraw_dvs")) {
            $query .="\n   AND  A.withdraw_dvs = $param[withdraw_dvs] ";
        }
        //사내닉네임(회원명)
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .="\n   AND  B.office_nick = $param[office_nick] ";
        }
        //탈퇴일자
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .="\n   AND  A.$val > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .="\n   AND  A.$val <= $param[to] ";
        }

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);
 
        if ($this->blankParameterCheck($param ,"sorting")) {
            $sorting = substr($param["sorting"], 1, -1);
            $query .= "\n ORDER BY " . $sorting;

            if ($this->blankParameterCheck($param ,"sorting_type")) {
                $sorting_type = substr($param["sorting_type"], 1, -1);
                $query .= " " . $sorting_type . " ,A.member_withdraw_seqno DESC";
            }
        } else {
            $query .= "\n ORDER BY A.member_withdraw_seqno DESC";
        }

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }
        return $conn->Execute($query);
    }

    /**
     * @brief 정리회원 복원
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateMemberRestore($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param["final_modi_date"] = date("Y-m-d H:i:s");
//        $param["final_login_date"] = date("Y-m-d H:i:s");

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
        $seqno = substr($param["member_seqno"], 1, -1);
  
        $query  = "\n    UPDATE  member ";
        $query .= "\n       SET  withdraw_dvs = %s ";
        $query .= "\n           ,final_modi_date = %s ";
 //       $query .= "\n           ,final_login_date = %s ";
        $query .= "\n     WHERE  member_seqno in (%s) ";

        $query = sprintf($query, 1,
                         $param["final_modi_date"],
                   //      $param["final_login_date"],
                         $seqno);

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 기업 개인 
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectGroupIdInfo($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
 
        $query  = "\nSELECT  member_seqno ";
        $query .= "\n  FROM  member ";

        //회원일련번호
        if ($this->blankParameterCheck($param ,"group_id")) {
            $query .= "\n    WHERE  group_id = $param[group_id] ";
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 회원 개인 정보 삭제
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateMemberInfoDelete($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param["final_modi_date"] = date("Y-m-d H:i:s");;

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nUPDATE  member ";
        $query .= "\n   SET  member_name = '탈퇴회원' ";
        $query .= "\n       ,mail = NULL ";
        $query .= "\n       ,mac_receipt_mng = NULL ";
        $query .= "\n       ,mac_resp = NULL ";
        $query .= "\n       ,ibm_receipt_mng = NULL ";
        $query .= "\n       ,ibm_resp = NULL ";
        $query .= "\n       ,cpn_admin_seqno = NULL ";
        $query .= "\n       ,grade = NULL ";
        $query .= "\n       ,office_nick = '탈퇴회원' ";
        $query .= "\n       ,withdraw_dvs = 5 ";
        $query .= "\n       ,passwd = '' ";
        $query .= "\n       ,own_point = NULL ";
        $query .= "\n       ,nick = '탈퇴회원' ";
        $query .= "\n       ,member_dvs = NULL ";
        $query .= "\n       ,mailing_yn = NULL ";
        $query .= "\n       ,sms_yn = NULL ";
        $query .= "\n       ,final_login_date = NULL ";
        $query .= "\n       ,cumul_sales_price = NULL ";
        $query .= "\n       ,cell_num = NULL ";
        $query .= "\n       ,birth = NULL ";
        $query .= "\n       ,first_join_date = NULL ";
        $query .= "\n       ,first_order_date = NULL ";
        $query .= "\n       ,final_order_date = NULL ";
        $query .= "\n       ,grade_adjust_date = NULL ";
        $query .= "\n       ,eval_regi_empl = NULL ";
        $query .= "\n       ,eval_reason = NULL ";
        $query .= "\n       ,member_typ = NULL ";
        $query .= "\n       ,excpt_member_dvs = NULL ";
        $query .= "\n       ,prepay_price = NULL ";
        $query .= "\n       ,order_lack_price = NULL ";
        $query .= "\n       ,virt_ba_seqno = NULL ";
        $query .= "\n       ,member_photo_path = NULL ";
        $query .= "\n       ,aprvl_yn = NULL ";
        $query .= "\n       ,office_member_grade = NULL ";
        $query .= "\n       ,final_modi_date = $param[final_modi_date] ";
        $query .= "\n       ,new_yn = NULL ";
        $query .= "\n       ,state = NULL ";
        $query .= "\n       ,cashreceipt_name = NULL ";
        $query .= "\n       ,cashreceipt_cell_num = NULL ";
        $query .= "\n       ,cashreceipt_card_num = NULL ";
        $query .= "\n       ,group_id = NULL ";
        $query .= "\n       ,certi_yn = NULL ";
        $query .= "\n       ,tel_num = NULL ";
        $query .= "\n       ,dlvr_friend_yn = NULL ";
        $query .= "\n       ,dlvr_friend_main = NULL ";
        $query .= "\n       ,auto_grade_yn = NULL ";
        $query .= "\n       ,group_name = NULL ";
        $query .= "\n       ,onefile_etprs_yn = NULL ";
        $query .= "\n       ,card_pay_yn = NULL ";
        $query .= "\n       ,biz_resp = NULL ";
        $query .= "\n       ,release_resp = NULL ";
        $query .= "\n       ,dlvr_resp = NULL ";
        $query .= "\n WHERE  member_seqno = $param[member_seqno]; ";

        $resultSet = $conn->Execute($query);
 
        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
?>
