<?
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");

$fb = new FormBean();
$ss = $fb->getSession();

$_SESSION["sell_site"] = "1";
?>
