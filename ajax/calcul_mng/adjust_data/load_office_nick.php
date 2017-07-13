<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/calcul_mng/settle/AdjustDataDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$adjustDAO = new AdjustDataDAO();

//검색어
$search = $fb->form("search_str");
//판매채널
$sell_site = $fb->form("sell_site");

$param = array();
$param["sell_site"] = $sell_site;
$param["search"] = $search;

$result = $adjustDAO->selectOfficeNickList($conn, $param);

//리스트 셋팅
$param = array();
$param["opt"] = "office_nick";
$param["opt_val"] = "member_seqno";
$param["func"] = "nick";
$buff = makeSearchListSub($result, $param);

echo $buff;
$conn->close();
?>
