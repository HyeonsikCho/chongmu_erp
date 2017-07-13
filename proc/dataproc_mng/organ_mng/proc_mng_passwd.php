<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$organDAO = new OrganMngDAO();

$empl_seqno = $fb->form("mng_seq");

//비밀번호 0000으로 초기화
$param = array();
$param["table"] = "empl";
$param["col"]["passwd"] = crypt("0000");
$param["prk"] = "empl_seqno";
$param["prkVal"] = $empl_seqno;

$result = $organDAO->updateData($conn, $param);

echo $result;

$conn->CompleteTrans();
$conn->close();
?>
