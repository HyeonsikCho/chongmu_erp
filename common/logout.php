<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
$fb = new FormBean();
$fb->removeAllSession();

header("Location: /login.html");
?>
