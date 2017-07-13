<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/common_info.php");

$fb = new FormBean();

//입력 구분
$dvs = $fb->form("dvs");

$dvs_html = "";
for($i = 0; $i < count(INSERT_DVS[$dvs]); $i++) {

   $dvs_html .=  "\n  <option value=\"" . INSERT_DVS[$dvs][$i] . "\">" . INSERT_DVS[$dvs][$i] . "</option>";

}

echo $dvs_html;
?>
