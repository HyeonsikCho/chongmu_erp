<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/order_status.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");

$fb = new FormBean();

$val = $fb->form("val");

$proc_arr = OrderStatus::STATUS_PROC[$val];

$option_html = "<option value=\"%s\">%s</option>";
$proc_html = sprintf($option_html, "", "전체");
foreach ($proc_arr as $status => $code) {
    $proc_html .= sprintf($option_html, $code, $status);
}

echo $proc_html;
?>
