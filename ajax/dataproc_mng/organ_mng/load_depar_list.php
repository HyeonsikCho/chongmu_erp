<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();
$organDAO = new OrganMngDAO();

$param = array();
//부서 리스트 생성
$result = $organDAO->selectDeparAdminList($conn, $param);
$depar_list = makeDeparList($result);

if ($depar_list == "") {

    "<tr><td colspan='5'>\"검색된 결과가 없습니다.\"</td></tr>";
}
echo $depar_list;

$conn->close();
?>
