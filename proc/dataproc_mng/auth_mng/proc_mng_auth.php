<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$conn->StartTrans();

$fb = new FormBean();
$organDAO = new OrganMngDAO();

$check = 1;

//직원 일련번호
$empl_seqno = $fb->form("select_empl_seqno");

foreach($fb->fb as $key=>$val) {

    $param = array();
    $param["table"] = "auth_admin_page";

    if ($key != "select_empl_seqno"){

        $page = explode("-", $key);
        $page_url = "/" . $page[0] . "/" . $page[1] . ".html";
        $auth_yn = $val;

        //권한유무 검사
        $param["col"] = "auth_admin_page_seqno";
        $param["where"]["page_url"] = $page_url;
        $param["where"]["empl_seqno"] = $empl_seqno;

        $result = $organDAO->selectData($conn, $param);
        if (!$result) $check = 0;
        $cnt = $result->recordCount();

        //관리자 권한 셋팅
        $param = array();
        $param["table"] = "auth_admin_page";
        $param["col"]["page_url"] = $page_url;
        $param["col"]["auth_yn"] = $auth_yn;

        //없으면 insert
        if ($cnt == 0) {

            $param["col"]["empl_seqno"] = $empl_seqno;
            $result = $organDAO->insertData($conn, $param);
            if (!$result) $check = 0;

        //있으면 update
        } else {

            $param["prk"] = "auth_admin_page_seqno";
            $param["prkVal"] = $result->fields["auth_admin_page_seqno"];
            $result = $organDAO->updateData($conn, $param);
            if (!$result) $check = 0;


        }
    }
}

echo $check;

$conn->CompleteTrans();
$conn->close();
?>
