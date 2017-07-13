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
$param["table"] = "opt_dscr";
$param["col"]["name"] = $fb->form("opt_name");
$param["col"]["dscr"] = $fb->form("dscr");

//옵션 설명 수정
if ($fb->form("opt_dscr_seqno")) {

    $param["prk"] = "opt_dscr_seqno";
    $param["prkVal"] = $fb->form("opt_dscr_seqno");

    $result = $mtraDAO->updateData($conn, $param);

//옵션 설명 추가
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
