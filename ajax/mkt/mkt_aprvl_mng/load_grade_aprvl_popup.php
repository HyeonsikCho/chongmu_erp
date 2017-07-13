<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/MktAprvlMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$mktDAO = new MktAprvlMngDAO();

$grade_req_seq = $fb->form("grade_req_seq");

//등급 요청
$param = array();
$param["table"] = "grade_req";
$param["col"] = "state";
$param["where"]["grade_req_seqno"] =  $grade_req_seq;
$result = $mktDAO->selectData($conn, $param);

$state = $result->fields["state"];

//이미 승인/거절 처리한 데이터는 수정 불가
if ($state != "1") {

    $param["dis_btn"] = "disabled=\"disabled\"";
}

$html = getGradeAprvlView($param);

echo $html;

$conn->close();
?>
