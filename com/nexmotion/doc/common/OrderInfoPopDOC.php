<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/common_define/product_info_class.php");


include_once($_SERVER["DOCUMENT_ROOT"] . '/test/Common/DPrintingFactory.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/test/Common/PrintoutInterface.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/test/BasicMaterials/Paper.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/test/BasicMaterials/Option.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/test/BasicMaterials/Afterprocess.php');

//include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ErpCommonUtil.php");
/**
 * OrderInfoPopDOC
 * @param 주문정보 팝업 html 생성
 *
 * @detail $param에는 주문 공통 테이블에 저장되어있는
 * 기본정보(basic_info)
 * 추가정보(add_info)
 * 가격정보(price_info)
 * 결제정보(pay_info)
 * html이 넘어온다
 *
 * @param $param = 정보 배열
 *
 * @return 팝업 html
 */
function makeOrderInfoHtml($param) {
    $basic_info = $param["prdt_basic_info"];
    $add_info   = $param["prdt_add_info"];
    $price_info = $param["prdt_price_info"];
    $pay_info   = $param["prdt_pay_info"];

    $html = <<<html
            <dl>
                <dt class="tit">
                    <h4>주문(결제)정보보기</h4>
                </dt>
                <dt class="cls">
                    <button type="button" onclick="hideRegiPopup()" class="btn btn-sm btn-danger fa fa-times"></button>
                </dt>
            </dl>

            <div class="pop-base" style="height:600px;">
                <div class="pop-content" style="min-height:560px;">
                <p>상품정보를 볼 수 있도록 구성한다.<br />파일업로드</p>
                    <div class="form-group">
                        $basic_info
                        $add_info
                        $price_info
                        $pay_info
                    </div>
                </div> <!-- pop-content -->
            </div>
            <!-- pop-base -->
	 	<div class="form-group">
                <p class="tac mt15" onclick="hideRegiPopup()">
                    <label class="btn btn_md fix_width120"> 닫기</label>
                </p>
            </div>
            <br />
html;

    return $html;
}

function makeProductInfoHtml($conn,$seqno,$param) {
	$product_info = ProductInfoClass::ORDER_STATUS_ARR;
	$order_no       = $param['order_no'];
	$prd_detail_no	= $param['prd_detail_no'];
	$cate_name      = $param['cate_name'];
	$paper_name     = $param['paper_name'];
	$print_name     = $param['print_name'];
	$work_size_wid  = $param['work_size_wid'];
	$work_size_vert = $param['work_size_vert'];
	$cut_size_wid   = $param['cut_size_wid'];
	$cut_size_vert  = $param['cut_size_vert'];
	$prd_amount     = $param['prd_amount'];
	$prd_count      = $param['prd_count'];
	$comment        = $param['comment'];
	$prd_status     = $product_info[$param['prd_status']];
	$after_history  = $param['after_history'];
	$order_prdlist_seq = $param['order_prdlist_seq'];
	$addtax_order_amnt = $param['addtax_order_amnt'];
	$origin_file_name  = $param['origin_file_name'];
	$order_img_seq	= $param['order_img_seq'];

	if(!empty($after_history)){
		$after_arr = explode('$',$after_history);
		for($i=0;$i<count($after_arr);$i++){
			$a_list .=$after_arr[$i]."\n";
		}
	}

	//$conn->debug = 1;
	$opt_history    = $param['opt_history'];
	if(!empty($opt_history)){
		$opt_arr = explode('/',$opt_history);
		for($i=0;$i<count($opt_arr);$i++){
			$o_list .=$opt_arr[$i]."\n";
		}

	}
	$img_list       = $param['img_list'];
	if(!empty($img_list)){
		$img_arr = explode('$',$img_list);
	}
	for($i=0;$i<count($img_arr);$i++){
		$detail_img[$i] = explode('&',$img_arr[$i]);
	}
	for($i=0;$i<count($detail_img);$i++){
		${'img'.$detail_img[$i][0]} = "<a href='/".$detail_img[$i][2].$detail_img[$i][3]."'>".$detail_img[$i][4]."</a>";
	}

	$options = "";
	foreach($product_info as $x => $x_value){
		$options .= "<option id=" . $x . " ";
		if(trim($prd_status) == $x_value)
			$options .= "selected";
		$options .= ">" . $x_value . "</option>";
	}

	$img_del_option = "";
	if(!empty($order_img_seq)){
		$img_del_option = "<img src='/design_template/images/btn_circle_x_red.png' id='work_file_del' file_seqno='" . $order_img_seq ."' onclick=removeUploadFile('" . $order_img_seq . "'); style='cursor:pointer';>";
	}

	$img_name_option = "";
	if(!empty($origin_file_name)){
		$img_name_option = "$origin_file_name</label>";
	}

	$img_name = date(Ymdhis) . "_" . mt_rand(100, 999);

	$factory = new DPrintingFactory();
	$product = $factory->create($param['cate_sortcode']);
	$order_html = $product->JC_makeOrderHtml($param);
	$delivery_html = $product->JC_makeDeliveryHtml($param['order_no']);


    $html = <<<html
            <dl>
                <dt class="tit">
                    <h4>상품정보보기</h4>
                </dt>
                <dt class="cls">
                    <button type="button" onclick="hideRegiPopup()" class="btn btn-sm btn-danger fa fa-times"></button>
                </dt>
            </dl>

            <div class="pop-base" style="height:600px;">
                <div class="pop-content" style="min-height:500px;">
                <p>상품정보를 조회합니다.</p>
                    <div class="form-group">
                        <p>
							<label class="control-label fix_width150 tar">접수상태</label><label class="fix_width20 fs14 tac">:</label> $prd_status      <br />
							<label class="control-label fix_width150 tar">접수상태 리스트</label><label class="fix_width20 fs14 tac">:</label>
								<select id=$order_prdlist_seq class="sel_status">
									$options
								</select>     <br />
							<label class="control-label fix_width150 tar">주문번호</label><label class="fix_width20 fs14 tac">:</label> $order_no
                            <label class="control-label fix_width150 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label> $cate_name
                            <label class="control-label fix_width150 tar">종이</label><label class="fix_width20 fs14 tac">:</label> $paper_name              <br />
                            <label class="control-label fix_width150 tar">작업사이즈</label><label class="fix_width20 fs14 tac">:</label> $work_size_wid * $work_size_vert       <br />
							<label class="control-label fix_width150 tar">재단사이즈</label><label class="fix_width20 fs14 tac">:</label> $cut_size_wid * $cut_size_vert        <br />
                            <label class="control-label fix_width150 tar">수량</label><label class="fix_width20 fs14 tac">:</label> $prd_amount            <br />
                            <label class="control-label fix_width150 tar">인쇄도수</label><label class="fix_width20 fs14 tac">:</label> $print_name
                            <label class="control-label fix_width150 tar">건수</label><label class="fix_width20 fs14 tac">:</label> $prd_count 건               <br />
							<label class="control-label fix_width150 tar">옵션</label><label class="fix_width20 fs14 tac">:</label> $o_list              <br />
							<label class="control-label fix_width150 tar">후공정</label><label class="fix_width20 fs14 tac">:</label>$a_list                <br />
							<label class="control-label fix_width150 tar">금액</label><label class="fix_width20 fs14 tac">:</label>$addtax_order_amnt 원            <br />
                            <label class="control-label fix_width150 tar">사용자</label><label class="fix_width20 fs14 tac"></label><br />
                            <label class="control-label fix_width150 tar">관리자</label><label class="fix_width20 fs14 tac"></label><br />
                            <label class="fileUpload" id="fileUpload" ono='$order_no' dno='$prd_detail_no'>
                            <button type='button' id='pickfiles' style='position: relative; z-index: 1;'>파일첨부</button>
                            </label>
                            <label id='filelist' class='filechk' fchk=true>$img1 $img_del_option</label>
							<label id='btn_upload' style='display:none;'><button type='button' id='uploadfiles'>업로드</button></label>
                            <br />
                        </p>
                    </div>
                </div> <!-- pop-content -->
            </div>
            <!-- pop-base -->
	 	<div class="form-group">
				<p class="tac mt15">
					<label id="order_request" class="btn btn_md fix_width120" onclick="callRequest()"> 주문넣기</label>
					<label class="btn btn_md fix_width120" onclick="applyOrderStatus()"> 적용</label>
				    <label class="btn btn_md fix_width120" onclick="hideRegiPopup()"> 닫기</label>
                </p>
            </div>
            <br />

   		<form id="orderForm" name="orderForm" method="post">
			$order_html
		</form>
		<form id="deliveryForm" name="deliveryForm" method="post">
			$delivery_html
		</form>
html;
    return $html;
}

function makeProduct_imgInfoHtml($param) {
	$order_no       = $param['order_no'];
    $cate_name      = $param["cate_name"];
    $paper          = $param["paper"];
    $size           = $param["size"];
    $amount         = $param["amount"];
    $print          = $param["print"];
    $cnt            = $param["cnt"];
    $price          = $param["price"];
    $tax            = $param["tax"];
    $pureprice      = $param["pureprice"];
    $puretax        = $param["puretax"];
    $totprice       = $param["totprice"];

    $html = <<<html
            <dl>
                <dt class="tit">
                    <h4>상품정보보기</h4>
                </dt>
                <dt class="cls">
                    <button type="button" onclick="hideRegiPopup()" class="btn btn-sm btn-danger fa fa-times"></button>
                </dt>
            </dl>

            <div class="pop-base" style="height:600px;">
                <div class="pop-content" style="min-height:500px;">
                <p>상품정보를 조회합니다.</p>
                    <div class="form-group">
                        <p>

                            <label class="control-label fix_width150 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label> $cate_name      <br />
                            <label class="control-label fix_width150 tar">종이</label><label class="fix_width20 fs14 tac">:</label> $paper              <br />
                            <label class="control-label fix_width150 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label> $size             <br />
                            <label class="control-label fix_width150 tar">수량</label><label class="fix_width20 fs14 tac">:</label> $amount             <br />
                            <label class="control-label fix_width150 tar">인쇄도수</label><label class="fix_width20 fs14 tac">:</label> $print          <br />
                            <label class="control-label fix_width150 tar">건수</label><label class="fix_width20 fs14 tac">:</label> $cnt                <br />
                            <label class="control-label fix_width150 tar">단가</label><label class="fix_width20 fs14 tac">:</label> $price 원( $tax 원)       <br />
                            <label class="control-label fix_width150 tar">금액</label><label class="fix_width20 fs14 tac">:</label> $pureprice 원( $puretax 원)<br />
                            <label class="control-label fix_width150 tar">총액</label><label class="fix_width20 fs14 tac">:</label> $totprice 원          <br />
                            <label class="control-label fix_width150 tar">이미지</label><label class="fix_width20 fs14 tac">:</label> $totprice 원          <br />
                        </p>
                    </div>
                </div> <!-- pop-content -->
            </div>
            <!-- pop-base -->
	 	<div class="form-group">
                <p class="tac mt15" onclick="hideRegiPopup()">
                    <label class="btn btn_md fix_width120"> 닫기</label>
                </p>
            </div>
            <br />
html;

    return $html;
}
?>
