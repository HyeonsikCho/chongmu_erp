<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . '/com/nexmotion/job/basic_mng/prdt_price_mng/PrdtPriceListDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$fb = new FormBean();
$util = new ErpCommonUtil();
$dao = new PrdtPriceListDAO();

// 공통사용 정보
$val = $fb->form("val");
$val = ($val[0] === '.') ? '0' . $val : $val; // 소수점 처리
$dvs = $fb->form("dvs");
$cate_sortcode = $fb->form("cate_sortcode");
$sell_site     = $fb->form("sell_site");
$mono_yn       = intval($fb->form("mono_yn"));

// 개별수정시 넘어오는 정보
$price_seqno = $fb->form("price_seqno");

//* 판매채널에 해당하는 가격 테이블 검색
$table_name = $dao->selectPriceTableName($conn, $mono_yn, $sell_site);

//$conn->debug = 1;
if (empty($price_seqno) === true) {
    // 일괄수정
    $paper_mpcode = $fb->form("paper_mpcode");
    $stan_mpcode  = $fb->form("stan_mpcode");

    //* 규격 맵핑코드 검색
    $print_tmpt = $fb->form("print_tmpt");
    $print_purp = $fb->form("print_purp");

    $param = array();
    $param["cate_sortcode"] = $cate_sortcode;
    $param["tmpt"] = $print_tmpt;
    $param["purp"] = $print_purp;

    $rs = $dao->selectCatePrintMpcode($conn, $param);
    $print_mpcode = $rs->fields["mpcode"];

    unset($rs);
    unset($param);


    //* 가격 업데이트 대상 검색
    $param["cate_sortcode"] = $cate_sortcode;
    $param["paper_mpcode"]  = $paper_mpcode;
    $param["stan_mpcode"]   = $stan_mpcode;
    $param["print_mpcode"]  = $print_mpcode;

    $rs = $dao->selectCatePriceListExcel($conn, $table_name, $param);

    unset($param);

    $conn->StartTrans();
    while ($rs && !$rs->EOF) {
        $price_seqno = $rs->fields["price_seqno"];
        $basic_price = $rs->fields["basic_price"];
        $rate =
            ($dvs === 'R') ? $val : $rs->fields["rate"];
        $aplc_price  =
            ($dvs === 'A') ? $val : $rs->fields["aplc_price"];

        $param["price_seqno"] = $price_seqno;
        $param["rate"]        = $rate;
        $param["aplc_price"]  = $aplc_price;
        $param["new_price"]   = $util->getNewPrice($basic_price,
                                                   $rate,
                                                   $aplc_price);

        $update_ret = $dao->updateCatePrice($conn, $table_name, $param);

        if (!$update_ret) {
            goto ERR;
        }

        $rs->MoveNext();
    }
    $conn->CompleteTrans();


} else {
    // 개별수정
    //* 가격 업데이트 대상 검색
    $param["price_seqno"]   = $price_seqno;

    $rs = $dao->selectCatePriceListExcel($conn, $table_name, $param);

    unset($param);

    $basic_price = $rs->fields["basic_price"];
    $rate =
        ($dvs === 'R') ? $val : $rs->fields["rate"];
    $aplc_price  =
        ($dvs === 'A') ? $val : $rs->fields["aplc_price"];

    $param["price_seqno"] = $price_seqno;
    $param["rate"]        = $rate;
    $param["aplc_price"]  = $aplc_price;
    $param["new_price"]   = $util->getNewPrice($basic_price,
                                               $rate,
                                               $aplc_price);

    $update_ret = $dao->updateCatePrice($conn, $table_name, $param);

    if (!$update_ret) {
        goto ERR;
    }
}

echo "T";
$conn->close();
exit;

ERR :
    $conn->CompleteTrans();
    $conn->close();
    echo "";
    exit;
?>
