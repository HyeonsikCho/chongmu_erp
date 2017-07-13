<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();

$param = array();
$param["area"] = $fb->form("area");
$param["gugun"] = $fb->form("gugun");
$param["doro_yn"] = $fb->form("doro_yn");

//도로명/동
$result = $dlvrDAO->selectDoroDong($conn, $param);

$html = makeDoroDongOptionHtml($result, $fb->form("doro_yn"));

echo $html;

$conn->close();
?>
