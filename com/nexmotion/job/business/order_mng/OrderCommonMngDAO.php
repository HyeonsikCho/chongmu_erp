<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/business/order_mng/OrderCommonMngHtml.php');


/*
주문된 상품의 리스트의 갯수를 구한다.
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');

include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/business/order_mng/OrderCommonMngHtml.php');
*/

/**
 * @file MemberCommonListDAO.php
 *
 * @brief 영업 - 주문관리 - 주문통합관리 DAO
 */
class OrderCommonMngDAO extends BusinessCommonDAO {
    function __construct() {
    }

    /**
     * @brief 주문 리스트 검색조건 없이 검색
     *
     * @detail 대용량 게시판 쿼리용
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectOrderListHtml($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        //$param = $this->parameterArrayEscape($conn, $param);

       /* $query  = "\n SELECT  A.order_common_seqno AS seqno";
        $query .= "\n        ,A.order_num";
        $query .= "\n        ,A.order_regi_date";
        $query .= "\n        ,A.title";
        $query .= "\n        ,A.order_detail";
        $query .= "\n        ,A.order_state";
        $query .= "\n        ,A.basic_price";
        $query .= "\n        ,A.add_after_price";
        $query .= "\n        ,A.add_opt_price";
        $query .= "\n   FROM  order_common AS A";

        $query .= "\n  WHERE 1 = 1 ";
        $query .= "\n    AND  A.order_common_seqno BETWEEN %s AND %s";

        $query .= "\n  ORDER BY A.order_common_seqno DESC";
        $query .= "\n  LIMIT %s";
       */

        $query  = "\n select  a.order_stime, a.order_no,c.user_nm, c.mysec_id, b.title, d.cate_name, b.flag, b.order_prdlist_seq,b.prd_status";
        $query .= "\n from order_master as a";
        $query .= "\n inner join order_prdlist as b";
        $query .= "\n on a.order_no = b.order_no";
        $query .= "\n inner join cmember as c";
        $query .= "\n on c.mysec_id = a.user_id";
        $query .= "\n inner join cate as d";
        $query .= "\n on b.cate_sortcode=d.sortcode and b.cate_sortcode !='999999999'";
        $query .= "\n WHERE 1 = 1 ";
        //$query .= "\n AND  b.order_prdlist_seq BETWEEN %s AND %s";
		$query .= "\n AND  a.order_status != ''";
        $query .= "\n ORDER BY a.order_no DESC";
        $query .= "\n LIMIT %d, %d";

        $query  = sprintf($query, $param["limit_from"]
                                , $param["list_size"]);

        $rs = $conn->Execute($query);

        if ($rs->EOF) {
            return false;
        }

        return makeOrderListHtml($conn, $this, $rs);
    }

    /**
     * @brief 주문 리스트 조건검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectOrderListCondHtml($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1, -1);


        $query  = "\n select  a.order_stime, a.order_no,c.user_nm, c.mysec_id, b.title, d.cate_name, b.flag, b.order_prdlist_seq,b.prd_status";
        $query .= "\n from order_master as a";
        $query .= "\n inner join order_prdlist as b";
        $query .= "\n on a.order_no = b.order_no";
        $query .= "\n inner join cmember as c";
        $query .= "\n on c.mysec_id = a.user_id";
        $query .= "\n inner join cate as d";
        $query .= "\n on b.cate_sortcode=d.sortcode and b.cate_sortcode !='999999999'";
        $query .= "\n WHERE a.order_status != '' and 1 = 1 ";

        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n    AND  b.cate_sortcode     = ";
            $query .= $param["cate_sortcode"];
        }
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .= "\n    AND  c.user_nm     = ";
            $query .= $param["office_nick"];
        }
        if ($this->blankParameterCheck($param ,"state")) {
            $query .= "\n    AND  A.order_state     = ";
            $query .= $param["state"];
        }
        if ($this->blankParameterCheck($param ,"from")) {
            $query .= "\n    AND  ";
            $query .= $param["from"];
            $query .= " <= a.order_stime";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $query .= "\n    AND  a.order_stime <= ";
            $query .= $param["to"];
        }

        $query .= "\n ORDER BY a.order_no DESC";
        $query .= "\n  LIMIT %s, %s";

        $query  = sprintf($query, substr($param["limit_block"], 1, -1)
                                , substr($param["list_size"], 1, -1));

        $rs = $conn->Execute($query);

        if ($rs->EOF == 1) {
            return false;
        }

        return makeOrderListHtml($conn, $this, $rs);
    }

    /**
     * @brief 주문 리스트 조건검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectOrderListCond($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1, -1);

        //검색된 주문건의 갯수와 금액의 합계를 구합니다.


        $query  = "\n select  count(a.order_master_seq) AS cnt";
        $query .= "\n from order_master as a";
        $query .= "\n inner join order_prdlist as b";
        $query .= "\n on a.order_no = b.order_no";
        $query .= "\n inner join cmember as c";
        $query .= "\n on c.mysec_id = a.user_id";
        $query .= "\n inner join cate as d";
        $query .= "\n on b.cate_sortcode=d.sortcode and b.cate_sortcode !='999999999'";
        $query .= "\n WHERE a.order_status != '' and 1 = 1 ";

        if ($this->blankParameterCheck($param ,"cate_sortcode")) {
            $query .= "\n    AND  b.cate_sortcode     = ";
            $query .= $param["cate_sortcode"];
        }
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .= "\n    AND  c.user_nm     = ";
            $query .= $param["office_nick"];
        }
        if ($this->blankParameterCheck($param ,"state")) {
            $query .= "\n    AND  A.order_state     = ";
            $query .= $param["state"];
        }
        if ($this->blankParameterCheck($param ,"from")) {
            $query .= "\n    AND  ";
            $query .= $param["from"];
            $query .= " <= a.order_stime";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $query .= "\n    AND  a.order_stime <= ";
            $query .= $param["to"];
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 상태변경 요청
     */
    function updateOrderStatusHtml($conn, $prd_status, $order_prdlist_seq) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $order_prdlist_seq = $this->parameterEscape($conn, $order_prdlist_seq);
        $prd_status = $this->parameterEscape($conn, $prd_status);

        $query  = "\nUPDATE order_prdlist ";
        $query .= "\nSET prd_status = %s ";
        $query .= "\n WHERE order_prdlist_seq = %s ";

        $query  = sprintf($query, $prd_status, $order_prdlist_seq);
        return $conn->Execute($query);
    }

    /**
     * @brief 배송정보 불러오기
     */
    function selectDeliveryInfo($conn, $order_no) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $query  = "\n   SELECT * ";
        $query .= "\n   FROM order_dlvr ";
        $query .= "\n   WHERE order_no = %s ";

        $query  = sprintf($query, $order_no);
        return $conn->Execute($query);
    }

    /**
     * @brief 주문별 후공정 가격 검색
     *
     * @param $conn  = connection identifier
     * @param $seqno = 주문 공통 일련번호
     *
     * @return 검색결과
     */
    /*************************************************
    function selectOrderAfterPrice($conn, $seqno) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();
        $temp["col"]   = "IFNULL(sum(price), 0) AS price";
        $temp["table"] = "order_after_history";
        $temp["where"]["order_common_seqno"] = $seqno;

        $rs = $this->selectData($conn, $temp);

        return $rs->fields["price"];
    }
    */

    /**
     * @brief 주문별 옵션 가격 검색
     *
     * @param $conn  = connection identifier
     * @param $seqno = 주문 공통 일련번호
     *
     * @return 검색결과
     */
    /*************************************************
    function selectOrderOptPrice($conn, $seqno) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $temp = array();
        $temp["col"]   = "IFNULL(sum(price), 0) AS price";
        $temp["table"] = "order_opt_history";
        $temp["where"]["order_common_seqno"] = $seqno;

        $rs = $this->selectData($conn, $temp);

        return $rs->fields["price"];
    }
    */
}
?>
