<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/calcul_mng/virt_ba_mng/VirtBaListDAO.php");
$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$virtDAO = new VirtBaListDAO();

//검색어
$search = $fb->form("search_str");
//판매채널
$sell_site = $fb->form("sell_site");
//검색 구분
$dvs = $fb->form("search_dvs");

$param = array();
$param["search"] = $search;
$param["cpn_admin_seqno"] = $sell_site;

if ($dvs == "1") {

    $func = "ba";
    $result = $virtDAO->selectBaNumList($conn, $param);
    
} else if ($dvs == "2"){

    $func = "member";
    $result = $virtDAO->selectMemberSeqList($conn, $param);
    
} else {

    $func = "editMember";
    $result = $virtDAO->selectMemberSeqList($conn, $param);

}

$buff = makeSearchCndList($result, $func);

echo $buff;
$conn->close();
?>
