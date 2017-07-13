<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$bulletinDAO = new BulletinMngDAO();

//팝업 일련번호
$popup_seqno = $fb->form("popup_seq");

//팝업 설정
$param = array();
$param["popup_seqno"] =  $popup_seqno;
$result = $bulletinDAO->selectPopupList($conn, $param);

//파일
$param["popup_file"] = $result->fields["file_path"] . $result->fields["save_file_name"];

$html = getPopupPreviewHtml($param);

echo $html;

$conn->close();
?>
