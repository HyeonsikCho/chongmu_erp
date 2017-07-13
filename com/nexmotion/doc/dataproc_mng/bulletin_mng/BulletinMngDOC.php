<?
//팝업 설정 html 팝업
function getPopupSetHtml($param) {

    $html = <<<VIEWHTML

    <form name="popup_form" id="popup_form" method="post">

                            <dl>
                                <dt class="tit">
                               	    <h4>팝업설정</h4>
                                </dt>
                                <dt class="cls">
                               	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                                </dt>
                            </dl>

                            <div class="pop-base">
                                <div class="pop-content">
                                    <div class="form-group">
                            		    <label class="control-label fix_width79 tar">팝업제목</label><label class="fix_width20 fs14 tac">:</label>
                            		    <input type="text" class="input_co2 fix_width500" name="popup_name" id="popup_name" value="$param[name]">
                            		    <br />
                                        <label class="control-label fix_width79 tar">사용여부</label><label class="fix_width20 fs14 tac">:</label>
                                        <label class="control-label"><input type="radio" class="radio_box" name="use_yn" value="Y" $param[use_y]>사용</label>
                                        <label class="fix_width40"> </label>
                                        <label class="control-label"><input type="radio" class="radio_box" name="use_yn" value="N" $param[use_n]>미사용</label>
                                        <br />

                            		    <label class="control-label fix_width79 tar">일자별</label><label class="fix_width20 fs14 tac">:</label>
                                        <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="start_date" name="start_date" value="$param[start_date]">
        		                        ~
                                        <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="end_date" name="end_date" value="$param[end_date]">
                            		    <br />

                            		    <label class="control-label fix_width79 tar">시간</label><label class="fix_width20 fs14 tac">:</label>
                            		    <select name="start_hour" id="start_hour" class="fix_width75">
                                        $param[hour_list]
        		                        </select>
        		                        <select name="start_min" id="start_min" class="fix_width75">
                                        $param[min_list]
        		                        </select>
        		                        ~
        		                        <select name="end_hour" id="end_hour" class="fix_width75">
                                        $param[hour_list]
        		                        </select>
        		                        <select name="end_min" id="end_min" class="fix_width75">
                                        $param[min_list]
        		                        </select>
                            		    <br />

                            		    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                        <input type="text" name="wid_size" id="wid_size" class="input_co2 fix_width100" value="$param[wid_size]">
        		                        X
        		                        <input type="text" name="vert_size" id="vert_size" class="input_co2 fix_width100" value="$param[vert_size]">
                                        <br />

                                        <label class="control-label fix_width79 tar">파일첨부</label><label class="fix_width20 fs14 tac">:</label>
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
                                            <label class="fix_width100"></label>
                                            <div id="file_area">
                                            <label class="fix_width100"> </label>
                                            <label id="uploaded_file" class="control-label">$param[file_name]</label>
                                            <span id="file_btn" onclick="delPopupFile('$param[popup_seqno]'); return false;" class="btn btn-sm btn-danger fa" $param[hide_btn]>이미지삭제</span>
                                            <br />
                                            </div>
                                        <label class="control-label fix_width79 tar">Link URL</label><label class="fix_width20 fs14 tac">:</label>
                            		    <input type="text" class="input_co2 fix_width500" name="url_addr" id="url_addr" value="$param[url_addr]">
                                        <br />

                                        <label class="control-label fix_width79 tar">타겟</label><label class="fix_width20 fs14 tac">:</label>
                            		    <select name="target_yn" class="fix_width150">
        				                    <option value="Y" $param[target_y]>현재창</option>
        				                    <option value="N" $param[target_n]>새창</option>
        		                        </select>

                                    </div>

                                    <hr class="hr_bd3_b">

                                    <div class="form-group">
                                        <p class="tac mt15">
                                		    <button type="button" onclick="savePopupSet('$param[popup_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                            <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                        </p>
                                    </div>
                                </div>
                            </div>

    </form>

VIEWHTML;

    return $html;

}

//팝업 설정 html 팝업
function getPopupPreviewHtml($param) {

    $html = <<<VIEWHTML

                            <dl>
                                <dt class="tit">
                               	    <h4>팝업미리보기</h4>
                                </dt>
                                <dt class="cls">
                               	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                                </dt>
                            </dl>
                            <div class="pop-base">
                                <div class="pop-content">
                                    <div class="form-group">

                                        <li class="fix_width400">
                                            <div>
                                            <img src="$param[popup_file]" class="process_view_box13">
                                            </div>
                                        </li>

                                    </div>
                                    <div class="form-group">
                                        <p class="tac mt15">
                                            <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                        </p>
                                    </div>
                                </div>
                            </div>


VIEWHTML;

    return $html;

}

//공지사항 파일 html
function getFileHtml($result) {

    $html = "";
    $i = 1;
    while ($result && !$result->EOF) {

        $file_name = $result->fields["org_file_name"];
        $file_seqno = $result->fields["notice_seq_no"];

        $html .= <<<VIEWHTML

                        <div id="file_area$i">
                        <label class="fix_width55"> </label>
                        <label id="uploaded_file" class="control-label">$file_name</label>

                        <span onclick="delNoticeFile('$file_seqno', '$i')" class="btn btn-sm btn-danger fa">이미지삭제</span>
                        </div>
VIEWHTML;

        $result->moveNext();
        $i++;

    }

    return $html;

}

//공지사항 설정 html 팝업
function getNoticeSetHtml($param) {
	$dvs_select = "";
	if($param['dvs'] == 0) {
		$dvs_select .= "<option value='0' selected>없음</option><option value='1'>호환성여부</option><option value='2'>긴급</option>";
	} else if($param['dvs'] == 1){
		$dvs_select .= "<option value='0'>없음</option><option value='1' selected>호환성여부</option><option value='2'>긴급</option>";
	} else if($param['dvs'] == 2){
		$dvs_select .= "<option value='0' >없음</option><option value='1'>호환성여부</option><option value='2' selected>긴급</option>";
	}

    $html = <<<VIEWHTML

    <form name="notice_form" id="notice_form" method="post">
                            <dl>
                                <dt class="tit">
                               	    <h4>공지관리</h4>
                                </dt>
                                <dt class="cls">
                               	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                                </dt>
                            </dl>

                            <div class="pop-base">
                                <div class="pop-content">
                                    <div class="form-group">
                            		    <label class="control-label fix_width79 tar">제목</label><label class="fix_width20 fs14 tac">:</label>
                                        <select name="dvs" id="dvs">
                                           $dvs_select;
                                        </select>
                            		    <input type="text" name="title" id="title" class="input_co2 fix_width550" value="$param[title]">
                                        <label class="control-label fix_width79 tar">파일첨부</label><label class="fix_width20 fs14 tac">:</label>
                                        <input id="upload_file" name="upload_file" class="disableInputField" placeholder="" readonly/>

                                        <label class="fileUpload">
                                            <input id="upload_btn" name="upload_btn" type="file" class="upload" />
                                            <span class="btn btn-sm btn-info fa">찾아보기</span>
                                        </label>
                                        <script type="text/javascript">
                                            document.getElementById("upload_btn").onchange = function () {
                                            document.getElementById("upload_file").value = this.value;
                                                 };
                                        </script>
                                        $param[file_html]

                            		    <br />
                            		    <br />
                                        <textarea name="ir1" id="ir1" rows="10" cols="100" style="width:766px; height:305px;"></textarea>

                                    </div>


                                    <hr class="hr_bd3">

                                    <div class="form-group">
                                        <p class="tac mt15">
                                            <label class="fix_width220"></label>
                                		    <button type="button" onclick="saveNotice('$param[seq_no]'); return false;" class="btn btn-sm btn-success">저장</button>
                                            <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                            <label class="fix_width220"></label>
                                            <button type="button" onclick="delNotice('$param[seq_no]'); return false;" class="btn btn-sm btn-danger" $param[del_btn]>삭제</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
    </form>

VIEWHTML;

    return $html;

}
?>
