<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/business/order_mng/OrderCommonMngDAO.php");


abstract class Product {
	var $name;
	var $sortcode;
	var $jc_orderhtml;

	var $dao;
	var $connectionPool;
	var $util;
	var $conn;

	function __construct($sortcode) {
		$this->sortcode = $sortcode;
		$this->connectionPool = new ConnectionPool();
		$this->conn = $this->connectionPool->getPooledConnection();
		$this->dao = new OrderCommonMngDAO();
		$this->util = new ErpCommonUtil();
		$this->name = "";
	}


	function makePaperOption() {
		$price_info_arr = array();
		$param = array();

		$paper = $this->dao->selectCatePaperHtml($this->conn, $this->sortcode, $price_info_arr);

		$html = '<select id="paper_cover" name="paper_cover" onchange="changeData();">' . $paper['info'] . '</select>';

		return $html;
	}

	function makePrintOption() {
		$price_info_arr = array();
		$price_info_arr['cate_sortcode'] = $this->sortcode;
		$param = array();
		$param['cate_sortcode'] = $this->sortcode;
		$print_tmpt = $this->dao->selectCatePrintTmptHtml($this->conn, $param, $price_info_arr);
		$print_tmpt = $print_tmpt["단면"] . $print_tmpt["양면"];

		$print_purp = $this->dao->selectCatePrintPurpHtml($this->conn, $this->sortcode);

		$html = '인쇄도수 : <select id="print" name="print" onchange="changeData();">' . $print_tmpt . '</select>';
		$html .= '<select id="print_purp" name="print_purp_cover " style="display:none">' . $print_purp .'</select>';

		return $html;
	}

	function makePrintTmptOption() {
		$price_info_arr = array();
		$price_info_arr['cate_sortcode'] = $this->sortcode;
		$param = array();
		$param['cate_sortcode'] = $this->sortcode;
		$print_tmpt = $this->dao->selectCatePrintTmptHtml($this->conn, $param, $price_info_arr);
		$print_tmpt = $print_tmpt["단면"] . $print_tmpt["양면"];

		$html = '<select id="bef_tmpt_cover" name="bef_tmpt_cover" onchange="changeData();">' . $print_tmpt . '</select>';

		return $html;
	}

	function makePrintPurpOption() {
		$price_info_arr = array();
		$price_info_arr['cate_sortcode'] = $this->sortcode;
		$param = array();
		$param['cate_sortcode'] = $this->sortcode;

		$print_purp = $this->dao->selectCatePrintPurpHtml($this->conn, $this->sortcode);

		$html = '<select id="print_purp" name="print_purp_cover " style="display:none">' . $print_purp .'</select>';

		return $html;
	}


	function makeSizeOption() {
		$price_info_arr = array();
		$price_info_arr['cate_sortcode'] = $this->sortcode;
		$param = array();
		$param['cate_sortcode'] = $this->sortcode;
		$size = $this->dao->selectCateSizeHtml($this->conn, $this->sortcode, $price_info_arr);
		$html = '<select id="size" name="size" def_cut_wid='.$price_info_arr['def_cut_wid'].' def_cut_vert=' . $price_info_arr['def_cut_vert'] . ' stan_mpcode=' . $price_info_arr['stan_mpcode'] . '>' . $size . '</select>';

		return $html;
	}

	function makeAmtOption() {
		$price_info_arr = array();
		$price_info_arr['cate_sortcode'] = $this->sortcode;
		$param = array();
		$param['cate_sortcode'] = $this->sortcode;
		$param["table_name"]    = 'ply_price_gp';
		$param["amt_unit"]      = '장';
		$amt = $this->dao->selectCateAmtHtml($this->conn, $param, $price_info_arr);

		$html =  '수량 : <select id="amt" name="amt" onchange="changeData();">' . $amt . '</select>';
		return $html;
	}

	function makeOptOption() {
		$opt = $this->dao->selectCateOptHtml($this->conn, $this->sortcode);
		$add_opt = $opt["info_arr"]["name"];
		$add_opt = $this->dao->parameterArrayEscape($this->conn, $add_opt);
		$add_opt = $this->util->arr2delimStr($add_opt);
		$param = array();
		$param["cate_sortcode"] = $this->sortcode;
		$param["opt_name"]      = $add_opt;
		$param["opt_idx"]       = $opt["info_arr"]["idx"];
		$add_opt = $this->dao->selectCateAddOptInfoHtml($this->conn, $param);

		$html = '<dd class="_folder list">' . $opt['html'] .$add_opt . '</dd>';
		return $html;
	}

	function makeAfterOption() {
		$after = $this->dao->selectCateAfterHtml($this->conn, $this->sortcode);
		$add_after = $after["info_arr"]["add"];
		$add_after = $this->dao->parameterArrayEscape($this->conn, $add_after);
		$add_after  = $this->util->arr2delimStr($add_after, '|');
		$param = array();
		$param["cate_sortcode"] = $this->sortcode;
		$param["after_name"]      = $add_after;

		$add_after = $this->dao->selectCateAddAfterInfoHtml($this->conn, $param);
		$html = '<dd class="_folder list">' . $after['html'] .$add_after . '</dd>';

		return $html;
	}

	function JC_makeDeliveryHtml($order_no) {
		$rs = $this->dao->selectDeliveryInfo($this->conn, $order_no);

		$dlvr_pay_way = substr($rs->fields["dlvr_pay_way"], 1);
		$order_user_phno = explode('-', $rs->fields["order_user_phno"]);
		$order_user_telno = explode('-', $rs->fields["order_user_telno"]);
		$res_user_phno = explode('-', $rs->fields["res_user_phno"]);
		$res_user_telno = explode('-', $rs->fields["res_user_telno"]);
		$order_full_addr = $rs->fields["order_user_addr1"] . " " . $rs->fields["order_user_addr2"];

		$html = '<input type="hidden" name="AProSale_Price[]" value="0">';
		$html .= '<input type="hidden" name="AProSale_PriceU[]" value="0">';
		$html .= '<input type="hidden" id="Secure_Id" name="Secure_Id[]" value="">'; // order폼에서 받아야함
		$html .= '<input type="hidden" name="Dcode" value="136-783">'; // 구 우편번호
		$html .= '<input type="hidden" name="Deli_Mode" value="C">';
		$html .= '<input type="hidden" name="Deli_Pay_Mode" value="'.$dlvr_pay_way.'">';
		$html .= '<input type="hidden" name="Exception_YN" value="N">';
		$html .= '<input type="hidden" name="GProSale_Price[]" value="0">';
		$html .= '<input type="hidden" name="GProSale_PriceU[]" value="0">';
		$html .= '<input type="hidden" name="mypoint" value="10000000">';
		$html .= '<input type="hidden" name="or_addr1" value="'. $rs->fields["order_user_addr1"] .'">';
		$html .= '<input type="hidden" name="or_addr2" value="'. $rs->fields["order_user_addr2"] .'">';
		$html .= '<input type="hidden" name="or_com" value="">';
		$html .= '<input type="hidden" name="or_email" value="">';
		$html .= '<input type="hidden" name="or_hp[]" value="'.$order_user_phno[0].'">';
		$html .= '<input type="hidden" name="or_hp[]" value="'.$order_user_phno[1].'">';
		$html .= '<input type="hidden" name="or_hp[]" value="'.$order_user_phno[2].'">';
		$html .= '<input type="hidden" name="or_name" value="'. $rs->fields["order_user_name"] .'">';
		$html .= '<input type="hidden" name="or_tel[]" value="'.$order_user_telno[0].'">';
		$html .= '<input type="hidden" name="or_tel[]" value="'.$order_user_telno[1].'">';
		$html .= '<input type="hidden" name="or_tel[]" value="'.$order_user_telno[2].'">';
		$html .= '<input type="hidden" name="or_zip1" value="136">'; // 주문자 (구) 우편번호 1 ------- or_zip1
		$html .= '<input type="hidden" name="or_zip2" value="783">'; // 주문자 (구) 우편번호 2 ------- or_zip2
		$html .= '<input type="hidden" name="order_S" value="2">';
		$html .= '<input type="hidden" name="order_type" value="direct">';
		$html .= '<input type="hidden" id="OriPayPrice" name="OriPayPrice" value="">'; // 세금붙기 전 원가, order 단계에서 가져오기
		$html .= '<input type="hidden" id="PayPrice" name="PayPrice" value="">'; // OriPayPrice + 세금 , order 단계에서 가져오기
		$html .= '<input type="hidden" name="PayPrice_Sale" value="0">';
		$html .= '<input type="hidden" name="ProSale_Price[]" value="0">';
		$html .= '<input type="hidden" name="ProSale_PriceU[]" value="0">';
		$html .= '<input type="hidden" name="re_addr1" value="'. $rs->fields["res_user_addr1"] .'">';
		$html .= '<input type="hidden" name="re_addr2" value="'. $rs->fields["res_user_addr2"] .'">';
		$html .= '<input type="hidden" name="re_hp[]" value="'.$res_user_phno[0].'">';
		$html .= '<input type="hidden" name="re_hp[]" value="'.$res_user_phno[1].'">';
		$html .= '<input type="hidden" name="re_hp[]" value="'.$res_user_phno[2].'">';
		$html .= '<input type="hidden" name="re_name" value="'. $rs->fields["res_user_name"] .'">';
		$html .= '<input type="hidden" name="re_tel[]" value="'.$res_user_telno[0].'">';
		$html .= '<input type="hidden" name="re_tel[]" value="'.$res_user_telno[1].'">';
		$html .= '<input type="hidden" name="re_tel[]" value="'.$res_user_telno[2].'">';
		$html .= '<input type="hidden" name="re_zip1" value="136">'; // 수령인 (구) 우편번호 1 ------- res_user_zipcode
		$html .= '<input type="hidden" name="re_zip2" value="783">'; // 수령인 (구) 우편번호 2 ------- res_user_zipcode
		$html .= '<input type="hidden" id="RPay_Price" name="RPay_Price[]" value="">'; // 결제금액 , order 단계에서 가져오기
		$html .= '<input type="hidden" id="RPay_PriceU" name="RPay_PriceU[]" value="">'; // 결제금액, order 단계에서 가져오기
		$html .= '<input type="hidden" name="Same" value="basic">';
		$html .= '<input type="hidden" name="Send_addr1" value="'.$order_full_addr.'">';
		$html .= '<input type="hidden" name="Send_chk" value="new">';
		$html .= '<input type="hidden" name="Send_name" value="'.$rs->fields["order_user_name"].'">';
		$html .= '<input type="hidden" name="Send_tel[]" value="'.$order_user_phno[0].'">';
		$html .= '<input type="hidden" name="Send_tel[]" value="'.$order_user_phno[1].'">';
		$html .= '<input type="hidden" name="Send_tel[]" value="'.$order_user_phno[2].'">';
		$html .= '<input type="hidden" name="Send_zip1" value="136">'; // 보내는 사람 우편번호 1 ------- or_zip1
		$html .= '<input type="hidden" name="Send_zip2" value="783">'; // 보내는 사람 우편번호2 ------- or_zip2
		$html .= '<input type="hidden" id="Taxes" name="Taxes" value="">'; // 전체액의 세금 order 단계에서 가져오기

		return $html;
	}

	function getDescription() {
		return $this->name;
	}

	function cost() {}
}