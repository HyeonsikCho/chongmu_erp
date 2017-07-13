<?
/**
 * @brief 클레임상세사항 html 생성
 * @param $param = 
 * @return 팝업 html
 */
function makeClaimContHtml($param) {
    $html = <<<html
            <div class="tb_group fix_width1200 clear">
    			<ul class="tab_box mt25">
    			    <li class="fl"><a class="box"> 클레임상세사항 </a> </li>
    			</ul>
			    <form>
				<div class="tab_box_con">
				<fieldset>
                <legend> 클레임 정보 </legend>	
					<div class="form-group" style="margin-left: 30px;">
                        $param[order_info_html]
						<br />                
					</div>

					<div class="form-group">
						<div class="table-body">
							<div class="table_basic" style="min-height: 0px;">
								<table class="table fix_width100f">
                                  <tbody>
										<tr>                  
											<td class="cellbg_td">클레임제목</td>
											<td colspan="3">$param[title]</td>								                	
										</tr>
										<tr>                  
											<td class="cellbg_td">발생비용</td>
											<td>$param[occur_price]</td>
											<td class="cellbg_td">클레임 견본</td>
											<td>$param[sample_origin_file_name]</td>								                                          </tr>
										<tr>                  
											<td class="cellbg_td">처리내용</td>
											<td colspan="3">$param[cust_cont]</td>								                	                         </tr>
                                    </tbody>
								</table>
							</div>
						</div>
					</div>	
					
				</fieldset>
				</div>			     
			    </form>
            </div> 
			
            <div class="tb_group fix_width1200 clear">
    			<ul class="tab_box mt25">
    			    <li class="fl"><a class="box"> 클레임처리내역 </a> </li>
    			</ul>
			    <form>
				<div class="tab_box_con">
				<fieldset>
                <legend> 클레임 처리정보 </legend>	
					<div class="form-group">
						<label class="control-label fix_width120 tar">담당자</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"> $param[empl_name]</label>
						<br />
					</div>
					
					<div class="form-group">
						<label class="control-label fix_width120 tar">클레임분류</label><label class="fix_width20 fs14 tac">:</label>
						<select class="fix_width180" id="claim_dvs">
        			        <option value="">클레임 분류(전체)</option>
        				    <option value="환불">환불</option>
        				    <option value="파손">파손</option>
        				    <option value="반품">반품</option>
						</select>
						<input type="text" class="input_co2 fix_width580" value="$param[dvs_detail]" id="dvs_detail">
						<br />
					</div>
					
					<div class="form-group">                    
						<label class="control-label fix_width120 tar">처리내용</label><label class="fix_width20 fs14 tac">:</label>
						<textarea class="bs_noti3" id="mng_cont">$param[mng_cont]</textarea>
						<br />
						<p style="position:relative;top:0px;left:980px;">
							<label class="btn btn_md fix_width120" onclick="procOrderClaim.save('$param[order_claim_seqno]')"> 저장하기 </label>
						</p>
					</div>         
				</fieldset>
				
				<fieldset class="mt25">
                <legend> 클레임 합의정보 </legend>	
					<div class="form-group">
						<label class="control-label fix_width120 tar">발생비용</label><label class="fix_width20 fs14 tac">:</label>
						<input type="text" class="input_co2 fix_width173" id="occur_price" value="$param[occur_price]" onkeyup="onlyNumberPrice(event);">
						<br />
					</div>
					
					<div class="form-group">
						<label class="control-label fix_width120 tar">환불금액 선입금</label><label class="fix_width20 fs14 tac">:</label>
						<input type="text" class="input_co2 fix_width173" id="refund_prepay" value="$param[refund_prepay]" onkeyup="onlyNumberPrice(event);">
						<label class="fix_width10"></label>
						<label class="control-label cp">또는 현금</label><label class="fix_width20 fs14 tac">:</label>
						<input type="text" class="input_co2 fix_width173" id="refund_money" value="$param[refund_money]" onkeyup="onlyNumberPrice(event);">
						<br />
					</div>
					
					<div class="form-group">
						<label class="control-label fix_width120 tar">고객부담</label><label class="fix_width20 fs14 tac">:</label>
						<input type="text" class="input_co2 fix_width173" id="cust_burden_price" value="$param[cust_burden_price]" onkeyup="onlyNumberPrice(event);">
						<br />
					</div>
					
					<div class="form-group">
						<label class="control-label fix_width120 tar">클레임처</label><label class="fix_width20 fs14 tac">:</label>
						<select class="fix_width180" id="extnl_etprs">
                            $param[extnl_etprs_html]
						</select>
						<label class="fix_width40"></label>
						<label class="control-label cp">금액</label><label class="fix_width20 fs14 tac">:</label>
						<input type="text" class="input_co2 fix_width173" id="outsource_burden_price" value="$param[outsource_burden_price]" onkeyup="onlyNumberPrice(event);">
						<br />
						<p style="position:relative;top:0px;left:980px;" id="agree_btn">
							<label class="btn btn_md fix_width120" onclick="procOrderClaim.agree('$param[order_claim_seqno]')"> 합의하기 </label>
						</p>
					</div>         
				</fieldset>
				
				<fieldset class="mt25">
                <legend> 클레임 재주문 </legend>	
					                <div class="form-group">
			        <label class="control-label fix_width120 tar">재인쇄 파일첨부</label><label class="fix_width20 fs14 tac">:</label>
			        <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
					<input id="upload_path" class="disableInputField" placeholder="Choose File" disabled="disabled"  value="$param[order_claim_file]"/>
                
                    <label class="fileUpload">
						<input id="upload_file" type="file" class="upload" onchange="fileSearchBtn(this.value);"/>
                        <span class="btn btn-sm btn-info fa" id="file_search">파일찾기</span>                        
                    </label>
                    <label class="fix_width10"></label>
                    <label class="control-label fix_width40 tar">건수</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co2 fix_width55" id="count" value="$param[count]">
                    
					<br />
                    <span class="fs13" style="position:relative;top:0px;left:143px;color:red;">* 파일을 압축하여 첨부해주세요.</span>
                    <p style="position:relative;top:-0px;left:980px;" id="order_btn">
                        <label class="btn btn_md fix_width120" onclick="procOrderClaim.order('$param[order_claim_seqno]')"> 주문하기 </label>
                    </p>
                </div>                
				</fieldset>
				</div>			     
			    </form>
            </div> 
html;

    return $html;
}
?>
