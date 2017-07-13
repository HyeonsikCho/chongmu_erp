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

$member_seqno = $fb->form("seqno");

$opt = array();
$opt[0] = "발급일";

$optVal = array();
$optVal[0] = "regi_date";

$param = array();
$param["value"] = $optVal;
$param["fields"] = $opt;
$param["id"] = "coupon_search_cnd";
$param["flag"] = TRUE;
$param["from_id"] = "coupon_from";
$param["to_id"] = "coupon_to";
$param["func"] = "couponDateSet";

//날짜 검색
$date_picker_html = makeDatePickerHtml($param);

//기업 개인인 경우 기업정보 보여줌
$param = array();
$param["member_seqno"] = $member_seqno;

$group_rs = $memberCommonListDAO->selectMemberDetailInfo($conn, $param);

if ($group_rs->fields["group_id"]) {
    $member_seqno = $group_rs->fields["group_id"];
}

$param = array();
$param["date_picker_html"] = $date_picker_html;

echo makeMemberCouponInfoHtml($param) . "♪";
$conn->close();
?>
