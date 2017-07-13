<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php");
$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cpDAO = new CpMngDAO();

//검색어
$search = $fb->form("search_str");
//회사 관리 일련번호
$cpn_seqno = $fb->form("cpn_admin_seqno");

$param = array();
$param["search"] = $search;
$param["cpn_seqno"] = $cpn_seqno;

$result = $cpDAO->selectMemberNickList($conn, $param);

$arr = array();
$arr["opt"] = "office_nick";
$arr["opt_val"] = "member_seqno";
$arr["func"] = "nick";

$buff = makeSearchListSub($result, $arr);
echo $buff;

$conn->close();
?>
