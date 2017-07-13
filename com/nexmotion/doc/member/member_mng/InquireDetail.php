<?php
//회원 기본정보 VIEW
function makeInquireInfoDetailHtml($param) {
$html = <<<InquireInfoDetailHtml
    <ul class="tab_box mt25">
    <li>
    <a class="box">문의관리</a>
    </li>
    </ul>
    <div class="tab_box_con">
        <fieldset class="mt25">
        <legend> 문의내용 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">문의제목 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[title]</span>
        <br />
		<label class="control-label fix_width150 tar">문의유형 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[inq_typ]</span>
        <br />
		<label class="control-label fix_width150 tar">회원명 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[member_name]</span>
        <br />
		<label class="control-label fix_width150 tar">연락처 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[tel_num]</span>
        <br />
		<label class="control-label fix_width150 tar">휴대전화 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[cell_num]</span>
        <br />
	    <label class="control-label fix_width150 tar">이메일 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[mail]</span>
        <br />
		<label class="control-label fix_width150 tar">첨부파일 </label><label class="fix_width20 fs14 tac">:</label>
        <span><a href="#">$param[origin_file_name]</a></span>
        <br />
		<label class="control-label fix_width150 tar">문의내용 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[cont]</span>
        <br />
                       	  	</div>
                       </fieldset>						 	
                       <fieldset class="mt25">
                       	      <legend> 답변내용 </legend>	   
                       	      <div class="form-group lh35">
                       	          <label class="control-label fix_width150 tar">답변자 </label><label class="fix_width20 fs14 tac">:</label>
                                  <span>$param[empl_name]</span><br />
								  <label class="control-label fix_width150 tar">답변내용 </label><label class="fix_width20 fs14 tac">:</label>
                                  <span>$param[repl_cont]</span><br />
                       	      </div>
							  <br /><br />
							 </fieldset>
					   </div>
InquireInfoDetailHtml;

    return $html;
}

//회원 기본정보 VIEW answ_yn N일때
function makeInquireInfoDetailHtml2($param) {
$html = <<<InquireInfoDetailHtml2
    <ul class="tab_box mt25">
    <li>
    <a class="box">문의관리</a>
    </li>
    </ul>
    <div class="tab_box_con">
        <fieldset class="mt25">
        <legend> 문의내용 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">문의제목 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[title]</span>
        <br />
		<label class="control-label fix_width150 tar">문의유형 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[inq_typ]</span>
        <br />
		<label class="control-label fix_width150 tar">회원명 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[member_name]</span>
        <br />
		<label class="control-label fix_width150 tar">연락처 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[tel_num]</span>
        <br />
		<label class="control-label fix_width150 tar">휴대전화 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[cell_num]</span>
        <br />
	    <label class="control-label fix_width150 tar">이메일 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[mail]</span>
        <br />
		<label class="control-label fix_width150 tar">첨부파일 </label><label class="fix_width20 fs14 tac">:</label>
        <span><a href="/common/oto_inq_file_down.php?seqno=$param">$param[origin_file_name]</a></span>
        <br />
		<label class="control-label fix_width150 tar">문의내용 </label><label class="fix_width20 fs14 tac">:</label>
        <span>$param[cont]</span>
        <br />
                       	  	</div>
                       </fieldset>						 	
                       <fieldset class="mt25">
                       	      <legend> 답변내용 </legend>	   
                       	      <div class="form-group lh35">
                       	          <label class="control-label fix_width150 tar">답변자 </label><label class="fix_width20 fs14 tac">:</label>
                                  <input type="text" value="$param[empl_name]" disabled><br />
								  <label class="control-label fix_width150 tar">답변내용 </label><label class="fix_width20 fs14 tac">:</label>
                                  <input type="textarea" value="$param[repl_cont]"><br />
                       	      </div>
							  <br /><br />
							  <!-- 다운로드 박스 -->
							  <div class="dnup">

													 <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
													 <!--<input id="uploadFile" class="disableInputField" placeholder="Choose File" disabled="disabled" />
									
													 <label class="fileUpload">
														 <input id="uploadBtn" type="file" class="upload" />
														 <span class="btn btn-sm btn-info fa fa-folder-open">파일찾기</span>
													 </label>
													 <script type="text/javascript">  
														  document.getElementById("uploadBtn").onchange = function () {
														  document.getElementById("uploadFile").value = this.value;
											    		};
													 </script> 
													  <span class="btn btn-sm btn-info fa fa-folder-open">업로드</span>
													<hr class="hr_bd">
                                                    </div>-->
                                                    <!-- <script src='//code.jquery.com/jquery.min.js'></script>
                                                    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js'></script>
                                                    <script>
                                                    $(function() {
                                                            $('#myform').ajaxForm({
                                                                    dataType: 'json',
                                                                    beforeSend: function() {
                                                                       $('#result').append( "beforeSend...\n" );
                                                                    },
                                                                    complete: function(data) {
                                                                    $('#result')
                                                                    .append( "complete...\n" )
                                                                    .append( JSON.stringify( data.responseJSON ) + "\n" );
                                                                    }
                                                                    });
                                                            });
                                                     </script>
                                                         <form id="myform" action="/proc/member/oto_inq_mng/upload_ok.php" enctype="multipart/form-data" method="post">
                                                         <input type="file" name="myfile">
                                                         <button>업로드</button>
                                                         </form>
                                                         <pre id="result"></pre>-->

                                                        <form>
                                                            File Description:<input type="text" id="desc" /><br />
                                                            Choose File:<input type="file" id="chosenFile" /><br />
                                                            <input type="button" id="submitFile" value="업로드" />
                                                        </form>
                                                        
                                                        <script type="text/javascript">
                                                            jQuery.noConflict();
                                                            jQuery(document).ready(function() {
                                                                    $("#submitFile").click(function() {
                                                                        $.ajax({
                                                                                url: "/proc/member/oto_inq_mng/upload2.php";
                                                                                type: "POST";
                                                                                contentType: false,
                                                                                processData: false,
                                                                                data: function() {
                                                                                      var data = new FormData();
                                                                                      data.append("fileDescription", jQuery("#desc").val());
                                                                                      data.append("chosenFile", jQuery("$chosenFile").get(0).files[0]);
                                                                                      return data;
                                                                                      // 또는 return new FormData(jQuery("form")[0]); 로 표현가능
                                                                                }(),
                                                                                error: function(_, testStatus, errorThrown) {
                                                                                     alert("Error");
                                                                                     console.log(textStatus, errorThrown);
                                                                                },
                                                                                success: function(response, textStatus) {
                                                                                    alert("Success");
                                                                                    console.log(response, textStatus);
                                                                                }
                                                                             });
                                                                    });
                                                            });
                                                       </script>
                                                           
                              <p class="btn-lg red_btn">
                                 <a href="#">등록한 내용으로 답변</a>					
                              </p>
                       </fieldset>
					   
					   </div>
InquireInfoDetailHtml2;

    return $html;
}


?>
