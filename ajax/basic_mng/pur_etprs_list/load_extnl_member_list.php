<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsListDAO();

$member_list = "";
$param = array();
//매입업체 일련번호
$param["table"] = "extnl_etprs_member";
$param["col"] = "mng, extnl_etprs_seqno, id, access_code, tel_num,
                 cell_num, mail, resp_task, extnl_etprs_member_seqno";
$param["where"]["extnl_etprs_seqno"] = $fb->form("etprs_seqno");

//매입업체 회원 결과리스트를 가져옴
$result = $purDAO->selectData($conn, $param);
$member_list = makeExtnlMemberList($result);

echo $member_list;

?>
