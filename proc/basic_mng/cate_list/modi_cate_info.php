<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/cate_mng/CateListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cateListDAO = new CateListDAO();

$conn->StartTrans();

$param = array();
$param["sortcode"] = $fb->form("sortcode");
$param["mono_dvs"] = $fb->form("mono_dvs");
$param["cate_name"] = $fb->form("cate_name");
$param["flattyp_yn"] = $fb->form("flattyp_yn");
$param["c_rate"] = $fb->form("c_rate");
$param["c_user_rate"] = $fb->form("c_user_rate");
//카테고리 별 계산방식 정보 가져옴
//1 : 전체, 2 : 합판, 3 : 독판
$rs = $cateListDAO->updateCalculWay($conn, $param);

if ($rs === FALSE) {
    echo false;
} else { 
    echo true;
}

$conn->CompleteTrans();
$conn->close();
?>
