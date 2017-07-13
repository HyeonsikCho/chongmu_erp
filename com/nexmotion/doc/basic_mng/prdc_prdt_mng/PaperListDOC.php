<?
function getPrdcPaperView($param) {

    $html = <<<VIEWHTML

    <form name="paper_form" id="paper_form" method="post">
														 	<dl>
														 	    <dt class="tit">
														 	    	  <h4>종이조회 / 수정</h4>
														 	    </dt>
														 	    <dt class="cls">
														 	    	  <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
														 	    </dt>
														 	</dl>
														 	 <div class="pop-base2">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">업체 정보 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">
														 	  	  	
							                    	           <div class="form-group">
							                    	               <label class="control-label fix_width120 tar">제조사</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" id="pop_manu_name" class="input_co2 fix_width180" value="$param[manu_name]" disabled>
							                    	               <label class="control-label fix_width120 tar">브랜드</label><label class="fix_width20 fs14 tac">:</label>
							                    	               <input type="text" id="pop_brand_name" class="input_co2 fix_width180" value="$param[brand]" disabled>
							                    	           </div>    
							                    	           
														 	  	  </div>
														 	 </div>
														 	 
														 	 <div class="pop-base2">
			  											 	 	  <ul class="tab_box">
						                                  <li>
						       	                              <a class="box">종이 사양 등록 </a> 
						                                  </li>
			  											 	 	  </ul>
														 	  	  <div class="pop-content">

							                    	            <div class="form-group">				                                                
				                                                <label class="control-label fix_width120 tar">종이대분류</label><label class="fix_width20 fs14 tac">:</label>
				                                                <select id="paper_sort" name="paper_sort" class="fix_width184">
                                                                $param[sort_html]
				                                                </select>
				                                                <label class="control-label fix_width123 tar">기준가격</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="basic_price" name="basic_price"onkeydown="return checkNumber(event)" onkeyup="removeChar(event)" maxlength="21" style="ime-mode:disabled;" class="input_co2 fix_width180" value="$param[basic_price]">
				                                                <br />
				                                                <label class="control-label fix_width120 tar">종이명</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="pop_paper_name" name="pop_paper_name" class="input_co2 fix_width180" value="$param[name]">
				                                                <label class="control-label fix_width120 tar">요율</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="pur_rate" name="pur_rate" class="input_co2 fix_width180" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' maxlength="21" style='ime-mode:disabled;' value="$param[pur_rate]">				                                                <br />
				                                                <br />
				                                                <label class="control-label fix_width120 tar">구분</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="dvs" name="dvs" class="input_co2 fix_width180" value="$param[dvs]">
				                                                <label class="control-label fix_width120 tar">적용금액</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="pur_aplc_price" name="pur_aplc_price" class="input_co2 fix_width180" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' maxlength="21" value="$param[pur_aplc_price]">
				                                                <br />
				                                                <label class="control-label fix_width120 tar">색상</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="color" name="color" class="input_co2 fix_width180" value="$param[color]">
				                                                <label class="control-label fix_width120 tar">매입가격</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" id="pur_price" name="pur_price" class="input_co2 fix_width180" value="$param[pur_price]" disabled>
				                                                <br />
				                                                <label class="control-label fix_width120 tar">평량</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width120" name="basisweight" id="basisweight" value="$param[basisweight]">
				                                                <select id="basisweight_unit" name="basisweight_unit" class="fix_width55">
				                                                    <option value="g">g</option>
				                                                    <option value="μ">μ</option>
				                                                </select>
				                                                <br /><br />
				                                                <label class="control-label fix_width120 tar">계열</label><label class="fix_width20 fs14 tac">:</label>
				                                                <select id="affil" name="affil" class="fix_width180">
				                                                    <option value="46">46계열</option>
				                                                    <option value="국">국계열</option>
				                                                    <option value="별">별규격계열</option>
				                                                </select>
				                                                <br />
				                                                <label class="control-label fix_width120 tar"></label><label class="fix_width20 fs14 tac"></label>
				                                                <label class="control-label  tar">가로사이즈</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width100"  id="wid_size" name="wid_size" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' maxlength="21" value="$param[wid_size]">  mm
				                                                <label class="control-label fix_width100  tar">세로사이즈</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width100" id="vert_size" name="vert_size" onkeydown='return checkNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' maxlength="21" value="$param[vert_size]">mm
				                                                
				                                                <hr class="hr_bd2">
				                                                
				                                                <label class="control-label fix_width120 tar">기준단위</label><label class="fix_width20 fs14 tac">:</label>
				                                                <input type="text" class="input_co2 fix_width180" id="crtr_unit" name="crtr_unit" value="$param[crtr_unit]">
				                                                
							                    	            </div>				                                

														 	  	  </div>
														 	 </div>
														 
														 	 <div class="form-group">			
														 	  	      <p class="tac mt15">
														 	  	          <button onclick="savePaper();" type="button" class="btn btn-sm btn-success">저장</button>
														 	  	          <label class="fix_width5"> </label>
														 	  	          <button onclick="delPopPaper();" type="button" class="btn btn-sm btn-danger">삭제</button>
														 	  	          <label class="fix_width140"> </label>
														 	  	          <button onclick="hideRegiPopup();" type="button" class="btn btn-sm btn-primary">닫기</button>
														 	  	      </p> 
														 	 </div>

														 	  <br />
                                                              </form>

VIEWHTML;

    return $html;

}
?>
