<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CommonDAO();

/*@
세션별 판매채널 처리 필요
 */

$param = array();
$param["sell_site"] = $fb->form("sell_site");
$param["depar_code"] = "001";

$rs = $dao->selectDeparInfo($conn, $param);

$arr = [];
$arr["flag"] = "Y";
$arr["def"] = "팀(전체)";
$arr["dvs"] = "depar_name";
$arr["val"] = "depar_code";

//등급 검색
echo makeSelectOptionHtml($rs, $arr);
$conn->close();
?>
