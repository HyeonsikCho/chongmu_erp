<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/MemberCommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/html/member/member_mng/InquireList.php");

/**
 * @file InquireMngDAO.php
 *
 * @brief 회원 - 회원관리 - 1대1문의리스트 DAO
 */
class InquireMngDAO extends MemberCommonDAO {

    function __construct() {
    }

    /**
     * @brief 1:1문의리스트
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectInquireList($conn, $dvs, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "SEQ") {
            $query  ="\nSELECT  A.oto_inq_seqno ";
            $query .="\n       ,A.regi_date ";
            $query .="\n       ,C.office_nick ";
            $query .="\n       ,A.inq_typ ";
            $query .="\n       ,A.title ";
            $query .="\n       ,A.regi_date ";
            $query .="\n       ,A.answ_yn ";

        }

        $query .="\n  FROM  oto_inq A ";
        $query .="\n       ,member C ";
        $query .="\n WHERE  A.member_seqno = C.member_seqno ";


        //카테고리 분류코드 빈값 체크
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .="\n   AND  C.cpn_admin_seqno = $param[sell_site] ";
        }
        //팀
        if ($this->blankParameterCheck($param ,"depar_code")) {
            $query .="\n   AND  C.biz_resp = $param[depar_code] ";
        }
        //사내닉네임(회원명)
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .="\n   AND  C.office_nick = $param[office_nick] ";
        }
        //문의일
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["regi_date"], 1, -1);
            $query .="\n   AND  A.regi_date > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["regi_date"], 1, -1);
            $query .="\n   AND  A.regi_date <= $param[to] ";
        }
        //상태
        if ($this->blankParameterCheck($param ,"answ_yn")) {
            $query .="\n   AND  A.answ_yn = $param[answ_yn] ";
        }

       $query .="\n ORDER BY A.oto_inq_seqno DESC ";

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }
        return $conn->Execute($query);
     }

    /**
     * @brief 1:1문의리스트
     *
     * @param $conn = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectInquireList2($conn, $dvs, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "SEQ") {
            $query  ="\nSELECT  A.oto_inq_seqno ";
            $query .="\n       ,A.regi_date ";
            $query .="\n       ,C.office_nick ";
            $query .="\n       ,A.inq_typ ";
            $query .="\n       ,A.title ";
            $query .="\n       ,A.regi_date ";
            $query .="\n       ,B.regi_date ";
            $query .="\n       ,A.answ_yn ";

        }

        $query .="\n  FROM  oto_inq A ";
        $query .="\n       ,oto_inq_reply B ";
        $query .="\n       ,member C ";
        $query .="\n WHERE  A.oto_inq_seqno = B.oto_inq_seqno ";
        $query .="\n   AND  A.member_seqno = C.member_seqno ";


        //카테고리 분류코드 빈값 체크
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .="\n   AND  C.cpn_admin_seqno = $param[sell_site] ";
        }
        //팀
        if ($this->blankParameterCheck($param ,"depar_code")) {
            $query .="\n   AND  C.biz_resp = $param[depar_code] ";
        }
        //사내닉네임(회원명)
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .="\n   AND  C.office_nick = $param[office_nick] ";
        }
        //답변일
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["regi_date"], 1, -1);
            $query .="\n   AND  B.regi_date > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["regi_date"], 1, -1);
            $query .="\n   AND  B.regi_date <= $param[to] ";
        }

       $query .="\n ORDER BY A.oto_inq_seqno DESC ";

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }
        return $conn->Execute($query);
     }


    /**
     * @brief 답변 유무에 따른 답변자, 일시 출력 
     *
     * @param $conn  = connection identifier
     * @param $seq = seqno 
     *
     * @return 검색결과
     */
    function otoRepl($conn, $seq) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $query  ="\nSELECT  B.regi_date ";
        $query .="\n       ,D.name ";

        $query .="\n  FROM  oto_inq_reply B ";
        $query .="\n       ,empl D ";
        $query .="\n WHERE  B.empl_seqno = D.empl_seqno ";
        $query .="\n   AND  B.oto_inq_seqno = '%s' ";

        $query  = sprintf($query, $seq);
        return $conn->Execute($query);
    }

    /**
     * @brief 1:1문의 관리팝업 셀렉터 
     *
     * @param $conn  = connection identifier
     * @param $seq = seqno 
     *
     * @return 검색결과
     */
    function selectInquireAnsw($conn, $seq) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }
        
        $query  ="\nSELECT  A.answ_yn ";
        $query .="\nFROM    oto_inq A ";
        $query .="\nWHERE   A.oto_inq_seqno = '%s' ";

        $query  = sprintf($query, $seq);

        return $conn->Execute($query);
    }
       

    /**
     * @brief 1:1문의 관리팝업 셀렉터 답변o
     *
     * @param $conn  = connection identifier
     * @param $seq = seqno 
     *
     * @return 검색결과
     */
    function selectInquireDetail($conn, $seq) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }
        
        $query  ="\nSELECT  A.title ";
        $query .="\n       ,A.inq_typ ";
        $query .="\n       ,C.member_name ";
        $query .="\n       ,A.tel_num ";
        $query .="\n       ,A.cell_num ";
        $query .="\n       ,A.cont ";
        $query .="\n       ,A.order_num ";
        $query .="\n       ,A.mail ";
        $query .="\n       ,D.name AS empl_name ";
        $query .="\n       ,B.cont AS repl_cont";

        $query .="\nFROM    oto_inq A ";
        $query .="\n       ,oto_inq_reply B ";
        $query .="\n       ,member C ";
        $query .="\n       ,empl D ";
        $query .="\nWHERE   A.member_seqno = C.member_seqno ";
        $query .="\nAND     A.oto_inq_seqno = B.oto_inq_seqno ";
        $query .="\nAND     B.empl_seqno = D.empl_seqno ";
        $query .="\nAND     A.oto_inq_seqno = '%s' ";

        $query  = sprintf($query, $seq);

        return $conn->Execute($query);
    }


     /**
     * @brief 1:1문의 관리팝업 셀렉터 답변x
     *
     * @param $conn  = connection identifier
     * @param $seq = seqno 
     *
     * @return 검색결과
     */
    function selectInquireDetail2($conn, $seq) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }
        
        $query  ="\nSELECT  A.title ";
        $query .="\n       ,A.inq_typ ";
        $query .="\n       ,C.member_name ";
        $query .="\n       ,A.tel_num ";
        $query .="\n       ,A.cell_num ";
        $query .="\n       ,A.cont ";
        $query .="\n       ,A.order_num ";
        $query .="\n       ,A.mail ";

        $query .="\nFROM    oto_inq A ";
        $query .="\n       ,member C ";
        $query .="\nWHERE   A.member_seqno = C.member_seqno ";
        $query .="\nAND     A.oto_inq_seqno = '%s' ";

        $query  = sprintf($query, $seq);

        return $conn->Execute($query);
    }
       
}
