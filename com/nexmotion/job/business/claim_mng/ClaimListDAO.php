<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/business/claim_mng/ClaimListHTML.php');

/**
 * @file MemberCommonListDAO.php
 *
 * @brief 영업 - 클레임관리 - 클레임리스트 DAO
 */

class ClaimListDAO extends BusinessCommonDAO {
    function __construct() {
    }

    /**
     * @brief 클레임리스트 조건검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectClaimListCond($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1, -1);

        if ($dvs == "COUNT") {
            $query  = "\n SELECT  COUNT(A.order_claim_seqno) AS cnt";
        } else {
            $query  = "\nSELECT  A.regi_date ";
            $query .= "\n       ,E.office_nick ";
            $query .= "\n       ,B.order_num ";
            $query .= "\n       ,A.title ";
            $query .= "\n       ,A.dvs ";
            $query .= "\n       ,A.dvs_detail ";
            $query .= "\n       ,A.state ";
            $query .= "\n       ,A.order_claim_seqno ";
            $query .= "\n       ,A.order_common_seqno ";
            $query .= "\n       ,A.title ";
            $query .= "\n       ,A.occur_price ";
            $query .= "\n       ,A.sample_origin_file_name ";
            $query .= "\n       ,A.sample_save_file_name ";
            $query .= "\n       ,A.sample_file_path ";
            $query .= "\n       ,A.cust_cont ";
            $query .= "\n       ,A.mng_cont ";
            $query .= "\n       ,D.name AS empl_name";
            $query .= "\n       ,A.refund_prepay ";
            $query .= "\n       ,A.refund_money ";
            $query .= "\n       ,A.cust_burden_price ";
            $query .= "\n       ,A.outsource_burden_price ";
            $query .= "\n       ,A.count ";
            $query .= "\n       ,A.extnl_etprs_seqno ";
            $query .= "\n       ,A.order_yn ";
            $query .= "\n       ,A.agree_yn ";
        }
        $query .= "\n  FROM  order_claim AS A ";
        $query .= "\n       ,order_common AS B ";
        $query .= "\n       ,extnl_etprs AS C ";
        $query .= "\n       ,empl AS D ";
        $query .= "\n       ,member AS E ";
        $query .= "\n WHERE  A.order_common_seqno = B.order_common_seqno ";
        $query .= "\n   AND  A.extnl_etprs_seqno = C.extnl_etprs_seqno ";
        $query .= "\n   AND  A.empl_seqno = D.empl_seqno ";
        $query .= "\n   AND  B.member_seqno = E.member_seqno ";
        if ($this->blankParameterCheck($param ,"order_claim_seqno")) {
            $query .= "\n   AND  A.order_claim_seqno = ";
            $query .= $param["order_claim_seqno"];
        }
        if ($this->blankParameterCheck($param ,"claim_dvs")) {
            $query .= "\n   AND  A.dvs = ";
            $query .= $param["claim_dvs"];
        }
        if ($this->blankParameterCheck($param ,"depar_code")) {
            $query .= "\n   AND  E.biz_resp = ";
            $query .= $param["depar_code"];
        }
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .= "\n   AND  E.cpn_admin_seqno = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .= "\n   AND  E.office_nick = ";
            $query .= $param["office_nick"];
        }
        if ($this->blankParameterCheck($param ,"state")) {
            $query .= "\n   AND  A.state = ";
            $query .= $param["state"];
        }
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .= "\n   AND  A.$val > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .= "\n   AND  A.$val <= $param[to] ";
        }
        
        $query .= "\nORDER BY order_claim_seqno DESC ";

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if (!$dvs) { 
            $query .= "\n LIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 주문 일련번호로 주문 내용 팝업 html 생성
     *
     * @param $conn  = connection identifier
     * @param $seqno = 주문 일련번호
     *
     * @return 주문정보팝업 html
     */
    function selectOrderInfoNonePop($conn, $seqno) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $seqno = $this->parameterEscape($conn, $seqno);

        $query  = "\n SELECT  prdt_basic_info";
        $query .= "\n        ,prdt_add_info";
        $query .= "\n        ,prdt_price_info";
        $query .= "\n        ,prdt_pay_info";

        $query .= "\n   FROM  order_common";

        $query .= "\n  WHERE  order_common_seqno = %s";

        $query  = sprintf($query, $seqno);

        $rs = $conn->Execute($query);

        return makeOrderInfoNonePopHtml($rs->fields);
    }
}
?>
