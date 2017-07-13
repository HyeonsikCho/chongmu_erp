<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ExcelLib.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/CalculPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new CalculPriceListDAO();
$util = new ErpCommonUtil();
$excelLib = new ExcelLib();

$sell_site = $fb->form("sell_site");
$paper_search = $fb->form("paper_search");
$paper_affil  = $fb->form("paper_affil");
$paper_affil  = $util->getUseAffil($paper_affil);
$paper_size   = $fb->form("paper_size");

$param = array();

//* 종이 검색어로 상품 종이 맵핑코드 검색
$info_fld_arr = array(
    "sort",
    "name",
    "dvs",
    "color",
    "basisweight",
    "affil",
    "size",
    "crtr_unit"
);

$param["paper_search"] = $paper_search;
$param["paper_affil"]  = $paper_affil;
$param["paper_size"]   = $paper_size;

$paper_rs = $dao->selectPrdtPaperMpcode($conn, $param, true);
$paper_total_arr = $util->makeTotalInfoArr($paper_rs, $info_fld_arr);
$mpcode_arr = $paper_total_arr["mpcode"];
$info_arr   = $paper_total_arr["info"];

unset($paper_rs);
unset($paper_total_arr);
unset($param);
unset($info_fld_arr);

//* 맵핑코드로 가격검색
$mpcode_arr_count = count($mpcode_arr);

if ($mpcode_arr_count === 0) {
    $conn->Close();
    echo "NOT_INFO";
    exit;
}

// 정보를 저장할 배열들
$basisweight_arr = array(); // 평량 배열
$title_arr = array(); // 제목 배열
$price_arr = array(); // 가격 배열

// 각 정보항목 폼
// 판매채널|종이분류|종이정보|계열|사이즈|기준단위
$title_form = "%s|%s|%s!%s!%s|%s|%s|%s";
// 기본가격|요율|적용금액|신규가격
$price_form = "%s|%s|%s|%s";

$param["sell_site"] = $sell_site;

// 판매채널 seqno로 판매채널명 검색
$site_name = $dao->selectSellSiteName($conn, array("seqno" => $sell_site));

for ($i = 0; $i < $mpcode_arr_count; $i++) {
    $mpcode = $mpcode_arr[$i];
    $info   = $info_arr[$i];

    $sheet_name = $info["name"];

    $basisweight = $info["basisweight"];

    $title = sprintf($title_form, $site_name
                                , $info["sort"]
                                , $info["name"]
                                , $info["dvs"]
                                , $info["color"]
                                , $info["affil"]
                                , $info["size"]
                                , $info["crtr_unit"]);

	$title_arr[$sheet_name][$title] = $title;

    $param["mpcode"] = $mpcode;

    $price_rs = $dao->selectPrdtPaperPriceExcel($conn, $param);

    if ($price_rs->EOF === true) {
        $basisweight_arr[''] = '';
        $price_arr[$sheet_name][$title][''] = "|||";
    }

    $basisweight_arr[$basisweight] = $basisweight;

    while ($price_rs && !$price_rs->EOF) {
        $basic_price     = $price_rs->fields["basic_price"];
        $sell_rate       = $price_rs->fields["sell_rate"];
        $sell_aplc_price = $price_rs->fields["sell_aplc_price"];
        $sell_price      = $price_rs->fields["sell_price"];

        $price = sprintf($price_form, $basic_price
                                    , $sell_rate
                                    , $sell_aplc_price
                                    , $sell_price);

        $price_arr[$sheet_name][$title][$basisweight] = $price;

        $price_rs->MoveNext();
    }
}

//* 생성된 정보배열 인덱스 정수로 바꿔서 정렬
// 평량배열 정렬
$basisweight_arr = $util->sortDvsArr($basisweight_arr);

// 제목배열, 가격배열 정렬
$title_arr_sort = array();
$price_arr_sort = array();

foreach ($title_arr as $sheet_name => $title_arr_temp) {
    $price_arr_temp = $price_arr[$sheet_name];

	$i = 0;
    foreach ($title_arr_temp as $key => $val) {
        $title_arr_sort[$sheet_name][$i] = $val;
        $price_arr_sort[$sheet_name][$i++] = $price_arr_temp[$key];
    }
}

unset($title_arr);
unset($price_arr);

$info_dvs_arr = array(1 => "판매채널",
                      2 => "종이분류",
                      3 => "종이",
                      4 => "계열",
                      5 => "사이즈",
                      6 => "기준단위",
                      7 => "평량");

$price_dvs_arr = array(0 => "판매가격",
                       1 => "기본금액",
                       2 => "요율",
                       3 => "적용가격");

$excelLib->initExcelFileWriteInfo((count($info_dvs_arr) - 1),
                                  count($price_dvs_arr),
                                  1);

foreach ($title_arr_sort as $sheet_name => $title_arr) {
    $excelLib->makePriceExcelSheet($sheet_name,
                                   $info_dvs_arr,
                                   $title_arr,
                                   $price_dvs_arr,
                                   $basisweight_arr,
                                   $price_arr_sort[$sheet_name]);
}

$file_path = $excelLib->createExcelFile("paper_sell_price_list");

if (is_file($file_path)) {
    echo "paper_sell_price_list";
} else {
    echo "FALSE";
}

$conn->Close();
?>
