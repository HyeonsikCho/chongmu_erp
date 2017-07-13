<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/common/util/PriceHtmlLib.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/PrdtPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$dao = new PrdtPriceListDAO();
$util = new ErpCommonUtil();
$htmlLib = new PriceHtmlLib();

$cate_sortcode = $fb->form("cate_sortcode");
$sell_site = $fb->form("sell_site");

$param = array();

//* 판매채널에 해당하는 합판형 가격테이블 검색
$table_name = $dao->selectPriceTableName($conn, '0', $sell_site);

//* 카테고리에 해당하는 수량단위 검색
$amt_unit = $dao->selectCateAmtUnit($conn, $cate_sortcode);

//* 종이 정보가 넘어온 것이 있을 경우 종이 맵핑코드 검색
$paper_info_arr = null;
$param["cate_sortcode"] = $cate_sortcode;
if (empty($fb->form("paper_name")) === false) {
    // 종이 정보가 있을경우 파라미터 추가
    $param["name"]          = $fb->form("paper_name");
    $param["dvs"]           = $fb->form("paper_dvs");
    $param["color"]         = $fb->form("paper_color");
    $param["basisweight"]   = $fb->form("paper_basisweight");
}
$paper_rs = $dao->selectCatePaperInfo($conn, "SEQ", $param);

$paper_total_arr = makePaperTotalInfoArr($paper_rs);
$paper_mpcode_arr = $paper_total_arr["mpcode"];
$paper_info_arr   = $paper_total_arr["info"];

unset($paper_rs);
unset($paper_total_arr);
unset($param);

//* 인쇄도수가 선택된 경우 인쇄방식 맵핑코드 검색
if (empty($fb->form("print_tmpt")) === false) {
    $param["cate_sortcode"] = $cate_sortcode;
    $param["tmpt"]          = $fb->form("print_tmpt");

    $print_rs = $dao->selectCatePrintMpcode($conn, $param);

    $mpcode_arr = $util->rs2arr($print_rs, "mpcode");
    $mpcode_arr = $dao->parameterArrayEscape($conn, $mpcode_arr);
    $print_mpcode = $util->arr2delimStr($mpcode_arr);

    unset($mpcode_arr);
    unset($print_rs);
    unset($param);

    $param["print_mpcode"] = $print_mpcode;
}

$param["cate_sortcode"] = $cate_sortcode;
$param["stan_mpcode"] = $fb->form("output_size");

//* 종이 맵핑코드 수 만큼 가격 검색
$paper_mpcode_arr_count = count($paper_mpcode_arr);

if ($paper_mpcode_arr_count === 0) {
    goto NOT_PRICE;
}

// 정보를 저장할 배열들
$amt_arr        = array(); // 수량 배열
$title_arr      = array(); // 제목 배열
$title_info_arr = array(); // 가격수정을 위한 제목 정보 배열
$price_arr      = array(); // 가격 배열

// 각 정보항목 폼
// 카테고리명|종이정보|사이즈|인쇄도수|기준수량
$title_form      = "%s|%s|%s|%s|%s";
// $title에 해당하는 식별값들(분류코드, 맵핑코드 등)
$title_info_form = "%s|%s|%s|%s|-";
// 일련번호|기본가격|요율|적용금액|신규가격
$price_form      = "%s|%s|%s|%s|%s";

for ($i = 0; $i < $paper_mpcode_arr_count; $i++) {
    $paper_mpcode = $paper_mpcode_arr[$i];
    $paper_info   = $paper_info_arr[$i];

    $param["paper_mpcode"] = $paper_mpcode;
	
    $price_info_rs = $dao->selectCatePriceList($conn, $table_name, $param);

    if ($price_info_rs->EOF === true) {
        continue;
    }

    while ($price_info_rs && !$price_info_rs->EOF) {
        $price_seqno = $price_info_rs->fields["price_seqno"];
        $amt         = $price_info_rs->fields["amt"];
        $basic_price = $price_info_rs->fields["basic_price"];
        $rate        = $price_info_rs->fields["rate"];
        $aplc_price  = $price_info_rs->fields["aplc_price"];
        $new_price   = $price_info_rs->fields["new_price"];

        $cate_name = $price_info_rs->fields["cate_name"];

        $print_name = $price_info_rs->fields["print_name"];

        $stan_name = $price_info_rs->fields["stan_name"];

        $title = sprintf($title_form, $cate_name
                                    , $paper_info
                                    , $stan_name
                                    , $print_name
                                    , $amt_unit);

        $title_info = sprintf($title_info_form, $cate_sortcode
                                              , $paper_mpcode
                                              , $stan_name
                                              , $print_name);

        $price = sprintf($price_form, $price_seqno
                                    , $basic_price
                                    , $rate
                                    , $aplc_price
                                    , $new_price);

        $amt_arr[$amt] = $amt;
        $title_arr[$title] = $title;
        $title_info_arr[$title] = $title_info;
        $price_arr[$title][$amt] = $price;

        $price_info_rs->MoveNext();
    }
}

if (count($amt_arr) === 0) {
    goto NOT_PRICE;
}

//* 생성된 정보배열 인덱스 정수로 바꿔서 정렬
// 수량배열 정렬
$amt_arr = $util->sortDvsArr($amt_arr);

// 제목배열, 제목 정보배열, 가격배열 정렬
$title_arr_sort      = array();
$title_info_arr_sort = array();
$price_arr_sort      = array();

$i = 0;
foreach ($title_arr as $key => $val) {
    $title          = $val;
    $title_info     = $title_info_arr[$key];
    $price_arr_temp = $price_arr[$key];

    $title_arr_sort[$i]      = $title; // 종이정보
    $title_info_arr_sort[$i] = $title_info; // 종이정보 식별값
    $price_arr_sort[$i++]    = $price_arr_temp; // 가격정보
}

unset($title_arr);
unset($title_info_arr);
unset($price_arr);

$title_id_arr = array(
    0 => "cate_name",
    1 => "paper_info",
    2 => "output_size",
    3 => "print_tmpt",
    4 => ""
);

$htmlLib->initInfo(count($title_id_arr), 1, "수량");

$thead = $htmlLib->getPriceTheadHtml($title_arr_sort,
                                     $title_id_arr,
                                     $title_info_arr_sort,
                                     true);
$tbody = $htmlLib->getPriceTbodyHtml(count($title_arr_sort),
                                     $price_arr_sort,
                                     $amt_arr,
                                     true);
$colgroup = $htmlLib->getColgroupHtml();

echo $colgroup . $thead . $tbody;

$conn->Close();
exit;

NOT_PRICE :
    $conn->Close();
    echo "<tr><td>검색된 내용이 없습니다.</td></tr>";
    exit;


/******************************************************************************
                            함수 영역
 *****************************************************************************/

/**
 * @brief 종이 정보 검색결과를 가격검색 및 제목생성에
 * 사용할 수 있도록 가공하는 함수
 *
 * @param $rs = 검색결과
 *
 * @return 가공된 배열
 */
function makePaperTotalInfoArr($rs) {
    $ret = array(
        "mpcode" => array(), // 종이 맵핑코드 배열, 가격검색시 사용
        "info"   => array()  // 종이 정보 배열, 제목 생성시 사용
    );

    $info_form = "%s %s %s %s";

    $i = 0;
    while ($rs && !$rs->EOF) {
        $mpcode      = $rs->fields["mpcode"];

        $name        = $rs->fields["name"];
        $dvs         = $rs->fields["dvs"];
        $color       = $rs->fields["color"];
        $basisweight = $rs->fields["basisweight"];

        $ret["mpcode"][$i] = $mpcode;
        $ret["info"][$i++] = sprintf($info_form, $name
                                               , $dvs
                                               , $color
                                               , $basisweight);
        $rs->MoveNext();
    }

    return $ret;
}
?>
