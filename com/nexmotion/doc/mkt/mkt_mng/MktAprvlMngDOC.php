<?
//등급 승인 View
function getGradeAprvlView($param) {

    $html = <<<VIEWHTML

            <dl>
                <dt class="tit">
                    <h4>등급 승인</h4>
                </dt>
                <dt class="cls">
                    <button type="button" onclick="hideRegiPopup()" class="btn btn-sm btn-danger fa fa-times"></button>
                </dt>
            </dl>  

            <div class="pop-base fl fix_width400">
                <div class="pop-content ofa fix_height300">
                    <div class="form-group">
                        <span>해당 요청을 승인하고자 하면 승인을 거절을 하고자 하면 승인 거절을 누르시면 됩니다. 닫기를 누르시면 아무것도 하지 않습니다.</span>
                    </div>  
                </div> <!-- pop-content -->
            </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label> </label>
	        <button onclick="acceptGradeAprvl(); return false;" type="button" class="btn btn-sm btn-success" $param[dis_btn]>승인</button>
	        <button onclick="rejectGradeAprvl(); return false;" type="button" class="btn btn-sm btn-danger" $param[dis_btn]>승인거절</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	    </p>
	    <br /> 
    </div>   	    

VIEWHTML;

    return $html;

}

//포인트 승인 View
function getPointAprvlView($param) {

    $html = <<<VIEWHTML

            <dl>
                <dt class="tit">
                    <h4>포인트 승인</h4>
                </dt>
                <dt class="cls">
                    <button type="button" onclick="hideRegiPopup()" class="btn btn-sm btn-danger fa fa-times"></button>
                </dt>
            </dl>  

            <div class="pop-base fl fix_width400">
                <div class="pop-content ofa fix_height300">
                    <div class="form-group">
                        <span>해당 요청을 승인하고자 하면 승인을 거절을 하고자 하면 승인 거절을 누르시면 됩니다. 닫기를 누르시면 아무것도 하지 않습니다.</span>
                    </div>  
                </div> <!-- pop-content -->
            </div>
     <!-- pop-base -->
     
    <div class="form-group">			
	    <p class="tac mt15">
	        <label> </label>

	        <a href="$param[file_path]$param[save_file_name]" target="_blank" type="button" class="btn btn-sm btn-info" $param[file_btn]>이미지보기</a>
	        <button onclick="acceptPointAprvl(); return false;" type="button" class="btn btn-sm btn-success" $param[dis_btn]>승인</button>
	        <button onclick="rejectPointAprvl(); return false;" type="button" class="btn btn-sm btn-danger" $param[dis_btn]>승인거절</button>
	        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
	    </p>
	    <br /> 
    </div>   	    

VIEWHTML;

    return $html;

}



?>
