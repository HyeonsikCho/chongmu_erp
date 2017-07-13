<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/basic_mng/prdt_mng/RegiPopupHtml.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/basic_mng/prdt_mng/PrdtBasicRegiListHtml.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');

/**
 * @file PrdtBasicRegiDAO.php
 *
 * @brief 기초관리 - 상품기초등록 - 상품기초등록 DAO
 */
class PrdtBasicRegiDAO extends BasicMngCommonDAO {

    /**
     * @brief 생성자
     *
     */
    function __construct() {
    }

    /**
     * @brief 상품 분류 가져옴 
     * table prdt_sort 
     */
    function selectPrdtSort($conn, $param) {

        //커넥션 체크
        if (!$this->connectionCheck($conn)) {
            return false;
        }

        //인젝션 어택 방지
        $param = $this->parameterArrayEscape($conn, $param);

        //카테고리 분류코드 빈값 체크
        if (!$this->blankParameterCheck($param ,"prdt_dvs")) {
            return false;
        }

        $query  = "\n SELECT sort ";         
        $query .= "\n       ,prdt_sort_seqno ";         
        $query .= "\n   FROM prdt_sort ";            
        $query .= "\n  WHERE prdt_dvs = " . $param["prdt_dvs"];

        return $conn->Execute($query);
    }
}
?>
