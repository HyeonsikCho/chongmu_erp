<?
//상태변경관리
function statusMng($list, $paging) {

    $html = <<<HTML

														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>상태변경관리</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="hideRegiPopup();"></button>
														 	    </dt>
														 	</dl>
														 	 <div class="pop-base">
														 	  	  <div class="pop-content">
							                    	            <div class="form-group">				                                                
                             <div class="table-body">
                                   <ul class="table_top">
							      	                  <li class="sel">
					                      	        <select class="fix_width200" id="pop_order_state" onchange="changeStatusOption();">
					                      	            <option value="">상태(전체)</option>
					                      	            <option value="320">중</option>
					                      	            <option value="330">교정</option>
					                      	            <option value="340">보류</option>
					                      	        </select>
					                      		    </li>
					                      		    <li class="sel tar">
					                      	            <label for="pop_search_txt" class="con_label">Search(인쇄제목) : <input type="text" class="search_btn fix_width120" id="pop_search_txt" onkeyup="searchKey(event);"><button type="button" class="btn btn-sm btn-info fa fa-search" onclick="searchText();"></button></label>
					                      		    </li>
                                   </ul>
					                      		<table class="fix_width100f">
                                                   <thead>
					                      				<tr>
					                      					<th class="bm2px">주문번호</th>
					                      					<th class="bm2px">회원명</th>
					                      					<th class="bm2px">인쇄제목</th>
					                      					<th class="bm2px">소분류</th>
					                      					<th class="bm2px">접수자</th>
					                      					<th class="bm2px">상태</th>
					                      					<th class="bm2px">관리</th>
					                      				</tr>
					                      			 </thead>
					                      			 <tbody id="pop_list">	
                                                         $list
					                      			 </tbody>
					                      		</table>
					                      		<p class="fs12" style="position: relative;padding: 0px;height: 0px;">
					                      			  Showing 1 to 5 of 20 entries
					                                  <select name="list_set" class="fix_width55" onchange="showPageSetting(this.value, 'pop');">
					                      	            <option>5</option>
					                      	            <option>10</option>
					                      	            <option>20</option>
					                              	    <option selected="selected">30</option>
					                      	          </select>
					                      		</p>
										           <div class="tac clear" id="pop_page">
                                                     $paging
										           </div>
					                  </div>
                       	      </div>
							                    	            </div>				                                

														 	  	  </div>
														 	 </div>
														 	  	      <p class="tac">
														 	  	          <button type="button" class="btn btn-sm btn-primary" onclick="hideRegiPopup();">닫기</button>
														 	  	      </p> 
                                                                      </ br>

														 	 </div>
														 	  <br />

HTML;

    return $html;
}

//접수창 팝업
function receiptPopup($param) {

    $html = <<<HTML
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>낱장형 접수창</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="hideReceiptPopup('$param[seqno]');"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 
														 	 <div class="pop-base">
														 	  	  <div class="pop-content">
							                    	           <div class="form-group">			
							                    	            	
							                    	            	<label class="control-label fix_width75 tar">주문번호</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">$param[order_num]</label> 
							                    	            	<br />
							                    	            	<label class="control-label fix_width75 tar">회원이름</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">$param[member_name]($param[office_nick])</label>
							                    	            	<br />
							                    	            	<label class="control-label fix_width75 tar">주문요약</label>
							                    	            	<br />							                    	            	
							                    	            	<label class="control-label fix_width44 tar"> </label><label class="control-label fix_width75 tar">인쇄물제목</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[title]</label>
							                    	            	<br />							                    	            	
							                    	            	<label class="control-label fix_width20 tar"> </label><label class="fix_width20 fs14 tac"> </label>   <label class="control-label fix_width75 tar">상품명</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[cate_name]</label>
							                    	            	<br />							                    	            	
							                    	            	<label class="control-label fix_width20 tar"> </label><label class="fix_width20 fs14 tac"> </label>   <label class="control-label fix_width75 tar">수량</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[amt]$param[amt_unit_dvs]</label>
							                    	            	                                               

                       	                                <div class="table-body">
                                                              <div class="table_basic">
					                                                		<table class="fix_width100f">
                                                                             <thead>
					                                                				<tr>
					                                                					<th class="bm2px"></th>
					                                                					<th class="bm2px">주문내용</th>
					                                                					<th class="bm2px">공정관리</th>
					                                                				</tr>
					                                                			 </thead>
					                                                			 <tbody>	
					                                                				<tr>
					                                                					<td class="fwb">종이</td>
					                                                					<td>$param[order_detail]</td>
					                                                					<td></td>
					                                                				</tr>
					                                                				<tr>
					                                                					<td class="fwb">사이즈</td>
					                                                					<td>$param[stan_name]</td>
					                                                					<td></td>
					                                                				</tr>
					                                                				<tr>
					                                                					<td class="fwb">인쇄도수</td>
					                                                					<td>$param[print_tmpt_name]</td>
					                                                					<td></td>
					                                                				</tr>
                                                                                    <tbody id="after_info">
					                      				                            $param[after_html]
                                                                                    </tbody>
					                                                				<tr>
					                                                					<td class="fwb">입출고</td>
					                                                					<td class="fwb">
					                                                						<label class="form-radio form-normal"><input type="radio" name="de-blk" $param[stor_release_y]>사용</label>
					                                                						<label class="fix_width15"></label>   
					                                                						<label class="form-radio"><input type="radio" name="de-blk" $param[stor_release_n]>사용안함</label>
					                                                					</td>
					                                                					<td></td>
					                                                				</tr>	
                                                                                    <!--                 
                                                                                    <tr>       
                                                                                    <td class="fwb">배송</td>
					                                                					<td>택배</td>
					                                                					<td></td>
					                                                				</tr>
                                                                                    -->
					                                                			 </tbody>
					                                                		</table>
                                                              </div>
                       	                                </div>
                       	                                
                       	                                <label class="control-label fix_width75 tar">고객메모</label><label class="fix_width20 fs14 tac">:</label>
							                    	           	    <textarea class="bs_noti2" disabled style="width: 384px;">$param[memo]</textarea>
							                    	           	    <br />							                    	           	    							                    	           	    
                                                                    $param[order_file_html]
							                    	           	    <label class="control-label fix_width75 tar">건수</label><label class="fix_width20 fs14 tac">:</label>	
							                    	           	    <label class="control-label">$param[count]건</label> 
							                    	           	    <br />
							                    	           	    <label class="control-label fix_width75 tar blue_text01">작업파일</label><label class="fix_width20 fs14 tac">:</label>	
							                    	           	    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
											                 	     <input id="uploadFile" class="disableInputField" placeholder="인쇄작업파일" disabled="disabled" />
                                                    
											                 	     <label class="fileUpload">
											                 	         <input id="uploadBtn" type="file" class="upload" />
											                 	         <span class="btn btn-sm btn-info fa fa-folder-open">찾아보기</span>
											                 	     </label>
											                 	     <script type="text/javascript">  
											                 	          document.getElementById("uploadBtn").onchange = function () {
											                 	          document.getElementById("uploadFile").value = this.value;
											                 	            };
											                 	     </script> 
											                 	     <br />
											                 	     <label class="control-label fix_width75 tar">배송정보</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">택배</label> 
											                 	     <br />
											                 	     <label class="control-label fix_width75 tar"> </label><label class="fix_width20 fs14 tac"> </label>	<label class="control-label">$param[order_dlvr]</label> 
                                                        <br />
                                                        <div style="margin-left:75px;width:410px;" class="process_view_box7">  
                                                        $param[opt_name]
                                  	  									</div>
				                                                
							                    	            </div>				                                
														 	  	  </div>
														 	 </div>
														 	  	<div class="form-group">			
														 	  	      <p class="tac mt15">
														 	  	          <button type="button" class="btn btn-sm btn-warning" onclick="changeStatus('$param[seqno]', '340', 'Y');">보류</button>
														 	  	          <label class="fix_width140"> </label>
														 	  	          <button type="button" class="btn btn-sm btn-success" onclick="getReceipt('$param[seqno]');">접수</button>
														 	  	          <button type="button" class="btn btn-sm btn-primary" onclick="hideReceiptPopup('$param[seqno]');">닫기</button>
														 	  	          <label class="fix_width140"> </label>
														 	  	          
														 	  	          <button type="button" class="btn btn-sm btn-danger" onclick="delOrder('$param[seqno]');">주문삭제</button>
														 	  	      </p> 
														 	 </div>
														 	  <br />
														 
HTML;

    return $html;
}

//접수창 후공정 팝업
function receiptAfterPopup($param) {

    $html = <<<HTML
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>생산지시서 - 후공정</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="hideAddAfterPopup();"></button>
														 	    </dt>
														 	</dl>
														 	 
														 	 
														 	 <div class="pop-base">
														 	  	  <div class="pop-content">
							                    	           <div class="form-group">			
							                    	           	<!--
							                    	            	  <div style="margin-left:75px;width:410px;" class="process_view_box7">  
                                                        $param[opt_name]
                                  	  									</div>

							                    	            	<label class="control-label fix_width75 tar">주문번호</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">$param[order_num]</label> 
							                    	            	<br />
							                    	            	<label class="control-label fix_width75 tar">회원이름</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">$param[member_name]($param[office_nick])</label>
							                    	            	<hr class="hr_bd3_b">
							                    	            	<label class="control-label fix_width75 tar">주문요약</label>
							                    	            	<br />
							                    	            	<label class="control-label fix_width44 tar"> </label><label class="control-label fix_width75 tar">인쇄물제목</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[title]</label>
							                    	            	<br />
							                    	            	<label class="control-label fix_width20 tar"> </label><label class="fix_width20 fs14 tac"> </label>   <label class="control-label fix_width75 tar">상품명</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[cate_name]</label>
							                    	            	<br />
							                    	            	<label class="control-label fix_width20 tar"> </label><label class="fix_width20 fs14 tac"> </label>   <label class="control-label fix_width75 tar">종이</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[order_detail]</label>
							                    	            	<br />
							                    	            	<label class="control-label fix_width20 tar"> </label><label class="fix_width20 fs14 tac"> </label>   <label class="control-label fix_width75 tar">인쇄도수</label><label class="fix_width20 fs14 tac">:</label><label class="control-label">$param[print_tmpt_name]</label>
							                    	            	<br /><br />
											                 	     
											                 	     <label class="control-label fix_width75 tar">배송정보</label><label class="fix_width20 fs14 tac">:</label>	<label class="control-label">택배</label> 
											                 	     <br />
											                 	     <label class="control-label fix_width75 tar"> </label><label class="fix_width20 fs14 tac"> </label>	<label class="control-label">서울 중구 을지로 15길 6-6 301호 영남자기 인사과</label> 
											                 	     <br /><br />
                                                                     -->
											                 	     <label class="control-label fix_width75 tar blue_text01">작업파일</label><label class="fix_width20 fs14 tac">:</label>	
							                    	           	    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
											                 	     <input id="upload_path" class="disableInputField" placeholder="후공정작업파일" disabled="disabled" />
                                                    
											                 	     <label class="fileUpload">
											                 	         <input id="upload_file" type="file" class="upload" onchange="fileSearchBtn(this.value);"/>
											                 	         <span class="btn btn-sm btn-info fa fa-folder-open">찾아보기</span>
											                 	     </label>
											                 	     <br />
											                 	       <label class="control-label fix_width75 tar">발주제목</label><label class="fix_width20 fs14 tac">:</label>	
                                                                       <label class="control-label">$param[title]</label>
							                    	           	    <br />
							                    	           	    <label class="control-label fix_width75 tar">후공정명</label><label class="fix_width20 fs14 tac">:</label>	
                                                                    <label class="control-label">$param[after_name]</label>
							                    	           	    <br />
							                    	           	    <label class="control-label fix_width75 tar blue_text01">수주처</label><label class="fix_width20 fs14 tac">:</label>	
                                                                    <select class="fix_width140" id="extnl_etprs_seqno">
                                                                      $param[etprs_html]
							                    	           	    </select>
							                    	           	    <br />
							                    	           	    <label class="control-label fix_width75 tar">수량</label><label class="fix_width20 fs14 tac">:</label>	
                                                                    <label class="control-label">$param[amt]$param[amt_unit_dvs]</label>
							                    	           	    <br />
                       	                                <label class="control-label fix_width75 tar blue_text01">메모</label><label class="fix_width20 fs14 tac">:</label>
							                    	           	    <textarea class="bs_noti2" style="width:269px;" id="memo"></textarea>
							                    	           	    <br />	
							                    	           	    <label class="control-label fix_width75 tar blue_text01">발주유형</label><label class="fix_width20 fs14 tac">:</label>							                    	           	    
							                    	           	    <select class="fix_width140" id="op_typ">
							                    	           	        <option value="전화발주">전화발주</option>
							                    	           	        <option value="팩스발주">팩스발주</option>
							                    	           	        <option value="이메일발주">이메일발주</option>
							                    	           	    </select>
							                    	           	    <input id="op_typ_detail" type="text" class="input_co2 fix_width140">
							                    	           	    <input id="order_common_seqno" type="hidden" class="fix_width140" value="$param[order_common_seqno]">
							                    	           	    <input id="after_seqno" type="hidden" class="fix_width140" value="$param[after_seqno]">
							                    	           	    <input id="title" type="hidden" class="fix_width140" value="$param[title]">
							                    	           	    <input id="after_name" type="hidden" class="fix_width140" value="$param[after_name]">
							                    	           	    <input id="amt" type="hidden" class="fix_width140" value="$param[amt]">
							                    	           	    <input id="amt_unit_dvs" type="hidden" class="fix_width140" value="$param[amt_unit_dvs]">
							                    	           	    <input id="seq" type="hidden" class="fix_width140" value="$param[seq]">

							                    	            </div>				                                
														 	  	  </div>
														 	 </div>
														 
	
														 	  	<div class="form-group">			
														 	  	      <p class="tac mt15">
														 	  	          <button type="button" class="btn btn-sm btn-success" onclick="saveAfterOp();">저장</button>
														 	  	          <button type="button" class="btn btn-sm btn-primary" onclick="hideAddAfterPopup();">닫기</button>
														 	  	      </p> 
														 	 </div>
														 	  <br />
														 
HTML;

    return $html;
}
?>
