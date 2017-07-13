<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common/sess_common.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/CommonDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/PasswordEncrypt.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$dao = new CommonDAO();
$fb = new FormBean();

$id = $fb->form("id");
$pw = $fb->form("pw");
$rs = $dao->selectEmpl($conn, $id);

$pw_hash = $rs->fields["passwd"];

if (password_verify($pw, $pw_hash) === false) {
    echo "false";
    exit;
}

$empl_seqno  = $rs->fields["empl_seqno"];
$name        = $rs->fields["name"];
$login_date  = date("Y-m-d H:i:s",time());
$cpn_admin_seqno = $rs->fields["cpn_admin_seqno"];

$fb->addSession("id"        , $id);
$fb->addSession("name"      , $name);
$fb->addSession("login_date", $login_date);
$fb->addSession("empl_seqno", $empl_seqno);
$fb->addSession("sell_site" , $cpn_admin_seqno);

echo "true";
?>
