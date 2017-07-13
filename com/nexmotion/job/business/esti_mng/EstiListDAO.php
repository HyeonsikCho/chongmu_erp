<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BusinessCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/business/esti_mng/EstiListHTML.php');

/**
 * @file MemberCommonListDAO.php
 *
 * @brief 영업 - 견적관리 - 견적리스트 DAO
 */

class EstiListDAO extends BusinessCommonDAO {
    function __construct() {
    }

    /**
     * @brief 견적리스트 조건검색
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectEstiListCond($conn, $param) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $dvs = substr($param["dvs"], 1, -1);

        if ($dvs == "COUNT") {
            $query  = "\n SELECT  COUNT(A.esti_seqno) AS cnt";
        } else {
            $query = "\n SELECT  A.esti_seqno ";
            $query .= "\n        ,A.req_date ";
            $query .= "\n        ,A.title ";
            $query .= "\n        ,A.paper ";
            $query .= "\n        ,A.print_tmpt ";
            $query .= "\n        ,A.size ";
            $query .= "\n        ,A.after ";
            $query .= "\n        ,A.amt ";
            $query .= "\n        ,A.inq_cont ";
            $query .= "\n        ,A.regi_date ";
            $query .= "\n        ,A.etc ";
            $query .= "\n        ,A.memo ";
            $query .= "\n        ,A.esti_price ";
            $query .= "\n        ,A.supply_price ";
            $query .= "\n        ,A.vat ";
            $query .= "\n        ,A.sale_price ";
            $query .= "\n        ,A.req_date ";
            $query .= "\n        ,A.answ_cont ";
            $query .= "\n        ,A.count ";
            $query .= "\n        ,A.state ";
            $query .= "\n        ,A.expec_order_date ";
            $query .= "\n        ,B.mysec_id as member_name ";
            $query .= "\n        ,B.user_nm as office_nick ";
        }
        $query .= "\n   FROM  esti AS A ";
        $query .= "\n        ,cmember AS B ";
        $query .= "\n  WHERE  A.cmember_seq = B.cmember_seq ";
        if ($this->blankParameterCheck($param ,"esti_seqno")) {
            $query .= "\n    AND  A.esti_seqno = ";
            $query .= $param["esti_seqno"];
        }
        if ($this->blankParameterCheck($param ,"depar_code")) {
            $query .= "\n    AND  B.biz_resp = ";
            $query .= $param["depar_code"];
        }
        if ($this->blankParameterCheck($param ,"sell_site")) {
            $query .= "\n    AND  B.cpn_admin_seqno = ";
            $query .= $param["sell_site"];
        }
        if ($this->blankParameterCheck($param ,"office_nick")) {
            $query .= "\n    AND  B.office_nick     = ";
            $query .= $param["office_nick"];
        }
        if ($this->blankParameterCheck($param ,"state")) {
            $query .= "\n    AND  A.state     = ";
            $query .= $param["state"];
        }
        if ($this->blankParameterCheck($param ,"from")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .= "\n    AND  A.$val > $param[from] ";
        }
        if ($this->blankParameterCheck($param ,"to")) {
            $val = substr($param["search_cnd"], 1, -1);
            $query .= "\n    AND  A.$val <= $param[to] ";
        }

        $query .= "\n ORDER BY esti_seqno DESC ";

        $s_num = substr($param["s_num"], 1, -1);
        $list_num = substr($param["list_num"], 1, -1);

        if (!$dvs) {
            $query .= "\n LIMIT ". $s_num . ", " . $list_num;
        }

        return $conn->Execute($query);
    }

    /**
     * @brief 견적리스트 삭제
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function deleteEstiList($conn, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);
        $seqno = substr($param["esti_seqno"], 1, -1);

        $query  = "\n DELETE ";
        $query .= "\n   FROM esti ";
        $query .= "\n  WHERE esti_seqno in ($seqno)";

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            $errorMessage = "데이터 삭제에 실패 하였습니다.";
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 인쇄정보 카테고리 중분류
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function selectCate($conn) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $query  = "\n SELECT DISTINCT B.cate_name ";
        $query .= "\n       ,A.cate_sortcode ";
        $query .= "\n   FROM prdt_print_info AS A";
        $query .= "\n       ,cate AS B";
        $query .= "\n  WHERE A.cate_sortcode = B.sortcode";

        return $conn->Execute($query);
    }

    /**
     * @brief 견적 수정
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateEstiList($conn, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nUPDATE  esti ";
        $query .= "\n   SET  memo = %s ";
        $query .= "\n       ,answ_cont = %s ";
        $query .= "\n       ,supply_price = %s ";
        $query .= "\n       ,vat = %s ";
        $query .= "\n       ,sale_price = %s ";
        $query .= "\n       ,esti_price = %s ";
        $query .= "\n       ,expec_order_date = %s ";
        $query .= "\n       ,state = %s ";
		$query .= "\n       ,etc = %s ";
        $query .= "\n WHERE  esti_seqno = %s ";

        $query = sprintf($query, $param["memo"],
                         $param["answ_cont"],
                         $param["supply_price"],
                         $param["vat"],
                         $param["sale_price"],
                         $param["esti_price"],
                         $param["expec_order_date"],
                         $param["state"],
                         $param["etc_cont"],
                         $param["esti_seqno"]);

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @brief 견적 상태 수정
     *
     * @param $conn  = connection identifier
     * @param $param = 검색조건 파라미터
     *
     * @return 검색결과
     */
    function updateEstiState($conn, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nUPDATE  esti ";
        $query .= "\n   SET  state = %s ";
        $query .= "\n WHERE  esti_seqno = %s ";

        $query = sprintf($query, $param["state"],
                         $param["esti_seqno"]);

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function deleteOrderImage($conn, $param) {

        if ($this->connectionCheck($conn) === false) {
            return false;
        }

        $param = $this->parameterArrayEscape($conn, $param);

        $query  = "\nDELETE ";
        $query .= "\n   FROM  order_img ";
        $query .= "\n WHERE  file_img_seq = %s ";

        $query = sprintf($query, $param["seqno"]);

        $resultSet = $conn->Execute($query);

        if ($resultSet === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
?>
