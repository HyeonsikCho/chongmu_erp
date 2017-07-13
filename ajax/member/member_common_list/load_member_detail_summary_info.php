<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/Template.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/MemberCommonListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$template = new Template();
$memberCommonListDAO = new MemberCommonListDAO();

$param = array();
$param["member_seqno"] = $fb->form("seqno");

$rs = $memberCommonListDAO->selectMemberSummaryInfo($conn, $param);
$order_count_rs = $memberCommonListDAO->selectOrderCountInfo($conn, $param);

$param = array();
$param["table"] = "member_cp";
$param["col"] = "COUNT(*) AS cp";
$param["where"]["member_seqno"] = $fb->form("seqno");

$cp_count_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["table"] = "depar_admin";
$param["col"] = "depar_code, depar_name";
$param["where"]["cpn_admin_seqno"] = $rs->fields["cpn_admin_seqno"];

$depar_rs = $memberCommonListDAO->selectData($conn, $param);

$biz_resp = "";
$release_resp = "";
$dlvr_resp = "";

while ($depar_rs && !$depar_rs->EOF) {

    if ($rs->fields["biz_resp"] == $depar_rs->fields["depar_code"]) {
        $biz_resp = $depar_rs->fields["depar_name"];
    }

    if ($rs->fields["release_resp"] == $depar_rs->fields["depar_code"]) {
        $release_resp = $depar_rs->fields["depar_name"];
    }
 
    if ($rs->fields["dlvr_resp"] == $depar_rs->fields["depar_code"]) {
        $dlvr_resp = $depar_rs->fields["depar_name"];
    }

    $depar_rs->moveNext();
}

$param = array();
$param["member_name"] = $rs->fields["member_name"];
$param["member_id"] = $rs->fields["member_id"];
$param["nick"] = $rs->fields["nick"];
$param["grade_name"] = $rs->fields["grade_name"];
$param["member_typ"] = $rs->fields["member_typ"];
$param["own_point"] = $rs->fields["own_point"];
$param["cp"] = $cp_count_rs->fields["cp"];
$param["order_count"] = $order_count_rs->fields["order_count"];
$param["eval_reason"] = $rs->fields["eval_reason"];
$param["first_join_date"] = $rs->fields["first_join_date"];
$param["first_order_date"] = $rs->fields["first_order_date"];
$param["final_order_date"] = $rs->fields["final_order_date"];
$param["biz_resp"] = $biz_resp;
$param["release_resp"] = $release_resp;
$param["dlvr_resp"] = $dlvr_resp;

echo makeMemberSummaryInfoHtml($param) . "♪" . $rs->fields["mailing_yn"] . "♪" . $rs->fields["sms_yn"];
$conn->close();
?>
