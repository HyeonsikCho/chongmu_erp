<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();
$main_seqno = $fb->form("main_member_seqno");

//메인 배송친구 리스트
$param = array();
$result = $dlvrDAO->selectDlvrMainList($conn, $param);
$main_list = makeDlvrMainSelectList($result, $main_seqno);

echo $main_list;

$conn->close();
?>
