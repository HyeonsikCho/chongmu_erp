<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/common/common.php");

$session = $fb->getSession();

$id = $session["id"];

if (empty($id) === true) {
    $template->reg("header_login_class", "login"); 
    $template->reg("header_login", getLogoutHtml()); 
    $template->reg("side_menu", ""); 
} else {
    $template->reg("header_login_class", "memberInfo"); 
    $template->reg("header_login", getLoginHtml($session)); 
    $template->reg("side_menu", getAsideHtml($session)); 
}
?>
