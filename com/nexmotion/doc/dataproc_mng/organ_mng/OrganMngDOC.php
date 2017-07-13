<?
//부서 관리 html 팝업
function getDeparAdminHtml($param) {

    $html = <<<VIEWHTML

    <form name="depar_form" id="depar_form" method="post">
 
                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>부서추가</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        														 	
                        			    <div class="pop-base">                                    
                                            <div class="pop-content">								 	  	
                                                <div class="form-group">                               		 
                                                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select onchange="changeHighDepar(this.value);" id="sell_site" name="sell_site" class="fix_width200" $param[dis_sel]>
                                                        $param[sell_site_html]
        		                                    </select>

                                        		    <label class="control-label fix_width79 tar">부서명</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width191" id="depar_name" name="depar_name" value="$param[depar_name]">
                        			    		    <br />		    
                        			    				         
                                                    <label class="control-label fix_width79 tar">상위부서</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select name="high_depar_code" id="high_depar_code" class="fix_width200" $param[dis_sel]>
                                                        $param[high_depar_html]
        		                                    </select>
                                                    <br />
                                                </div>
                                                
                                                <hr class="hr_bd3">
                        			    		     
                                                <div class="form-group">
                                                    <p class="tac mt15">                                                        
                                            		    <button type="button" onclick="saveDeparInfo('$param[depar_admin_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                                        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>                                                        
                                                    </p> 
                                                </div>                                                                                         
                        			        </div> 
                        			    </div>                    			    
 
    </form>
VIEWHTML;

    return $html;

}

//관리자 html 팝업
function getMngHtml($param) {

    $html = <<<VIEWHTML

    <form name="mng_form" id="mng_form" method="post">
                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>관리자 관리</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        			    <div class="pop-base">
                                            <div class="pop-content">
                                                <div class="form-group">
                                                    <label class="control-label fix_width79 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select onchange="changeDepar(this.value);" id="sell_site" name="sell_site" class="fix_width200" $param[dis_sel]>
                                                        $param[sell_site_html]
        		                                    </select>
                        			    		    <br />
                                        		    <label class="control-label fix_width79 tar">성명</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width170" id="mng_name" name="mng_name" value="$param[mng_name]">
                        			    		    <br />
                        			    		    
                        			    		    <label class="control-label fix_width79 tar">사원번호</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width170" name="empl_code" value="$param[empl_code]">
                        			    		    <br />
                        			    		    
                        			    		    <label class="control-label fix_width79 tar">ID</label><label class="fix_width20 fs14 tac">:</label>
                        			    		    <input type="text" class="input_co2 fix_width170" id="empl_id" name="empl_id" value="$param[empl_id]">
                        			    		    <button onclick="resetPasswd('$param[empl_seqno]'); return false;" class="btn btn_pu fix_width120 fix_height30 bgreen fs12">비밀번호초기화</button>
                        			    		    <br /><br /><br />
                        			    		    
                        			    		    <label class="control-label fix_width79 tar">부서명</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select name="depar_code" id="depar_code" class="fix_width180">
                                                        $param[depar_name_html]
        		                                    </select>
                                                    <br />
                                                    
                                                    <label class="control-label fix_width79 tar">보안등급</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select name="admin_auth" class="fix_width100">
                                                        $param[admin_auth_html]
        		                                    </select>
                                                    <br />
                                                    
                                                    <label class="control-label fix_width79 tar">직책</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select name="job_code" class="fix_width100">
                                                        $param[job_name_html]
        		                                    </select>
                                                    <br />
                                                    
                                                    <label class="control-label fix_width79 tar">직급</label><label class="fix_width20 fs14 tac">:</label>
                                                    <select name="posi_code" class="fix_width100">
                                                        $param[posi_name_html]
        		                                    </select>
                                                    <br />

                                                    <label class="control-label fix_width79 tar">입사일</label><label class="fix_width20 fs14 tac">:</label>
                                                    <input placeholder="yyyy-MM-dd" class="input_co2 fix_width83 date" id="enter_date" name="enter_date" value="$param[enter_date]">
                                                    <br />                                            
                                                </div>
                                                
                                                <hr class="hr_bd3_b">
                        			    		     
                                                <div class="form-group">
                                                    <p class="tac mt15">
                                                        <label class="fix_width140"></label>
                                            		    <button type="button" onclick="saveMngInfo('$param[empl_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                                        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>
                                                        <label class="fix_width120"></label>
                                                        <button type="button" onclick="resignMng('$param[empl_seqno]'); return false;" class="btn btn-sm btn-danger">퇴사</button>
                                                    </p>
                                                </div>
                        			        </div>
                        			    </div>
    </form>

VIEWHTML;

    return $html;

}

//권한 관리 html 팝업
function getMngAuthHtml($param) {

    $html = <<<VIEWHTML

    <form name="auth_form" id="auth_form" method="post">
                        			    <dl>
                        			        <dt class="tit">
                        			       	    <h4>접근권한설정</h4>
                        			        </dt>
                        			        <dt class="cls">
                        			       	    <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-danger fa fa-times"></button>
                        			        </dt>
                        			    </dl>
                        														 	
                        			    <div class="pop-base">                                    
                                            <div class="pop-content table-body">								 	  	
                                                <div class="table_basic">                                
                                			        <table class="table fix_width100f">
                                                        <thead>
                                			                <tr>
                                			    	            <th class="bm2px">#</th>
                                			    	            <th class="bm2px">분류</th>
                                			    	            <th class="bm2px">페이지</th>
                                			    	            <th class="bm2px">허용여부</th>                                			    	            
                                			                </tr>
                                                        </thead>
                                                        <tbody>
                                			                <tr>                  
                                			                	<td>1</td>
                                			                	<td>영업</td>
                                			                	<td>주문통합관리</td>
                                			                	<td><input type="radio" value="Y" class="radio_box" name="business-order_common_mng" $param[order_common_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" value="N" class="radio_box" name="business-order_common_mng" $param[order_common_mng_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>2</td>
                                			                	<td>영업</td>
                                			                	<td>주문수기등록</td>
                                                                <td><input type="radio" value="Y" class="radio_box" name="business-order_hand_regi" $param[order_hand_regi_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" value="N" class="radio_box" name="business-order_hand_regi" $param[order_hand_regi_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>3</td>
                                			                	<td>영업</td>
                                			                	<td>견적리스트</td>
                                                                <td><input type="radio" value="Y" class="radio_box" name="business-esti_list" $param[esti_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" value="N" class="radio_box" name="business-esti_list" $param[esti_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>클레임관리</td>
                                                                <td><input type="radio" value="Y" class="radio_box" name="business-claim_list" $param[claim_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" value="N" class="radio_box" name="business-claim_list" $param[claim_list_n]>허용안함</label></td> 
                                			                </tr>                    			               
                                                            <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>MBO통합보고서</td> <td><input type="radio" value="Y" class="radio_box" name="business-mbo_common_report" $param[mbo_common_report_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="business-mbo_common_report" $param[mbo_common_report_n]>허용안함</label></td> 
                                			                </tr>  
                                                            <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>MBO관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="business-mbo_mng" $param[mbo_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="business-mbo_mng" $param[mbo_mng_n]>허용안함</label></td> 
                                			                </tr>  
                                                            <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>매출MBO</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="business-sales_mbo" $param[sales_mbo_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="business-sales_mbo" $param[sales_mbo_n]>허용안함</label></td> 
                                			                </tr>  
                                                            <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>미수금MBO</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="business-oa_mbo" $param[oa_mbo_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="business-oa_mbo" $param[oa_mbo_n]>허용안함</label></td> 
                                			                </tr>  
                                                            <tr class="cellbg">   
                                			                    <td>4</td>               
                                			                	<td>영업</td>
                                			                	<td>매출추이리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="business-sales_prog_list" $param[sales_prog_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="business-sales_prog_list" $param[sales_prog_list_n]>허용안함</label></td> 
                                			                </tr>  
                                			                <tr>                  
                                			                	<td>6</td>
                                			                	<td>생산</td>
                                			                	<td>접수리스트</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="produce-receipt_list" $param[receipt_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-receipt_list" $param[receipt_list_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>7</td>
                                			                	<td>생산</td>
                                			                	<td>조판대기리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-typset_standby_list" $param[typset_standby_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-typset_standby_list" $param[typset_standby_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>8</td>
                                			                	<td>생산</td>
                                			                	<td>조판리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-typset_list" $param[typset_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-typset_list" $param[typset_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">   
                                			                    <td>9</td>               
                                			                	<td>생산</td>
                                			                	<td>생산공정관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-process_mng" $param[process_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-process_mng" $param[process_mng_n]>허용안함</label></td> 
                                			                </tr>                    			               
                                			                <tr>                  
                                			                	<td>10</td>
                                			                	<td>생산</td>
                                			                	<td>인쇄생산기획</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-print_produce_plan" $param[print_produce_plan_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-print_produce_plan" $param[print_produce_plan_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>11</td>
                                			                	<td>생산</td>
                                			                	<td>종이자재관리</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="produce-paper_materials_mng" $param[paper_materials_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-paper_materials_mng" $param[paper_materials_mng_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>12</td>
                                			                	<td>생산</td>
                                			                	<td>종이재고관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-paper_stock_mng" $param[paper_stock_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="procude-paper_stock_mng" $param[paper_stock_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>13</td>
                                			                	<td>생산</td>
                                			                	<td>원자재관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-raw_materials_mng" $param[raw_materials_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-raw_materials_mng" $param[raw_materials_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">   
                                			                    <td>14</td>               
                                			                	<td>생산</td>
                                			                	<td>공정별결과</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-process_result" $param[process_result_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-process_result" $param[process_result_n]>허용안함</label></td> 
                                			                </tr>                    			               
                                			                <tr>                  
                                			                	<td>15</td>
                                			                	<td>생산</td>
                                			                	<td>인쇄생산대비실적</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="produce-print_plan_result" $param[print_plan_result_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="produce-print_plan_result" $param[print_plan_result_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>16</td>
                                			                	<td>회원</td>
                                			                	<td>회원통합리스트</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="member-member_common_list" $param[member_common_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="member-member_common_list" $param[member_common_list_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr>                  
                                			                	<td>16</td>
                                			                	<td>회원</td>
                                			                	<td>휴면대상회원리스트</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="member-quiescence_list" $param[quiescence_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="member-quiescence_list" $param[quiescence_list_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr>                  
                                			                	<td>16</td>
                                			                	<td>회원</td>
                                			                	<td>정리회원리스트</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="member-reduce_list" $param[reduce_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="member-reduce_list" $param[reduce_list_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                    			            <tr>                  
                                			                	<td>16</td>
                                			                	<td>회원</td>
                                			                	<td>배송친구리스트</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="member-delivery_list" $param[delivery_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="member-delivery_list" $param[delivery_list_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr>                  
                                			                	<td>16</td>
                                			                	<td>회원</td>
                                			                	<td>1:1문의 관라</td>
                                			                	<td><input type="radio" class="radio_box" value="Y" name="member-oto_inq_mng" $param[oto_inq_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="member-oto_inq_mng" $param[oto_inq_mng_n]>허용안함</label></td>                                			                	
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>17</td>
                                			                	<td>마케팅</td>
                                			                	<td>등급관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="mkt-grade_mng" $param[grade_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="mkt-grade_mng" $param[grade_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>17</td>
                                			                	<td>마케팅</td>
                                			                	<td>포인트관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="mkt-point_mng" $param[point_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="mkt-point_mng" $param[point_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>17</td>
                                			                	<td>마케팅</td>
                                			                	<td>쿠폰관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="mkt-cp_mng" $param[cp_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="mkt-cp_mng" $param[cp_mng_n]>허용안함</label></td> 
                                			                </tr>
                                 			                <tr class="cellbg">                  
                                			                	<td>17</td>
                                			                	<td>마케팅</td>
                                			                	<td>이벤트관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="mkt-event_mng" $param[event_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="mkt-event_mng" $param[event_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr class="cellbg">                  
                                			                	<td>17</td>
                                			                	<td>마케팅</td>
                                			                	<td>마케팅승인관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="mkt-mkt_aprvl_mng" $param[mkt_aprvl_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="mkt-mkt_aprvl_mng" $param[mkt_aprvl_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>상품가격리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-prdt_price_list" $param[prdt_price_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-prdt_price_list" $param[prdt_price_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>후공정가격리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-after_price_list" $param[after_price_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-after_price_list" $param[after_price_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>옵션가격리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-opt_price_list" $param[opt_price_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-opt_price_list" $param[opt_price_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>계산형가격리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-calcul_price_list" $param[calcul_price_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-calcul_price_list" $param[calcul_price_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>카테고리리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-cate_list" $param[cate_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-cate_list" $param[cate_list_n]>허용안함</label></td> 
                                			                </tr>
                                 			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>기본생산업체관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-basic_pro_bus_mng" $param[basic_pro_bus_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-basic_pro_bus_mng" $param[basic_pro_bus_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>상품기초등록</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-prdt_basic_regi" $param[prdt_basic_regi_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-prdt_basic_regi" $param[prdt_basic_regi_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>상품구성아이템등록</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-prdt_item_regi" $param[prdt_item_regi_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-prdt_item_regi" $param[prdt_item_regi_n]>허용안함</label></td> 
                                			                </tr>

                                 			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>매입업체리스트</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-pur_etprs_list" $param[pur_etprs_list_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-pur_etprs_list" $param[pur_etprs_list_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>매입업체등록</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-pur_etprs_regi" $param[pur_etprs_regi_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-pur_etprs_regi" $param[pur_etprs_regi_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>조판관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-typset_mng" $param[typset_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-typset_mng" $param[typset_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>종이관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-paper_mng" $param[paper_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-paper_mng" $param[paper_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>출력관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-output_mng" $param[output_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-output_mng" $param[output_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>인쇄관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-print_mng" $param[print_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-print_mng" $param[print_mng_n]>허용안함</label></td> 
                                			                </tr>
                                 			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>후공정관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-after_mng" $param[after_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-after_mng" $param[after_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>기초관리</td>
                                			                	<td>옵션관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="basic_mng-opt_mng" $param[opt_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="basic_mng-opt_mng" $param[opt_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>상품정보관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-prdt_info_mng" $param[prdt_info_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-prdt_info_mng" $param[prdt_info_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>자제설명관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-mtra_dscr_mng" $param[mtra_dscr_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-mtra_dscr_mng" $param[mtra_dscr_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>권한관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-auth_mng" $param[auth_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-auth_mng" $param[auth_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>조직관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-organ_mng" $param[organ_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-organ_mng" $param[organ_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>패스워드변경</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-passwd_change" $param[passwd_change_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-passwd_change" $param[passwd_change_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>팝업관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-popup_mng" $param[popup_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-popup_mng" $param[popup_mng_n]>허용안함</label></td> 
                                			                </tr>
                                			                <tr>                  
                                			                	<td>18</td>
                                			                	<td>전산관리</td>
                                			                	<td>공지관리</td>
                                                                <td><input type="radio" class="radio_box" value="Y" name="dataproc_mng-notice_mng" $param[notice_mng_y]>허용
                                			                	    <label class="fix_width10"> </label>
                                			                	    <input type="radio" class="radio_box" value="N" name="dataproc_mng-notice_mng" $param[notice_mng_n]>허용안함</label></td> 
                                			                </tr>
                                                        </tbody>
                                			        </table>                    			        	              
                                                </div>
                        			        </div> 
                        			    </div>          
                                                    <p class="tac mt15">                                                        
                                            		    <button type="button" onclick="saveMngAuth('$param[empl_seqno]'); return false;" class="btn btn-sm btn-success">저장</button>
                                                        <button type="button" onclick="hideRegiPopup(); return false;" class="btn btn-sm btn-primary">닫기</button>                                                        
                                                    </p> 
                                                    <br /><br />
    </form>

VIEWHTML;

    return $html;

}

?>


