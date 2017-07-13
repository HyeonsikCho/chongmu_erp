<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/StickerOrder.php');
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/StickerOrder_S10.php');
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/StickerOrder_S20.php');
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/StickerOrder_S30.php');
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/PrintoutInterface.php');

class Sticker extends Product implements PrintoutInterface
{
    /**
     * @var string
     */
    var $amt;
    var $size_w, $size_h;
    var $papers;
    var $options;
    var $afterprocesses;
    var $stickerOrder;


    function makeHtml() {
        $html = '<h2>명함주문</h2></br></br>';
        $html .= $this->makePaperOption();
        $html .= $this->makePrintOption();
        $html .= $this->makeSizeOption();
        $html .= $this->makeAmtOption();
        $html .= $this->makeOptOption();
        $html .= $this->makeAfterOption();
        $html .= '<input type="hidden" id="sortcode" name="sortcode" value="' . $this->sortcode .'"></br></br>';
        $html .= '<input type="hidden" id="opt_name_list" name="opt_name_list" value="">';
        $html .= '<input type="hidden" id="opt_mp_list" name="opt_mp_list" value="">';
        $html .= '<input type="hidden" id="after_name_list" name="after_name_list" value="">';
        $html .= '<input type="hidden" id="after_mp_list" name="after_mp_list" value="">';
        $html .= '<span id="total_price">0원</span>';
        return $html;
    }

    function JC_makeOrderHtml($param) {
        $html = "";

        $factory = new DPrintingFactory();
        $product = $factory->create($param['cate_sortcode']);

        // 기본가격
        $basic_price = intval($param['addtax_order_amnt']) - intval($param['addtax_after_amnt']);

        // 카테고리 코드
        $ca_code = ProductInfoClass::CATE_CODE[$param['cate_sortcode']];

		// 페이지코드
		$page_code = ProductInfoClass::PAGE_CODE[$param['cate_sortcode']];

		// 종이코드
		$paper_code = ProductInfoClass::PAPER_CODE[$param['paper_name']];


		$html .= '<input type="hidden" name="Basic_Price" value="'.$basic_price.'">';
		$html .= '<input type="hidden" name="Ca_Code" value="'.$ca_code.'">';
		$html .= '<input type="hidden" name="Color_Code" value="'.$param["output_board_amt"].'">';
		$html .= '<input type="hidden" name="CS_MaxSizeH" value="">';
		$html .= '<input type="hidden" name="CS_MaxSizeW" value="">';
		$html .= '<input type="hidden" name="CS_MinSizeH" value="">';
		$html .= '<input type="hidden" name="CS_MinSizeW" value="">';
		$html .= '<input type="hidden" name="CutSizeH" value="'.$param["cut_size_vert"].'">';
		$html .= '<input type="hidden" name="CutSizeW" value="'.$param["cut_size_wid"].'">';
		$html .= '<input type="hidden" name="Digits" value="'.$param["stan_cal"].'">';
		$html .= '<input type="hidden" name="direct" value="Y">';
		$html .= '<input type="hidden" name="EditSizeH" value="'.$param["work_size_vert"].'">';
		$html .= '<input type="hidden" name="EditSizeW" value="'.$param["work_size_wid"].'">';
		$html .= '<input type="hidden" name="mode" value="to_cart">';
		$html .= '<input type="hidden" name="Num" value="'.$param["prd_count"].'">';
		$html .= '<input type="hidden" name="Page_CaCode" value="' . $page_code . '">';
		$html .= '<input type="hidden" id="Price" name="Price" value="'.$param["addtax_order_amnt"].'">';
		$html .= '<input type="hidden" name="Qty" value="' . $param["prd_amount"] . '">';
		$html .= '<input type="hidden" name="Side_Code" value="S">';
		$html .= '<input type="hidden" id= "DSFile" name="DSFile" value="">'; //
		$html .= '<input type="hidden" name="DSOriFile" value="'.$param["origin_file_name"].'">'; //
		$html .= '<input type="hidden" name="Memo" value="">';
		$html .= '<input type="hidden" name="Subject" value="'.$param["title"].'">';
		$html .= '<input type="hidden" id="DataGubun" name="DataGubun" value="0">';

        // ca_code에 따라 다른 함수 호출, 전략패턴 참고
        $this->setStickerOrder($factory->createSticker($ca_code));
        $html .= $this->getOrder($param);

		return $html;
	}

    function setStickerOrder($so) {
        $this->stickerOrder = $so;
    }

    function cost() {
        return 0;
    }

    function getOrder($param) {
        return $this->stickerOrder->getOrderType($param);
    }
}

?>