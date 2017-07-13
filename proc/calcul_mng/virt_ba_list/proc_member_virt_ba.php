<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/virt_ba_mng/VirtBaListDAO.php");
$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$virtDAO = new VirtBaListDAO();
$conn->StartTrans();

//가상계좌 회원 맵핑 끊기
$param = array();
$param["virt_seqno"] = $fb->form("virt_ba_admin_seqno");
$result = $virtDAO->updateMemberVirtBa($conn, $param);

echo $result;
$conn->CompleteTrans();
$conn->close();
?>
