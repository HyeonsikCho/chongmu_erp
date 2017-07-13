<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/set/BasicDataDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();

$basicDAO = new BasicDataDAO();
$conn->StartTrans();

//계정 상세
$param = array();
$param["table"] = "acc_detail";
$param["col"]["acc_subject_seqno"] = $fb->form("acc_subject");
$param["col"]["name"] = $fb->form("acc_detail");
$param["col"]["note"] = $fb->form("note");

if ($fb->form("acc_detail_seqno")) {

    $param["prk"] = "acc_detail_seqno";
    $param["prkVal"] = $fb->form("acc_detail_seqno");

    $result = $basicDAO->updateData($conn, $param);

} else {

    $result = $basicDAO->insertData($conn, $param);

}

echo $result;
$conn->CompleteTrans();
$conn->close();
?>
