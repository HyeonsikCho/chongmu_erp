<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/cate_mng/CateListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cateListDAO = new CateListDAO();

$param = array();
$param["sortcode"] = $fb->form("sortcode");

//카테고리 별 계산방식 정보 가져옴
//1 : 전체, 2 : 합판, 3 : 독판
$rs = $cateListDAO->selectCateInfo($conn, $param);

$conn->close();
echo $rs->fields["mono_dvs"] . "♪" . $rs->fields["flattyp_yn"] . "♪" . $rs->fields["c_rate"] ."♪" . $rs->fields["c_user_rate"];
?>
