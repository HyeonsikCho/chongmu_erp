<?
//상품정보 html
function getPrdtInfoHtml($param) {

    $html = <<<VIEWHTML

    <form name="prdt_form" id="prdt_form" method="post">
                            <div class="form-group">
				                <label class="control-label fix_width150 tar">품절 여부</label><label class="fix_width20 fs14 tac"> : </label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="gen_y" name="gen_y" value="Y" $param[gen_y]> 일반상품으로 표시</label>
				                <label class="fix_width55"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="prjt_y" name="prjt_y" value="Y" $param[prjt_y]> 기획상품으로 표시</label>
				                <br />
				            </div>
				            
				            <div class="form-group">
				                <label class="control-label fix_width170 tar"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="new_y" name="new_y" value="Y" $param[new_y]> 신상품으로 표시</label>
				                <label class="fix_width68"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="recomm_y" name="recomm_y" value="Y" $param[recomm_y]> 추천상품으로 표시</label>
				                <br />
				            </div>
				            
				            <div class="form-group">
				                <label class="control-label fix_width170 tar"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="soldout_y" name="soldout_y" value="Y" $param[soldout_y]> 품절상품으로 표시</label>
				                <label class="fix_width55"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="popular_y" name="popular_y" value="Y" $param[popular_y]> 인기상품으로 표시</label>
				                <br />
				            </div>
				            
				            <div class="form-group">
				                <label class="control-label fix_width170 tar"></label>
				                <label class="form-radio"><input type="checkbox" class="check_box" id="event_y" name="event_y" value="Y" $param[event_y]> 이벤트상품으로 표시</label>				                
				                <br /><br />
				            </div>
				            
				            <div class="form-group">
				                <label class="control-label fix_width150 tar">구분</label><label class="fix_width20 fs14 tac"> : </label>
				                <label class="form-radio form-normal"><input type="radio" name="bun_yn" value="Y" class="radio_box" $param[bun_y]>묶음가능</label>
				                <label class="fix_width15"></label>   
				                <label class="form-radio"><input type="radio" name="bun_yn" value="N" class="radio_box" $param[bun_n]>묶음불가능</label>
				                <br /><br />
							</div>
				            <div class="pop-base fl fix_width1150">
				                <div class="pop-content ofa fix_height415">
                                    <ul class="form-group">
                                        <li class="fix_width400 fl">
                                            <div>
                                            <img id="main_photo" src="$param[photo1]" class="process_view_box10">
                                            </div>
                                        </li>
                                        <li class="fix_width120 fl">
                                            <div>
                                            <img onclick="changePhoto('$param[photo1]'); return false;" src="$param[photo1]" class="process_view_box11">
                                            </div>
                                            <br />
                                            <div>
                                            <img onclick="changePhoto('$param[photo2]')" src="$param[photo2]" class="process_view_box11">
                                            </div>
                                            <br />
                                            <div>
                                            <img onclick="changePhoto('$param[photo3]')" src="$param[photo3]" class="process_view_box11">
                                            </div>
                                            <br />
                                            <div>
                                            <img onclick="changePhoto('$param[photo4]')" src="$param[photo4]" class="process_view_box11">
                                            </div>
                                        </li>
                                        
                                        <li class="fix_width500 fl">

                                            <div id="file_area1">
                                                <label class="fix_width105"> </label>
                                                <label id="file_name1" class="control-label cp blue_text01">$param[file_name1]</label>
                                                <button onclick="delPhotoFile('$param[photo_seqno1]',1)" type="button" id="del_btn1" class="btn btn-sm bred fa" $param[del_btn1]>이미지삭제</button>                        
                                            </div>
                                            <label class="control-label fix_width85 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                                            <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                                            <input id="upload_file1" name="upload_file1" class="disableInputField" placeholder="" readonly/>
                                            
                                            <label class="fileUpload">
                                                <input id="upload_btn1" name="upload_btn1" type="file" class="upload" />
                                                <span class="btn btn-sm btn-info fa">찾아보기</span>
                                            </label>
                                            <script type="text/javascript">  
                                                document.getElementById("upload_btn1").onchange = function () {
                                                document.getElementById("upload_file1").value = this.value;
                                                     };
                                            </script>
                                            <br />

                                            <div id="file_area2">
                                                <label class="fix_width105"> </label>
                                                <label id="file_name2" class="control-label cp blue_text01">$param[file_name2]</label>
                                                <button onclick="delPhotoFile('$param[photo_seqno2]',2)" type="button" id="del_btn2" class="btn btn-sm bred fa" $param[del_btn2]>이미지삭제</button>                        
                                            </div>
                                            <label class="control-label fix_width85 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                                            <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                                            <input id="upload_file2" name="upload_file2" class="disableInputField" placeholder="" readonly/>
                                            
                                            <label class="fileUpload">
                                                <input id="upload_btn2" name="upload_btn2" type="file" class="upload" />
                                                <span class="btn btn-sm btn-info fa">찾아보기</span>
                                            </label>
                                            <script type="text/javascript">  
                                                document.getElementById("upload_btn2").onchange = function () {
                                                document.getElementById("upload_file2").value = this.value;
                                                     };
                                            </script>
                                            <br />
                                            
                                            <div id="file_area3">
                                                <label class="fix_width105"> </label>
                                                <label class="control-label cp blue_text01" id="file_name3">$param[file_name3]</label>
                                                <button onclick="delPhotoFile('$param[photo_seqno3]',3)" type="button" class="btn btn-sm bred fa" id="del_btn3" $param[del_btn3]>이미지삭제</button>                        
                                            </div>
                                            <label class="control-label fix_width85 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                                            <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                                            <input id="upload_file3" name="upload_file3" class="disableInputField" placeholder="" readonly/>
                                            
                                            <label class="fileUpload">
                                                <input id="upload_btn3" name="upload_btn3" type="file" class="upload" />
                                                <span class="btn btn-sm btn-info fa">찾아보기</span>
                                            </label>
                                            <script type="text/javascript">  
                                                document.getElementById("upload_btn3").onchange = function () {
                                                document.getElementById("upload_file3").value = this.value;
                                                     };
                                            </script>
                                            <br />
 
                                            <div id="file_area4">
                                                <label class="fix_width105"> </label>
                                                <label class="control-label cp blue_text01" id="file_name4">$param[file_name4]</label>
                                                <button onclick="delPhotoFile('$param[photo_seqno4]',4)" type="button" class="btn btn-sm bred fa" id="del_btn4" $param[del_btn4]>이미지삭제</button>                        
                                            </div>

                                            <label class="control-label fix_width85 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                                            <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                                            <input id="upload_file4" name="upload_file4" class="disableInputField" placeholder="" readonly/>
                                            <label class="fileUpload">
                                                <input id="upload_btn4" name="upload_btn4" type="file" class="upload" />
                                                <span class="btn btn-sm btn-info fa">찾아보기</span>
                                            </label>
                                            <script type="text/javascript">  
                                                document.getElementById("upload_btn4").onchange = function () {
                                                document.getElementById("upload_file4").value = this.value;
                                                     };
                                            </script>
                                            <br /><br />
                                            
                                        </li>
                                    </ul> 
                                </div>
				            </div>
				            
				            <div class="pop-base fl fix_width1150">
				                <div class="pop-content ofa fix_height200">

                                    <ul class="form-group">
                                        <li class="fix_width500 fl">
                                            <div>
                                            <img src="$param[banner]" class="process_view_box12">
                                            </div>
                                        </li>
                                        
                                        <li class="fix_width500 fl">

                                            <div id="banner_file_area">
                                                <label class="fix_width105"> </label>
                                                <label class="control-label cp blue_text01">$param[banner_file_name]</label>
                                                <button onclick="delBannerFile('$param[banner_seqno]')" type="button" class="btn btn-sm bred fa" $param[del_btn_bn]>이미지삭제</button>                        
                                            </div>
                                            <label class="control-label fix_width85 tar">이미지</label><label class="fix_width20 fs14 tac">:</label>
                                            <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->                    
                                            <input id="upload_bn_file" name="upload_bn_file" class="disableInputField" placeholder="" readonly/>
                                            
                                            <label class="fileUpload">
                                                <input id="upload_bn_btn" name="upload_bn_btn" type="file" class="upload" />
                                                <span class="btn btn-sm btn-info fa">찾아보기</span>
                                            </label>
                                            <script type="text/javascript">  
                                                document.getElementById("upload_bn_btn").onchange = function () {
                                                document.getElementById("upload_bn_file").value = this.value;
                                                     };
                                            </script>
                                            <br /><br />
                                            <label class="control-label fix_width85 tar">Link URL</label><label class="fix_width20 fs14 tac">:</label>
                                            <input type="text" name="url_addr" class="input_co2 fix_width350" value="$param[url_addr]">
                                            <label class="control-label fix_width85 tar">Target</label><label class="fix_width20 fs14 tac"> : </label>
				                            <label class="form-radio form-normal"><input type="radio" name="target_yn" value="Y" class="radio_box" $param[target_y]>현재창</label>
				                            <label class="form-radio"><input type="radio" name="target_yn" value="N" class="radio_box" $param[target_n]>새창</label>
	

                                        </li>
				                </div>
				            </div>
    </form>
VIEWHTML;

    return $html;

}
?>



