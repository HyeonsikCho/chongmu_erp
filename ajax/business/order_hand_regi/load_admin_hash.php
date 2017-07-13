<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/common_info.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/PasswordEncrypt.php");

echo password_hash(ADMIN_FLAG[0], PASSWORD_DEFAULT);
?>
