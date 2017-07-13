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

//상세정보
$param = array();
$param["table"] = "member_detail_info";
$param["col"] = "wd_yn ,wd_anniv ,occu1 ,occu2 
                ,occu_detail ,interest_field1, interest_field2
                ,interest_field_detail ,design_yn ,produce_yn ,use_pro
                ,interest_item1, interest_item2, interest_item_detail
                ,interest_prior, plural_deal_yn ,plural_deal_site_name1
                ,plural_deal_site_detail1, plural_deal_site_name2
                ,plural_deal_site_detail2, recomm_id, recomm_id_detail
                ,memo, regi_date, member_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$detail_rs = $memberCommonListDAO->selectData($conn, $param);

//관심 상품
$param = array();
$param["table"] = "member_interest_prdt";
$param["col"] = "interest_1 ,interest_2 ,interest_3 ,interest_4 
                ,interest_5 ,interest_6 ,interest_7 ,interest_8
                ,interest_9 ,interest_10 ,interest_11 ,interest_12
                ,interest_13,interest_14,interest_15";
$param["where"]["member_seqno"] = $fb->form("seqno");

$inter_prdt_rs = $memberCommonListDAO->selectData($conn, $param);

//관심 이벤트
$param = array();
$param["table"] = "member_interest_event";
$param["col"] = "interest_1 ,interest_2 ,interest_3 ,interest_4 
                ,interest_5 ,interest_6 ,interest_7 ,interest_8
                ,interest_9 ,interest_10";
$param["where"]["member_seqno"] = $fb->form("seqno");

$inter_event_rs = $memberCommonListDAO->selectData($conn, $param);

//관심 디자인
$param = array();
$param["table"] = "member_interest_design";
$param["col"] = "interest_1 ,interest_2 ,interest_3 ,interest_4 
                ,interest_5 ,interest_6 ,interest_7 ,interest_8
                ,interest_9 ,interest_10";
$param["where"]["member_seqno"] = $fb->form("seqno");

$inter_design_rs = $memberCommonListDAO->selectData($conn, $param);

//관심요구사항
$param = array();
$param["table"] = "member_interest_needs";
$param["col"] = "interest_1 ,interest_2 ,interest_3 ,interest_4 
                ,interest_5 ,interest_6 ,interest_7 ,interest_8
                ,interest_9 ,interest_10";
$param["where"]["member_seqno"] = $fb->form("seqno");

$inter_needs_rs = $memberCommonListDAO->selectData($conn, $param);

$param = array();
$param["wd_anniv"] = $detail_rs->fields["wd_anniv"];
$param["occu_detail"] = $detail_rs->fields["occu_detail"];
$param["interest_field_detail"] = $detail_rs->fields["interest_field_detail"];
$param["plural_deal_site_detail1"] = $detail_rs->fields["plural_deal_site_detail1"];
$param["plural_deal_site_detail2"] = $detail_rs->fields["plural_deal_site_detail2"];
$param["recomm_id"] = $detail_rs->fields["recomm_id"];
$param["recomm_id_detail"] = $detail_rs->fields["recomm_id_detail"];
$param["memo"] = $detail_rs->fields["memo"];
$param["member_seqno"] = $fb->form("seqno");

echo makeMemberAddInfoHtml($param) . "♪" . $detail_rs->fields["wd_yn"] . "♪" . 
       $detail_rs->fields["occu1"] . "♪" . $detail_rs->fields["occu2"] . "♪" .
       $detail_rs->fields["interest_field1"] . "♪" . $detail_rs->fields["interest_field2"] . "♪" .
       //5

       $inter_prdt_rs->fields["interest_1"] . "♪" . $inter_prdt_rs->fields["interest_2"] . "♪" .
       $inter_prdt_rs->fields["interest_3"] . "♪" . $inter_prdt_rs->fields["interest_4"] . "♪" .
       $inter_prdt_rs->fields["interest_5"] . "♪" . $inter_prdt_rs->fields["interest_6"] . "♪" .
       $inter_prdt_rs->fields["interest_7"] . "♪" . $inter_prdt_rs->fields["interest_8"] . "♪" . 
       $inter_prdt_rs->fields["interest_9"] . "♪" . $inter_prdt_rs->fields["interest_10"] . "♪" . 
       $inter_prdt_rs->fields["interest_11"] . "♪" . $inter_prdt_rs->fields["interest_12"] . "♪" .
       //17

       $inter_event_rs->fields["interest_1"] . "♪" . $inter_event_rs->fields["interest_2"] . "♪" . 
       $inter_event_rs->fields["interest_3"] . "♪" . $inter_event_rs->fields["interest_4"] . "♪" .
       $inter_event_rs->fields["interest_5"] . "♪" . $inter_event_rs->fields["interest_6"] . "♪" .
       //23

       $inter_design_rs->fields["interest_1"] . "♪" . 
       //24

       $inter_needs_rs->fields["interest_1"] . "♪" . $inter_needs_rs->fields["interest_2"] . "♪" . 
       $inter_needs_rs->fields["interest_3"] . "♪" . $inter_needs_rs->fields["interest_4"] . "♪" . 
       $inter_needs_rs->fields["interest_5"] . "♪" . $inter_needs_rs->fields["interest_6"] . "♪" . 
       $inter_needs_rs->fields["interest_7"] . "♪" . $inter_needs_rs->fields["interest_8"] . "♪" . 
       $inter_needs_rs->fields["interest_9"] . "♪" . $inter_needs_rs->fields["interest_10"] . "♪" .
       //34

       $detail_rs->fields["design_yn"] . "♪" . $detail_rs->fields["produce_yn"] . "♪" .
       $detail_rs->fields["use_pro"] . "♪" . $detail_rs->fields["interest_item1"] . "♪" .
       $detail_rs->fields["interest_item2"] . "♪" . $detail_rs->fields["interest_prior"] . "♪" .
       $detail_rs->fields["plural_deal_yn"] . "♪" . $detail_rs->fields["plural_deal_site_name1"] . "♪" .
       $detail_rs->fields["plural_deal_site_name2"];
$conn->close();
?>
