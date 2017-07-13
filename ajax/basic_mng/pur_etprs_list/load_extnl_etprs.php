<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new PurEtprsListDAO();

//매입업체 가져오기
$param = array();
$param["pur_prdt"] = $fb->form("val");

$rs = $dao->selectPurManu($conn, $param);
$html = makeOptionHtml($rs, "extnl_etprs_seqno", "manu_name", "업체(전체)");

echo $html;
$conn->close();
?>
