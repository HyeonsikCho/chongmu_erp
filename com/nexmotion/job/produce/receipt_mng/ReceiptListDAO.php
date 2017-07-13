<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/ProduceCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/produce/receipt_mng/ReceiptListHTML.php');

/**
 * @file ReceiptListDAO.php
 *
 * @brief 생산 - 접수관리 - 접수리스트 DAO
 */
class  ReceiptListDAO extends ProduceCommonDAO {
 
    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /**
     * @brief 접수리스트
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectReceiptList($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $dvs = substr($param["dvs"], 1, -1);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "SEQ") {
            $query  = "\nSELECT  A.order_num ";
            $query .= "\n       ,B.member_name ";
            $query .= "\n       ,B.member_seqno ";
            $query .= "\n       ,A.title ";
            $query .= "\n       ,A.order_detail ";
            $query .= "\n       ,A.stan_name ";
            $query .= "\n       ,C.cate_name ";
            $query .= "\n       ,A.print_tmpt_name ";
            $query .= "\n       ,A.order_regi_date ";
            $query .= "\n       ,A.count ";
            $query .= "\n       ,A.amt ";
            $query .= "\n       ,A.amt_unit_dvs ";
            $query .= "\n       ,A.order_state ";
            $query .= "\n       ,A.order_common_seqno ";
            $query .= "\n       ,D.resp_deparcode AS deparcode ";
        }
        $query .= "\n  FROM  order_common AS A ";
        $query .= "\n       ,member AS B ";
        $query .= "\n       ,cate AS C ";
        $query .= "\n       ,member_mng AS D ";
        $query .= "\n WHERE  A.member_seqno = B.member_seqno ";
        $query .= "\n   AND  A.cate_sortcode = C.sortcode ";
        $query .= "\n   AND  A.del_yn = 'N' ";
        $query .= "\n   AND  A.member_seqno = D.member_seqno ";
 
        //카테고리 검색
        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n   AND  A.cate_sortcode = $param[cate_sortcode] ";
        }
        //부서 검색
        if ($this->blankParameterCheck($param ,"depar_code")) {
            $query .= "\n   AND  D.mng_dvs = '일반' ";
            $query .= "\n   AND  D.resp_deparcode = $param[depar_code] ";
        }
        //상태 검색
        if ($this->blankParameterCheck($param ,"order_state")) {
            $query .= "\n   AND  A.order_state = $param[order_state] ";
        } else {
            $query .= "\n   AND  (A.order_state = '310' OR A.order_state = '410')";
        }
        //조건 검색
        if ($this->blankParameterCheck($param ,"search_txt")) {
            $field = substr($param["search_cnd"], 1, -1);
            $query .= "\n   AND  $field = $val ";
        }
        //주문일 접수일
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["search_cnd2"], 1, -1);
            $query .= "\n   AND  A.$val > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["search_cnd2"], 1, -1);
            $query .= "\n   AND  A.$val <= $param[to] ";
        }

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }
    
    /**
     * @brief 상태변경관리 접수리스트
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectStatusReceiptList($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $dvs = substr($param["dvs"], 1, -1);

        if ($dvs == "COUNT") {
            $query  ="\nSELECT  COUNT(*) AS cnt ";
        } else if ($dvs == "SEQ") {
            $query .= "\nSELECT  A.order_num ";
            $query .= "\n       ,B.member_name ";
            $query .= "\n       ,A.title ";
            $query .= "\n       ,C.cate_name ";
            $query .= "\n       ,A.receipt_mng ";
            $query .= "\n       ,A.order_state ";
            $query .= "\n       ,A.order_common_seqno ";
        }
        $query .= "\n  FROM  order_common AS A ";
        $query .= "\n       ,member AS B ";
        $query .= "\n       ,cate AS C ";
        $query .= "\n WHERE  A.member_seqno = B.member_seqno ";
        $query .= "\n   AND  A.cate_sortcode = C.sortcode ";

        //상태 검색
        if ($this->blankParameterCheck($param ,"order_state")) {
            $query .= "\n   AND  A.order_state = $param[order_state] ";
        } else {
            $query .= "\n   AND  A.order_state LIKE '3%' ";
        }
        //조건 검색
        if ($this->blankParameterCheck($param ,"search_txt")) {
            $val = substr($param["search_txt"], 1, -1);
            $query .= "\n   AND  A.title LIKE '%$val%' ";
        }

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if ($dvs == "SEQ") { 
            $query .= "\nLIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 주문 상태 변경
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateStatus($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
  
        $query  = "\n    UPDATE  order_common ";
        $query .= "\n       SET  order_state = %s ";
        $query .= "\n     WHERE  order_common_seqno = %s ";

        $query = sprintf($query,
                         $param["state"],
                         $param["seqno"]);

        $resultSet = $conn->Execute($query);
 
        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 접수팝업 - 주문 상세
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectReceiptView($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\nSELECT  A.order_num ";
        $query .= "\n       ,B.member_name ";
        $query .= "\n       ,B.office_nick ";
        $query .= "\n       ,A.title ";
        $query .= "\n       ,C.cate_name ";
        $query .= "\n       ,A.amt ";
        $query .= "\n       ,A.amt_unit_dvs ";
        $query .= "\n       ,A.order_detail ";
        $query .= "\n       ,A.stan_name ";
        $query .= "\n       ,A.print_tmpt_name ";
        $query .= "\n       ,A.memo ";
        $query .= "\n       ,A.stor_release_yn ";
        $query .= "\n       ,A.count ";
        $query .= "\n       ,A.receipt_mng ";
        $query .= "\n  FROM  order_common AS A ";
        $query .= "\n       ,member AS B ";
        $query .= "\n       ,cate AS C ";
        $query .= "\n WHERE  A.member_seqno = B.member_seqno ";
        $query .= "\n   AND  A.cate_sortcode = C.sortcode ";
        $query .= "\n   AND  A.del_yn = 'N' ";
 
        //주문공통 일련번호
        if ($this->blankParameterCheck($param ,"order_common_seqno")) {
            $query .= "\n   AND  A.order_common_seqno = $param[order_common_seqno] ";
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 접수팝업 - 배송정보
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectOrderDlvr($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        $query .= "\nSELECT  addr ";
        $query .= "\n       ,name ";
        $query .= "\n  FROM  order_dlvr ";
        $query .= "\n WHERE  1 = 1 ";
 
        //주문공통 일련번호
        if ($this->blankParameterCheck($param ,"order_common_seqno")) {
            $query .= "\n   AND  order_common_seqno = $param[order_common_seqno] ";
        }

        return $conn->Execute($query);
    }
 
    /**
     * @brief 접수
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateReceipt($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param["receipt_regi_date"] = date("Y-m-d H:i:s");

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
  
        $query  = "\n    UPDATE  order_common ";
        $query .= "\n       SET  receipt_regi_date = %s ";
        $query .= "\n           ,order_state = %s ";
        $query .= "\n           ,receipt_mng = %s ";
        $query .= "\n     WHERE  order_common_seqno = %s ";

        $query = sprintf($query,
                         $param["receipt_regi_date"],
                         $param["order_state"],
                         $param["receipt_mng"],
                         $param["seqno"]);

        $resultSet = $conn->Execute($query);
 
        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 주문 취소
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateOrderDel($conn, $param) {

        //커넥션 체크
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);
  
        $query  = "\n    UPDATE  order_common ";
        $query .= "\n       SET  eraser = %s ";
        $query .= "\n           ,del_yn = 'Y' ";
        $query .= "\n     WHERE  order_common_seqno = %s ";

        $query = sprintf($query,
                         $param["eraser"],
                         $param["seqno"]);

        $resultSet = $conn->Execute($query);
 
        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
?>
