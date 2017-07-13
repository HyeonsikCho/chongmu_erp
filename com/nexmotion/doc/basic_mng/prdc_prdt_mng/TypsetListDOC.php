<?
//조판 파일 html
function getFileHtml($param) {

    $html = <<<VIEWHTML

                        <div id="file_area">
                        <label class="fix_width100"> </label>
                        <label class="control-label cp blue_text01">$param[file_name]</label>
                        <br /> 
                        </div>

VIEWHTML;

    return $html;

}


//생산 조판 html
function getPrdcTypsetView($param) {

    $html = <<<VIEWHTML

    <form name="typset_form" id="typset_form" method="post">
									  <dl>
										  <dt class="tit">
										  <h4>생산조판정보</h4>
										  </dt>
										  <dt class="cls">
											  <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
										  </dt>
									  </dl>
									  <div class="pop-base">
										  <div class="pop-content">

											  <div class="form-group">
                                                  <label class="control-label fix_width83 tar">카테고리</label><label class="fix_width10 fs14 tac">:</label>
				                                  <select id="cate_top" onchange="cateSelect.pop('top', this.value);" class="fix_width150">
                                                    $param[cate_top]
				                                  </select>  
				                                  <select id="cate_mid" onchange="cateSelect.pop('mid', this.value);" class="fix_width150">
                                                    $param[cate_mid]
				                                  </select> 
				                                  <select id="cate_bot" name="cate_bot" class="fix_width150">
                                                    $param[cate_bot]
				                                  </select>
												  <br />

												  <label class="control-label fix_width83 tar">조판명</label><label class="fix_width10 fs14 tac">:</label>
												  <input type="text" class="input_co2 fix_width305" id="pop_typset_name" name="pop_typset_name" value="$param[name]">
												  <br />

												  <label class="control-label fix_width83 tar">계열</label><label class="fix_width10 fs14 tac">:</label>
												  <select id="affil" name="affil" class="fix_width150">
													  <option value="46">46계열</option>
													  <option value="국">국계열</option>
													  <option value="별">별계열</option>
												  </select>
												  <br />
												  <label class="control-label fix_width83 tar">절수</label><label class="fix_width10 fs14 tac">:</label>
												  <select id="subpaper" name="subpaper" class="fix_width150">
													  <option value="2절">2절</option>
													  <option value="4절">4절</option>
													  <option value="8절">8절</option>
													  <option value="16절">16절</option>
													  <option value="32절">32절</option>
												  </select>
												  <br />
												  <label class="control-label fix_width83 tar">판형파일</label><label class="fix_width10 fs14 tac">:</label>
												  <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly />
												  <label class="fileUpload">
													  <input id="upload_btn" name="upload_btn" type="file" class="upload"/>
													  <span class="btn btn-sm btn-info fa fa-folder-open">파일찾기</span>
												  </label>
												  <script type="text/javascript">
													  document.getElementById("upload_btn").onchange = function () {
														  document.getElementById("upload_file").value = this.value;
													  };
												  </script>
												  <br />
                                                  $param[file_html]
												  <label class="control-label fix_width83 tar">사이즈</label><label class="fix_width10 fs14 tac">:</label>
												  <label class="control-label fix_width83 tar">가로사이즈</label><label class="fix_width10 fs14 tac">:</label>

				                                    <input type="text" class="input_co2 fix_width100"  id="wid_size" name="wid_size" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' maxlength="21" value="$param[wid_size]">  mm
												  <label class="control-label fix_width83 tar">세로사이즈</label><label class="fix_width10 fs14 tac">:</label>
				                                    <input type="text" class="input_co2 fix_width100" id="vert_size" name="vert_size" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' maxlength="21" value="$param[vert_size]">mm
												  <br />
                   	                     	 	  <label class="control-label fix_width83 tar">홍각기/돈땡</label><label class="fix_width10 fs14 tac">:</label>
                                                  <label class="control-label cp"><input type="radio" class="radio_box" name="honggak_yn" value="Y" checked>홍각기</label>  
                                                  <label class=" fix_width05"></label>
                                                  <label class="control-label cp"><input type="radio" class="radio_box" name="honggak_yn" value="N">돈땡</label>
                                                  <br />                                 
                       	                     	  <label class="control-label fix_width83 tar">용도/배송판</label><label class="fix_width10 fs14 tac">:</label>
                                           	  	  <select class="fix_width120" id="purp" name="purp">
       	                                            <option value="">용도(전체)</option>
       	                                            <option value="일반옵셋">일반옵셋</option>
                                          	  	  </select>
                                        	  	  <label class=" fix_width10 tac">/</label>
                                               	  <select class="fix_width120" id="dlvrboard" name="dlvrboard">
					                      	        <option value="">배송판(전체)</option>
					                      	        <option value="서울판">서울판</option>
                                                  </select>
                                                  <br />
                  	                     	 	  <label class="control-label fix_width83 tar">입고처</label><label class="fix_width10 fs14 tac">:</label>
                                           	  	  <select class="fix_width120" onchange="loadExtnlEtprs(this.value, 'extnl_etprs_seqno');" id="pur_prdt">
                                                    <option value="">품목(전체)</option>
                                                    <option value="종이">종이</option>
                                                    <option value="출력">출력</option>
                                                    <option value="인쇄">인쇄</option>
                                                    <option value="후공정">후공정</option>
                                           	  	  </select>
                                                  <select class="fix_width150" id="extnl_etprs_seqno" name="extnl_etprs_seqno">
					                      	        <option value="">업체(전체)</option>
                                                    $param[manu_name]
                                                  </select>
                                                  <br />

												  <label class="control-label fix_width83 tar">판설명</label><label class="fix_width10 fs14 tac">:</label>
												  <textarea id="dscr" name="dscr" class="bs_noti2"></textarea>
											  </div>
											  <hr class="hr_bd3">

											  <p class="tac mt15">
												  <button type="button" id="save_typset" onclick="saveTypset('$param[add_yn]'); return false;" class="btn btn-sm btn-success">저장</button>
												  <label class="fix_width5"> </label>
												  <button type="button" id="del_typset" onclick="delPopTypset(); return false;" class="btn btn-sm btn-danger">삭제</button>
												  <label class="fix_width140"> </label>
												  <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
											  </p>
										  </div>
									  </div>
                                      </form>
VIEWHTML;

    return $html;
}
?>
