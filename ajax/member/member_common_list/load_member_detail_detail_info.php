<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/Template.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/MemberCommonListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$template = new Template();
$dao = new MemberCommonListDAO();

$param = array();
$param["member_seqno"] = $fb->form("seqno");

$rs = $dao->selectMemberDetailInfo($conn, $param);

$sell_site = $rs->fields["cpn_admin_seqno"];

$param = array();
$param["table"] = "member_certi";
$param["col"] = "certinum, origin_file_name, member_certi_seqno";
$param["where"]["member_seqno"] = $fb->form("seqno");

$certi_rs = $dao->selectData($conn, $param);

$certi_yn = "";
if ($certi_rs->EOF == 1) {
    $certi_yn = "N";
} else {
    $certi_yn = "Y";
}

$param = array();
$param["sell_site"] = $sell_site;
$param["depar_code"] = "001";

$biz_rs = $dao->selectDeparInfo($conn, $param);

$arr = [];
$arr["flag"] = "N";
$arr["def"] = "";
$arr["dvs"] = "depar_name";
$arr["val"] = "depar_code";

$biz_resp = makeSelectOptionHtml($biz_rs, $arr);

$param = array();
$param["table"] = "empl";
$param["col"] = "empl_seqno, name";
$param["where"]["depar_code"] = '001001';
$param["where"]["cpn_admin_seqno"] = $sell_site;

$empl_rs = $dao->selectData($conn, $param);

$arr = [];
$arr["flag"] = "N";
$arr["def"] = "";
$arr["dvs"] = "name";
$arr["val"] = "empl_seqno";

$empl = makeSelectOptionHtml($empl_rs, $arr);

$param = array();
$param["sell_site"] = $sell_site;
$param["depar_code"] = "002";

$release_rs = $dao->selectDeparInfo($conn, $param);

$arr = [];
$arr["flag"] = "N";
$arr["def"] = "";
$arr["dvs"] = "depar_name";
$arr["val"] = "depar_code";

$release_resp = makeSelectOptionHtml($release_rs, $arr);

$param = array();
$param["sell_site"] = $sell_site;
$param["depar_code"] = "003";

$dlvr_rs = $dao->selectDeparInfo($conn, $param);

$arr = [];
$arr["flag"] = "N";
$arr["def"] = "";
$arr["dvs"] = "depar_name";
$arr["val"] = "depar_code";

$dlvr_resp = makeSelectOptionHtml($dlvr_rs, $arr);

if ($rs->fields["member_dvs"] == "기업") {
    $param = array();
    $param["table"] = "licensee_info";
    $param["col"] = "crn, repre_name, bc, tob, tel_num, zipcode, addr, addr_detail";
    $param["where"]["member_seqno"] = $fb->form("seqno");

    $licensee_rs = $dao->selectData($conn, $param);

    $param = array();
    $param["group_id"] = $fb->form("seqno");

    $mng_info_rs = $dao->selectMemberDetailInfo($conn, $param);

    if (!$mng_info_rs->EOF == 1) {
        $mng_info_html = makeMemberMngDetailHtml($mng_info_rs);
    } else {
        $mng_info_html = "<tr><td colspan=\"5\">검색 된 내용이 없습니다.</td></tr>";
    }

    $param = array();
    $param["table"] = "accting_mng";
    $param["col"] = "name, tel_num, cell_num, mail";
    $param["where"]["member_seqno"] = $fb->form("seqno");
 
    $accting_mng_info_rs = $dao->selectData($conn, $param);

    if (!$accting_mng_info_rs->EOF == 1) {
        $accting_mng_info_html = makeMemberAcctingMngDetailHtml($accting_mng_info_rs);
    } else {
        $accting_mng_info_html = "<tr><td colspan=\"4\">검색 된 내용이 없습니다.</td></tr>";
    }

    $param = array();
    $param["table"] = "admin_licenseeregi";
    $param["col"] = "crn, corp_name, repre_name, tel_num, addr, addr_detail";
    $param["where"]["member_seqno"] = $fb->form("seqno");

    $admin_licenseeregi_info_rs = $dao->selectData($conn, $param);

    if (!$admin_licenseeregi_info_rs->EOF == 1) {
        $admin_licenseeregi_info_html = makeMemberidminLicenseeregiDetailHtml($admin_licenseeregi_info_rs);
    } else {
        $admin_licenseeregi_info_html = "<tr><td colspan=\"6\">검색 된 내용이 없습니다.</td></tr>";
    }
}

$tel_num1 = "";
$tel_num2 = "";
$tel_num3 = "";

if (!empty($licensee_rs->fields["tel_num"])) {
    $tmp = explode("-", $licensee_rs->fields["tel_num"]);
    $tel_num1 = $tmp[0];
    $tel_num2 = $tmp[1];
    $tel_num3 = $tmp[2];
}

$param = array();
$param["table"] = "member_mng";
$param["col"] = "resp_deparcode, tel_mng, ibm_mng, mac_mng";
$param["where"]["member_seqno"] = $fb->form("seqno");
$param["where"]["mng_dvs"] = "일반";

$gene_rs = $dao->selectData($conn, $param);

$param = array();
$param["table"] = "member_mng";
$param["col"] = "resp_deparcode, tel_mng, ibm_mng, mac_mng";
$param["where"]["member_seqno"] = $fb->form("seqno");
$param["where"]["mng_dvs"] = "상업";

$busi_rs = $dao->selectData($conn, $param);

$param = array();
$param["member_seqno"] = $fb->form("seqno");
$param["nick"] = $rs->fields["nick"];
$param["eval_reason"] = $rs->fields["eval_reason"];
$param["certinum"] = $certi_rs->fields["certinum"];
$param["origin_file_name"] = $certi_rs->fields["origin_file_name"];
$param["cashreceipt_card_num"] = $rs->fields["cashreceipt_card_num"];
$param["biz_resp"] = $biz_resp;
$param["empl"] = $empl;
$param["release_resp"] = $release_resp;
$param["dlvr_resp"] = $dlvr_resp;
$param["crn"] = $licensee_rs->fields["crn"];
$param["repre_name"] = $licensee_rs->fields["repre_name"];
$param["bc"] = $licensee_rs->fields["bc"];
$param["tob"] = $licensee_rs->fields["tob"];
$param["tel_num2"] = $tel_num2;
$param["tel_num3"] = $tel_num3;
$param["zipcode"] = $licensee_rs->fields["zipcode"];
$param["addr"] = $licensee_rs->fields["addr"];
$param["addr_detail"] = $licensee_rs->fields["addr_detail"];
$param["mng_info_html"] = $mng_info_html;
$param["accting_mng_info_html"] = $accting_mng_info_html;
$param["admin_licenseeregi_info_html"] = $admin_licenseeregi_info_html;
$param["sell_site"] = $sell_site;
$param["member_certi_seqno"] = $certi_rs->fields["member_certi_seqno"];

echo makeMemberDetailInfoHtml($param) . "♪" . $rs->fields["member_dvs"] . "♪" . 
            $rs->fields["mailing_yn"] . "♪" . $rs->fields["sms_yn"] . "♪" . 
            $rs->fields["biz_resp"] . "♪" . $rs->fields["release_resp"] . "♪" . 
            $rs->fields["dlvr_resp"] . "♪" . $tel_num1 . "♪" . $certi_yn . "♪" . 
            $gene_rs->fields["resp_deparcode"] . "♪" . $gene_rs->fields["tel_mng"] . "♪" . 
            $gene_rs->fields["ibm_mng"] . "♪" . $gene_rs->fields["mac_mng"] . "♪" . 
            $busi_rs->fields["resp_deparcode"] . "♪" . $busi_rs->fields["tel_mng"] . "♪" . 
            $busi_rs->fields["ibm_mng"] . "♪" . $busi_rs->fields["mac_mng"] . "♪" . 
            $sell_site;
$conn->close();
?>
