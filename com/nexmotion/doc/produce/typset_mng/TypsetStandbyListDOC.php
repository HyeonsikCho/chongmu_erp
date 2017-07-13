<?
//분판 팝업
function getDivideTypsetPopup() {

    $html = <<<HTML
                       	         <!-- View edit 팝업창 -->                       	         
                       	 <!--        <div class="pop_add_box fix_width350 position350"> -->
														     <dl>
														         <dt class="tit">
														         	  <h4>분판관리</h4>
														         </dt>
														         <dt class="cls">
														         	  <button type="button" class="btn btn-sm btn-danger fa fa-times"></button>
														         </dt>
														     </dl>
														      
														      <div class="pop-base">
														       	  <div class="pop-content">
														       	  	
							                       	           <div class="form-group tac">
							                       	               <input type="text" class="input_co2 fix_width55" value="1"> 
							                       	               <button type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></button>
							                       	               <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-minus"></i></button>
							                       	           </div>  
							                       	           <div class="form-group tac">
							                       	               <input type="text" class="input_co2 fix_width55" value="1"> 
							                       	               <button type="button" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></button>
							                       	               <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-minus"></i></button>
							                       	           </div>
							                       	           <hr class="hr_bd2">
							                       	           <div class="form-group tac">							                    	               
							                       	               <label class="control-label fix_width">합계</label><label class="fix_width20 fs14 tac">:</label>
							                       	               <label class="control-label fix_width">1000</label>
							                       	           </div>  
							                       	           
														       	  </div>
														      </div>
                                 
														       <div class="pop-base tac">
														       	   <button type="button" class="btn  btn-primary fwb nanum"> 저장</button>
														       </div>
                                 
                       	         </div>                       	         
                       	         <!-- View edit 팝업창 -->

 
HTML;

    return $html;
}

?>
