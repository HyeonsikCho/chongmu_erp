<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/esti_mng/EstiListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new EstiListDAO();
$check = 1;

$conn->StartTrans();
$seqno = explode(',', $fb->form("seqno"));

//견적파일 삭제
$param = array();
$param["table"] = "esti_file";
$param["prk"] = "esti_seqno";
$param["prkVal"] = $seqno;

$rs = $dao->deleteMultiData($conn, $param);

if (!$rs) {
    $check = 0;
}

//견적 삭제
$param = array();
$param["esti_seqno"] = $fb->form("seqno");

$rs = $dao->deleteEstiList($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>
