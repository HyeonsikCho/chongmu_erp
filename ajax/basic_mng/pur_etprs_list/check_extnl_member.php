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
$param["table"] = "extnl_etprs_member";
$param["col"] = "extnl_etprs_member_seqno";
$param["where"]["id"] = $fb->form("mem_id");

//결과값을 가져옴
$result = $purDAO->selectData($conn, $param);
$cnt = $result->recordCount();

if ($cnt == 0) {

    echo "1";
    

} else {

    echo "2";

}

$conn->close();
?>
