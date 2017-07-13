<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/PrintoutInterface.php');

class Envelope extends Product implements PrintoutInterface
{
    /**
     * @var string
     */
    var $amt;
    var $size_w, $size_h;
    var $papers;
    var $options;
    var $afterprocesses;

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

        $after_history = explode("$", $param['after_history']);
        $after_count = count($after_history);
        $amt = $param['prd_amount'] * $param['prd_count'];
        $JC_after_html = "";
        for($i = 0; $i < $after_count ; $i++) {
            if($after_history[$i] == '') {
                break;
            }
            $after = explode("|", $after_history[$i]);
            $product = $factory->createAfter($product, $after[0]);
            $product->setAfterprocess($param['prd_detail_no'] ,$after[0]);
            $JC_after_html .= $product->JC_makeOrderHtml($after);
        }

        // 기본가격
        $basic_price = intval($param['addtax_order_amnt']) - intval($param['addtax_after_amnt']);

        // 카테고리 코드
        $ca_code = ProductInfoClass::CATE_CODE[$param['cate_sortcode']];

		// 페이지코드
		$page_code = ProductInfoClass::PAGE_CODE[$param['cate_sortcode']];

		// 종이코드
		$paper_code = ProductInfoClass::PAPER_CODE[$param['paper_name']];
        if($paper_code == "") {
            if($param["cate_paper_mpcode"] == '390' || $param["cate_paper_mpcode"] == '395') {
                $paper_code = "L4/B/110";
            } else if($param["cate_paper_mpcode"] == '391' || $param["cate_paper_mpcode"] == '396') {
                $paper_code = "L5/B/110";
            }
        }

        $paper_code_tmp = explode("/", $paper_code);
		$paper_code1 = $paper_code_tmp[0] . "/" . $paper_code_tmp[1];

		$paper_code2 = $paper_code_tmp[2];

		// 규격, 비규격 여부 and 사이즈 ID 설정
		$standard = "SEL";
		$s_code = "";

        if($param['cate_stan_mpcode'] == "742") {
            $s_code = "EC1";
        } else if($param['cate_stan_mpcode'] == "945") {
            $s_code = "EC2";
        } else if($param['cate_stan_mpcode'] == "946") {
            $s_code = "EC3";
        } else if($param['cate_stan_mpcode'] == "947") {
            $s_code = "EC4";
        } else if($param['cate_stan_mpcode'] == "948") {
            $s_code = "EC5";
        } else if($param['cate_stan_mpcode'] == "949") {
            $s_code = "EC6";
        } else if($param['cate_stan_mpcode'] == "950") {
            $s_code = "EC7";
        } else if($param['cate_stan_mpcode'] == "951") {
            $s_code = "EC8";
        }

		$side_code = "S";

		//상품 아이디
		$pro_code = "";
        $pro_code = $ca_code . str_replace('/', '', $paper_code) . $s_code . $param['output_board_amt'] . $side_code . ProductInfoClass::COATING_CODE[$param['cate_sortcode']];

		$html .= '<input type="hidden" name="After_TPrice" value="' . $product->cost() . '">';
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
		$html .= '<input type="hidden" name="Paper_Code" value="' . $paper_code1 . '">';
		$html .= '<input type="hidden" name="Paper_Code2" value="' . $paper_code2 . '">';
		$html .= '<input type="hidden" id="Price" name="Price" value="'.$param["addtax_order_amnt"].'">';
		$html .= '<input type="hidden" name="Pro_Code" value="' . $pro_code . '">'; //
		$html .= '<input type="hidden" name="Pro_Code_basic" value="' . $pro_code . '">'; //
		$html .= '<input type="hidden" name="Qty" value="' . $param["prd_amount"] . '">';
		$html .= '<input type="hidden" name="S_Code" value="'.$s_code.'">';
		$html .= '<input type="hidden" name="Side_Code" value="'.$side_code.'">';
		$html .= '<input type="hidden" name="Standard" value="' . $standard . '">';
		$html .= '<input type="hidden" id= "DSFile" name="DSFile" value="">'; //
		$html .= '<input type="hidden" name="DSOriFile" value="'.$param["origin_file_name"].'">'; //
		$html .= '<input type="hidden" name="Memo" value="">';
		$html .= '<input type="hidden" name="Subject" value="'.$param["title"].'">';
		$html .= '<input type="hidden" id="DataGubun" name="DataGubun" value="0">';
		$html .= $JC_after_html;

		return $html;
	}

    function cost() {
        return 0;
    }
}

?>