<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/define/value_define.php');

$fb = new FormBean();

$type_46  = $fb->form("46");
$type_guk = $fb->form("GUK");

$ret = "<option value=\"\">전체</option>";

$option_form = "<option value=\"%s*%s\">%s*%s</option>";

if ($type_46 === "true") {
    $ret .= sprintf($option_form, ValueDefine::TYPE_46_SIZE[1]["WID"]
                                , ValueDefine::TYPE_46_SIZE[1]["VERT"]
                                , ValueDefine::TYPE_46_SIZE[1]["WID"]
                                , ValueDefine::TYPE_46_SIZE[1]["VERT"]);
}
if ($type_guk === "true") {
    $ret .= sprintf($option_form, ValueDefine::TYPE_GUK_SIZE[1]["WID"]
                                , ValueDefine::TYPE_GUK_SIZE[1]["VERT"]
                                , ValueDefine::TYPE_GUK_SIZE[1]["WID"]
                                , ValueDefine::TYPE_GUK_SIZE[1]["VERT"]);
}

echo $ret;
?>
