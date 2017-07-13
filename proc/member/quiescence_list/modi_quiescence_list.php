<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/QuiescenceListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$quiescenceListDAO = new QuiescenceListDAO();
$check = 1;

$conn->StartTrans();

//회원 휴면처리
$param = array();
$param["seqno"] = $fb->form("seqno");

$rs = $quiescenceListDAO->updateMemberQuiescence($conn, $param);

if (!$rs) {
    $check = 0;
}

$seqno = explode(',', $fb->form("seqno"));

$i = 0;
foreach ($seqno as $key=>$value) {

    //회원탈퇴 입력
    $param = array();
    $param["table"] = "member_withdraw";
    $param["col"]["withdraw_code"] = $fb->form("withdraw_code");
    $param["col"]["withdraw_dvs"] = "탈퇴대기/휴면";
    $param["col"]["reason"] = "마지막 로그인 날짜가 1년이 넘게 되어 휴면처리 합니다.";
    $param["col"]["withdraw_date"] = date("Y-m-d H:i:s");
    $param["col"]["withdraw_code"] = "14";
    $param["col"]["member_seqno"] = $seqno[$i];

    $rs = $quiescenceListDAO->insertData($conn, $param);

    if (!$rs) {
        $check = 0;
        $conn->CompleteTrans();
        $conn->close();
        echo $check;
        exit;
    }

    //회원 쿠폰 삭제
    $param = array();
    $param["table"] = "member_cp";
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $seqno[$i];

    $rs = $quiescenceListDAO->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
        $conn->CompleteTrans();
        $conn->close();
        echo $check;
        exit;
    }

    //회원 포인트 내역 삭제
    $param = array();
    $param["table"] = "member_point_history";
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $seqno[$i];

    $rs = $quiescenceListDAO->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
        $conn->CompleteTrans();
        $conn->close();
        echo $check;
        exit;
    }

    //회원 포인트 요청 삭제
    $param = array();
    $param["table"] = "member_point_req";
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $seqno[$i];

    $rs = $quiescenceListDAO->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
        $conn->CompleteTrans();
        $conn->close();
        echo $check;
        exit;
    }
    $i++;
}

$conn->CompleteTrans();
$conn->close();
echo $check;
?>
