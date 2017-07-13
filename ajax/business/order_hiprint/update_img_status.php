<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/FileDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/common_config.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new FileDAO();

$param = array();
$param['save_file_name'] = $fb->form("save_file_name");
$param['prd_detail_no'] = $fb->form("prd_detail_no");


$rs1 = $dao->selectOrderImgPath($conn, $param);
$param['file_path'] = ORDER_USERUPLOAD_FILE . "/" .date('Y') . date('m'). date('d').  "/";
$oriFile = $_SERVER["DOCUMENT_ROOT"] . "/" . $rs1->fields['file_path'] . $rs1->fields['save_file_name'];
$destFile = $_SERVER["DOCUMENT_ROOT"] . "/" . $param['file_path'] . $param['save_file_name'];


rename($oriFile, $destFile);

$rs2 = $dao->updateOrderImg($conn, $param);

if($rs2) {
    echo 1;
} else {
    echo 0;
}

?>
