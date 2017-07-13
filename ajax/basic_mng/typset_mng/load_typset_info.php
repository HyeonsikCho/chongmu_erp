<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/TypsetMngDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new TypsetMngDAO();

//조판 일련번호
$typset_seqno = $fb->form("typset_seqno");

$param = array();
$param["table"] = "typset_format";
$param["col"] = "name, affil, subpaper, wid_size, 
                 vert_size, dscr, cate_sortcode,
                 purp, dlvrboard, extnl_etprs_seqno";
$param["where"]["typset_format_seqno"] = $typset_seqno;

$result = $dao->selectData($conn, $param);

$d_param = array();

//조판명
$d_param["name"] = $result->fields["name"];
$affil = $result->fields["affil"];
$subpaper = $result->fields["subpaper"];
$d_param["wid_size"] = $result->fields["wid_size"];
$d_param["vert_size"] = $result->fields["vert_size"];
$dscr = $result->fields["dscr"];
$cate_sortcode = $result->fields["cate_sortcode"];
$purp = $result->fields["purp"];
$dlvrboard = $result->fields["dlvrboard"];
$extnl_etprs_seqno = $result->fields["extnl_etprs_seqno"];

$param = array();
$param["table"] = "extnl_etprs";
$param["col"] = "pur_prdt, manu_name";
$param["where"]["extnl_etprs_seqno"] = $extnl_etprs_seqno;

$result = $dao->selectData($conn, $param);

$pur_prdt = $result->fields["pur_prdt"];

$param = array();
$param["table"] = "typset_format_file";
$param["col"] = "origin_file_name, typset_format_file_seqno";
$param["where"]["typset_format_seqno"] = $typset_seqno;

$result = $dao->selectData($conn, $param);

$d_param["add_yn"] = "N";

$file_html = "";
//조판 파일이 있을때
if ($result) {

    $param = array();
    $param["file_name"] = $result->fields["origin_file_name"];

    if ($param["file_name"]) {
        $file_html = getFileHtml($param);
    }
}

$cate_top = substr($cate_sortcode, 0, 3);
$cate_mid = substr($cate_sortcode, 0, 6);

$param = array();
$param["table"] = "extnl_etprs";
$param["col"] = "extnl_etprs_seqno, manu_name";
$param["where"]["pur_prdt"] = $pur_prdt;

$rs = $dao->selectData($conn, $param);

$d_param["file_html"] = $file_html;
$d_param["cate_top"] = $dao->selectCateList($conn);
$d_param["cate_mid"] = $dao->selectCateList($conn, $cate_top);
$d_param["cate_bot"] = $dao->selectCateList($conn, $cate_mid);
$d_param["manu_name"] = makeOptionHtml($rs, "extnl_etprs_seqno", "manu_name", "", "N");

$html = getPrdcTypsetView($d_param);

$select_box_val = $affil . "♪♡♭" . $subpaper . "♪♡♭" . $dscr
        . "♪♡♭" . $cate_top . "♪♡♭" . $cate_mid 
        . "♪♡♭" . $cate_sortcode . "♪♡♭" . $purp . "♪♡♭" . $dlvrboard
        . "♪♡♭" . $extnl_etprs_seqno . "♪♡♭" . $pur_prdt;

echo $html . "♪♥♭" . $select_box_val;
$conn->close();
?>
