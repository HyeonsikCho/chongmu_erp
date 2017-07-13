<?
//파일 html
function getFileHtml($param) {

    $html = <<<VIEWHTML

                        <div id="file_area">
                        <label class="fix_width100"> </label>
                        <label class="control-label cp blue_text01">$param[file_name]</label>
                        <button onclick="$param[event_func]('$param[file_seqno]')" type="button" class="btn btn-sm bred fa fa-times"></button>                        
                        <input type="hidden" id="file_name" value="$param[file_name]">
                        <br /> 
                        </div>

VIEWHTML;

    return $html;

}

//오특이 이벤트 팝업 html
function getOeventView($param) {

    $html = <<<VIEWHTML

    <form name="oevent_form" id="oevent_form" method="post">
     <dl>
          <dt class="tit">
               <h4>이벤트 - 오특이 등록/수정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base2">        
			  											 	 	  
          <div class="pop-content">

                <div class="form-group">
                     
                    <label class="control-label fix_width79 tar">이벤트 이름</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="event_name" name="event_name" class="input_co5 fix_width200">
                    <br />
                    
                    <label class="control-label fix_width79 tar">진열여부</label><label class="fix_width20 fs14 tac">:</label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="Y">진열</label>
                    <label class="fix_width40"> </label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="N" checked>미진열</label>                    
                    <br />
                    
                    <label class="control-label fix_width79 tar">일자별</label><label class="fix_width20 fs14 tac">:</label>
                    <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="oevent_date" name="oevent_date" value="$param[oevent_date]">
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
                    
                    <hr class="hr_bd3_b">
 
                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="sell_site" name="sell_site" class="fix_width150">
                        $param[sell_site]
					</select>
                    <br />

                    <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
	                 <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                        $param[cate_top]
                    </select>
	                 <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
				        <option value="">중분류</option>
                    </select>
	                 <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
				        <option value="">소분류</option>
                    </select>
                    <br />
                       
                    <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
					<select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
				        <option value="">종이명</option>
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
				        <option value="">구분</option>
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
				        <option value="">색상</option>
                    </select>
					<select id="paper_basisweight" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
				        <option value="">평량</option>
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
					<select onchange="resetAmtPriceInfo(); return false;" id="output_size" class="fix_width100">
				        <option value="">사이즈</option>
                    </select>
                    <br />
                    <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
					<select id="print_tmpt" onchange="loadAmtUnit(); return false;" class="fix_width100">
				        <option value="">인쇄도수</option>
                    </select>
                    <br />
                    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="amt" name="amt" onchange="loadPrice(); return false;" class="fix_width100">
				        <option value="">수량</option>
                    </select>
                    <input id="amt_unit" name="amt_unit" type="text" class="input_co5 fix_width24" readonly>
                    <br />
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">가격</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co5 fix_width100" id="basic_price" readonly>
                    <label class="fix_width20"> </label>
                    <label class="control-label fix_width79 tar">할인금액</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="sale_price" name="sale_price" onkeyup="return loadSumPrice(event, this.value);" style='ime-mode:disabled;' maxlength="21" class="input_co5 fix_width100">
                    <label class="fix_width20"> </label>                    
                    <input type="text" id="sum_price" name="sum_price" class="input_co5 fix_width100" readonly>
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
                </div>
                
                

          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label class="fix_width200"> </label>
	        <button onclick="saveOeventInfo('$param[oevent_seqno]'); return false;" type="button" class="btn btn-sm btn-success">저장</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	        <label class="fix_width200"> </label>	        
	        <button type="button" class="btn btn-sm btn-danger" onclick="delOevent('$param[oevent_seqno]'); return false;" $param[hide_btn]>삭제</button>
	    </p>
	    <br /> 
    </div>   	    
    </form>

VIEWHTML;
    return $html;

}

//오특이 이벤트 팝업 수정 html
function getOeventDetailView($param) {

    $html = <<<VIEWHTML

    <form name="oevent_form" id="oevent_form" method="post">
     <dl>
          <dt class="tit">
               <h4>이벤트 - 오특이 등록/수정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base2">        
			  											 	 	  
          <div class="pop-content">

                <div class="form-group">
                     
                    <label class="control-label fix_width79 tar">이벤트 이름</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="event_name" name="event_name" class="input_co5 fix_width200" value="$param[event_name]">
                    <br />
                    
                    <label class="control-label fix_width79 tar">진열여부</label><label class="fix_width20 fs14 tac">:</label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="Y" $param[dsply_y]>진열</label>
                    <label class="fix_width40"> </label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="N" $param[dsply_n]>미진열</label>                    
                    <br />
                    
                    <label class="control-label fix_width79 tar">일자별</label><label class="fix_width20 fs14 tac">:</label>
                    <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="oevent_date" name="oevent_date" value="$param[oevent_date]">
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
                    
                    <hr class="hr_bd3_b">
 
                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="sell_site" name="sell_site" class="fix_width150">
                        $param[sell_site]
					</select>
                    <br />

                    <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
	                 <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                    $param[cate_top]
                    </select>
	                 <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
                     $param[cate_mid]

                    </select>
	                 <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
                     $param[cate_bot]
                    </select>
                    <br />
                       
                    <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
					<select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
                    $param[paper_name]
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
                    $param[paper_dvs]
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
                    $param[paper_color]
                    </select>
					<select id="paper_basisweight" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
                    $param[paper_basisweight]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
					<select id="output_size" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
                    $param[output_size]
                    </select>
                    <br />
                    <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
					<select id="print_tmpt" onchange="loadAmtUnit(); return false;" class="fix_width100">
                    $param[print_tmpt]
                    </select>
                    <br />
                    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="amt" name="amt" onchange="loadPrice(); return false;" class="fix_width100">
                    $param[amt]
                    </select>
                    <input id="amt_unit" name="amt_unit" type="text" class="input_co5 fix_width24" value="$param[amt_unit]" readonly>
                    <br />
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">가격</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co5 fix_width100" id="basic_price" value="$param[basic_price]" readonly>
                    <label class="fix_width20"> </label>
                    <label class="control-label fix_width79 tar">할인금액</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="sale_price" name="sale_price" onkeyup="return loadSumPrice(event, this.value);" style='ime-mode:disabled;' maxlength="21" class="input_co5 fix_width100" value="$param[sale_price]">
                    <label class="fix_width20"> </label>                    
                    <input type="text" id="sum_price" name="sum_price" class="input_co5 fix_width100" value="$param[sum_price]" readonly>
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
                </div>
                
          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label class="fix_width200"> </label>
	        <button onclick="saveOeventInfo('$param[oevent_seqno]')" type="button" class="btn btn-sm btn-success">저장</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	        <label class="fix_width200"> </label>	        
	        <button type="button" class="btn btn-sm btn-danger" onclick="delOevent('$param[oevent_seqno]')" $param[hide_btn]>삭제</button>
	    </p>
	    <br /> 
    </div>   	    
    </form>

VIEWHTML;
    return $html;

}

//요즘바빠요 이벤트 팝업 html
function getNowadaysView($param) {

    $html = <<<VIEWHTML

    <form name="nowadays_form" id="nowadays_form" method="post">
 
     <dl>
          <dt class="tit">
               <h4>이벤트 - 요즘바빠요 등록/수정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base2">        
			  											 	 	  
          <div class="pop-content">

                <div class="form-group">          
                     
                    <label class="control-label fix_width79 tar">이벤트 이름</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="event_name" name="event_name" class="input_co5 fix_width200">
                    <br />
                    
                    <label class="control-label fix_width79 tar">진열여부</label><label class="fix_width20 fs14 tac">:</label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="Y">진열</label>
                    <label class="fix_width40"> </label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="N" checked>미진열</label>                    
                    <br />            
                    
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="sell_site" name="sell_site" class="fix_width150">
				        $param[sell_site]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
	                <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                        $param[cate_top]
                    </select>
	                <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
				        <option value="">중분류</option>
                    </select>
	                <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
				        <option value="">소분류</option>
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
					<select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
				        <option value="">종이명</option>
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
				        <option value="">구분</option>
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
				        <option value="">색상</option>
                    </select>
					<select id="paper_basisweight" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
				        <option value="">평량</option>
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
					<select onchange="resetAmtPriceInfo(); return false;" id="output_size" class="fix_width100">
				        <option value="">사이즈</option>
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
					<select id="print_tmpt" onchange="loadAmtUnit(); return false;" class="fix_width100">
				        <option value="">인쇄도수</option>
                    </select>                    
                    <br />
                    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="amt" name="amt" onchange="loadPrice(); return false;" class="fix_width100">
				        <option value="">수량</option>
                    </select>
                    <input id="amt_unit" name="amt_unit" type="text" class="input_co5 fix_width24" readonly>
                    <br />
                    
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">가격</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co5 fix_width100" id="basic_price" readonly>
                    <label class="fix_width20"> </label>
                    <label class="control-label fix_width79 tar">할인금액</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="sale_price" name="sale_price" onkeyup="return loadSumPrice(event, this.value);" style='ime-mode:disabled;' maxlength="21" class="input_co5 fix_width100">
                    <label class="fix_width20"> </label>                    
                    <input type="text" id="sum_price" name="sum_price" class="input_co5 fix_width100" readonly>
                    <br />                                 
                    
                    <label class="control-label fix_width79 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
                    <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly/>
                    
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
                    <br />               
                </div>
                
                

          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label class="fix_width200"> </label>
	        <button onclick="saveNowadaysInfo('$param[nowadays_seqno]'); return false;" type="button" class="btn btn-sm btn-success">저장</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	        <label class="fix_width200"> </label>	        
	        <button type="button" class="btn btn-sm btn-danger" onclick="delNowadays('$param[nowadays_seqno]'); return false;" $param[hide_btn]>삭제</button>
	    </p>
	    <br /> 
    </div>   	    
    </form>

VIEWHTML;
    return $html;

}

//요즘바빠요 이벤트 팝업 수정 html
function getNowadaysDetailView($param) {

    $html = <<<VIEWHTML

    <form name="nowadays_form" id="nowadays_form" method="post">
 
     <dl>
          <dt class="tit">
               <h4>이벤트 - 요즘바빠요 등록/수정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
														 	
     <div class="pop-base2">        
			  											 	 	  
          <div class="pop-content">

                <div class="form-group">          
                     
                    <label class="control-label fix_width79 tar">이벤트 이름</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="event_name" name="event_name" value="$param[event_name]" class="input_co5 fix_width200">
                    <br />
                    
                    <label class="control-label fix_width79 tar">진열여부</label><label class="fix_width20 fs14 tac">:</label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="Y" $param[dsply_y]>진열</label>
                    <label class="fix_width40"> </label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="dsply_yn" value="N" $param[dsply_n]>미진열</label>                    
                    <br />            
                    
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="sell_site" name="sell_site" class="fix_width150">
				        $param[sell_site]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
	                <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                        $param[cate_top]
                    </select>
	                <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
                        $param[cate_mid]
                    </select>
	                <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
                        $param[cate_bot]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
					<select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
                    $param[paper_name]
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
                    $param[paper_dvs]
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
                    $param[paper_color]
                    </select>
					<select id="paper_basisweight" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
                    $param[paper_basisweight]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
					<select onchange="resetAmtPriceInfo(); return false;" id="output_size" class="fix_width100">
                    $param[output_size]
                    </select>
                    <br />
                    
                    <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
					<select id="print_tmpt" onchange="loadAmtUnit(); return false;" class="fix_width100">
                    $param[print_tmpt]
                    </select>                    
                    <br />
                    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="amt" name="amt" onchange="loadPrice(); return false;" class="fix_width100">
                    $param[amt]
                    </select>
                    <input id="amt_unit" name="amt_unit" type="text" class="input_co5 fix_width24" value="$param[amt_unit]" readonly>
                    <br />
                    
                    <hr class="hr_bd3_b">
                    
                    <label class="control-label fix_width79 tar">가격</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co5 fix_width100" id="basic_price" value="$param[basic_price]" readonly>
                    <label class="fix_width20"> </label>
                    <label class="control-label fix_width79 tar">할인금액</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" id="sale_price" name="sale_price" onkeyup="return loadSumPrice(event, this.value);" style='ime-mode:disabled;' maxlength="21" class="input_co5 fix_width100" value="$param[sale_price]">
                    <label class="fix_width20"> </label>                    
                    <input type="text" id="sum_price" name="sum_price" class="input_co5 fix_width100" value="$param[sum_price]" readonly>
                    <br />                                 
                    
                    <label class="control-label fix_width79 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
                    <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly/>
                    
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
                    <br />               
                </div>
                
                

          </div> <!-- pop-content -->
     </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label class="fix_width200"> </label>
	        <button onclick="saveNowadaysInfo('$param[nowadays_seqno]'); return false;" type="button" class="btn btn-sm btn-success">저장</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	        <label class="fix_width200"> </label>	        
	        <button type="button" class="btn btn-sm btn-danger" onclick="delNowadays('$param[nowadays_seqno]'); return false;" $param[hide_btn]>삭제</button>
	    </p>
	    <br /> 
    </div>   	    
    </form>

VIEWHTML;
    return $html;

}

//골라담기 이벤트 팝업 수정 html
function getOvertoView($param) {

    $html = <<<VIEWHTML

     <dl>
          <dt class="tit">
               <h4>이벤트 - 골라담기 등록/수정</h4>
          </dt>
          <dt class="cls">
               <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
          </dt>
     </dl>  
			
     <div class="pop-base">        

        <div class="tb_group fix_width650 clear">
                    
            <ul class="tab_box mt25">
		           <li class="fl"><a class="box"> 이벤트 일반 </a> </li>
		    </ul>
            
            <div class="tab_box_con">
                
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="sell_site" name="sell_site" class="fix_width150">
                        $param[sell_site]
                    </select>
                    <br />
		        </div>
	
                <div class="form-group">
                    <label class="control-label fix_width79 tar">이벤트 이름</label><label class="fix_width20 fs14 tac">:</label>
                    <input type="text" class="input_co5 fix_width200" id="event_name" name="event_name" value="$param[event_name]">
                    <br />
                </div>
                
                <div class="form-group">
                    <label class="control-label fix_width79 tar">사용여부</label><label class="fix_width20 fs14 tac">:</label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="use_yn" value="Y" $param[use_y]>사용</label>
                    <label class="fix_width40"> </label>
                    <label class="control-label cp"><input type="radio" class="radio_box" name="use_yn" value="N" $param[use_n]>미사용</label>
                    <br />
                </div>
                
                <div class="form-group">
                    <label class="fix_width5"> </label>
                    <label class="control-label cp">전체주문금액</label>
                    <label class="fix_width5"> </label>
                    <input type="text" class="input_co5 fix_width75" name="tot_order_price" id="tot_order_price" value="$param[tot_order_price]">
                    <label class="fix_width5"> </label>
                    <label class="control-label cp">원 이상일때 </label>
                    <label class="fix_width5"> </label>
                    <label class="control-label cp">요율</label>
                    <label class="control-label cp"><input type="text" name="sale_rate" id="sale_rate" class="input_co5 fix_width75" value="$param[sale_rate]">% 할인</label>            
                </div>
                
                <div class="form-group">			
            	    <p class="tac mt5">	        
            	        <label class="fix_width400"> </label>
            	        <button type="button" onclick="saveOvertoGroup(); return false;" class="btn btn-sm btn-success">그룹저장</button>
            	        <button id="del_group_btn" type="button" onclick="delOvertoGroup(); return false;" class="btn btn-sm btn-danger" $param[dis_btn]>그룹삭제</button>
            	    </p>	
                </div> 
            </div>
        </div>
        
        <div class="tb_group fix_width650 clear">
                    
            <ul class="tab_box mt25">
		           <li class="fl"><a class="box"> 이벤트 상세 </a> </li>
		    </ul>
		    <div id="detail_area" class="tab_box_con">

                <form name="overto_form" id="overto_form" method="post">
	        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                        $param[cate_top]
                    </select>
	                <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
				        <option value="">중분류</option>
                    </select>
	                <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
				        <option value="">소분류</option>
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
				        <option value="">종이명</option>
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
				        <option value="">구분</option>
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
				        <option value="">색상</option>
                    </select>
					<select id="paper_basisweight" onchange="resetAmtPriceInfo(); return false;" class="fix_width100">
				        <option value="">평량</option>
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
                    <select onchange="resetAmtPriceInfo(); return false;" id="output_size" class="fix_width100">
				        <option value="">사이즈</option>
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="print_tmpt" class="fix_width100">
				        <option value="">인쇄도수</option>
                    </select>   
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                    <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly/>
                    
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
                    <br /> 
		        </div>
		        
		        <div class="form-group">			
            	    <p class="tac mt5">	                    	        
            	        <button type="button" id="prdt_add_btn" onclick="saveOvertoPrdt(''); return false;" class="btn btn-sm btn-success" $param[dis_btn]>상품추가</button>            	        
            	    </p>	
                </div>
		        
		        <div class="form-group">
		        </div>
		        
		        <div class="form-group">
		        </div>
		        
		        
                </form>
		    </div>
		    
		</div>
		
		<div class="tb_group fix_width650 clear">
                    
            <ul class="tab_box mt25">
		           <li class="fl"><a class="box"> 골라담는 상품 </a> </li>
		    </ul>
		    
		    <div class="tab_box_con">
		        <div class="form-group">
		            <div class="table-body">
                        <div class="table_basic">
					        <table class="fix_width100f">
					        	<thead>
					           <tr>
					        	    <th class="bm2px">No</th>					                      				    
					        	    <th class="bm2px">카테고리</th>
					        	    <th class="bm2px">종이</th>					                    	    
					        	    <th class="bm2px">사이즈</th>
					        	    <th class="bm2px">인쇄</th>
					        	    <th class="bm2px">관리</th>
					        	</tr>					                      				
					         </thead>
					         <tbody id="prdt_list">	
                             $param[prdt_list]
					         </tbody>
					        </table>					        
					    </div>
                    </div>					                                      
		        </div>		        
		    </div>         
        </div>
        
     </div>
     <!-- pop-base -->
     
     
    <div class="form-group">			
	    <p class="tac mt15">	        
	        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>	        
	    </p>
	    <br /> 
    </div>   	    
          
 

VIEWHTML;
    return $html;

}
 

//골라담기 이벤트 팝업 수정 html
function getOvertoDetailView($param) {

    $html = <<<VIEWHTML

                <form name="overto_form" id="overto_form" method="post">
	        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">카테고리</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="cate_top" onchange="cateSelect.exec('top', this.value); return false;" class="fix_width100">
                        $param[cate_top]
                    </select>
	                <select id="cate_mid" onchange="cateSelect.exec('mid', this.value); return false;" class="fix_width100">
                        $param[cate_mid]
                    </select>
	                <select id="cate_bot" name="cate_bot" onchange="initDetailInfo(this.value); return false;" class="fix_width100">
                        $param[cate_bot]
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">종이</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="paper_name" onchange="paperSelect.exec('NAME', this.value); return false;" class="fix_width100">
                        $param[paper_name]
                    </select>
					<select id="paper_dvs" onchange="paperSelect.exec('DVS', this.value); return false;" class="fix_width100">
                        $param[paper_dvs]
                    </select>
					<select id="paper_color" onchange="paperSelect.exec('COLOR', this.value); return false;" class="fix_width100">
                        $param[paper_color]
                    </select>
					<select id="paper_basisweight" class="fix_width100">
                        $param[paper_basisweight]
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="output_size" class="fix_width100">
                        $param[output_size]
                    </select>
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">인쇄</label><label class="fix_width20 fs14 tac">:</label>
                    <select id="print_tmpt" class="fix_width100">
                        $param[print_tmpt]
                    </select>   
                    <br />
		        </div>
		        
		        <div class="form-group">
		            <label class="control-label fix_width79 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                    <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                    <input id="upload_file" name="upload_file" class="disableInputField" placeholder="Choose File" readonly/>
                    
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
                    <br /> 
		        </div>
		        
		        <div class="form-group">			
            	    <p id="prdt_btn_area" class="tac mt5">	                    	        
            	        <button type="button" id="prdt_add_btn" onclick="saveOvertoPrdt('$param[overto_detail_seqno]'); return false;" class="btn btn-sm btn-success">상품수정</button>            	        
                        <button type="button" id="edit_cancle_btn" onclick="resetOvertoAddDetail(); return false;" class="btn btn-sm btn-danger">수정취소</button>            	       
            	    </p>	
                </div>
		        
		        <div class="form-group">
		        </div>
		        
		        <div class="form-group">
		        </div>
		        


VIEWHTML;
    return $html;

}

?>
