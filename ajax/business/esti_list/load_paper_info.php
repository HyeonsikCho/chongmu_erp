<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/common/BasicMngCommonDAO.php");

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new BasicMngCommonDAO();
$commonDAO = $dao;

$dvs = $fb->form("dvs");

$param = array();
$param["name"] = $fb->form("paper_name");
$param["dvs"] = $fb->form("paper_dvs");
$param["color"] = $fb->form("paper_color");

//종이명
if ($dvs === "NAME") {

    $param = array();
    $rs = $dao->selectPaperInfo($conn, "DVS", $param);

    echo makeOptionHtml($rs, "name", "name", "종이(전체)")
         . "♪" . "<option value=\"\">구분(전체)</option>"
         . "♪" . "<option value=\"\">색상(전체)</option>"
         . "♪" . "<option value=\"\">평량(전체)</option>";

//종이구분
} else if ($dvs === "DVS") {

    if ($fb->form("paper_name") == "") {
       
        echo "<option value=\"\">구분(전체)</option>"
        . "♪" . "<option value=\"\">색상(전체)</option>"
        . "♪" . "<option value=\"\">평량(전체)</option>";

    } else {
        $rs = $dao->selectPaperInfo($conn, "DVS", $param);
        $dvs_html = makeOptionHtml($rs, "dvs", "dvs", "구분(전체)");

        $rs = $dao->selectPaperInfo($conn, "COLOR", $param);
        $color_html = makeOptionHtml($rs, "color", "color", "색상(전체)");

        $rs = $dao->selectPaperInfo($conn, "BASISWEIGHT", $param);
        $basisweight_html = makeOptionHtml($rs, "basisweight", "basisweight", "평량(전체)");

        echo $dvs_html . "♪" . $color_html . "♪" . $basisweight_html;
    }

//종이 색상
} else if ($dvs === "COLOR") {
 
    $rs = $dao->selectPaperInfo($conn, "COLOR", $param);
    $color_html = makeOptionHtml($rs, "color", "color", "색상(전체)");
 
    $rs = $dao->selectPaperInfo($conn, "BASISWEIGHT", $param);
    $basisweight_html = makeOptionHtml($rs, "basisweight", "basisweight", "평량(전체)");

    echo $color_html . "♪" . $basisweight_html;

//종이 평량
} else if ($dvs === "BASISWEIGHT") {
 
    $rs = $dao->selectPaperInfo($conn, "BASISWEIGHT", $param);
    $basisweight_html = makeOptionHtml($rs, "basisweight", "basisweight", "평량(전체)");

    echo $basisweight_html;
}

$conn->Close();
?>
