<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$bulletinDAO = new BulletinMngDAO();

//팝업 파일 지우기
$param = array();
$param["table"] = "popup_admin";
$param["col"]["file_path"] = "";
$param["col"]["save_file_name"] = "";
$param["col"]["origin_file_name"] = "";
$param["prk"] = "popup_admin_seqno";
$param["prkVal"] = $fb->form("popup_seqno");

$result = $bulletinDAO->updateData($conn, $param);

if ($result) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>
