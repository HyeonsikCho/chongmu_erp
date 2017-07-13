<?
/**
 * @file excel_download_price_regi_modi.php
 *
 * @brief 엑셀 다운로드를 처리
 */

include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ConnectionPool.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ErpCommonUtil.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/define/excel_define.php');

// 세션체크 필요함

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$util = new ErpCommonUtil();

$name = $_GET["name"];
$mono_yn = $_GET["mono_yn"];
$sell_site = $_GET["sell_site"];

if (empty($sell_site) === false) {
    // 판매채널 검색이 필요한 경우에만

    $sell_site = $conn->qstr($sell_site, get_magic_quotes_gpc());

    // 판매채널명 검색
    $query = "SELECT sell_site FROM cpn_admin WHERE cpn_admin_seqno = %s";
    $query = sprintf($query, $sell_site);

    $rs = $conn->Execute($query);

    if ($rs->EOF) {
        echo "<script>alert('존재하지않는 판매채널입니다.');</script>";
        exit;
    }

    $sell_site = $rs->fields["sell_site"];
}

$down_file_name = NULL;

if ($name === "prdt_price_list") {
    $mono_yn = ($mono_yn === "0") ? "확정형" : "계산형";
    $down_file_name = $sell_site . "_판매가격_" . $mono_yn . ".xlsx"; 
} else if ($name === "aft_sell_price_list") {
    $down_file_name = "상품_후공정_판매가격.xlsx"; 
} else if ($name === "opt_sell_price_list") {
    $down_file_name = "상품_옵션_판매가격.xlsx"; 
} else if ($name === "paper_sell_price_list") {
    $down_file_name = "상품_종이_판매가격.xlsx"; 
} else if ($name === "output_sell_price_list") {
    $down_file_name = "상품_출력_판매가격.xlsx"; 
} else if ($name === "print_sell_price_list") {
    $down_file_name = "상품_인쇄_판매가격.xlsx"; 
} else if ($name === "paper_pur_price_list") {
    $down_file_name = "종이_매입가격.xlsx"; 
} else if ($name === "output_pur_price_list") {
    $down_file_name = "출력_매입가격.xlsx"; 
} else if ($name === "print_pur_price_list") {
    $down_file_name = "인쇄_매입가격.xlsx"; 
} else if ($name === "after_pur_price_list") {
    $down_file_name = "후공정_매입가격.xlsx"; 
} else if ($name === "opt_pur_price_list") {
    $down_file_name = "옵션_매입가격.xlsx"; 
}

$file_path = DOWNLOAD_PATH . '/' . $name . ".xlsx";


if (!is_file($file_path)) {
    echo "<script>alert('가격 엑셀이 존재하지 않습니다.');</script>";
    exit;
}

$file_size = filesize($file_path);
if ($util->isIe()) {
    $down_file_name = $util->utf2euc($down_file_name);
}

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$down_file_name\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $file_size");

ob_clean();
flush();
readfile($file_path);
?>
