<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');

/**
 * @file BasicMngCommonDAO.php
 *
 * @brief 회원 공통DAO
 */
class MemberCommonDAO extends CommonDAO {
 
    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /**
     * @brief 회원정보탭 - 기본정보
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectMemberDetailInfo($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nSELECT  A.nick ";
        $query .= "\n       ,A.member_typ ";
        $query .= "\n       ,A.new_yn ";
        $query .= "\n       ,A.birth ";
        $query .= "\n       ,A.mailing_yn ";
        $query .= "\n       ,A.sms_yn ";
        $query .= "\n       ,A.eval_reason ";
        $query .= "\n       ,A.member_dvs ";
        $query .= "\n       ,A.biz_resp ";
        $query .= "\n       ,A.cashreceipt_card_num ";
        $query .= "\n       ,A.release_resp ";
        $query .= "\n       ,A.dlvr_resp ";
        $query .= "\n       ,A.cpn_admin_seqno ";
        $query .= "\n       ,A.grade ";
        $query .= "\n       ,A.group_id ";
        $query .= "\n       ,A.group_name ";
        $query .= "\n       ,A.mail ";
        $query .= "\n       ,A.tel_num ";
        $query .= "\n       ,A.cell_num ";
        $query .= "\n       ,A.member_id ";
        $query .= "\n       ,A.member_name ";
        $query .= "\n       ,A.first_join_date ";
        $query .= "\n       ,A.first_order_date ";
        $query .= "\n       ,A.final_order_date ";
        $query .= "\n       ,A.own_point ";
        $query .= "\n       ,B.sell_site ";
        $query .= "\n       ,C.grade_name ";
        $query .= "\n  FROM  member A ";
        $query .= "\n       ,cpn_admin AS B ";
        $query .= "\n       ,member_grade_policy C ";
        $query .= "\n WHERE  A.cpn_admin_seqno = B.cpn_admin_seqno ";
        $query .= "\n   AND  A.grade = C.grade ";

        //회원일련번호
        if ($this->blankParameterCheck($param ,"member_seqno")) {
            $query .= "\n   AND  A.member_seqno = $param[member_seqno] ";
        }
 
        //기업 개인
        if ($this->blankParameterCheck($param ,"group_id")) {
            $query .= "\n   AND  A.group_id = $param[group_id] ";
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 회원요약정보 - 지난달 주문건수
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectOrderCountInfo($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $d = mktime(0,0,0, date("m"), 1, date("Y")); //이번달 1일
        $prev_month = strtotime("-1 month", $d); //한달전
        $param["prev_from"] = date("Y-m-01", $prev_month ); //지난달 1일
        $param["prev_to"] = date("Y-m-t", $prev_month ); //지난달 말일

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nSELECT  COUNT(*) AS order_count ";
        $query .= "\n  FROM  order_common ";
        $query .= "\n WHERE  1 = 1 ";
        $query .= "\n   AND  member_seqno = $param[member_seqno] ";
        $query .= "\n   AND  order_regi_date > $param[prev_from]";
        $query .= "\n   AND  order_regi_date <= $param[prev_to] ";

        return $conn->Execute($query);
    }
}
