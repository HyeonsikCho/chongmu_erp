<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/MemberCommonListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$memberCommonListDAO = new MemberCommonListDAO();

$check = 1;
$conn->StartTrans();

$param = array();
$param["table"] = "member_detail_info";
$param["col"] = "member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$sel_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "member_detail_info";
$param["col"]["wd_yn"] = $fb->form("wd_yn");
$param["col"]["wd_anniv"] = $fb->form("wd_anniv");
$param["col"]["occu1"] = $fb->form("occu1");
$param["col"]["occu2"] = $fb->form("occu2");
$param["col"]["occu_detail"] = $fb->form("occu_detail");
$param["col"]["interest_field1"] = $fb->form("interest_field1");
$param["col"]["interest_field2"] = $fb->form("interest_field2");
$param["col"]["interest_field_detail"] = $fb->form("interest_field_detail");
$param["col"]["design_yn"] = $fb->form("design_yn");
$param["col"]["produce_yn"] = $fb->form("produce_yn");
$param["col"]["use_pro"] = $fb->form("use_pro");
$param["col"]["interest_item1"] = $fb->form("interest_item1");
$param["col"]["interest_item2"] = $fb->form("interest_item2");
$param["col"]["interest_item_detail"] = $fb->form("interest_item_detail");
$param["col"]["interest_prior"] = $fb->form("interest_prior");
$param["col"]["plural_deal_yn"] = $fb->form("plural_deal_yn");
$param["col"]["plural_deal_site_name1"] = $fb->form("plural_deal_site_name1");
$param["col"]["plural_deal_site_name2"] = $fb->form("plural_deal_site_name2");
$param["col"]["plural_deal_site_detail1"] = $fb->form("plural_deal_site_detail1");
$param["col"]["plural_deal_site_detail2"] = $fb->form("plural_deal_site_detail2");
$param["col"]["recomm_id"] = $fb->form("recomm_id");
$param["col"]["recomm_id_detail"] = $fb->form("recomm_id_detail");
$param["col"]["memo"] = $fb->form("memo");

if ($sel_rs->EOF == 1) {
    $param["col"]["regi_date"] = date("Y-m-d H:i:s");
    $param["col"]["member_seqno"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->insertData($conn, $param);

} else {
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->updateData($conn, $param);
}

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "member_interest_prdt";
$param["col"] = "member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$sel_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "member_interest_prdt";
$param["col"]["interest_1"] = $fb->form("inter_prdt1");
$param["col"]["interest_2"] = $fb->form("inter_prdt2");
$param["col"]["interest_3"] = $fb->form("inter_prdt3");
$param["col"]["interest_4"] = $fb->form("inter_prdt4");
$param["col"]["interest_5"] = $fb->form("inter_prdt5");
$param["col"]["interest_6"] = $fb->form("inter_prdt6");
$param["col"]["interest_7"] = $fb->form("inter_prdt7");
$param["col"]["interest_8"] = $fb->form("inter_prdt8");
$param["col"]["interest_9"] = $fb->form("inter_prdt9");
$param["col"]["interest_10"] = $fb->form("inter_prdt10");
$param["col"]["interest_11"] = $fb->form("inter_prdt11");
$param["col"]["interest_12"] = $fb->form("inter_prdt12");

if ($sel_rs->EOF == 1) {
    $param["col"]["member_seqno"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->insertData($conn, $param);

} else {
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->updateData($conn, $param);
}

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "member_interest_event";
$param["col"] = "member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$sel_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "member_interest_event";
$param["col"]["interest_1"] = $fb->form("inter_event1");
$param["col"]["interest_2"] = $fb->form("inter_event2");
$param["col"]["interest_3"] = $fb->form("inter_event3");
$param["col"]["interest_4"] = $fb->form("inter_event4");
$param["col"]["interest_5"] = $fb->form("inter_event5");
$param["col"]["interest_6"] = $fb->form("inter_event6");

if ($sel_rs->EOF == 1) {
    $param["col"]["member_seqno"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->insertData($conn, $param);

} else {
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->updateData($conn, $param);
}

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "member_interest_design";
$param["col"] = "member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$sel_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "member_interest_design";
$param["col"]["interest_1"] = $fb->form("inter_design1");

if ($sel_rs->EOF == 1) {
    $param["col"]["member_seqno"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->insertData($conn, $param);

} else {
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->updateData($conn, $param);
}

if (!$rs) {
    $check = 0;
}

$param = array();
$param["table"] = "member_interest_needs";
$param["col"] = "member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$sel_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "member_interest_needs";
$param["col"]["interest_1"] = $fb->form("inter_needs1");
$param["col"]["interest_2"] = $fb->form("inter_needs2");
$param["col"]["interest_3"] = $fb->form("inter_needs3");
$param["col"]["interest_4"] = $fb->form("inter_needs4");
$param["col"]["interest_5"] = $fb->form("inter_needs5");
$param["col"]["interest_6"] = $fb->form("inter_needs6");
$param["col"]["interest_7"] = $fb->form("inter_needs7");
$param["col"]["interest_8"] = $fb->form("inter_needs8");
$param["col"]["interest_9"] = $fb->form("inter_needs9");
$param["col"]["interest_10"] = $fb->form("inter_needs10");

if ($sel_rs->EOF == 1) {
    $param["col"]["member_seqno"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->insertData($conn, $param);

} else {
    $param["prk"] = "member_seqno";
    $param["prkVal"] = $fb->form("seqno");
    $rs = $memberCommonListDAO->updateData($conn, $param);
}

if (!$rs) {
    $check = 0;
}

echo $check;
$conn->CompleteTrans();
$conn->close();
?>
