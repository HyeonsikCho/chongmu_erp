<?
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/common/CommonDAO.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");

$fb = new FormBean();
$commonDAO = new CommonDAO();

$func = "hideRegiPopup";
$func2 = "popZipEnterCheck";
$func3 = "searchZipStr";

if ($fb->form("type") == 1) {
    $func = "hidePopPopup";
    $func2 = "popPopZipEnterCheck";
    $func3 = "popSearchZipStr";
}

$html = makeZipPopupHtml($func, $func2, $func3);

echo $html;

?>
