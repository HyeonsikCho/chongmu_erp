<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/order_status.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderCommonMngDAO.php");

$connectionpool = new connectionpool();
$conn = $connectionpool->getpooledconnection();

$fb = new formbean();
$dao = new ordercommonmngdao();
$util = new erpcommonutil();

$cate_sort_code    = $fb->form("cate_sort_code");
$opt               = $fb->form("opt");
$papercode         = $fb->form("papercode");
$printcode         = $fb->form("printcode");
$stancode         = $fb->form("stancode");
//$conn->debug=1;
$html =  $dao->ChongSelectOptList($conn, $cate_sort_code,$opt,$papercode,$printcode,$stancode);

$conn->Close();
echo $html;
exit;

?>
