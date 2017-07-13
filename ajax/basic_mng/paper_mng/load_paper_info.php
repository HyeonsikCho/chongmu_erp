<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/PaperMngDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$paperDAO = new PaperMngDAO();

//종이 일련번호
$paper_seqno = $fb->form("paper_seqno");

$param = array();
$param["paper_seqno"] = $paper_seqno;

$result = $paperDAO->selectPrdcPaperList($conn, $param);

//종이 대분류
$param = Array();
$param["table"] = "produce_sort";
$param["col"] = "sort";
$param["where"]["produce_dvs"] = "1";

$t_result = $paperDAO->selectData($conn, $param);

$arr = [];
$arr["dvs"] = "sort";
$arr["val"] = "sort";

$sort_html = makeSelectOptionHtml($t_result, $arr);

$param = array();
$param["manu_name"] = $result->fields["manu_name"];
$param["brand"] = $result->fields["brand"];
$param["sort_html"] = $sort_html;
$param["name"] = $result->fields["name"];
$param["dvs"] = $result->fields["dvs"];
$param["color"] = $result->fields["color"];
$param["basisweight"] = $result->fields["basisweight"];
$param["wid_size"] = $result->fields["wid_size"];
$param["vert_size"] = $result->fields["vert_size"];
$param["crtr_unit"] = $result->fields["crtr_unit"];
$param["basic_price"] = $result->fields["basic_price"];
$param["pur_rate"] = $result->fields["pur_rate"];
$param["pur_aplc_price"] = $result->fields["pur_aplc_price"];
$param["pur_price"] = $result->fields["pur_price"];

$html = getPrdcPaperView($param);

$select_box_val = $result->fields["sort"] . "♪♡♭" . $result->fields["affil"] . "♪♡♭" . $result->fields["basisweight_unit"] ;

echo $html . "♪♥♭" . $select_box_val;

$conn->close();
?>
