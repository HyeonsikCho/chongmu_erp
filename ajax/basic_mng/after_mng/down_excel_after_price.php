<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ExcelLib.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdc_prdt_mng/AfterMngDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new AfterMngDAO();
$util = new ErpCommonUtil();
$excelLib = new ExcelLib();

$name         = $fb->form("name");
$depth1       = $fb->form("depth1");
$depth2       = $fb->form("depth2");
$depth3       = $fb->form("depth3");
$etprs_seqno  = $fb->form("manu_seqno");
$brand_seqno  = $fb->form("brand_seqno");

// 정보를 저장할 배열들
$amt_arr   = array(); // 평량 배열
$title_arr = array(); // 제목 배열
$price_arr = array(); // 가격 배열

// 각 정보항목 폼
// 제조사|브랜드|후공정명|depth1|depth2|depth3|기준단위
$title_form      = "%s|%s|%s|%s|%s|%s|%s";
// 기본가격|요율|적용금액|신규가격
$price_form      = "%s|%s|%s|%s";

$param["name"]        = $name;
$param["depth1"]      = $depth1;
$param["depth2"]      = $depth2;
$param["depth3"]      = $depth3;
$param["brand_seqno"] = $brand_seqno;
$param["etprs_seqno"] = $etprs_seqno;

$price_rs = $dao->selectPrdcAfterPrice($conn, $param);

if ($price_rs->EOF) {
    $conn->Close();
    echo "NOT_INFO";
    exit;
}

while ($price_rs && !$price_rs->EOF) {
    $manu      = $price_rs->fields["manu_name"];
    $brand     = $price_rs->fields["brand_name"];
    $name      = $price_rs->fields["name"];
    $depth1    = $price_rs->fields["depth1"];
    $depth2    = $price_rs->fields["depth2"];
    $depth3    = $price_rs->fields["depth3"];
    $amt       = $price_rs->fields["amt"];
    $crtr_unit = $price_rs->fields["crtr_unit"];

    $basic_price    = $price_rs->fields["basic_price"];
    $pur_rate       = $price_rs->fields["pur_rate"];
    $pur_aplc_price = $price_rs->fields["pur_aplc_price"];
    $pur_price      = $price_rs->fields["pur_price"];

    $title = sprintf($title_form, $manu
                                , $brand
                                , $name
                                , $depth1
                                , $depth2
                                , $depth3
                                , $crtr_unit);

    $price = sprintf($price_form, $basic_price
                                , $pur_rate
                                , $pur_aplc_price
                                , $pur_price);

    $amt_arr[$amt] = $amt;
    $title_arr[$name][$title] = $title;
    $price_arr[$name][$title][$amt] = $price;

    $price_rs->MoveNext();
}


//* 생성된 정보배열 인덱스 정수로 바꿔서 정렬
// 수량배열 정렬
$amt_arr = $util->sortDvsArr($amt_arr);

// 제목배열, 제목 정보배열, 가격배열 정렬
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

$info_dvs_arr = array(1 => "제조사",
                      2 => "브랜드",
                      3 => "후공정명",
                      4 => "Depth1",
                      5 => "Depth2",
                      6 => "Depth3",
                      7 => "기준단위",
                      8 => "수량");

$price_dvs_arr = array(0 => "매입가격",
                       1 => "기준가격",
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
                                   $amt_arr,
                                   $price_arr_sort[$sheet_name]);
}

$file_path = $excelLib->createExcelFile("after_pur_price_list");

if (is_file($file_path)) {
    echo "after_pur_price_list";
} else {
    echo "FALSE";
}

$conn->Close();
?>

