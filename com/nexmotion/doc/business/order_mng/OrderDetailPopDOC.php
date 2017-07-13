<?
/**
 * @brief 주문 상태 상세조회 팝업 html 생성
 *
 * @param $param = 
 *
 * @return 팝업 html
 */
function makeOrderDetailHtml($param) {
    $html = <<<html
    <dl>
        <dt class="tit">
            <h4>주문상세조회</h4>
        </dt>
        <dt class="cls">
            <button type="button" onclick="hideRegiPopup();" class="btn btn-sm btn-danger fa fa-times"></button>
        </dt>
    </dl>  
														 	
    <div class="pop-base fl fix_width1000"> 
        <div class="tb_group fix_width950 mt25">
                <div class="tab_box_con">
                    <div class="tabbable">                   	
                      	<ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_list1" data-toggle="tab"> 조판 </a> </li>
                           <li><a href="#tab_list2" data-toggle="tab"> 출력 </a> </li>
                           <li><a href="#tab_list3" data-toggle="tab"> 인쇄 </a> </li>
                           <li><a href="#tab_list4" data-toggle="tab"> 후공정 </a> </li>
                           <li><a href="#tab_list5" data-toggle="tab"> 입출고 </a> </li>
                      	</ul>
                      	<div class="tab-content">                		  
                     	    
                     	    <!-- 탭 박스 조판 -->
	                        <div class="tab-pane active" id="tab_list1">
	                            <div class="pop-content ofa fix_height590">
                                    <ul class="form-group">
                                        <li class="fix_width440 fl">
                                            <label class="control-label fix_width79 tar">조판명</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width150 tar">조판명 (A123456789)</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조판자</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width120 tar">상업인쇄팀 박땡떙</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">계열/절수</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width63 tar">46 / 2절</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조판사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width73 tar">788*595</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조판일자</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width120 tar">2015.10.22 15:00</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">홍각기/돈떙</label><label class="fix_width20 fs14 tac">:</label>
        		                         	<label class="control-label fix_width40 tar">홍각기</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">원본파일</label><label class="fix_width20 fs14 tac">:</label>
        		                         	<label class="control-label fix_width150 tar">명함_1111111111111</label>
        		                         	<br />
        		                         	<label class="fix_width79"></label>
        		                         	<label class="control-label fix_width170 tar">11111234567890.ai</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">인쇄수량</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width63 tar">1R</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조판메모</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width85 tar">컴퍼니 이정은</label>
                                          	<br />
                                          	
                                          	<br />                      	  	  
                                          	  	  
                                        </li>                        
                                      	  
                                        <li  class="fix_width350 fl">                               	
                                            <div class="process_view_box7">  
                                      	    	! 배다인쇄
                                      	    </div>                                  	  
                                      	    <br />
                                      	    <div class="process_view_box8">  
                                      	    	* 출력정보
                                      	    </div>                          
                                        </li>                                  
                                    </ul>
                                </div> 
	                        </div> <!-- 탭 박스 조판 -->
	                        
	                        <!-- 탭 박스 출력 -->
	                        <div class="tab-pane" id="tab_list2">
	                            <div class="pop-content ofa fix_height590">
                                    <ul class="form-group">
                                        <li class="fix_width440 fl">
                                            <label class="control-label fix_width79 tar">출력명</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width150 tar">출력명 (A123456789)</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">발주자</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width120 tar">상업인쇄팀 박땡떙</label>
                                          	<br />
                                          	
        		                            <label class="control-label fix_width79 tar">수주처</label><label class="fix_width20 fs14 tac">:</label>
        		                            <label class="control-label fix_width79 tar">본사출력실</label>
        		                            <label class="fix_width15"></label>
                                          	<label class="control-label fix_width79 tar">작업자</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width40 tar">제조사</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">발주방법</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width55 tar">전화발주</label>
                                          	<label class="control-label fix_width100 tar">02-2245-9876</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">날짜</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width250 tar">2015.10.22 15:00 ~ 2015.1022 15:23</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width100 tar">국 (788 * 595)</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width100 tar">4판</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">판구분</label><label class="fix_width20 fs14 tac">:</label>
        		                         					<label class="control-label fix_width40 tar">국산판</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조판메모</label><label class="fix_width20 fs14 tac">:</label>
                                          	<textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">작업자메모</label><label class="fix_width20 fs14 tac">:</label>
                                          	<textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">작업금액</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width50 tar">150,000</label>
                                          	<br />
                                          	
                                          	<label class="control-label fix_width79 tar">조정금액</label><label class="fix_width20 fs14 tac">:</label>
                                          	<label class="control-label fix_width50 tar">8,500</label>
                                          	<br />                      	  	  
                                          	  	  
                                        </li>                        
                                      	  
                                        <li  class="fix_width350 fl">                               	
                                            <div class="process_view_box7">
                                      	    	! 배다인쇄
                                      	    </div>                                  	  
                                      	    <br />
                                      	    <div class="process_view_box8">  
                                      	    	* 출력정보
                                      	    </div>                          
                                        </li>                                  
                                    </ul>
                                </div>	                            
	                        </div> <!-- 탭 박스 출력 -->
	                        
	                        <!-- 탭 박스 인쇄 -->
	                        <div class="tab-pane" id="tab_list3">
	                            <div class="pop-content ofa fix_height590">

                                    <ul class="form-group">
                                        <li class="fix_width440 fl">
                                      	    <label class="control-label fix_width79 tar">인쇄명</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width150 tar">인쇄명 (A123456789)</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">발주자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width120 tar">상업인쇄팀 박땡떙</label>
                                      	    <br />
                                      	    
    		                         	    <label class="control-label fix_width79 tar">수주처</label><label class="fix_width20 fs14 tac">:</label>
    		                         	    <label class="control-label fix_width79 tar">본사출력실</label>
    		                         	    <label class="fix_width15"></label>
                                      	    <label class="control-label fix_width79 tar">작업자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width40 tar">제조사</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">발주방법</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width55 tar">전화발주</label>
                                      	    <label class="control-label fix_width100 tar">02-2245-9876</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">날짜</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width250 tar">2015.10.22 15:00 ~ 2015.1022 15:23</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">사이즈</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width100 tar">국 (788 * 595)</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width100 tar">4R</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">인쇄도수</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width150 tar">전면 기본 4도 별색 1도</label>                                  	  	  
                                      	    <br />
                                      	    <label class="control-label fix_width81 tar"></label>
                                      	    <label class="control-label fix_width170 tar">후면 기본 1도 별색 1도</label>
                                      	    <br />                              	  	  
                                      	    
                                      	    <label class="control-label fix_width79 tar">조판메모</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">작업자메모</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">작업금액</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width50 tar">150,000</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">조정금액</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width50 tar">8,500</label>                                      	    
                                        </li>                        	  
                                        <li  class="fix_width350 fl">
                                            <div class="process_view_box7">
                                  	    	! 배다인쇄
                                  	        </div>
                                  	        <br />
                                  	        <div class="process_view_box8">  
                                  	    	* 인쇄정보
                                  	        </div>
                                        </li>
                                  
                                    </ul>
                                </div> 
	                        </div> <!-- 탭 박스 인쇄 -->
	                        
	                        <!-- 탭 박스 후공정 -->
	                        <div class="tab-pane" id="tab_list4">
	                            <div class="pop-content ofa fix_height590">
                                    <ul class="form-group">
                                        <li class="fix_width440 fl">
                                            <label class="control-label fix_width79 tar">후공정명</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width162 tar">후공정명 (A123456789)</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">발주자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width120 tar">상업인쇄팀 박땡떙</label>
                                      	    <br />
                                      	    
    		                         	    <label class="control-label fix_width79 tar">수주처</label><label class="fix_width20 fs14 tac">:</label>
    		                         	    <label class="control-label fix_width79 tar">본사출력실</label>
    		                         	    <label class="fix_width15"></label>
                                      	    <label class="control-label fix_width79 tar">작업자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width40 tar">제조사</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">발주방법</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width55 tar">전화발주</label>
                                      	    <label class="control-label fix_width100 tar">02-2245-9876</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">날짜</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width250 tar">2015.10.22 15:00 ~ 2015.1022 15:23</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">소분류</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width55 tar">카테고리</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">작업상세</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width55 tar">코팅</label>
                                      	    <label class="control-label fix_width55 tar">무광</label>
                                      	    <label class="control-label fix_width55 tar">단면</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">수량</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width100 tar">4R</label>
                                      	    <br />                             	    
                                      	    
                                      	    <label class="control-label fix_width79 tar">접수자메모</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">작업자메모</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <textarea class="bs_noti2" disabled>어저구 저쩌구 그래서 어쩐다 그런다 </textarea>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">작업금액</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width50 tar">150,000</label>
                                      	    <label class="fix_width55"></label>
                                      	    <label class="control-label fix_width79 tar">조정금액</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width50 tar">8,500</label>                                	    
                                        </li>                        	  
                                        <li  class="fix_width350 fl">
                                            <div class="process_view_box7">
                                      	    	! 배다인쇄
                                            </div>
                                  	        <br />
                                  	        <div class="process_view_box9">
                                  	    	    * 대상정보
                                  	        </div>
                                  	        <br />
                                  	        <div class="process_view_box9">
                                  	    	    * 후공정정보
                                  	        </div>
                                        </li>                                  
                                    </ul>
                                </div>
	                        </div> <!-- 탭 박스 후공정 -->
	                        
	                        <!-- 탭 박스 후공정 -->
	                        <div class="tab-pane" id="tab_list5">
	                            <div class="pop-content ofa fix_height590">
                                    <ul class="form-group">
                                        <li class="fix_width440 fl">                               	    
    		                         	    <label class="control-label fix_width79 tar">입고자</label><label class="fix_width20 fs14 tac">:</label>
    		                         	    <label class="control-label fix_width40 tar">김발주</label>
    		                         	    <label class="fix_width30"></label>
                                      	    <label class="control-label fix_width79 tar">입고일자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width120 tar">2015.10.22 15:00</label>
                                      	    <br />
                                      	    
                                      	    <label class="control-label fix_width79 tar">출고자</label><label class="fix_width20 fs14 tac">:</label>
    		                         	    <label class="control-label fix_width40 tar">김발주</label>
    		                         	    <label class="fix_width30"></label>
                                      	    <label class="control-label fix_width79 tar">출고일자</label><label class="fix_width20 fs14 tac">:</label>
                                      	    <label class="control-label fix_width120 tar">2015.10.22 15:23</label>                              	                                    	    
                                        </li>                        	                                                 
                                    </ul>
                                </div>
	                        </div> <!-- 탭 박스 후공정 -->
	                        
	                    </div>
                    </div>
                </div>
        </div>
    </div>
     <!-- pop-base -->
     
    <div class="pop-base clear">     
        <p onclick="hideRegiPopup();" class="tac mt5">
            <label class="btn btn_md fix_width120"> 닫기</label>          
        </p>
        <br /><br />          
    </div>
html;

    return $html;
}
?>
