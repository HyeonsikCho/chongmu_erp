<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/InquireMngDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/member/member_mng/InquireDetail.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$InquireMngDAO = new InquireMngDAO();

$seqno = $fb->form("seqno");

$rs = $InquireMngDAO->selectInquireAnsw($conn, $seqno);
$insw = array();
$answ_yn = $rs->fields["answ_yn"];
$insw["answ_yn"] = $answ_yn;

$param = array();

if ($answ_yn === "Y" ) { 
    $rs1 = $InquireMngDAO->selectInquireDetail($conn, $seqno);

    $title       = $rs1->fields["title"];
    $inq_typ     = $rs1->fields["inq_typ"];
    $member_name = $rs1->fields["member_name"];
    $tel_num     = $rs1->fields["tel_num"];
    $cell_num    = $rs1->fields["cell_num"];
    $cont        = $rs1->fields["cont"];
    $order_num   = $rs1->fields["order_num"];
    $mail        = $rs1->fields["mail"];
    $empl_name   = $rs1->fields["empl_name"];
    $repl_cont   = $rs1->fields["repl_cont"];

    $param["title"] = $title;
    $param["inq_typ"] = $inq_typ;
    $param["member_name"] = $member_name;
    $param["tel_num"] = $tel_num;
    $param["cell_num"] = $cell_num;
    $param["cont"] = $cont;
    $param["order_num"] = $order_num;
    $param["mail"] = $mail;
    $param["empl_name"] = $empl_name;
    $param["repl_cont"] = $repl_cont;

    echo makeInquireInfoDetailHtml($param) . "♪";
} else if ($answ_yn === "N") {
    $rs2 = $InquireMngDAO->selectInquireDetail2($conn, $seqno);

    $title       = $rs2->fields["title"];
    $inq_typ     = $rs2->fields["inq_typ"];
    $member_name = $rs2->fields["member_name"];
    $tel_num     = $rs2->fields["tel_num"];
    $cell_num    = $rs2->fields["cell_num"];
    $cont        = $rs2->fields["cont"];
    $order_num   = $rs2->fields["order_num"];
    $mail        = $rs2->fields["mail"];

    $param["title"] = $title;
    $param["inq_typ"] = $inq_typ;
    $param["member_name"] = $member_name;
    $param["tel_num"] = $tel_num;
    $param["cell_num"] = $cell_num;
    $param["cont"] = $cont;
    $param["order_num"] = $order_num;
    $param["mail"] = $mail;

    echo makeInquireInfoDetailHtml2($param) . "♪";
}


$conn->close();
?>
