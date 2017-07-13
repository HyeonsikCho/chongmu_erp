<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/MktAprvlMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$mktDAO = new MktAprvlMngDAO();

//검색조건(검색어)
$search = $fb->form("search_str");
//판매채널
$sell_site = $fb->form("sell_site");

$param = array();
$param["search"] = $search;
$param["cpn_seqno"] = $sell_site;

$result = $mktDAO->selectOfficeNickList($conn, $param);

$arr = array();
$arr["opt"] = "office_nick";
$arr["opt_val"] = "member_seqno";
$arr["func"] = "name";

$buff = makeSearchListSub($result, $arr);
echo $buff;

$conn->close();
?>
