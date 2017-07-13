<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common/sess_common.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/PasswordEncrypt.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$commonDAO = new CommonDAO();
$fb = new FormBean();
$check=1;

$param = array();
$param["table"] = "empl";
$param["col"] = "passwd";
$param["where"]["empl_seqno"] = $_SESSION["empl_seqno"];
$result = $commonDAO->selectData($conn, $param);
if (!$result) {

    $check = 0;
}

$pw_hash = $result->fields["passwd"];

//이전 비밀번호와 비교 후 맞을때
if (password_verify($fb->form("pw"), $pw_hash) === true) {

    $new_pw = $fb->form("new_pw");
    $new_pw_verify = $fb->form("new_pw_verify");

    //새로운 비밀번호와 비밀번호 확인이 같을때
    if ($new_pw == $new_pw_verify) {

        $param = array();
        $param["table"] = "empl";
        $param["col"]["passwd"] = crypt($new_pw);
        $param["prk"] = "empl_seqno";
        $param["prkVal"] = $_SESSION["empl_seqno"];

        $result = $commonDAO->updateData($conn, $param);

        //비밀번호 변경에 실패했을때
        if (!$result) {

            $check = 0;
        }

    //새로운 비밀번호와 비밀번호 확인이 다를때
    } else {

        $check = 3;
    }

//이전 비밀번호와 맞지 않을때
} else {

    $check = 2;

}

echo $check;
?>
