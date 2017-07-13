<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsListDAO();

//매입업체 테이블
$param = array();
//제조사
//매입 품목
$param["pur_prdt"] = $fb->form("pur_prdt");
//매입 업체 일련번호
$param["etprs_seqno"] = $fb->form("etprs_seqno");
//매입 브랜드 일련번호
$param["brand_seqno"] = $fb->form("brand_seqno");

//결과값을 가져옴
$result = $purDAO->selectExtnlEtprs($conn, $param);
$list = makeExtnlEtprsList($result);

echo $list;

$conn->close();
?>
