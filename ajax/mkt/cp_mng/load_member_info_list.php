<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cpDAO = new CpMngDAO();

$param = array();
//회사 관리 일련번호
$param["cpn_seqno"] = $fb->form("cpn_admin_seqno");
//회원 일련번호
$param["member_seqno"] = $fb->form("member_seqno");
//팀 구분
$param["depar_dvs"] = $fb->form("depar_dvs");
//회원 구분
$param["member_typ"] = $fb->form("member_typ");
//등급 구분
$param["grade"] = $fb->form("grade");

$result = $cpDAO->selectMemberInfoList($conn, $param);
$list = makeMemberInfoList($result);

echo $list;

$conn->close();
?>
