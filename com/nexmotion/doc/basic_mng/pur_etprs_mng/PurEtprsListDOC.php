<?
//매입 업체 VIEW
function getPurEtprsView($param){

    $html = <<<VIEWHTML

														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>VIEW</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="closeLayer('#view_list')"></button>
														 	    </dt>
														 	</dl>
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">매입업체 조회 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">매입업체명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu_name]" disabled>
							                    	               <label class="control-label fix_width120 tar">매입품</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[pur_prdt]" disabled>
                                                                   <label class="control-label fix_width120 tar">거래상태</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <label class="form-radio"><input type="radio" name="active" class="radio_box" $param[deal_y] disabled> 거래중</label>
							                    	               <label class="fix_width15"></label>   
							                    	               <label class="form-radio"><input type="radio" name="active" class="radio_box" $param[deal_n] disabled> 거래중지</label>	

							                    	               <br />							                    	             
							                    	           </div>    
							                    	           
							                    	           <!-- TAB UI -->
							                    	           <ul class="nav nav-tabs">
							                    	               <li class="active">
							                    	                   <a href="#tab1" data-toggle="tab"> 매입업체 정보 </a> 
							                    	               </li>
							                    	           </ul>
							                    	           <!-- TAB UI -->
							                    	           
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">회사명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[cpn_name]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">홈페이지</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" value="$param[hp]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[tel_num]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">팩스번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[fax]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width250" value="$param[mail]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width40" value="$param[zipcode]" disabled>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" value="$param[addr_front]" disabled>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" value="$param[addr_rear]" disabled>
							                    	           </div>
							                    	           <hr class="hr_bd3">
                                                               $param[etprs_mng_list]
							                    	           <hr class="hr_bd3">
                                                               $param[acct_mng_list]
							                    	           <!-- TAB UI -->
							                    	           <ul class="nav nav-tabs mt15">
							                    	               <li class="active">
							                    	                   <a href="#tab1" data-toggle="tab"> 매입업체 사업자등록증 정보 </a> 
							                    	               </li>
							                    	           </ul>
							                    	           <!-- TAB UI -->
							                    	           
							                    	           <div class="form-group"> 
							                    	               <label class="control-label fix_width120 tar">회사명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[bls_cpn_name]" disabled>
							                    	               <label class="fix_width40"> </label>
							                    	               <label class="control-label fix_width100 tar">대표자명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[repre_name]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">사업자등록번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" maxlength="3" class="input_co2 fix_width55" value="$param[crn_first]" disabled> - <input type="text" maxlength="2" class="input_co2 fix_width30" value="$param[crn_scd]" disabled> - <input type="text" maxlength="5" class="input_co2 fix_width55" value="$param[crn_thd]" disabled>
							                    	               <label class="fix_width20"> </label>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">업태</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[tob]" disabled>
							                    	               <label class="fix_width40"> </label>
							                    	               <label class="control-label fix_width100 tar">종목</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[bc]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width40" value="$param[bls_zipcode]" disabled>
							                    	                <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" value="$param[bls_addr_front]" disabled>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" value="$param[bls_addr_rear]" disabled>
							                    	           </div>
							                    	           <hr class="hr_bd3">
							                    	           <div class="form-group">
							                    	               <label class="control-label tar fix_width120"> 거래은행</label><label class="fix_width20 fs14 tac">:</label>

																	<input type="text" class="input_co2 fix_width100" value="$param[bank_name]" disabled>
							                    	               <label class="fix_width10"></label>
							                    	               <label class="control-label tar"> 계좌번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width150" value="$param[ba_num]" disabled>
							                    	               <br />
							                    	               <hr class="hr_bd3">
							                    	           	    <label class="control-label fix_width120 tar">참고사항</label><label class="fix_width20 fs14 tac">:</label>
							                    	           	    <textarea class="bs_noti">$param[add_items]</textarea>
							                    	           </div>

														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">매입업체 공급품 리스트 </a> 
						                                  </li>
			  											 	 	  </ul>
			  											 	 	  
			  											 	 	  <div class="tab_box_con">
                                                   <div class="tabbable">
                                                   	    
                                                   	    <ul class="nav nav-tabs">
                                                   	        <li class="active"><a href="#" data-toggle="tab"> $param[pur_prdt] </a> </li>
                                                   	    </ul>
                                                   	    <div id="prdt_list" class="tab-content">
                                                        $param[prdt_list]
                                                   	    </div><!-- tab-content -->
                                                   	
                                                   </div>
			  											 	 	  </div>

														 	 </div><!-- pop-base -->


VIEWHTML;

    return $html;

}

//매입품목 수정 테이블
function getPurEtprsEdit($param) {

    $html = <<<EDITHTML

														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>EDIT</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="closeLayer('#edit_list')"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">매입업체 수정 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">매입업체명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="pur_manu" value="$param[manu_name]">
							                    	               <label class="control-label fix_width120 tar">매입품</label><label class="fix_width20 fs14 tac">:</label>
                                                                    <select name="edit_pur_prdt" id="edit_pur_prdt" class="fix_width120">
							                    						<option value="종이">종이</option>
							                    						<option value="출력">출력</option>
							                    						<option value="인쇄">인쇄</option>
							                    						<option value="후공정">후공정</option>
							                    						<option value="옵션">옵션</option>
				                                                    </select>  
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">거래상태</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <label class="form-radio"><input type="radio" name="deal_type" value="Y" class="radio_box" $param[deal_y]> 거래중</label>
							                    	               <label class="fix_width15"></label>   
							                    	               <label class="form-radio"><input type="radio" name="deal_type" value="N" class="radio_box" $param[deal_n]> 거래중지</label>			                    	               
							                    	           </div>    
							                    	           
							                    	           <!-- TAB UI -->
							                    	           <ul class="nav nav-tabs">
							                    	               <li class="active">
							                    	                   <a href="#tab1" data-toggle="tab"> 매입업체 정보 </a> 
							                    	               </li>
							                    	           </ul>
							                    	           <!-- TAB UI -->
							                    	           
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">회사명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="cpn_name" maxlength="30" value="$param[cpn_name]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">홈페이지</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" name="hp" maxlength="255" value="$param[hp]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="tel_num" maxlength="30" value="$param[tel_num]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">팩스번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="fax" maxlength="30" value="$param[fax]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width120 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width250" name="mail" maxlength="255" value="$param[mail]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width40" maxlength="5" name="zipcode" id="zip" value="$param[zipcode]" readonly>
							                    	               <label class="btn btn_pu fix_width75 bgreen fs13" onclick="popZipLayer('etprsClick');">우편번호</label>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" id="addr_front" maxlength="255" name="addr_front" value="$param[addr_front]" readonly>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" id="addr_rear" maxlength="255" name="addr_rear" value="$param[addr_rear]">
							                    	           </div>
							                    	           <hr class="hr_bd3">
                                                               $param[etprs_mng_list]
							                    	           <hr class="hr_bd3">
                                                               $param[acct_mng_list]
							                    	           <!-- TAB UI -->
							                    	           <ul class="nav nav-tabs mt15">
							                    	               <li class="active">
							                    	                   <a href="#tab1" data-toggle="tab"> 매입업체 사업자등록증 정보 </a> 
							                    	               </li>
							                    	           </ul>
							                    	           <!-- TAB UI -->
							                    	           
							                    	           <div class="form-group"> 
							                    	               <label class="control-label fix_width120 tar">회사명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="bls_cpn_name" value="$param[bls_cpn_name]" maxlength="30">
							                    	               <label class="fix_width40"> </label>
							                    	               <label class="control-label fix_width100 tar">대표자명</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="repre_name" value="$param[repre_name]" maxlength="30">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">사업자등록번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width55" name="crn_first" maxlength="3" value="$param[crn_first]"> - <input type="text" class="input_co2 fix_width30" maxlength="2" name="crn_scd" value="$param[crn_scd]"> - <input type="text" class="input_co2 fix_width55" maxlength="5" name="crn_thd" value="$param[crn_thd]">
							                    	               <label class="fix_width20"> </label>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">업태</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="tob" value="$param[tob]" maxlength="30">
							                    	               <label class="fix_width40"> </label>
							                    	               <label class="control-label fix_width100 tar">종목</label><label class="fix_width20 fs14 tac" maxlength="30">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="bc" value="$param[bc]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" maxlength="5" class="input_co2 fix_width40" name="bls_zipcode" id="bls_zip" value="$param[bls_zipcode]" readonly>
							                    	               <label class="btn btn_pu fix_width75 bgreen fs13" onclick="popZipLayer('blsClick');">우편번호</label>
							                    	                <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" name="bls_addr_front" id="bls_addr_front" value="$param[bls_addr_front]" readonly>
							                    	               <br />
							                    	               <label class="fix_width140"></label>
							                    	               <input type="text" class="input_co2 fix_width350" name="bls_addr_rear" id="bls_addr_rear" maxlength="255" value="$param[bls_addr_rear]">
							                    	           </div>
							                    	           <hr class="hr_bd3">
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar"> 거래은행</label><label class="fix_width20 fs14 tac">:</label>
                                                                    <select id="bls_bank_name" name="bls_bank_name" class="fix_width120">
							                    						     <option value="신한은행">신한은행</option>
							                    						     <option value="국민은행">국민은행</option>
							                    						     <option value="농협">농협</option>
							                    						     <option value="우리은행">우리은행</option>
							                    						     <option value="기업은행">기업은행</option>
							                    						     <option value="하나은행">하나은행</option>
							                    						     <option value="외환은행">외한은행</option>
							                    						     <option value="경남은행">경남은행</option>
							                    						     <option value="광주은행">광주은행</option>
							                    						     <option value="대구은행">대구은행</option>
							                    						     <option value="부산은행">부산은행</option>
							                    						     <option value="산업은행">산업은행</option>
							                    						     <option value="상호저축은행">상호저축은행</option>
							                    						     <option value="새마을은행">새마을은행</option>
							                    						     <option value="수협">수협</option>
							                    						     <option value="신협">신협</option>
							                    						     <option value="씨티은행">씨티은행</option>
							                    						     <option value="우체국은행">우체국은행</option>
							                    						     <option value="전북은행">전북은행</option>
							                    						     <option value="제주은행">제주은행</option>
							                    						     <option value="SC제일은행">SC제일은행</option>
							                    						     <option value="HSBC은행">HSBC은행</option>
							                    						     <option value="도이치은행">도이치은행</option>
							                    	               </select>
							                    	               <label class="fix_width10"></label>
							                    	               <label class="control-label tar"> 계좌번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width150" name="ba_num" maxlength="30" value="$param[ba_num]">
							                    	               <hr class="hr_bd3">
							                    	           	    <label class="control-label fix_width120 tar">참고사항</label><label class="fix_width20 fs14 tac">:</label>
							                    	           	    <textarea class="bs_noti" maxlength="255" name="add_items">$param[add_items]</textarea>
							                    	           </div>
                                                                <!-- TAB UI -->
							                    	           <ul class="nav nav-tabs  mt25">
							                    	               <li class="active">
							                    	                   <a href="#tab1" data-toggle="tab"> 매입업체 로그인 관리 </a> 
							                    	               </li>
							                    	           </ul>
							                    	           <!-- TAB UI -->
                                                                <div class="form-group"> 
							                    	               <div class="table-body">
                                                                        <ul class="table_top">
                                    							      	               <li class="sel">
                                    					                      	            <label class="fs14 fwb">담당자</label>
                                    							      	               </li>
                                    							      	               <li class="sel tar">
                                    					                      	             <label class="btn btn_pu fix_width102 bgreen fs13" onclick="popMngLayer('Y'); return false;">add</label>
                                    							      	               </li>

                                                            <div style="display:none;" id="add_extnl_member">
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>사업자정보 - 담당자</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-danger fa fa-times"></button>
														 	      </dt>
														 	</dl>  

														 	<div class="pop-base">
														 	  	  <div class="pop-content">
														 	  	    <div class="form-group">
														 	  	        <label class="control-label fix_width75 tar">아이디</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input id="mem_id" name="mem_id" type="text" class="input_co2 fix_width100" maxlength="50">
    														 	        <button id="check_id" onclick="checkId()" type="button" class="btn btn-xs btn-info"><i class="fa fa-check-square"></i> 아이디중복체크</button>
    														 	        <br />
    														 	        
    														 	        <label class="control-label fix_width75 tar">접속코드</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input type="text" class="input_co2 fix_width100" maxlength="255" name="mem_passwd" id="mem_passwd">    														 	        
    														 	        <br />
    														 	        
    														 	        <label class="control-label fix_width75 tar">이름</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input type="text" class="input_co2 fix_width75" name="mem_name" id="mem_name" maxlength="30">
    														 	        <label class="control-label fix_width75 tar">직책</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input type="text" class="input_co2 fix_width75" name="mem_job" id="mem_job" maxlength="30">
    														 	        <label class="control-label fix_width75 tar">담당업무</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input type="text" class="input_co2 fix_width75" name="mem_task" id="mem_task" maxlength="20">
    														 	        <br />
    														 	        
    														 	        <label class="control-label fix_width75 tar">E-mail</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <input type="text" class="input_co2 fix_width75" name="mem_mail_top" id="mem_mail_top" maxlength="50"> @ <input type="text" name="mem_mail_btm" id="mem_mail_btm" class="input_co2 fix_width100" maxlength="50">
    														 	        <select onchange="changeMail(this.value)" id="mail_type" class="fix_width110">
    														 	            <option value="">직접입력</option>
    														 	            <option value="naver.com">naver.com</option>
    														 	            <option value="gmail.com">gmail.com</option>
    														 	            <option value="daum.net">daum.net</option>
    														 	            <option value="hanmail.net">hanmail.net</option>
    														 	            <option value="hotmail.com">hotmail.com</option>
    														 	            <option value="nate.com">nate.com</option>
    														 	        </select>
    														 	        <br />
    														 	        <label class="control-label fix_width75 tar">전화번호</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <select id="mem_tel_top" name="mem_tel_top" class="fix_width75">
    														 	            <option value="">선택</option>
    														 	            <option value="02">02</option>
    														 	            <option value="051">051</option>
    														 	            <option value="053">053</option>
    														 	            <option value="032">032</option>
    														 	            <option value="062">062</option>
    														 	            <option value="042">042</option>
    														 	            <option value="052">052</option>
    														 	            <option value="044">044</option>
    														 	            <option value="031">031</option>
    														 	            <option value="033">033</option>
    														 	            <option value="043">043</option>
    														 	            <option value="041">041</option>
    														 	            <option value="063">063</option>
    														 	            <option value="061">061</option>
    														 	            <option value="054">054</option>
    														 	            <option value="055">055</option>
    														 	            <option value="064">064</option>
    														 	        </select> -  <input id="mem_tel_mid" name="mem_tel_mid" type="text" class="input_co2 fix_width75" maxlength="4">-<input id="mem_tel_btm" name="mem_tel_btm" type="text" class="input_co2 fix_width75" maxlength="4">
    														 	        <br />
    														 	         <label class="control-label fix_width75 tar">핸드폰</label><label class="fix_width10 fs14 tac">:</label>
    														 	        <select name="mem_cel_top" id="mem_cel_top" name="mem_cel_top" class="fix_width75">
    														 	            <option value="">선택</option>
    														 	            <option value="010">010</option>
    														 	            <option value="011">011</option>
    														 	            <option value="016">016</option>
    														 	            <option value="018">018</option>
    														 	            <option value="019">019</option>
    														 	        </select> -  <input name="mem_cel_mid" id="mem_cel_mid" type="text" class="input_co2 fix_width75" maxlength="4">-<input name="mem_cel_btm" id="mem_cel_btm" type="text" class="input_co2 fix_width75" maxlength="4">
    														 	        <hr class="hr_bd2">
    														 	        <p class="tac mt15">														 	  	  	 		        													 														 	  	  	 		        													 
                                                                          	<button onclick="saveExtnlMember();" type="button" class="btn btn-sm btn-success">저장</button>
                                                                            <label class="fix_width5"> </label>
                                                                            <button onclick="delExtnlMember();" type="button" id="del_member" class="btn btn-sm btn-danger">삭제</button>
                                                                            <label class="fix_width5"> </label>
                                                                            <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">확인</button>
                                                                        </p>
														 	  	    </div>												 	
														 	  	  </div>
														 	</div>
														 	 
                                   </div>



                                                                        </ul>
                                                                        <div class="table_basic">
                                    					                      		<table class="fix_width100f">
                                                                                <thead>
                                    					                      				<tr>
                                    					                      					<th class="bm2px">담당자</th>
                                    					                      					<th class="bm2px">아이디</th>
                                    					                      					<th class="bm2px">접속코드</th>
                                    					                      					<th class="bm2px">전화번호</th>
                                    					                      					<th class="bm2px">핸드폰</th>
                                    					                      					<th class="bm2px">E-mail</th>
                                    					                      					<th class="bm2px">관리</th>
                                    					                      				</tr>
                                    					                      			 </thead>
                                    					                      			 <tbody id="extnl_member">	
                                                                                         $param[extnl_member]
                                    					                      			 </tbody>
                                    					                      		</table>
                                                        
                                                                        </div>
                       	      </div>
							                    	           </div>
							                    	           

							                    	           <hr class="hr_bd3">
							                    	           <div class="form-group ofh mt25 tac">
							                    	               <label class="btn btn_md fix_width102 co_blue fs13" onclick="editEtprsInfo('$param[etprs_seqno]')"> 적용</label>
							                    	           </div>
														 	</div>
														</div>

                       	      </div>  
                       	      <!-- View 팝업창 -->
					                   

EDITHTML;

    return $html;

}

//매입 품목 리스트 
function getPurPrdtList($param) {

    $html = <<<PAPERHTML
                                                                                <div class="tab-pane active" id="buy_tab1"> <!-- 종이 tab 01 -->
														 	    	      	          <table class="table fix_width100f">
					                      			                              <thead id="supply_thead">
                                                                                    $param[prdt_thead]
					                      			                              </thead>
					                      			                              <tbody id="supply_tbody">	
                                                                                     $param[prdt_tbody]
					                      			                              </tbody>
														 	    	      	      </table>
    <p class="p_num_p fs12">
Showing 1 to 5 of 30 entries
        <select name="list_set" class="fix_width55" onchange="showPageSetting(this.value);">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
        </select>
    </p>
                                                                                <div class="tac clear" id="supply_page">
                                                                                </div>


                                                   	    	    </div>
PAPERHTML;

    return $html;
}

//매입 품목 후공정 리스트
function getAfterList($param) {

    $html = <<<AFTERHTML
                                                                <div class="tab-pane" id="buy_tab4"> <!-- 후공정 tab 04 -->
                                                   	    	    	
                                                   	    	       	<table class="table fix_width100f">
                                                   	    	       	    <thead>
                                                   	    	       	        <tr>
                                                   	    	       	            <th class="bm2px"><a href="#" class="blue_text01">브랜드 <i class="fa fa-sort"></i></a></th>
                                                   	    	       	            <th class="bm2px">후공정대분류</th>
                                                   	    	       	            <th class="bm2px">계열</th> 
                                                   	    	       	            <th class="bm2px"><a href="#" class="blue_text01">후공정명  <i class="fa fa-sort"></i></a></th>
                                                   	    	       	            <th class="bm2px">용도</th>
                                                   	    	       	            <th class="bm2px">상세</th>					                      					
                                                   	    	       	            <th class="bm2px">가로사이즈</th>
                                                   	    	       	            <th class="bm2px">세로사이즈</th>
                                                   	    	       	            <th class="bm2px">기준단위</th>
                                                   	    	       	            <th class="bm2px">조회</th>
                                                   	    	       	   </tr>
                                                   	    	       	    </thead>
                                                   	    	       	    <tbody>	
                                                   	    	       	        <tr>
					                                        					<td>건식R1000</td>
					                                        					<td>코팅</td>
					                                        					<td>46</td>
					                                        					<td>46 건식코팅</td>
					                                        					<td>건식기</td>
					                                        					<td>옵셋기 후공정</td>					                                        					
					                                        					<td>1,000</td>
					                                        					<td>788</td>					                      					
					                                        					<td>판</td>
					                                        					<td><button type="button" class="bgreen btn_pu btn fix_height20 fix_width75" onclick="location='매입업체리스트-view-후공정-edit.html'">view</button></td>
					                                        				</tr>
					                                        				<tr class="cellbg">
					                                        					<td>아발론</td>
					                                        					<td>CTP</td>
					                                        					<td>46</td>
					                                        					<td>46 건식코팅</td>
					                                        					<td>건식기</td>
					                                        					<td>옵셋기 후공정</td>					                                        					
					                                        					<td>1,000</td>
					                                        					<td>788</td>					                      					
					                                        					<td>판</td>
					                                        					<td><button type="button" class="bgreen btn_pu btn fix_height20 fix_width75" onclick="location='매입업체리스트-view-후공정-edit.html'">view</button></td>
					                                        				</tr>
					                                        				<tr>
					                                        					<td>아발론</td>
					                                        					<td>CTP</td>
					                                        					<td>46</td>
					                                        					<td>46 건식코팅</td>
					                                        					<td>건식기</td>
					                                        					<td>옵셋기 후공정</td>					                                        					
					                                        					<td>1,000</td>
					                                        					<td>788</td>					                      					
					                                        					<td>판</td>
					                                        					<td><button type="button" class="bgreen btn_pu btn fix_height20 fix_width75" onclick="location='매입업체리스트-view-후공정-edit.html'">view</button></td>
					                                        				</tr>
					                                        				<tr class="cellbg">
					                                        					<td>아발론</td>
					                                        					<td>CTP</td>
					                                        					<td>46</td>
					                                        					<td>46 건식코팅</td>
					                                        					<td>건식기</td>
					                                        					<td>옵셋기 후공정</td>					                                        					
					                                        					<td>1,000</td>
					                                        					<td>788</td>					                      					
					                                        					<td>판</td>
					                                        					<td><button type="button" class="bgreen btn_pu btn fix_height20 fix_width75" onclick="location='매입업체리스트-view-후공정-edit.html'">view</button></td>
					                                        				</tr>
					                                        				<tr>
					                                        					<td>아발론</td>
					                                        					<td>CTP</td>
					                                        					<td>46</td>
					                                        					<td>46 건식코팅</td>
					                                        					<td>건식기</td>
					                                        					<td>옵셋기 후공정</td>					                                        					
					                                        					<td>1,000</td>
					                                        					<td>788</td>					                      					
					                                        					<td>판</td>
					                                        					<td><button type="button" class="bgreen btn_pu btn fix_height20 fix_width75" onclick="location='매입업체리스트-view-후공정-edit.html'">view</button></td>
					                                        				</tr>
					                                        				</tbody>
					                                        		</table>
                                                   	    	       	
                                                   	    	    </div>
                                                   	    	    



AFTERHTML;

    return $html;
}

//매입 업체 담당자 VIEW
function getEtprsMng($param) {


    $html = <<<MNGHTML

                                                        <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">매입업체 담당자</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" value="$param[name]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">부서</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" value="$param[depar]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">직책</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" value="$param[job]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" value="$param[tel_num]" disabled>
							                    	                <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">내선</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width75" value="$param[exten_num]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">핸드폰번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[cell_num]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" value="$param[mail]" disabled>
							                    	           </div>

MNGHTML;

    return $html;
}

//매입 업체 담당자 EDIT
function getEditEtprsMng($param) {

    $html = <<<MNGHTML
							                    	           <div class="form-group" id="add_etprs_mng_$param[idx]">
							                    	               <label class="control-label fix_width120 tar">매입업체 담당자</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" name="etprs_mng_name[]" value="$param[name]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">부서</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" name="etprs_depar[]" value="$param[depar]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">직책</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" name="etprs_job[]" value="$param[job]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" name="etprs_tel_num[]" value="$param[tel_num]">
							                    	                <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">내선</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width75" name="etprs_exten_num[]" value="$param[exten_num]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">핸드폰번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="etprs_cell_num[]" value="$param[cell_num]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" name="etprs_email[]" value="$param[mail]">
                                                                   </div>

MNGHTML;

    return $html;

}




//매입업체 회계 담당자 VIEW
function getAcctMng($param) {

    $html = <<<MNGHTML


							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">회계 담당자</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" value="$param[name]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">부서</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" value="$param[depar]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">직책</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" value="$param[job]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" value="$param[tel_num]" disabled>
							                    	                <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">내선</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width75" value="$param[exten_num]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">핸드폰번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[cell_num]" disabled>
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" value="$param[mail]" disabled>
							                    	           </div>
MNGHTML;

    return $html;
}


//매입업체 회계 담당자 EDIT
function getEditAcctMng($param) {

    $html = <<<MNGHTML

							                    	           <div class="form-group" id="add_acct_mng_$param[idx]">
							                    	               <label class="control-label fix_width120 tar">회계 담당자</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" name="accting_mng_name[]" value="$param[name]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">부서</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" name="accting_depar[]" value="$param[depar]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">직책</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width120" name="accting_job[]" value="$param[job]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width100" name="accting_tel_num[]" value="$param[tel_num]">
							                    	                <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width30 tar">내선</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width75" name="accting_exten[]" value="$param[exten_num]">
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">핸드폰번호</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" name="accting_cell_num[]" value="$param[cell_num]">
							                    	               <label class="fix_width28"> </label>
							                    	               <label class="control-label fix_width100 tar">E-Mail</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width200" name="accting_email[]" value="$param[mail]">
                                                                   </div>


MNGHTML;

    return $html;
}

//매입업체 - 종이
function getPaperView($param) {

    $html = <<<PAPERVIEWHTML
    
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>종이 조회</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button onclick="closeLayer('#prdt_view')" type="button" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">종이 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">							                    	            		 
							                    	            	   <label class="control-label fix_width150 tar">종이 대분류</label><label class="fix_width20 fs14 tac">:</label>
							                    	            	   <input type="text" class="input_co2 fix_width180" value="$param[sort]" disabled>							                    	            	   


				                                                        <label class="control-label fix_width120 tar">기존가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            	   <input type="text" class="input_co2 fix_width180" value="$param[basic_price]" disabled>							                    	            	   
							                    	            	   <br />							                    	            	   
				                                             <label class="control-label fix_width150 tar">종이명</label><label class="fix_width20 fs14 tac">:</label>
				                                             <input type="text" class="input_co2 fix_width180" value="$param[name]" disabled>

				                                                        <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
							                    	            	   <input type="text" class="input_co2 fix_width180" value="$param[pur_rate]" disabled>	
							                    	            	   <br />
							                    	            	   <label class="control-label fix_width150 tar">구분</label><label class="fix_width20 fs14 tac">:</label>
				                                             <input type="text" class="input_co2 fix_width180" value="$param[dvs]" disabled>

				                                                        <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
							                    	            	   <input type="text" class="input_co2 fix_width180" value="$param[pur_aplc_price]" disabled>	
							                    	            	   <br />
							                    	            	   <label class="control-label fix_width150 tar">색상</label><label class="fix_width20 fs14 tac">:</label>
				                                             <input type="text" class="input_co2 fix_width180" value="$param[color]" disabled>

				                                                        <label class="control-label fix_width120 tar">매입가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            	   <input type="text" class="input_co2 fix_width180" value="$param[pur_price]" disabled>	
							                    	            	   <br />
							                    	            	   <label class="control-label fix_width150 tar">평량</label><label class="fix_width20 fs14 tac">:</label>
				                                             <input type="text" class="input_co2 fix_width180" value="$param[basisweight]" disabled>
							                    	            	   <br />
							                    	                 <label class="control-label fix_width150 tar">계열</label><label class="fix_width20 fs14 tac"> : </label>
				                                             <input type="text" class="input_co2 fix_width180" value="$param[affil]" disabled>
				                                             <br />							                    	            	   				                                                  
								                                	     <label class="fix_width170"></label>
                                                       <label class="con_label">가로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       <input type="text" class="input_co2 fix_width100" value="$param[wid_size]" disabled> <span class="con_label">mm</span>
                                                       <label class="fix_width20"></label>   
                                                       <label class="con_label">세로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       <input type="text" class="input_co2 fix_width100" value="$param[vert_size]" disabled> <span class="con_label">mm</span>
								                                </div>
								                                
								                                <hr class="hr_bd2">
								                                
								                                <div class="form-group">
				                                                 <label class="control-label fix_width150 tar">기준단위</label><label class="fix_width20 fs14 tac"> : </label>
				                                                 <input type="text" class="input_co2 fix_width150" value="$param[crtr_unit]" disabled>
								                                </div>				                                

														 	  	  </div>
														 	 </div>
														 	 
														 	  <div class="pop-base tac">														 	  	   
														 	  	   <button onclick="closeLayer('#prdt_view')" type="button" class="btn  btn-primary fwb nanum"> 확인</button>
														 	  </div>
														 	  
														 	  <br />
														 

                       	      </div>  
PAPERVIEWHTML;

    return $html;




}

//매입업체 - 출력
function getOutputView($param) {

    $html = <<<OUTPUTVIEWHTML
    
	<dl>
														 	    <dt class="tit">
														 	    	  <h4>출력 조회</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" onclick="closeLayer('#prdt_view')" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">출력 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">
				                                                <label class="control-label fix_width150 tar">출력 대분류</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[top]" disabled>
                                                                <label class="control-label fix_width120 tar">기존가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[basic_price]" disabled>							    
				                                                <br />				                                                
				                                                <label class="control-label fix_width150 tar">출력명</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[name]" disabled>
                                                                <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_rate]" disabled>	
				                                              	<br />
				                                                <label class="control-label fix_width150 tar">출력판</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[board]" disabled>
                                                                <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_aplc_price]" disabled>	
				                                                <br />
				                                                <label class="control-label fix_width150 tar">계열</label><label class="fix_width20 fs14 tac"> : </label>
				                                             	<input type="text" class="input_co2 fix_width180" value="$param[affil]" disabled>
                                                                <label class="control-label fix_width120 tar">판매가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_price]" disabled>	
				                                             		<br />							                    	            	   				                                                  
								                                	     		<label class="fix_width170"></label>
                                                       		<label class="con_label">가로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       		<input type="text" class="input_co2 fix_width100" value="$param[wid_size]" disabled> <span class="con_label">mm</span>
                                                       		<label class="fix_width20"></label>   
                                                       		<label class="con_label">세로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       		<input type="text" class="input_co2 fix_width100" value="$param[vert_size]" disabled> <span class="con_label">mm</span>				                                              	
							                    	            </div>				                                
								                                
								                                <hr class="hr_bd2">
								                                
								                                <div class="form-group">
				                                                 <br />
				                                                 <label class="control-label fix_width150 tar">기준단위</label><label class="fix_width20 fs14 tac"> : </label>
				                                                 <input type="text" class="input_co2 fix_width150" value="$param[crtr_unit]" disabled>
								                                </div>                      								                                

														 	  	  </div>
														 	 </div>
														 	 
														 	  <div class="pop-base tac">
														 	  	   <button onclick="closeLayer('#prdt_view')" type="button" class="btn  btn-primary fwb nanum"> 확인</button>
														 	  </div>
														 	  
														 	  <br />
														 

OUTPUTVIEWHTML;

    return $html;

}

//매입업체 - 인쇄
function getPrintView($param) {

    $html = <<<PRINTVIEWHTML
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>인쇄 조회</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button onclick="closeLayer('#prdt_view')" type="button" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">인쇄 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">
				                                                <label class="control-label fix_width150 tar">인쇄 대분류</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[top]" disabled>
                                                                <label class="control-label fix_width120 tar">기존가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[basic_price]" disabled>	
				                                                <br />				                                                
				                                                <label class="control-label fix_width150 tar">인쇄명</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[name]" disabled>				                                                
                                                                <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_rate]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width150 tar">인쇄색도</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[tmpt]" disabled>
                                                                <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_aplc_price]" disabled>
				                                                <br />
							                    	            <label class="control-label fix_width150 tar">계열</label><label class="fix_width20 fs14 tac"> : </label>
				                                             	<input type="text" class="input_co2 fix_width180" value="$param[affil]" disabled>
                                                                <label class="control-label fix_width120 tar">판매가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_price]" disabled>
				                                             		<br />							                    	            	   				                                                  
								                                	     		<label class="fix_width170"></label>
                                                       		<label class="con_label">가로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       		<input type="text" class="input_co2 fix_width100" value="$param[wid_size]" disabled> <span class="con_label">mm</span>
                                                       		<label class="fix_width20"></label>   
                                                       		<label class="con_label">세로사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                                       		<input type="text" class="input_co2 fix_width100" value="$param[vert_size]" disabled> <span class="con_label">mm</span>
								                                </div>
								                                
								                                <hr class="hr_bd2">
								                                
								                                <div class="form-group">
				                                                 <label class="control-label fix_width150 tar">기준단위</label><label class="fix_width20 fs14 tac"> : </label>
				                                                 <input type="text" class="input_co2 fix_width150" value="$param[crtr_unit]" disabled>
								                                </div>							                                

														 	  	  </div>
														 	 </div>
														 	 
														 	  <div class="pop-base tac">
														 	  	   <button type="button" onclick="closeLayer('#prdt_view')" class="btn  btn-primary fwb nanum"> 확인</button>
														 	  </div>
														 	  
														 	  <br />
	
    
PRINTVIEWHTML;

    return $html;

}

//매입업체 - 후공정
function getAfterView($param) {

    $html = <<<AFTERVIEWHTML

	<dl>
														 	    <dt class="tit">
														 	    	  <h4>후공정 조회</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button onclick="closeLayer('#prdt_view')" type="button" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">후공정 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">
				                                                <label class="control-label fix_width150 tar">후공정명</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[name]" disabled>
                                                                <label class="control-label fix_width120 tar">기존가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[basic_price]" disabled>	
				                                                <br />				                                                
				                                                <label class="control-label fix_width150 tar">Depth1</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[depth1]" disabled>
                                                                <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_rate]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width150 tar">Depth2</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[depth2]" disabled>
                                                                <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_aplc_price]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width150 tar">Depth3</label><label class="fix_width20 fs14 tac"> : </label>
				                                             	<input type="text" class="input_co2 fix_width180" value="$param[depth3]" disabled>
                                                                <label class="control-label fix_width120 tar">판매가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_price]" disabled>
								                                </div>				                                
								                                <hr class="hr_bd2">
								                                <div class="form-group">
				                                                 <label class="control-label fix_width150 tar">단위</label><label class="fix_width20 fs14 tac"> : </label>
				                                                 <input type="text" class="input_co2 fix_width180" value="$param[crtr_unit]" disabled>
                                                                </div>
														 	  	  </div>
														 	 </div>
														 	 
														 	  <div class="pop-base tac">
														 	  	   <button type="button" onclick="closeLayer('#prdt_view')" class="btn  btn-primary fwb nanum"> 확인</button>
														 	  </div>
														 	  
														 	  <br />
AFTERVIEWHTML;

    return $html;

}

//매입업체 - 옵션
function getOptView($param) {

    $html = <<<OPTVIEWHTML
    
	<dl>
														 	    <dt class="tit">
														 	    	  <h4>옵션 조회</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" onclick="closeLayer('#prdt_view')" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[manu]" disabled>
							                    	               <br />
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">옵션 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">
				                                                <label class="control-label fix_width150 tar">옵션명</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[name]" disabled>
                                                                <label class="control-label fix_width120 tar">기존가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[basic_price]" disabled>	
				                                                <br />				                                                
				                                                <label class="control-label fix_width150 tar">Depth1</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[depth1]" disabled>
                                                                <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_rate]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width150 tar">Depth2</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" value="$param[depth2]" disabled>
                                                                <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_aplc_price]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width150 tar">Depth3</label><label class="fix_width20 fs14 tac"> : </label>
				                                             	<input type="text" class="input_co2 fix_width180" value="$param[depth3]" disabled>
                                                                <label class="control-label fix_width120 tar">판매가격</label><label class="fix_width20 fs14 tac">:</label>
							                    	            <input type="text" class="input_co2 fix_width180" value="$param[pur_price]" disabled>
                                                                </div>
                                                                <hr class="hr_bd2">
								                                <div class="form-group">
                                                                <label class="control-label fix_width150 tar">단위</label><label class="fix_width20 fs14 tac"> : </label>
				                                                 <input type="text" class="input_co2 fix_width150" value="$param[crtr_unit]" disabled>
								                                </div>	
														 	  	  </div>
														 	 </div>
														 	 
														 	  <div class="pop-base tac">
														 	  	   <button type="button" onclick="closeLayer('#prdt_view')" class="btn  btn-primary fwb nanum"> 확인</button>
														 	  </div>
														 	  
														 	  <br />
														 

OPTVIEWHTML;

    return $html;

}










?>
