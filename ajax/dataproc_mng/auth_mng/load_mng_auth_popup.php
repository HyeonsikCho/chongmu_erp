<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();


$fb = new FormBean();
$organDAO = new OrganMngDAO();

//직원 일련번호
$empl_seqno = $fb->form("empl_seq");

$param = array();
$param["table"] = "auth_admin_page";
$param["col"] = "page_url, auth_yn";
$param["where"]["empl_seqno"] = $empl_seqno;

$result = $organDAO->selectData($conn, $param);

$param = array();
while ($result && !$result->EOF) {

    $page_url = $result->fields["page_url"];
    $page = explode("/", $page_url);
    $url = explode(".", $page[2]);
    $auth_yn = $result->fields["auth_yn"];

    //권한이 있으면
    if ($auth_yn == "Y") {

        $param[$url[0] . "_y"] = "checked=\"checked\"";

    } else {

        $param[$url[0] . "_n"] = "checked=\"checked\"";

    }

    $result->moveNext();
}
$param["empl_seqno"] = $empl_seqno;

$html = getMngAuthHtml($param);

echo $html;
$conn->close();
?>
