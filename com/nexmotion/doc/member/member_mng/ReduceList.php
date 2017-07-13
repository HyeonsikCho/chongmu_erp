<?
//정리회원 정보 
function makeReduceMemberInfo($param) {

    $html = <<<ReduceHtml

        <ul class="tab_box mt25">
        <li><a class="box">정리회원 정보</a></li>
        </ul>
        <form>
        <div class="tab_box_con">

        <fieldset class="mt25">
        <legend> 매출정보 </legend>	

        <div class="form-group">
        <label class="control-label fix_width120 tar">회원명 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[member_name]" disabled>
        <label class="control-label fix_width75 tar">아이디 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[member_id]" disabled>
        <label class="control-label fix_width75 tar">회원구분 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[member_dvs]" disabled>
        <label class="control-label fix_width75 tar">판매채널 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[sell_site]" disabled>
        <br />
        <label class="control-label fix_width120 tar">핸드폰 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[cell_num]" disabled>
        <label class="control-label fix_width75 tar">E-Mail </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[mail]" disabled>
        <label class="control-label fix_width75 tar">생년월일 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[birth]" disabled>
        <label class="fix_width10"></label>
        <label class="form-radio form-normal"><input type="radio" name="new_yn" class="radio_box" checked disabled> 기존회원</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="new_yn" class="radio_box" disabled> 신규회원</label>  

        <hr class="hr_bd2">

        <label class="control-label fix_width120 tar">사내성향평가  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width310" placeholder="" value="$param[eval_reason]" disabled>
        <br />
        <label class="control-label fix_width120 tar">가입일자  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width310" placeholder="" value="$param[first_join_date]" disabled>
        <br />
        <label class="control-label fix_width120 tar">첫주문  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width310" placeholder="" value="$param[first_order_date]" disabled>
        <br />
        <label class="control-label fix_width120 tar">최근주문  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width310" placeholder="" value="$param[final_order_date]" disabled>

        <hr class="hr_bd2">

        <label class="control-label fix_width120 tar">등급 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[grade_name]" disabled> 
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[member_typ]" disabled> 
        <br />
        <label class="control-label fix_width120 tar">주문건수 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis fix_width140" placeholder="" value="$param[order_count]" disabled> 건 

        </div>

        </fieldset>						 	

        <fieldset class="mt25">
        <legend> 매출정보 </legend>	

        <div class="form-group">
        <label class="control-label fix_width110 tar">일자별 검색</label><label class="fix_width20 fs14 tac"> : </label>
         $param[date_picker_html]
        <p class="btn-lg red_btn">
        <a style="cursor: pointer;" onclick="searchMemberDetailInfo('sales');">선택 조건으로 검색</a>
        </p>				                           
        </div>


        <div class="table-body">
        <ul class="table_top">
        <li class="sel">
        <label class="fs14 fwb" id="member_sales_total"></label>     
        </li>
        <li class="sel tar">
        <label for="sales_search" class="con_label">Search(인쇄물제목) : <input id="sales_search" type="text" class="search_btn fix_width180" onkeydown="detailSearchKey(event, this.value, 'sales');"><button type="button" class="btn btn-sm btn-info fa fa-search" onclick="detailSearchText('sales');"></button></label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px"> No</th>					                      					        
        <th class="bm2px">주문번호</th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="detailSortList('order_num', this, 'sales');" class="blue_text01 sorting">인쇄물제목 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="detailSortList('order_detail', this, 'sales');" class="blue_text01 sorting">상품내역 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px">수량(건)</th>	
        <th class="bm2px">결제금액</th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="detailSortList('order_regi_date', this, 'sales');" class="blue_text01 sorting">주문일 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px">상태</th>
        <th class="bm2px">상세보기</th>
        </tr>
        </thead>
        <tbody id="member_sales_list">	
        </tbody>
        </table>
        <p class="p_num_b fs12">
        Showing 1 to 5 of 30 entries
		<select name="detail_list_set" class="fix_width55" onchange="detailShowPageSetting(this.value, 'sales');">
        <option>5</option>
        <option>10</option>
        <option>20</option>
	    <option selected="selected">30</option>
        </select>
        </p>
        <div class="tac clear" id="member_sales_page">
        </div>
        </div>
        </div>

        </fieldset>

        <fieldset class="mt25">
        <legend> 탈퇴사유 </legend>	   

        <div class="form-group fix_width860 lh35 mauto">
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="1" id="reduce_1" disabled> 상품종류 부족</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="2" id="reduce_2" disabled> 상품가격 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="3" id="reduce_3" disabled> 상품품질 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="4" id="reduce_4" disabled> 반품/교환 서비스 불만</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="5" id="reduce_5" disabled> 납기 및 배송 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="6" id="reduce_6" disabled> AS서비스 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="7" id="reduce_7" disabled> 상담원 고객응대 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="8" id="reduce_8" disabled> 쇼핑몰 불편 및 속도불만</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="9" id="reduce_9" disabled> 이용빈도 낮음</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="10" id="reduce_10" disabled> 타인 주민등록 도용</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="11" id="reduce_11" disabled> 중복가입</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="12" id="reduce_12" disabled> 이민</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="13" id="reduce_13" disabled> 재가입</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="14" id="reduce_14" disabled> 기타</label>
        <textarea class="bs_noti3 input_dis_co2" style="width:840px;height:112px;" disabled>$param[withdraw_reason]</textarea>
        </div>
        </fieldset>

        </div>
        </form>

ReduceHtml;

    return $html;
}
?>

