<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();
$conn->StartTrans();

//메인 업체 seqno
$seqno = $fb->form("seqno");
//승인 or 거절 여부
$type = $fb->form("type");

$param = array();
$param["table"] = "dlvr_friend_main";
$param["col"]["state"] = $type;
$param["prk"] = "dlvr_friend_main_seqno";
$param["prkVal"] = $seqno;

$result = $dlvrDAO->updateData($conn, $param);

if ($result) {
    
    echo "수정 하였습니다.";

} else {

    echo "수정에 실패하였습니다.";
}

$conn->CompleteTrans();
$conn->close();
?>
