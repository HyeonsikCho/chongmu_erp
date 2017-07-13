<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$cpDAO = new CpMngDAO();

//회사 관리 일련번호
$cpn_seqno = $fb->form("cpn_seqno");

$param = array();
$param["cpn_seqno"] = $cpn_seqno;
$result = $cpDAO->selectCpList($conn, $param);
$list = makeCpList($result);

echo $list;

$conn->close();
?>
