<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();
$conn->StartTrans();

//메인 업체 회원 seqno
$member_seqno = $fb->form("member_seqno");
//배송 서브 업체 일련번호
$sub_seqno = $fb->form("sub_seqno");

$param = array();
$param["member_seqno"] = $member_seqno;
$result = $dlvrDAO->selectMemberMainSeqno($conn, $param);
$dlvr_friend_main_seqno = $result->fields["dlvr_friend_main_seqno"];

//승인 or 거절 여부
$type = $fb->form("type");

$param = array();
$param["table"] = "dlvr_friend_sub";
$param["col"]["state"] = $type;
$param["col"]["dlvr_friend_main_seqno"] = $dlvr_friend_main_seqno;
$param["prk"] = "dlvr_friend_sub_seqno";
$param["prkVal"] = $sub_seqno;

$result = $dlvrDAO->updateData($conn, $param);

if ($result) {
    
    echo "수정 하였습니다.";

} else {

    echo "수정에 실패하였습니다.";
}

$conn->CompleteTrans();
$conn->close();
?>
