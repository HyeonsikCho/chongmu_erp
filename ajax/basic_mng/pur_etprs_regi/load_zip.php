<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/basic_mng/pur_etprs_mng/PurEtprsRegiDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$purDAO = new PurEtprsRegiDAO();

//검색어
$val = $fb->form("val");
//우편번호 검색 타입 ex)지번,도로명
$type = $fb->form("type");
//검색 위치
$click_func = $fb->form("func");

$param = array();
$param["val"] = $val;
$param["type"] = $type;
$param["area"] = $fb->form("area");

//지번 검색일때
if ($type == "N") {

    $result = $purDAO->selectJibunZip($conn, $param);
    $buff = makeSearchAddrList($result, $type, $click_func);

//도로명 검색일때
} else if ($type == "Y") {

    $result = $purDAO->selectDoroZip($conn, $param);
    $buff = makeSearchAddrList($result, $type, $click_func);

}

echo $buff;
$conn->close();
?>
