<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/BasicMngCommonDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();

$basicDAO = new BasicMngCommonDAO();

//제조사
$manu_seqno = $fb->form("manu_seqno");
//타입
$type = $fb->form("type");
//검색조건(제조사 일련번호 or 검색어)
$search = $fb->form("search_str");

$param = array();
$param["manu_seqno"] = $manu_seqno;
$param["search"] = $search;

$result = $basicDAO->selectPrdcBrand($conn, $param);

if ($type == "Y") {

    $arr = [];
    $arr["flag"] = "Y";
    $arr["def"] = "선택";
    $arr["def_val"] = "";
    $arr["dvs"] = "name";
    $arr["val"] = "extnl_brand_seqno";

    $buff = makeSelectOptionHtml($result, $arr);

} else {

    $arr = [];
    $arr["col"] = "name";
    $arr["val"] = "extnl_brand_seqno";
    $arr["type"] = "brand";

    $buff = makeSearchList($result, $arr);
}

echo $buff;
$conn->close();
?>
