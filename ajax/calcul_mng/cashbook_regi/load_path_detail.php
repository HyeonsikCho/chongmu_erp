<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/calcul_mng/settle/IncomeDataDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$incomeDAO = new IncomeDataDAO();

//입출금경로 상세
$param = array();
$param["path"] = $fb->form("depo_path");
$result = $incomeDAO->selectPathDetail($conn, $param);

//셀렉트 옵션 셋팅
$param = array();
$param["flag"] = "Y";
$param["def"] = "전체";
$param["def_val"] = "";
$param["val"] = "name";
$param["dvs"] = "name";
$detail_html = makeSelectOptionHtml($result, $param);

if ($detail_html == "") {

    $detail_html = "\n  <option value=\"\">상세없음</option>";

}

echo $detail_html;
$conn->close();
?>
