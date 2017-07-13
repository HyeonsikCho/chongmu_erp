<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/calcul_mng/settle/AdjustRegiDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$adjustDAO = new AdjustRegiDAO();
$conn->StartTrans();
$check = 1;

//조정 테이블에 입력
$param = array();
$param["table"] = "adjust";
$param["col"]["member_seqno"] = $fb->form("member_seqno");
$param["col"]["cont"] = $fb->form("cont");
$param["col"]["deal_date"] = $fb->form("deal_date");
$param["col"]["regi_date"] = date("Y-m-d H:i:s", time());
$param["col"]["price"] = $fb->form("price");
$param["col"]["dvs"] = $fb->form("dvs");
$param["col"]["dvs_detail"] = $fb->form("dvs_detail");
$param["col"]["empl_seqno"] = $_SESSION["empl_seqno"];

$result = $adjustDAO->insertData($conn, $param);
if (!$result) $check = 0;

//회원 테이블에서 예치금 검색
$param = array();
$param["member_seqno"] = $fb->form("member_seqno");

$result = $adjustDAO->selectMemberPrepay($conn, $param);
if (!$result) $check = 0;

//회원 예치금 수정
$param = array();
$param["table"] = "member";
$param["prepay_price"] = $result->fields["prepay_price"] + $fb->form("price");
$param["member_seqno"] = $fb->form("member_seqno");
$result = $adjustDAO->updateMemberPrepay($conn, $param);
if (!$result) $check = 0;

echo $check;

$conn->CompleteTrans();
$conn->close();
?>
