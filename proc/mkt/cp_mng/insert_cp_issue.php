<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/CpMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$cpDAO = new CpMngDAO();
$check = 0;

$seqno = $fb->form("cp_seqno");

$param = array();
$param["table"] = "cp_object_appoint_temp";
$param["col"] = "member_seqno";

$result = $cpDAO->selectData($conn, $param);
if (!$result) {

    $check = 1;
}

while ($result && !$result->EOF) {

    $member_seqno = $result->fields["member_seqno"];
    $issue_date = date("Y-m-d H:i:s", time());
    
    //랜덤 쿠폰번호 생성
    $cp_num = "";

    $feed = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i=0; $i < 10; $i++) {

        $cp_num .= substr($feed, rand(0, strlen($feed)-1), 1);

    }

    $param = array();
    $param["table"] = "cp_issue";
    $param["col"]["member_seqno"] = $member_seqno;
    $param["col"]["cp_num"] = $cp_num;
    $param["col"]["issue_date"] = $issue_date;
    $param["col"]["cp_seqno"] = $seqno;

    $cp_result = $cpDAO->insertData($conn, $param);
    if (!$cp_result) {

        $check = 1;
    }

    $result->moveNext();
}

$param = array();
$param["cp_seqno"] = $fb->form("cp_seqno");
$result = $cpDAO->selectCpIssueList($conn, $param);

$list = makeAppointMemberList($result);

echo $check . "♪♥♭" . $list;

$conn->CompleteTrans();
$conn->close();
?>
