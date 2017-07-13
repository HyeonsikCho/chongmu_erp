<?php
include_once($_SERVER["DOCUMENT_ROOT"] .'/test/Common/PrintoutInterface.php');
include_once($_SERVER["DOCUMENT_ROOT"] . "/define/product_info_class.php");

class Master_NCR extends Master implements PrintoutInterface
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
        $html = '<h2>마스터주문</h2></br></br>';
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

    function makePaperOption() {
        $price_info_arr = array();
        $param = array();

        $paper = $this->dao->selectCatePaperHtml($this->conn, $this->sortcode, $price_info_arr);

        $html = '<input type="hidden" id="paper_cover" name="paper_cover" value="'. $paper['mpcode'] .'"';

        return $html;
    }

    function makePrintTmptOption() {
        $price_info_arr = array();
        $price_info_arr['cate_sortcode'] = $this->sortcode;
        $param = array();
        $param['cate_sortcode'] = $this->sortcode;
        $print_tmpt = $this->dao->selectCatePrintTmptHtml($this->conn, $param, $price_info_arr);
        $print_tmpt = $print_tmpt["단면"] . $print_tmpt["양면"];

        $html = '<select class="withBtn _relatedSummary _color" id="bef_tmpt_cover" name="bef_tmpt_cover" onchange="changeData();">' . $print_tmpt . '</select>';

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
		$paper_code = "";

        if($param['cate_sortcode'] == "007001001") {
            $paper_code = "N1";
        } else if($param['cate_sortcode'] == "007001002") {
            $paper_code = "N2";
        } else if($param['cate_sortcode'] == "007001003") {
            $paper_code = "N3";
        }

        $paper_code2 = "X/XXX";

		// 규격, 비규격 여부 and 사이즈 ID 설정
		$standard = "SEL";
        $s_code = "";
        if($param['cate_stan_mpcode'] == "793" || $param['cate_stan_mpcode'] == "803" || $param['cate_stan_mpcode'] == "813") {
            $s_code = "M01";
        } else if($param['cate_stan_mpcode'] == "794" || $param['cate_stan_mpcode'] == "804" || $param['cate_stan_mpcode'] == "814") {
            $s_code = "M02";
        } else if($param['cate_stan_mpcode'] == "795" || $param['cate_stan_mpcode'] == "805" || $param['cate_stan_mpcode'] == "815") {
            $s_code = "M03";
        } else if($param['cate_stan_mpcode'] == "796" || $param['cate_stan_mpcode'] == "806" || $param['cate_stan_mpcode'] == "816") {
            $s_code = "M04";
        } else if($param['cate_stan_mpcode'] == "797" || $param['cate_stan_mpcode'] == "807" || $param['cate_stan_mpcode'] == "817") {
            $s_code = "M05";
        } else if($param['cate_stan_mpcode'] == "798" || $param['cate_stan_mpcode'] == "808" || $param['cate_stan_mpcode'] == "818") {
            $s_code = "M10";
        } else if($param['cate_stan_mpcode'] == "799" || $param['cate_stan_mpcode'] == "809" || $param['cate_stan_mpcode'] == "819") {
            $s_code = "M11";
        } else if($param['cate_stan_mpcode'] == "800" || $param['cate_stan_mpcode'] == "810" || $param['cate_stan_mpcode'] == "820") {
            $s_code = "M12";
        } else if($param['cate_stan_mpcode'] == "801" || $param['cate_stan_mpcode'] == "811" || $param['cate_stan_mpcode'] == "821") {
            $s_code = "M13";
        } else if($param['cate_stan_mpcode'] == "802" || $param['cate_stan_mpcode'] == "812" || $param['cate_stan_mpcode'] == "822") {
            $s_code = "M14";
        }

        $detail = explode(" / ", $param['detail']);

        $tmp = str_replace("전면 : ","",$detail[0]); // 전면
        $tmp = explode(",", $tmp);
        for($i = 0 ; $i < count($tmp); $i++) {
            $color = "";
            if($tmp[$i] == "먹") {
                $color = "V";
            } else if($tmp[$i] == "원청") {
                $color = "W";
            } else if($tmp[$i] == "군청") {
                $color = "X";
            } else if($tmp[$i] == "원적") {
                $color = "Y";
            } else if($tmp[$i] == "금적") {
                $color = "Z";
            }
            $html .= '<input type="hidden" name="RibbonFront[]" value="'.$color.'">';
        }

        $tmp = str_replace("후면 : ","",$detail[1]); // 후면
        $tmp = explode(",", $tmp);
        for($i = 0 ; $i < count($tmp); $i++) {
            $color = "";
            if($tmp[$i] == "먹") {
                $color = "V";
            } else if($tmp[$i] == "원청") {
                $color = "W";
            } else if($tmp[$i] == "군청") {
                $color = "X";
            } else if($tmp[$i] == "원적") {
                $color = "Y";
            } else if($tmp[$i] == "금적") {
                $color = "Z";
            }
            $html .= '<input type="hidden" name="RibbonBefore[]" value="'.$color.'">';
        }

        $tmp = str_replace("제본 : ","",$detail[2]); // 제본
        $binding = "0";
        if($tmp == "좌철제본") {
            $binding = "2";
        } else if($tmp == "상철제본") {
            $binding = "1";
        }
        $html .= '<input type="hidden" name="MO_Binding" value="'. $binding .'">';

        $tmp = str_replace("다름여부 : ","",$detail[3]); // 다름여부
        if($tmp == "Y") {
            $html .= '<input type="hidden" name="MO_GB" value="Y">';
        }

        $tmp = str_replace("색상 : ","",$detail[4]); // 색상
        $tmp = explode(",", $tmp);

        if(count($tmp) == 2) {
            $html .= '<input type="hidden" name="NCR_H" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[0]] . '">';
            $html .= '<input type="hidden" name="NCR_L" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[1]] . '">';
        } else if(count($tmp) == 3) {
            $html .= '<input type="hidden" name="NCR_H" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[0]] . '">';
            $html .= '<input type="hidden" name="NCR_M1" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[1]] . '">';
            $html .= '<input type="hidden" name="NCR_L" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[2]] . '">';
        } else if(count($tmp) == 4) {
            $html .= '<input type="hidden" name="NCR_H" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[0]] . '">';
            $html .= '<input type="hidden" name="NCR_M1" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[1]] . '">';
            $html .= '<input type="hidden" name="NCR_M2" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[2]] . '">';
            $html .= '<input type="hidden" name="NCR_L" value="'. ProductInfoClass::NCR_PAPER_COLOR_MATCHING[$tmp[3]] . '">';
        }


		// 면, 도수
		$side_code = "S";

		//상품 아이디
		$pro_code = "";
        $tmp_paper_code2 = explode("/", $paper_code2);
        $pro_code = $ca_code . $paper_code . $tmp_paper_code2[0] . $tmp_paper_code2[1] . $s_code . $param['output_board_amt'] . $side_code . "0";



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
		$html .= '<input type="hidden" name="Paper_Code1" value="' . $paper_code . '">';
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