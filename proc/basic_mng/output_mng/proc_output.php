<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/OutputMngDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$outputDAO = new OutputMngDAO();
$conn->StartTrans();

$param = array();

$param["table"] = "output";
//출력 대분류
$param["col"]["top"] = $fb->form("output_top");
//기준가격
$param["col"]["basic_price"] = $fb->form("basic_price");
//출력명
$param["col"]["name"] = $fb->form("pop_output_name");
//요율
$param["col"]["pur_rate"] = $fb->form("pur_rate");
//판
$param["col"]["board"] = $fb->form("board");
//적용 금액
$param["col"]["pur_aplc_price"] = $fb->form("pur_aplc_price");
//계열
$param["col"]["affil"] = $fb->form("affil");
//가로사이즈
$param["col"]["wid_size"] = $fb->form("wid_size");
//세로사이즈
$param["col"]["vert_size"] = $fb->form("vert_size");
//기준단위
$param["col"]["crtr_unit"] = $fb->form("crtr_unit");
//수량
$param["col"]["amt"] = $fb->form("amt");
//매입금액 = 기준금액 (1+(요율)/100) + 적용금액
$param["col"]["pur_price"] = ($fb->form("basic_price") * 
                             (1 + $fb->form("pur_rate")/100)) + 
                             $fb->form("pur_aplc_price");
$param["prk"] = "output_seqno";
$param["prkVal"] = $fb->form("output_seqno");

$result = $outputDAO->updateData($conn, $param);

if ($result) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>

