<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsListDAO();

//외부업체 회원 일련번호
$member_seqno = $fb->form("mem_seqno");

//외부업체 회원 정보 가져오기
$param = array();
$param["table"] = "extnl_etprs_member";
$param["col"] = "mng, extnl_etprs_member_seqno, id,
                 access_code, tel_num, cell_num,
                 job, mail, resp_task";
$param["where"]["extnl_etprs_member_seqno"] = $member_seqno;

$result = $purDAO->selectData($conn, $param);

$name = $result->fields["mng"];
$member_seqno = $result->fields["member_seqno"];
$id = $result->fields["id"];
$access_code = $result->fields["access_code"];
$tel_num = $result->fields["tel_num"];
$cell_num = $result->fields["cell_num"];
$mail = $result->fields["mail"];
$resp_task = $result->fields["resp_task"];
$job = $result->fields["job"];

$tel = explode('-', $tel_num);
$tel_top = $tel[0];
$tel_mid = $tel[1];
$tel_btm = $tel[2];

$cel = explode('-', $cell_num);
$cel_top = $cel[0];
$cel_mid = $cel[1];
$cel_btm = $cel[2];

$mail = explode('@', $mail);
$mail_top = $mail[0];
$mail_btm = $mail[1];

echo $id . "♪♥♭" . $access_code . "♪♥♭" . $name . "♪♥♭" . 
     $job . "♪♥♭" . $resp_task . "♪♥♭" . $mail_top  . "♪♥♭" .
     $mail_btm . "♪♥♭" . $tel_top . "♪♥♭"  . $tel_mid . "♪♥♭" .
     $tel_btm . "♪♥♭" . $cel_top . "♪♥♭" . $cel_mid . "♪♥♭" .
     $cel_btm;

$conn->close();
?>
