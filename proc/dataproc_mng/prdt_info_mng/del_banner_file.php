<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/set/PrdtInfoMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$prdtDAO = new PrdtInfoMngDAO();

//카테고리 배너 파일 삭제
$param = array();
$param["table"] = "cate_banner";
$param["col"]["file_path"] = "";
$param["col"]["save_file_name"] = "";
$param["col"]["origin_file_name"] = "";
$param["prk"] = "cate_banner_seqno";
$param["prkVal"] = $fb->form("banner_seqno");

$result = $prdtDAO->updateData($conn, $param);

if ($result) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>
