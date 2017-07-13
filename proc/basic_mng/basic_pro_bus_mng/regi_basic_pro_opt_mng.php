<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/cate_mng/BasicProBusMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new BasicProBusMngDAO();
$check = 1;

$el = $fb->form("el");
$conn->StartTrans();

if ($fb->form($el . "_produce_yn") === "N") {

    $param = array();
    $param["table"] = "basic_produce_" . $el;
    $param["prk"] = "typset_format_seqno";
    $param["prkVal"] = $fb->form("seqno");

    $rs = $dao->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
    }

    $conn->CompleteTrans();
    $conn->Close();
    echo $check;
    exit;
} 

$param = array();
$param["table"] = "basic_produce_opt";
$param["col"]["typset_format_seqno"] = $fb->form("seqno");
$param["col"]["opt_seqno"] = $fb->form("opt_seqno");

$rs = $dao->insertData($conn, $param);

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "typset_format";
$param["col"]["process_yn"] = "Y";
$param["prk"] = "typset_format_seqno";
$param["prkVal"] = $fb->form("seqno");

$rs = $dao->updateData($conn, $param);

if (!$rs) {
    $check = 0;
}

$conn->CompleteTrans();
$conn->Close();
echo $check;
?>