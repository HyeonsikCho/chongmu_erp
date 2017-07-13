<?
/**
 * @brief 문의 관리 html 생성
 * @param $param = 
 * @return html
 */
function makeInquireContHtml($param) {

    $html = <<<html
            <!-- 문의내용 VIEW TAB -->
								<ul class="tab_box mt25">
						       <li><a class="box">문의관리</a></li>
								</ul>
					   <form>
						 <div class="tab_box_con">			 	
                       <fieldset>
                       	  	<legend> 문의내용 </legend>	
                       	  	
                       	  	<div class="form-group">
                       	          <label class="control-label fix_width150 tar">문의제목 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[title]</label>
								  <br />
								  <label class="control-label fix_width150 tar">문의유형 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[inq_typ]</label>
								  <br />
								  <label class="control-label fix_width150 tar">회원명 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[office_nick]($param[member_name])</label>
								  <br />
								  <label class="control-label fix_width150 tar">연락처 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[tel_num]</label>
								  <br />
								  <label class="control-label fix_width150 tar">휴대전화 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[cell_num]</label>
								  <br />
								  <label class="control-label fix_width150 tar">이메일 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[mail]</label>
								  <br />
								  <label class="control-label fix_width150 tar">첨부파일 </label><label class="fix_width20 fs14 tac">:</label>
                                  $param[inq_file_html]
								  <br />
								  <label class="control-label fix_width150 tar">문의내용 </label><label class="fix_width20 fs14 tac">:</label>
								  <textarea class="bs_noti3 input_co2_dis" disabled="disabled">$param[cont]</textarea>
								  <br />
                       	  	</div>
                       </fieldset>						 	

                       <fieldset class="mt25">
                       	      <legend> 답변내용 </legend>	   
                       	      
                       	      <div class="form-group lh35">
                       	          <label class="control-label fix_width150 tar">답변자 </label><label class="fix_width20 fs14 tac">:</label>
								  <label class="control-label cp">$param[name]</label>
								  <br />
								  <label class="control-label fix_width150 tar">답변내용 </label><label class="fix_width20 fs14 tac">:</label>
								  <textarea class="bs_noti3" id="reply_cont">$param[reply_cont]</textarea>
								  <br />
	            				  <label class="control-label fix_width150 tar">파일첨부</label><label class="fix_width20 fs14 tac">:</label>
						          <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
						          <input id="upload_path" class="disableInputField" style="margin-top: 10px;" placeholder="Choose File" disabled="disabled" value="$param[reply_file]"/>
						          <label class="fileUpload">
							      <input id="upload_file" type="file" class="upload" onchange="fileSearchBtn(this.value);"/>
							      <span class="btn btn-sm btn-info fa" id="file_search">파일찾기</span>
					    	      </label>
                                  <!--  $param[reply_file_html] -->
                       	      </div>
							  <p class="btn-lg red_btn">
                                 <a style="cursor: pointer;" id="reply_btn" onclick="regiReply.exec('$param[oto_inq_seqno]');">등록한 내용으로 답변</a>					
                              </p>
                       </fieldset>
					   
					   </div>
					   </form>            
html;

    return $html;
}
?>
