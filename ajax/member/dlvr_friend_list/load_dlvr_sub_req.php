<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();

//주소 검색어
$search = $fb->form("search");
//메인 서브 구분
$type = $fb->form("type");

$param = array();
$param["search"] = $search;
$param["type"] = $type;

$result = $dlvrDAO->selectSubReqList($conn, $param);
$buff = makeSubReqList($result);

echo $buff;
$conn->close();
?>
