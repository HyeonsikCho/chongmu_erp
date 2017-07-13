<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/PrintMngDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$printDAO = new PrintMngDAO();
$conn->StartTrans();

$param = array();

$param["table"] = "print";
//인쇄 대분류
$param["col"]["top"] = $fb->form("print_top");
//기준가격
$param["col"]["basic_price"] = $fb->form("basic_price");
//인쇄명
$param["col"]["name"] = $fb->form("pop_print_name");
//요율
$param["col"]["pur_rate"] = $fb->form("pur_rate");
//인쇄 색도
$param["col"]["crtr_tmpt"] = $fb->form("crtr_tmpt");
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
//매입금액 = 기준금액 (1+(요율)/100) + 적용금액
$param["col"]["pur_price"] = ($fb->form("basic_price") * 
                             (1 + $fb->form("pur_rate")/100)) + 
                             $fb->form("pur_aplc_price");
//수량
$param["col"]["amt"] = $fb->form("amt");
$param["prk"] = "print_seqno";
$param["prkVal"] = $fb->form("print_seqno");

$result = $printDAO->updateData($conn, $param);

if ($result) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>

