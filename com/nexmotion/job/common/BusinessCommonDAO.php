<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');

/**
 * @file BusinessCommonDAO.php
 *
 * @brief 영업 공통DAO
 */
class BusinessCommonDAO extends CommonDAO {
    function __construct() {
    }

    /**
     * @brief 주문 테이블 마지막 seqno 검색
     *
     * @param $conn  = connection identifier
     *
     * @return 마지막 seqno
     */
    function selectLastOrderSeqno($conn) {
        if ($this->connectionCheck($conn) === false) {
            return false;
        }
        /*
        $query  = "\n SELECT  order_common_seqno AS seqno";
        $query .= "\n   FROM  order_common";
        $query .= "\n  ORDER BY order_common_seqno DESC";
        $query .= "\n  LIMIT  1";
        */
        $query  = "\n SELECT  order_prdlist_seq AS seqno";
        $query .= "\n   FROM  order_prdlist";
        $query .= "\n  ORDER BY order_prdlist_seq DESC";
        $query .= "\n  LIMIT  1";

        $rs = $conn->Execute($query);

        return $rs->fields["seqno"];
    }
}
?>
