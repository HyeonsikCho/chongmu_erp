<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/ReduceListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$reduceListDAO = new ReduceListDAO();

$check = 1;

$conn->StartTrans();

$param = array();
$param["member_seqno"] = $fb->form("seqno");

$rs = $reduceListDAO->updateMemberRestore($conn, $param);

if (!$rs) {
    $check = 0; 
} 

//회원 탈퇴 테이블 회원 삭제 -> 복원
$param = array();
$param["table"] = "member_withdraw";
$param["prk"] = "member_seqno";
$param["prkVal"] = explode(',', $fb->form("seqno"));

$rs = $reduceListDAO->deleteMultiData($conn, $param);

if (!$rs) {
    $check = 0;
}

echo $check;
$conn->CompleteTrans();
$conn->close();
?>
