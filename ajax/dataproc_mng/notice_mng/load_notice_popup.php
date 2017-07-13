<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/bulletin_mng/BulletinMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$bulletinDAO = new BulletinMngDAO();

$cont = "";
//공지사항 일련번호
$notice_seqno = $fb->form("notice_seq");

//공지사항 수정일때
if ($notice_seqno) {

    //공지사항
    $param = array();
    $param["table"] = "board_notice";
    $param["col"] = "title, content, dvs";
    $param["where"]["seq_no"] = $notice_seqno;
    $result = $bulletinDAO->selectData($conn, $param);
    //공지사항 파일
    $f_param = array();
    $f_param["table"] = "board_notice_file";
    $f_param["col"] = "seq_no, org_file_name";
    $f_param["where"]["notice_seq_no"] = $notice_seqno;
    $f_result = $bulletinDAO->selectData($conn, $f_param);

    if ($f_result->recordCount() > 0) {
        $file_html = getFileHtml($f_result);
    }

    //파라미터 셋팅
    $param = array();
    $param["title"] = $result->fields["title"];
    $param["seq_no"] = $notice_seqno;
    $param["file_html"] = $file_html;
	$param["dvs"] = $result->fields["dvs"];
    $cont = $result->fields["content"];

//공지사항 등록일때
} else {

    //파라미터 셋팅
    $param = array();
    $param["del_btn"] = "style=\"display:none\"";

}

echo getNoticeSetHtml($param) . "♪" . $cont;
$conn->close();
?>
