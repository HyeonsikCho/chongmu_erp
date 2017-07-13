<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/member/member_mng/DlvrListDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dlvrDAO = new DlvrListDAO();

$param = array();
//sort 할 컬럼명
$param["sort"] = $fb->form("sort_col");
//sort type (ex:DESC, ASC)
$param["sort_type"] = $fb->form("sort_type");

$result = $dlvrDAO->selectDlvrMainList($conn, $param);

$main_list = makeDlvrMainList($result);

echo $main_list;

$conn->close();
?>
