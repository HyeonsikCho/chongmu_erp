<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/PointMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$pointDAO = new PointMngDAO();

$conn->StartTrans();

//포인트 저장
$param = array();
$param["table"] = "point_policy";
$param["col"]["member_join_point"] = $fb->form("join_point");
$param["col"]["prdt_order_give_rate"] = $fb->form("order_rate");
$param["col"]["point_policy_seqno"] = "1";

$result = $pointDAO->replaceData($conn, $param);

if ($result) {
    
    echo "1";

} else {

    echo "2";
}

$conn->CompleteTrans();
$conn->close();
?>
