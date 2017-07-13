<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');


$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$basicDAO = new BasicMngCommonDAO();

//검색 조건에 들어갈 이름
$name = $fb->form("name");
//테이블명
$table = $fb->form("table");
//load 하려는 depth
$depth = $fb->form("depth");

$param = array();
$param["name"] = $name;
$param["table"] = $table;
$param["depth"] = $depth;

$result = $basicDAO->selectPrdcDepthName($conn, $param);

$arr = [];
$arr["flag"] = "Y";
$arr["def"] = "전체";
$arr["dvs"] = $depth;
$arr["val"] = $depth;

$buff = makeSelectOptionHtml($result, $arr);

echo $buff;
$conn->close();
?>
