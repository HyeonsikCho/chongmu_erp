<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/set/MtraDscrMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$mtraDAO = new MtraDscrMngDAO();

$param = array();
$param["table"] = "paper_dscr";
$param["col"]["name"] = $fb->form("paper_name");
$param["col"]["dvs"] = $fb->form("dvs");
$param["col"]["paper_sense"] = $fb->form("sense");

//종이 설명 수정
if ($fb->form("paper_dscr_seqno")) {

    $param["prk"] = "paper_dscr_seqno";
    $param["prkVal"] = $fb->form("paper_dscr_seqno");

    $result = $mtraDAO->updateData($conn, $param);

//종이 설명 추가
} else {

    $result = $mtraDAO->insertData($conn, $param);

}

if ($result) {

    echo "1";

} else {

    echo "2";

}

$conn->CompleteTrans();
$conn->close();
?>

