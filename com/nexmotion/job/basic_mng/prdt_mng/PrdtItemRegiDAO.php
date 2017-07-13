<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/html/basic_mng/prdt_mng/PrdtItemRegiListHtml.php');

class PrdtItemRegiDAO extends BasicMngCommonDAO {

    function __construct() {
    }
  
    /**
     * @brief 카테고리 상품 mpcode 가져옴
     * table prdt_sort 
     */
    function selectCateMpcode($conn, $param) {

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
        
        $table = substr($param["table"], 1, -1);
        $seqno = substr($param["seqno"], 1, -1);

        $query  = "\n SELECT mpcode ";         
        $query .= "\n   FROM $table";            
        $query .= "\n  WHERE $table" . "_seqno = $seqno";

        return $conn->Execute($query);
    }
}
?>
