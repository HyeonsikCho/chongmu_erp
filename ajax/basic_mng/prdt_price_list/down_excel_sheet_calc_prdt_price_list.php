<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/ExcelLib.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/PrdtPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new PrdtPriceListDAO();
$util = new ErpCommonUtil();
$excelLib = new ExcelLib();

$cate_sortcode = $fb->form("cate_sortcode");
$sell_site = $fb->form("sell_site");

$param = array();

//* 판매채널에 해당하는 합판/계산형 가격테이블 검색
$table_name = $dao->selectPriceTableName($conn, '1', $sell_site);

//* 카테고리에 해당하는 수량단위 검색
$amt_unit = $dao->selectCateAmtUnit($conn, $cate_sortcode);

//* 종이 정보가 넘어온 것이 있을 경우 종이 맵핑코드 검색
$info_fld_arr = array(
    "name",
    "dvs",
    "color",
    "basisweight"
);

$param["cate_sortcode"] = $cate_sortcode;
if (empty($fb->form("paper_name")) === false) {
    // 종이 정보가 있을경우 파라미터 추가
    $param["name"]          = $fb->form("paper_name");
    $param["dvs"]           = $fb->form("paper_dvs");
    $param["color"]         = $fb->form("paper_color");
    $param["basisweight"]   = $fb->form("paper_basisweight");
}
$paper_rs = $dao->selectCatePaperInfo($conn, "SEQ", $param);

$paper_total_arr = $util->makeTotalInfoArr($paper_rs, $info_fld_arr);
$paper_mpcode_arr = $paper_total_arr["mpcode"];
$paper_info_arr = $paper_total_arr["info"];

unset($paper_rs);
unset($paper_total_arr);
unset($param);
unset($info_fld_arr);

//* 인쇄도수가 선택된 경우 인쇄방식 맵핑코드 검색
$bef_print_tmpt = $fb->form("bef_print_tmpt");
if (empty($bef_print_tmpt) === false) {
    $param["cate_sortcode"] = $cate_sortcode;
    $param["tmpt"]          = $bef_print_tmpt;

    $print_rs = $dao->selectCatePrintMpcode($conn, $param);

    $mpcode_arr = $util->rs2arr($print_rs, "mpcode");
    $mpcode_arr = $dao->parameterArrayEscape($conn, $mpcode_arr);
    $print_mpcode = $util->arr2delimStr($mpcode_arr);

    unset($mpcode_arr);
    unset($print_rs);
    unset($param);

    $param["bef_print_mpcode"] = $print_mpcode;
}

$param["cate_sortcode"] = $cate_sortcode;
$param["stan_mpcode"] = $fb->form("output_size");

// 종이 맵핑코드 수 만큼 가격 검색
$paper_mpcode_arr_count = count($paper_mpcode_arr);

// 정보를 저장할 배열들
$amt_arr   = array(); // 수량 배열
$title_arr = array(); // 제목 배열
$price_arr = array(); // 가격 배열

// 각 정보항목 폼
// 카테고리명|종이정보|사이즈|인쇄도수|기준단위
$title_form = "%s|%s!%s!%s!%s|%s|%s|%s";
// 종이금액|인쇄금액|출력금액|총합금액
$price_form = "%s|%s|%s|%s";

//* 선택한 카테고리에 해당하는 사이즈, 인쇄 맵핑코드, 이름을 가져온다
//* 관련정보는 있되 가격이 없는 부분이 있는 것을 생성하기 위함
$info_rs = $dao->selectCatePriceInfoListExcel($conn, $param);

// 관련정보가 존재하지 않는경우 종료
if ($info_rs->EOF === true) {
    $conn->Close();
    echo "NOT_INFO";
    exit;
}

while ($info_rs && !$info_rs->EOF) {
    $cate_name    = $info_rs->fields["cate_name"];
    $stan_name    = $info_rs->fields["stan_name"];
    $print_tmpt   = $info_rs->fields["print_tmpt"];

    $stan_mpcode  = $info_rs->fields["stan_mpcode"];
    $print_mpcode = $info_rs->fields["print_mpcode"];

    //* 검색한 맵핑코드와 종이 맵핑코드를 결함해서 가격 검색
    for ($i = 0; $i < $paper_mpcode_arr_count; $i++) {
        $paper_mpcode = $paper_mpcode_arr[$i];
        $paper_info = $paper_info_arr[$i];

		$sheet_name = $paper_info["name"];

        $title = sprintf($title_form, $cate_name
                                    , $paper_info["name"]
                                    , $paper_info["dvs"]
                                    , $paper_info["color"]
                                    , $paper_info["basisweight"]
                                    , $stan_name
                                    , $print_tmpt
                                    , $amt_unit);

        $title_arr[$sheet_name][$title] = $title;
		
        $param["paper_mpcode"]     = $paper_mpcode;
        $param["stan_mpcode"]      = $stan_mpcode;
        $param["bef_print_mpcode"] = $print_mpcode;
		
        $price_rs = $dao->selectCateCalcPriceListExcel($conn,
                                                       $table_name,
                                                       $param);

        if ($price_rs->EOF === true) {
            $amt_arr[''] = '';
            $price_arr[$title][''] = "|||";
        }

        while ($price_rs && !$price_rs->EOF) {
            $amt          = $price_rs->fields["amt"];
            $paper_price  = $price_rs->fields["paper_price"];
            $print_price  = $price_rs->fields["print_price"];
            $output_price = $price_rs->fields["output_price"];
            $sum_price    = $price_rs->fields["sum_price"];

            $price = sprintf($price_form, $paper_price
                                        , $print_price
                                        , $output_price
                                        , $sum_price);

            $amt_arr[$amt] = $amt;
            $price_arr[$sheet_name][$title][$amt] = $price;

            $price_rs->MoveNext();
        }
    }

    $info_rs->MoveNext();
}

//* 생성된 정보배열 인덱스 정수로 바꿔서 정렬
// 수량배열 정렬
$amt_arr = $util->sortDvsArr($amt_arr);

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

$info_dvs_arr = array(1 => "카테고리",
                      2 => "종이",
                      3 => "사이즈",
                      4 => "인쇄도수",
                      5 => "기준단위",
                      6 => "수량");

$price_dvs_arr = array(0 => "종이가격",
                       1 => "인쇄가격",
                       2 => "출력가격",
                       3 => "판매가격");

$excelLib->initExcelFileWriteInfo((count($info_dvs_arr) - 1),
                                  count($price_dvs_arr),
                                  1);

foreach ($title_arr_sort as $sheet_name => $title_arr) {
    $excelLib->makePriceExcelSheet($sheet_name,
                                   $info_dvs_arr,
                                   $title_arr,
                                   $price_dvs_arr,
                                   $amt_arr,
                                   $price_arr_sort[$sheet_name],
                                   false);
}

$file_path = $excelLib->createExcelFile("prdt_price_list");

if (is_file($file_path)) {
    echo "prdt_price_list";
} else {
    echo "FALSE";
}

$conn->Close();
exit;

NOT_PRICE:
    $conn->Close();
    echo "NOT_PRICE";
    exit;
?>
