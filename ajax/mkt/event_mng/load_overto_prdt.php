<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/mkt/mkt_mng/EventMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$eventDAO = new EventMngDAO();

//골라담기 상품 리스트 그리기
$param["overto_seqno"] = $fb->form("overto_seqno");
$result = $eventDAO->selectOvertoDetailList($conn, $param);
$list = makeOvertoDetailList($result);

if (trim($list) == "") {

    $list = "<tr><td colspan='6'>검색된 결과가 없습니다.</td></tr>";

}

echo $list;

$conn->close();
?>
