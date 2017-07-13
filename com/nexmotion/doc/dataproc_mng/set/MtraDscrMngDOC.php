<?
//종이설명 팝업 html
function getPaperDscrHtml($param) {

    $html = <<<VIEWHTML

    <form name="paper_form" id="paper_form" method="post">
 
                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>종이 기본설명 관리</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        														 	
                        			    <div class="pop-base">                                    
                                            <div class="pop-content">								 	  	
                                                <div class="form-group">                               		 
                                        		    <label class="control-label fix_width79 tar">종이명</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" id="paper_name" name="paper_name" class="input_co2 fix_width180" value="$param[name]">
                        			    		    <br />		    
                        			    				         
                                                    <label class="control-label fix_width79 tar">구분</label><label class="fix_width20 fs14 tac">:</label>
                                                    <input type="text" class="input_co2 fix_width180" id="dvs" name="dvs" value="$param[dvs]">
                                                    <br />
                                                    
                                                    <label class="control-label fix_width79 tar">느낌</label><label class="fix_width20 fs14 tac">:</label>
                                                    <input type="text" class="input_co2 fix_width180" id="sense" name="sense" value="$param[sense]">
                                                    <br />
                                                </div>
                                                
                                                <hr class="hr_bd3_b">
                        			    		     
                                                <div class="form-group">
                                                    <p class="tac mt15">
                                                        <label></label>
                                            		    <button type="button" onclick="savePaperDscr('$param[paper_dscr_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                                        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                                        <button type="button" onclick="delPaperDscr('$param[paper_dscr_seqno]'); return false;" class="btn btn-sm btn-danger">삭제</button>
                                                    </p> 
                                                </div>                                                                                         
                        			        </div> 
                        			    </div>                    			    

    </form>
VIEWHTML;

    return $html;

}

//후공정설명 팝업 html
function getAfterDscrHtml($param) {

    $html = <<<VIEWHTML

    <form name="after_form" id="after_form" method="post">

                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>후공정 기본설명 관리</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        			    <div class="pop-base">
                                            <div class="pop-content">
                                                <div class="form-group">
                                        		    <label class="control-label fix_width79 tar">후공정명</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width250" id="after_name" name="after_name" value="$param[name]">
                        			    		    <br />		    
                        			    				         
                                                    <label class="control-label fix_width79 tar">후공정설명</label><label class="fix_width20 fs14 tac">:</label>
                                                    <textarea class="bs_noti2" name="dscr" id="after_dscr">$param[dscr]</textarea>
                                                    <br />                                               
                                                </div>
                                                
                                                <hr class="hr_bd3_b">
                        			    		     
                                                <div class="form-group">
                                                    <p class="tac mt15">
                                            		    <button type="button" onclick="saveAfterDscr('$param[after_dscr_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                                        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                                        <button type="button" onclick="delAfterDscr('$param[after_dscr_seqno]'); return false;" class="btn btn-sm btn-danger">삭제</button>
                                                    </p>
                                                </div>
                        			        </div>
                        			    </div>

    </form>
VIEWHTML;

    return $html;

}

//옵션설명 팝업 html
function getOptDscrHtml($param) {

    $html = <<<VIEWHTML

    <form name="opt_form" id="opt_form" method="post">

                                
                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>옵션 기본설명 관리</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        			    <div class="pop-base">
                                            <div class="pop-content">
                                                <div class="form-group">
                                        		    <label class="control-label fix_width79 tar">옵션명</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width250" name="opt_name" id="opt_name" value="$param[name]">
                        			    		    <br />		    
                        			    				         
                                                    <label class="control-label fix_width79 tar">옵션설명</label><label class="fix_width20 fs14 tac">:</label>
                                                    <textarea name="dscr" id="opt_dscr" class="bs_noti2">$param[dscr]</textarea>
                                                    <br />                                               
                                                </div>
                                                <hr class="hr_bd3_b">
                        			    		     
                                                <div class="form-group">
                                                    <p class="tac mt15">
                                            		    <button onclick="saveOptDscr('$param[opt_dscr_seqno]'); return false;" type="button" class="btn btn-sm btn-success">저장</button>
                                                        <button onclick="hideRegiPopup(); return false;" type="button" class="btn btn-sm btn-primary">닫기</button>
                                                        <button onclick="delOptDscr('$param[opt_dscr_seqno]'); return false;" type="button" class="btn btn-sm btn-danger">삭제</button>
                                                    </p>
                                                </div>
                        			        </div>
                        			    </div>
 
    </form>
VIEWHTML;

    return $html;

}




?>
