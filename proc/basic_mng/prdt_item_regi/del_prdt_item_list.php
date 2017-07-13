<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ConnectionPool.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/entity/FormBean.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_mng/PrdtItemRegiDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$prdtItemRegiDAO = new PrdtItemRegiDAO();

$conn->StartTrans();

$check = 1;

//상품종이 일련번호
$seqno = explode(',', $fb->form("seqno"));
$table = $fb->form("table");
$price_table = "";

if ($table === "cate_size") {
    $table = "cate_stan";
} else if ($table === "cate_tmpt") {
    $table = "cate_print";
}

$param = array();
$param["table"] = $table;
$param["seqno"] = $fb->form("seqno");

$sel_rs = $prdtItemRegiDAO->selectCateMpcode($conn, $param);

while ($sel_rs && !$sel_rs->EOF) {

    //합판금액 굿프린팅 삭제
    $param = array();
    $param["table"] = "ply_price_gp";
    $param["prk"] = $talbe . "_mpcode";
    $param["prkVal"] = $sel_rs->fields["mpcode"];

    $rs = $prdtBasicRegiDAO->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
        echo $check;
        exit;
    }

    //합판금액 디프린팅 삭제
    $param = array();
    $param["table"] = "ply_price_dp";
    $param["prk"] = $table . "_mpcode";
    $param["prkVal"] = $sel_rs->fields["mpcode"];

    $rs = $prdtBasicRegiDAO->deleteData($conn, $param);

    if (!$rs) {
        $check = 0;
        echo $check;
        exit;
    }

    if ($table == "cate_after" || $table == "cate_opt") {

        //카테고리 후공정/옵션 가격 삭제
        $param = array();
        $param["table"] = $table . "_price";
        $param["prk"] = $table . "_mpcode";
        $param["prkVal"] = $sel_rs->fields["mpcode"];

        $rs = $prdtBasicRegiDAO->deleteData($conn, $param);

        if (!$rs) {
            $check = 0;
            echo $check;
            exit;
        }
    }

    $sel_rs->moveNext();
}

$param = array();
$param["table"] = $table;
$param["prk"] = $table . "_seqno";
$param["prkVal"] = $seqno;

$rs = $prdtItemRegiDAO->deleteMultiData($conn, $param);
 
if (!$rs) {
    $check = 0;
}

echo $check;
$conn->CompleteTrans();
$conn->close();
?>
