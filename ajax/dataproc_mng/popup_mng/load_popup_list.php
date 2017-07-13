<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$bulletinDAO = new BulletinMngDAO();

//팝업 리스트
$result = $bulletinDAO->selectPopupList($conn, $param);
$popup_list = makePopupList($result);

echo $popup_list;

$conn->close();
?>
