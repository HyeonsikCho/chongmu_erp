<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/set/MtraDscrMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$mtraDAO = new MtraDscrMngDAO();

//종이 설명 일련번호
$paper_dscr_seq = $fb->form("paper_dscr_seq");
$param = array();

//종이 설명 수정일때
if($paper_dscr_seq) {

    //종이 설명
    $param["table"] = "paper_dscr";
    $param["col"] = "name, dvs, paper_sense";
    $param["where"]["paper_dscr_seqno"] =  $paper_dscr_seq;
    $result = $mtraDAO->selectData($conn, $param);

    //html data 셋팅
    $param = array();
    $param["name"] = $result->fields["name"];
    $param["dvs"] = $result->fields["dvs"];
    $param["sense"] = $result->fields["paper_sense"];
    $param["paper_dscr_seqno"] = $paper_dscr_seq;

}

$html = getPaperDscrHtml($param);

echo $html;
$conn->close();
?>
