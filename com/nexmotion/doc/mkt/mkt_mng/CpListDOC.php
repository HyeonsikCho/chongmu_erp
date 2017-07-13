<?
//쿠폰 파일 html
function getFileHtml($param) {

    $html = <<<VIEWHTML

                        <div id="file_area">
                        <label class="fix_width100"> </label>
                        <label class="control-label cp blue_text01">$param[file_name]</label>
                        <button onclick="delCpFile('$param[file_seqno]')" type="button" class="btn btn-sm bred fa fa-times"></button>                        
                        <br /> 
                        </div>

VIEWHTML;

    return $html;

}

//발행 매수 html
function getAmtHtml($param) {

    $html = <<<VIEWHTML
 
                        <div id="amt_area" $param[amt_dspl]>
                        <label class="control-label fix_width79 tar">발행매수</label><label class="fix_width20 fs14 tac">:</label>
                        <input type="text" id="public_amt" name="public_amt" maxlength="21" class="input_co5 fix_width170" value="$param[public_amt]">
                        <br />
                        </div>

VIEWHTML;

    return $html;

}

//쿠폰 view html
function getCpView($param) {

    $html = <<<VIEWHTML


    <form name="cp_form" id="cp_form" method="post">
     <dl>
          <dt class="tit">
               <h4>쿠폰등록</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="closeLayer('#cp_popup_layer')" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base fl fix_width860">        
			  											 	 	  
          <div class="pop-content ofa">

                <ul class="form-group">
                     <li class="fix_width550 fl">
                        <label class="control-label fix_width79 tar">쿠폰명</label><label class="fix_width20 fs14 tac">:</label>
                        <input type="text" id="pop_cp_name" name="pop_cp_name" maxlength="50" class="input_co5 fix_width170" value="$param[cp_name]">
                        <br />
                        
                        <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                        <select id="pop_sell_site" name="pop_sell_site" class="fix_width150">
                        $param[sell_site]
                        </select> 
                        <br />
                        <label class="control-label fix_width79 tar">할인내용</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"><input type="radio" class="radio_box" name="sale_dvs" value="%" $param[per_check]>할인요율</label>
                        <label class="fix_width10"> </label>
                        <label class="control-label cp"><input maxlength="21" type="text" class="input_co5 fix_width75" name="per_val" id="per_val" value="$param[per_val]">%</label>
                        <label class="fix_width40"> </label>
                        <label class="control-label cp">최대</label>
                        <label class="control-label cp"><input maxlength="21" type="text" class="input_co5 fix_width75" name="max_sale_price" id="max_sale_price" value="$param[max_sale_price]">원</label>
                        <br />
                        
                        <label class="fix_width100"> </label>
                        <label class="control-label cp"><input maxlength="21" type="radio" class="radio_box" name="sale_dvs" value="원" $param[won_check]>할인금액</label>
                        <label class="fix_width10"> </label>
                        <label class="control-label cp"><input maxlength="21" type="text" class="input_co5 fix_width75" name="min_order_price" id="min_order_price" value="$param[min_order_price]">원 이상 구매시</label>
                        <label class="control-label cp"><input maxlength="21" type="text" class="input_co5 fix_width75" name="won_val" id="won_val"  value="$param[won_val]">원</label>
                        <br />
                        
                        <label class="control-label fix_width79 tar">유효기간</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="Y" name="period_limit" $param[limit_y]>기간제</label>
                        <label class="fix_width20"> </label>
                            <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="public_date_from" name="public_start_date" value="$param[public_start_date]">
                        <label class="control-label cp">~</label>
                            <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="public_date_to" name="public_end_date" value="$param[public_end_date]">
                        <br />
                        <label class="fix_width100"> </label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="N" name="period_limit" $param[limit_n]>발행 후</label>
                        <label class="fix_width10"> </label>
                        <label class="control-label cp"><input type="text" maxlength="21" class="input_co5 fix_width75" name="public_deadline_day" id="public_deadline_day" value="$param[public_deadline_day]">일</label>
                        <label class="fix_width10"> </label>
                        <label class="control-label cp">소멸날짜</label>
                        <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="expire_date" name="public_extinct_date" value="$param[public_extinct_date]">
                        <br />
                        <label class="control-label fix_width79 tar">사용기간</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="Y" name="hour_limit" $param[limit_y]>시간제</label>
                        <label class="fix_width20"> </label>
                        <select id="start_hour" name="start_hour" class="fix_width63">
                        $param[hour_list]
                        </select>
                        <select id="start_min" name="start_min" class="fix_width63">
                        $param[min_list]
                        </select>
                        <label class="control-label cp">~</label>
                        <select id="end_hour" name="end_hour" class="fix_width63">
                        $param[hour_list]
                        </select>
                        <select id="end_min" name="end_min" class="fix_width63">
                        $param[min_list]
                        </select>
                        <br />
                        <label class="fix_width100"> </label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="N" name="hour_limit" $param[limit_n]>시간 제한 없음</label>
                        <br />
                        <label class="control-label fix_width79 tar">대상지정방식</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="Y" onchange="showAmtArea(this.value); return false;" name="object_appoint" $param[object_y]>대상지정</label>
                        <label class="fix_width10"> </label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="N" onchange="showAmtArea(this.value); return false;" name="object_appoint" $param[object_n]>대상미지정</label>
                        <br />
                        $param[amt_html]
                        <label class="control-label fix_width79 tar">사용여부</label><label class="fix_width20 fs14 tac">:</label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="Y" name="use_yn" $param[use_y]>사용</label>
                        <label class="fix_width37"> </label>
                        <label class="control-label cp"><input type="radio" class="radio_box" value="N" name="use_yn" $param[use_n]>미사용</label>
                        <br />                        
                        
                        <label class="control-label fix_width79 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                        <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
                        <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly />
                        
                        <label class="fileUpload">
                            <input id="upload_btn" name="upload_btn" type="file" class="upload" />
                            <span class="btn btn-sm btn-info fa">찾아보기</span>
                        </label>
                        <script type="text/javascript">  
                            document.getElementById("upload_btn").onchange = function () {
                            document.getElementById("upload_file").value = this.value;
                                 };
                        </script>
                        <br />
                        $param[file_html]
                    </li>          
                     	  
                     <li  class="fix_width450 fl">
                        <label class="control-label fix_width79 tar">대상상품선택</label><label class="fix_width20 fs14 tac">:</label>
                        $param[cate_mid]
                     </li>
                     
                </ul>

          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
     <div class="pop-base clear">     
     	<p class="tac mt5">
          <label onclick="saveCpInfo('$param[cp_seqno]')" class="btn btn_md fix_width120"> 적용</label>          
      </p>
      <br /><br />    	    
          
    </div>

    </form>
VIEWHTML;

    return $html;

}

//대상 지정 html
function getObjectView($param) {

    $html = <<<VIEWHTML

<!-- 쿠폰대상지정 팝업창 --> 
     <dl>
          <dt class="tit">
               <h4>쿠폰대상지정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="closeLayer('#object_popup_layer')" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base fl" style="width: 980px;">        
			  											 	 	  
          <div class="pop-content ofa fix_height800" >

                <ul class="form-group">
				     <li>
					    <div class="pop-content">								        	   
					    <label class="control-label fix_width180 tar">회원명</label> <label class="fix_width10 fs14 tac"> : </label> <input maxlength="50" id="office_nick" name="office_nick" onkeydown="loadMemberName(event, this.value, '')"  type="text" class="input_co2" style="width: 173px;" placeholder="검색창 팝업 사용">
						<label class="control-label fix_width180 tar">팀구분</label> <label class="fix_width10 fs14 tac"> : </label> <select id="depar_dvs" class="fix_width180">
                            $param[depar_html]
                        </select>
                        <br />
						<label class="control-label fix_width180 tar">회원구분</label> <label class="fix_width10 fs14 tac"> : </label> <select id="member_typ" class="fix_width180">
                        <option value="">전체</option>
                        <option value="일반회원">일반회원</option>
                        <option value="예외업체">예외업체</option>
                        </select>
						<label class="control-label fix_width180 tar">등급구분</label> <label class="fix_width10 fs14 tac"> : </label> <select id="grade_dvs" class="fix_width180">
                            $param[grade_html]
                        </select>
						<br />
					    <p class="btn-lg red_btn">
                          <a style="cursor: pointer;" onclick="loadMemberInfoList(); return false;">검색</a>
                        </p>
                     <br /><br /><br />
						<hr class="hr_bd3">
						</div>
					 </li>
					 
                     <li  class="fix_width450 fl">
                        <div class="table-body" style="width: 500px;">
                            <div class="ofa fix_height350 mb15">
                                <table class="table fix_width100f ">
    					            <thead>
    					               <tr>
					                        <th class="bm2px"><input type="checkbox" id="all_member_chk" onclick="allCheck('all_member_chk', 'member_list');"></th>
    					            	    <th class="bm2px">회원명</th>
    					            	    <th class="bm2px">등급</th>					            	    
											<th class="bm2px">팀구분</th>
											<th class="bm2px">회원구분</th>
											<th class="bm2px">핸드폰번호</th>
    					            	</tr>					                      				
    					             </thead>
    					             <tbody id="member_list">	
                                     <tr>
                                        <td colspan="6">검색된 내용이 없습니다.</td>
                                    </tr>
    					             </tbody>
    					        </table>
                            </div>
                        </div>
                     </li>
                     
                     <li class="fix_width48 fl">
                        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
                        <button type="button" onClick="addMemberAppoint()" class="btn btn-sm btn-info">▶</button>
                     </li>
                     	  
                     <li  class="fix_width450 fl">
                        <div class="table-body" style="width: 332px;">
                            <div class="ofa fix_height350 mb15">
                                <table class="table fix_width100f ">
    					            <thead>
    					               <tr>
					                      	<th class="bm2px"><input type="checkbox" id="all_appoint_chk" onclick="allCheck('all_appoint_chk', 'appoint_list');"></th>
    					            	    <th class="bm2px">회원명</th>
    					            	    <th class="bm2px">쿠폰번호</th>					            	    
    					            	</tr>					                      				
    					             </thead>
    					             <tbody id="appoint_list">	
                                    $param[issue_list]
    					             </tbody>
    					        </table>
    					        
                            </div>
                            <button class="btn btn_pu fix_width75 fix_height30 bred fs12" onclick="delAppointMember(); return false;">삭제</button>
    					    <br />
                        </div>
                     </li>
                     
                </ul>

          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
     <div class="pop-base clear">     
     	<p class="tac mt5">
          <label class="btn btn_md fix_width120" onclick="addCpIssue()"> 발급</label>          
      </p>
      <br /><br />    	    
          
    </div>
        
<!-- 쿠폰대상지정 팝업창 -->  



VIEWHTML;

    return $html;

}

?>
