<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();
$organDAO = new OrganMngDAO();

//검색어
$search = $fb->form("search_str");
//판매채널 일련번호
$cpn_admin_seqno = $fb->form("sell_site");

$param = array();
$param["search"] = $search;
$param["cpn_admin_seqno"] = $cpn_admin_seqno;

//직원 이름 검색
$result = $organDAO->selectEmplNameList($conn, $param);

$arr = [];
$arr["col"] = "name";
$arr["val"] = "empl_seqno";
$arr["type"] = $fb->form("type");

$buff = makeSearchSeqList($result, $fb->form("type"));

echo $buff;

$conn->close();
?>
