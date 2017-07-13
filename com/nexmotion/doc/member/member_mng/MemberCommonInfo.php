<?php
//회원 기본정보 VIEW
function makeMemberBasicInfoHtml($param) {

    $html = <<<CommonInfoHtml
        <div class="tab_box_con">
        <fieldset>
        <legend> 기본정보 </legend>	
        <div class="form-group">
        <label class="control-label fix_width120 tar">회원명</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width120" value="$param[member_name]" disabled>
        <label class="control-label fix_width75 tar">아이디</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width145" value="$param[member_id]" disabled>
        <label class="control-label fix_width75 tar">회원구분</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width120" style="width: 127px;padding: 5px;" value="" id="member_dvs">
        <option value="개인">개인</option>
        <option value="기업">기업</option>
        <option value="외국인">외국인</option>
        </select>
        <label class="control-label fix_width75 tar">판매채널</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width145" value="$param[sell_site]" disabled>
        </div>               
        <div class="form-group">
        <label class="control-label fix_width120 tar">핸드폰</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width120" value="$param[cell_num]" id="cell_num" onkeydown="removeChar(event);">
        <label class="control-label fix_width75 tar">E-mail</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width145" value="$param[mail]" id="mail">
        <label class="control-label fix_width75 tar">생년월일</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width120" value="$param[birth]" id="birth" onkeydown="removeChar(event);">
        <label class="control-label fix_width75 tar">가격회원</label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="new_yn" class="radio_box" value="N" disabled> 기존회원</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="new_yn" class="radio_box" value="Y" disabled> 신규회원</label>
        </div>
        <div class="form-group">
        <label class="control-label fix_width120 tar">업체구분</label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked class="radio_box" name="member_typ" value="일반회원" onclick="selectMemberTyp(this.value);"> 일반회원</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="member_typ" class="radio_box" value="예외업체" onclick="selectMemberTyp(this.value);"> 예외업체</label>
        <label class="control-label tar" style="width:159px;">파일업로드</label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="onefile_etprs_yn" class="radio_box" value="Y"> 원파일</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="onefile_etprs_yn" class="radio_box" value="N"> 낱건파일</label>
        <label class="control-label tar" style="width:159px;">카드결재</label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="card_pay_yn" class="radio_box" value="Y"> 가능</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="card_pay_yn" class="radio_box" value="N"> 불가능</label>
        </div>
        <div class="form-group" id="oa" style="display:none;">
        <label class="control-label fix_width120 tar">고정미수</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width170" value="$param[fix_oa]" id="fix_oa" onkeyup="this.value == onlyNumber(event, this);">
        <label class="control-label tar" style="width:159px;">악성미수</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width170" value="$param[bad_oa]" id="bad_oa" onkeyup="this.value == onlyNumber(event, this);">
        <label class="control-label tar" style="width:148px;">여신한도</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width170" value="$param[loan_limit_price]" id="loan_limit_price" onkeyup="this.value == onlyNumber(event, this);">
        </div>
        <div class="form-group">
        <label class="fix_width10"></label>   
        </div>
        <label class="btn btn_md fix_width140 fr" onclick="saveBasicInfo('$param[member_seqno]');"><i class="fa fa-user"></i> 가입정보 기본저장</label>
        </fieldset>	
        </div>

CommonInfoHtml;

    return $html;
}

//회원정보 VIEW - 요약정보 
function makeMemberSummaryInfoHtml($param) {
 
    $html = <<<SummaryInfoHtml
 
        <div class="form-group">
        <label class="control-label fix_width150 tar">아이디 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[member_id]" disabled>
        <br />
        <label class="control-label fix_width150 tar">사내닉네임 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[nick]" disabled>
        </div>
        <hr class="hr_bd2">          
        <div class="form-group">                       	          
        <label class="control-label fix_width150 tar">E-mail 수신여부  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" name="mailing_yn" class="radio_box" value="Y" checked disabled> 예</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="mailing_yn" class="radio_box" value="N" disabled> 아니오</label>
        <br />
        <label class="control-label fix_width150 tar">SMS 수신여부  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" name="sms_yn" class="radio_box" checked value="Y" disabled> 예</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="sms_yn" class="radio_box" value="N" disabled> 아니오</label>                  
        </div>
        <hr class="hr_bd2">
        <div class="form-group">
        <label class="control-label fix_width150 tar">등급  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[grade_name]" disabled>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[member_typ]" disabled>
        <br />
        <label class="control-label fix_width150 tar">포인트  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[own_point]" disabled> <label class="control-label">P</label>
        <br />
        <label class="control-label fix_width150 tar">쿠폰  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width55" placeholder="" value="$param[cp]" disabled> <label class="control-label">매</label>
        <br />
        <label class="control-label fix_width150 tar">주문수  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[order_count]" disabled> <label class="control-label">건 (지난달)</label>
        </div>
        <hr class="hr_bd2">                           
        <div class="form-group">
        <label class="control-label fix_width150 tar">사내성향평가  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width310" placeholder="" value="$param[eval_reason]" disabled>
        <br />
        <label class="control-label fix_width150 tar">가입일자  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width310" placeholder="" value="$param[first_join_date]" disabled>
        <br />
        <label class="control-label fix_width150 tar">첫주문  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width310" placeholder="" value="$param[first_order_date]" disabled>
        <br />
        <label class="control-label fix_width150 tar">최근주문  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width310" placeholder="" value="$param[final_order_date]" disabled>    
        </div>
        <hr class="hr_bd2">           

        <div class="form-group">
        <label class="control-label fix_width150 tar">사내영업담당  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[biz_resp]" disabled>
        <br />
        <label class="control-label fix_width150 tar">사내출고담당  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[release_resp]" disabled>
        <br />
        <label class="control-label fix_width150 tar">사내배송담당 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width140" placeholder="" value="$param[dlvr_resp]" disabled>
        </div>

SummaryInfoHtml;

    return $html;
}

//회원정보 VIEW - 회원정보 
function makeMemberDetailInfoHtml($param) {
 
    $html = <<<DetailInfoHtml
        <fieldset>
        <legend> 기본정보 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">사내닉네임 </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[nick]" id="nick">
        <br />
        <label class="control-label fix_width150 tar">E-mail 수신여부  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="mailing_yn" class="radio_box" value="Y"> 예</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="mailing_yn" class="radio_box" value="N"> 아니오</label>

        <br />
        <label class="control-label fix_width150 tar">SMS 수신여부  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="sms_yn" class="radio_box" value="Y"> 예</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="sms_yn" class="radio_box" value="N"> 아니오</label>                  

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">인증정보  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="certi_yn" class="radio_box" value="Y" onclick="certiCtrl(this.value);"> 유</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="certi_yn" class="radio_box" value="N" onclick="certiCtrl(this.value);"> 무</label>
        <br />
        <div id="certi_info">
        <label class="control-label fix_width150 tar">인증번호  </label><label class="fix_width20 fs14 tac">:</label>                       	          
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[certinum]" id="certinum">
        <br />

        <label class="control-label fix_width150 tar">증빙이미지  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="control-label">
          <a href="/common/certi_file_down.php?seqno=$param[member_certi_seqno]">$param[origin_file_name]</a>
        </label> 
        <br />
        <label class="fix_width170"></label>
        <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
        <input class="disableInputField mt05" placeholder="Choose File" name="file_path" id="file_path" disabled="disabled" />

        <label class="fileUpload mt05">
        <input type="file" name="file_img" id="file_img" class="upload" onchange="fileSearchBtn(this.value, 'file');"/>
        <span class="btn btn-sm btn-info fa fa-folder-open">파일찾기</span>
        </label>
        </div>
        <hr class="hr_bd2">
        <label class="control-label fix_width150 tar">사내회원평가  </label><label class="fix_width20 fs14 tac">:</label>
        <textarea class="bs_noti" id="eval_reason">$param[eval_reason]</textarea>

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">사내영업담당  </label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width180" id="biz_resp">
          $param[biz_resp]
        </select>
        <br />
        <label class="control-label fix_width150 tar">사내출고담당  </label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width180" id="release_resp">
          $param[release_resp]
        </select>
        <br />
        <label class="control-label fix_width150 tar">사내배송담당 </label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width180" id="dlvr_resp">
          $param[dlvr_resp]
        </select>
        <br />
        <label class="control-label fix_width150 tar">일반 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="control-label fix_width150 tar">통화접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width180" id="gene_resp" onchange="selectBizResp(this.value, '$param[sell_site]', 'gene');">
          $param[biz_resp]
        </select>
        <select class="fix_width180" id="gene_tel_receipt_mng">
          $param[empl]
        </select>
        <br />
        <label class="control-label fix_width324 tar">IBM접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="fix_width180"></label>
        <select class="fix_width180" id="gene_ibm_receipt_mng">
          $param[empl]
        </select>
        <br />
        <label class="control-label fix_width324 tar">MAC접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="fix_width180"></label>
        <select class="fix_width180" id="gene_mac_receipt_mng">
          $param[empl]
        </select>
        <br />
        <label class="control-label fix_width150 tar">상업 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="control-label fix_width150 tar">통화접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width180" id="busi_resp" onchange="selectBizResp(this.value, '$param[sell_site]', 'busi');">
          $param[biz_resp]
        </select>
        <select class="fix_width180" id="busi_tel_receipt_mng">
          $param[empl]
        </select>
        <br />
        <label class="control-label fix_width324 tar">IBM접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="fix_width180"></label>
        <select class="fix_width180" id="busi_ibm_receipt_mng">
          $param[empl]
        </select>
        <br />
        <label class="control-label fix_width324 tar">MAC접수 담당자  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="fix_width180"></label>
        <select class="fix_width180" id="busi_mac_receipt_mng">
          $param[empl]
        </select>
        </div>
        <label class="btn btn_md fix_width140 fr" onclick="saveMemberDetailInfo('$param[member_seqno]', 'basic');"><i class="fa fa-check-square"></i> 저장</label>
        </fieldset>

        <fieldset class="mt25">
        <legend> 현금영수증 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">현금영수증</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="영수증 카드번호" value="$param[cashreceipt_card_num]" onkeydown="removeChar(event);" maxlength="20" id="cashreceipt_card_num">
        </div>
        <label class="btn btn_md fix_width140 fr" onclick="saveMemberDetailInfo('$param[member_seqno]', 'cashreceipt');"><i class="fa fa-check-square"></i> 저장</label>
        </fieldset>


        <fieldset class="mt25" style="disply:none;" id="licensee_info">
        <legend> 사업자정보 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">사업자등록번호</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[crn]" onkeydown="removeChar(event);" maxlength="20" id="crn">
        <br />
        <label class="control-label fix_width150 tar">대표자</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[repre_name]" id="repre_name">
        <br />
        <label class="control-label fix_width150 tar">업태</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[bc]" id="bc">
        <br />
        <label class="control-label fix_width150 tar">종목</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width180" placeholder="" value="$param[tob]" id="tob">
        <br />
        <label class="control-label fix_width150 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width63" id="tel_num1">
        <option value="02">02</option>
        <option value="031">031</option>
        <option value="032">032</option>
        <option value="033">033</option>
        <option value="041">041</option>
        <option value="042">042</option>
        <option value="043">043</option>
        <option value="044">044</option>
        <option value="051">051</option>
        <option value="052">052</option>
        <option value="053">053</option>
        <option value="054">054</option>
        <option value="055">055</option>
        <option value="061">061</option>
        <option value="062">062</option>
        <option value="063">063</option>
        <option value="064">064</option>
        </select> - <input type="text" class="input_co2 fix_width75" id="tel_num2" placeholder="" value="$param[tel_num2]" onkeydown="onlyNumber2(event);" maxlength="4"> - <input type="text" class="input_co2 fix_width75" id="tel_num3" placeholder="" value="$param[tel_num3]" onkeydown="onlyNumber2(event);" maxlength="4">
        <br />
        <label class="control-label fix_width150 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width63" placeholder="" value="$param[zipcode]" id="zipcode" onkeydown="onlyNumber2(event);">
        <label class="btn btn_pu fix_width102 bgreen fs13" onclick="popZipLayer('getAddrInfo');">우편번호</label> 
        <br />
        <label class="control-label fix_width170 tar"></label>
        <input type="text" class="input_co2 fix_width288" placeholder="" value="$param[addr]" id="addr">
        <br />
        <label class="control-label fix_width170 tar"></label>                       	          
        <input type="text" class="input_co2 fix_width288" placeholder="" value="$param[addr_detail]" id="addr_detail">
        </div>
        <label class="btn btn_md fix_width140 fr" onclick="saveMemberDetailInfo('$param[member_seqno]', 'licensee');"><i class="fa fa-check-square"></i> 저장</label>
        </fieldset>

        <fieldset class="mt25" id="mng_info">
        <legend> 담당자정보 </legend>	

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">
        <label class="fs14 fwb">담당자</label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px">담당자</th>
        <th class="bm2px">아이디</th>
        <th class="bm2px">전화번호</th>
        <th class="bm2px">핸드폰</th>
        <th class="bm2px">E-mail</th>
        </tr>
        </thead>
        <tbody>	
          $param[mng_info_html]
        </tbody>
        </table>

        </div>
        </div>

        </fieldset>

        <fieldset class="mt25" id="accting_mng">
        <legend> 회계담당자정보 </legend>	

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">
        <label class="fs14 fwb">회계담당자</label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px">회계담당자</th>
        <th class="bm2px">전화번호</th>
        <th class="bm2px">핸드폰</th>
        <th class="bm2px">E-mail</th>
        </tr>
        </thead>
        <tbody>	
          $param[accting_mng_info_html]
        </tbody>
        </table>

        </div>
        </div>
        </fieldset>

        <fieldset class="mt25" id="admin_licenseeregi">
        <legend> 관리사업자등록증 </legend>	

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">
        <label class="fs14 fwb">* 관리중인 사업자등록증 목록입니다.</label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px">No</th>
        <th class="bm2px">등록번호</th>
        <th class="bm2px">상호</th>
        <th class="bm2px">대표자명</th>
        <th class="bm2px">전화번호</th>
        <th class="bm2px">주소</th>
        </tr>
        </thead>
        <tbody>	
          $param[admin_licenseeregi_info_html]
        </tbody>
        </table>
        </div>
        </div>
        </fieldset>

DetailInfoHtml;

    return $html;
}

//회원정보 VIEW - 추가정보 
function makeMemberAddInfoHtml($param) {
 
    $html = <<<AddInfoHtml
        <fieldset class="mt25">
        <legend> 추가 가입정보 </legend>	                       	      
        <div class="form-group">
        <label class="control-label fix_width150 tar">결혼유무  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="wd_yn" class="radio_box" value="N" onclick="wdCtrl(this.value);"> 미혼</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="wd_yn" class="radio_box" value="Y" onclick="wdCtrl(this.value);"> 기혼</label>
        <span id="wd_anniv_info" style="display:none;">
        <label class="control-label tar" style="width:153px;">결혼기념일</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width150" placeholder="" value="$param[wd_anniv]" id="wd_anniv">
        </span>
        <br />
        <label class="control-label fix_width150 tar">회원직업</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width150" id="occu1">
        <option>IT 전산개발</option>
        </select>
        <select class="fix_width150" id="occu2">
        <option>영업</option>
        </select>
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="occu_detail" value="$param[occu_detail]">
        <br />
        <label class="control-label fix_width150 tar">관심분야</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width150" id="interest_field1">
        <option>요식업</option>
        </select>
        <select class="fix_width150" id="interest_field2">
        <option>한식</option>
        </select>
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="interest_field_detail" value="$param[interest_field_detail]">

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">관심상품 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt1" class="check_box"> 명함</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt2" class="check_box"> 스티커</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt3" class="check_box"> 전단</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt4" class="check_box"> 광고홍보물</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt5" class="check_box"> 봉투</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt6" class="check_box"> 마스터(경인쇄)</label>
        <br />
        <label class="control-label fix_width170 tar"> </label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt7" class="check_box"> 초소량인쇄</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt8" class="check_box"> 디지털인쇄</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt9" class="check_box"> 판촉물</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt10" class="check_box"> 패캐지</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt11" class="check_box"> 실사출력</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_prdt12" class="check_box"> 청접장/초대장</label>
        <br />
        <label class="control-label fix_width150 tar">관심이벤트 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event1" class="check_box"> 오특이</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event2" class="check_box"> 테마쇼핑</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event3" class="check_box"> 골라담자</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event4" class="check_box"> 포인트</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event5" class="check_box"> 쿠폰</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_event6" class="check_box"> 내가제일잘나가</label>
        <br />
        <label class="control-label fix_width150 tar">관심디자인 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal fix_width130"><input type="checkbox" id="inter_design1" class="check_box"> 항목정의</label>
        <br />
        <label class="control-label fix_width150 tar">관심요구사항 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs1" class="check_box"> 방문요청</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs2" class="check_box"> 담당자지정</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs3" class="check_box"> 다양한제품출시</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs4" class="check_box"> 지속적인이벤트</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs5" class="check_box"> 원활한 A/S</label>
        <br />
        <label class="control-label fix_width170 tar"> </label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs6" class="check_box"> 사이트제작조안</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs7" class="check_box"> 프로그램공동구매</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs8" class="check_box"> 커뮤니티강화</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs9" class="check_box"> 정기모임</label>
        <label class="form-radio form-normal fix_width140"><input type="checkbox" id="inter_needs10" class="check_box"> 유/무상교육</label>

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">디자인  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="design_yn" class="radio_box" value="N"> 디자인과련 기획전체를 외주합니다.</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="design_yn" class="radio_box" value="Y"> 디자인은 자체적으로 처리합니다.</label>
        <br />
        <label class="control-label fix_width150 tar">생산  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="produce_yn" class="radio_box" value="N"> 인쇄외 모든 품목을 외주합니다.</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="produce_yn" class="radio_box" value="Y"> 자체적으로 인쇄를 생산합니다.</label>     
        <br />
        <label class="control-label fix_width150 tar">사용프로그램 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="use_pro" class="radio_box" value="1"> 코렐드로우</label>
        <label class="form-radio form-normal"><input type="radio" name="use_pro" class="radio_box" value="2"> 일러스트레이터</label>
        <label class="form-radio form-normal"><input type="radio" name="use_pro" class="radio_box" value="3"> 인디자인</label>
        <label class="form-radio form-normal"><input type="radio" name="use_pro" class="radio_box" value="4"> 포토샵</label>
        <label class="form-radio form-normal"><input type="radio" name="use_pro" class="radio_box" value="5"> PDF</label>
        <label class="form-radio form-normal"><input type="radio" name="use_pro" class="radio_box" value="6"> 기타</label>

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">관심아이템</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width150" id="interest_item1">
        <option>판매아이템</option>
        </select>
        <select class="fix_width150" id="interest_item2">
        <option>칼라차트</option>
        </select>
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="interest_item_detail">
        <br />
        <label class="control-label fix_width150 tar">관심우선순위 </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" checked name="interest_prior" class="radio_box" value="1"> 가격</label>
        <label class="form-radio form-normal"><input type="radio" name="interest_prior" class="radio_box" value="2"> 품질</label>
        <label class="form-radio form-normal"><input type="radio" name="interest_prior" class="radio_box" value="3"> 납기</label>
        <label class="form-radio form-normal"><input type="radio" name="interest_prior" class="radio_box" value="4"> 서비스</label>

        <hr class="hr_bd2">

        <label class="control-label fix_width150 tar">복수거래유무  </label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" name="plural_deal_yn" class="radio_box" value="Y" onclick="dealCtrl(this.value);"> 복수거래중</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" checked name="plural_deal_yn" class="radio_box" value="N" onclick="dealCtrl(this.value);"> 단수거래중</label>     
        <br />

        <div id="plural_deal_info" style="display:none;">
        <label class="control-label fix_width150 tar">복수거래업체</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width150" id="plural_deal_site_name1">
        <option>애드코아</option>
        <option>(굿)굿프린팅</option>
        </select>
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="plural_deal_site_detail1" value="$param[plural_deal_site_detail1]">
        <br />
        <label class="control-label fix_width170 tar"> </label>
        <select class="fix_width150" id="plural_deal_site_name2">
        <option>디티피아</option>
        <option>(굿)굿프린팅</option>
        </select>
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="plural_deal_site_detail2" value="$param[plural_deal_site_detail2]">
        <br />
        </div>
        <label class="control-label fix_width150 tar">추천인성명  </label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2" style="width:143px;" placeholder="" id="recomm_id" value="$param[recomm_id]">
        <input type="text" class="input_co2 fix_width440" placeholder="세부적으로 적습니다." id="recomm_id_detail" value="$param[recomm_id_detail]">
        <br />
        <label class="control-label fix_width150 tar">메모  </label><label class="fix_width20 fs14 tac">:</label>
        <textarea class="bs_noti" id="memo" style="width:580px;">$param[memo]</textarea>


        </div>
        <label class="btn btn_md fix_width140 fr" onclick="saveMemberAddInfo('$param[member_seqno]');"><i class="fa fa-check-square"></i> 저장</label>
        </fieldset>


AddInfoHtml;

    return $html;
}

//회원정보 VIEW - 배송정보 
function makeMemberDlvrInfoHtml($param) {
 
    $html = <<<DlvrInfoHtml
        <fieldset>
        <legend> 기본배송지 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">배송지별칭</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width180" placeholder="" value="$param[dlvr_name]" disabled>
        <label class="control-label fix_width150 tar">전화번호</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[tel_num1]" disabled> - <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[tel_num2]" disabled> - <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[tel_num3]" disabled>
        <br />
        <label class="control-label fix_width150 tar">성명/상호</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width180" placeholder="" value="$param[recei]" disabled>
        <label class="control-label fix_width150 tar">휴대번호</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[cell_num1]" disabled> - <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[cell_num2]" disabled> - <input type="text" class="input_dis_co2 fix_width75" placeholder="" value="$param[cell_num3]" disabled>
        <br />                       	          
        <label class="control-label fix_width150 tar">주소</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2" style="width:635px;" placeholder="" value="$param[addr]" disabled>
        </div>
        </fieldset>

        <fieldset class="mt25">
        <legend> 배송지관리 </legend>	                 	      
        <div class="table-body">
        <ul class="table_top">
        <li class="sel">

        </li>
        <li class="sel tar">
        <label class="btn btn_pu fix_width102 bgreen fs13" onclick="regiMyDlvr('$param[member_seqno]');">추가</label>
        </li>
        </ul>
        <div class="table_basic">
        <div class="table_scroll fix_height415">
        <table class="fix_width100f">
        <thead>
        <tr>					                      					
        <th class="bm2px">No</th>							                      					
        <th class="bm2px">배송지별칭 </th>
        <th class="bm2px">받으시는분 </th>
        <th class="bm2px">주소 </th>
        <th class="bm2px">전화번호 </th>
        <th class="bm2px">등록일 </th>
        <th class="bm2px">관리</th>
        </tr>
        </thead>
        <tbody>	
          $param[dlvr_list_html]
        </tbody>
        </table>
        </div>		
        </div>
        </div>

        </fieldset>

        <fieldset class="mt25">
        <legend> 배송친구 </legend>	
        <div class="form-group">
        <label class="control-label fix_width150 tar">배송친구</label><label class="fix_width20 fs14 tac">:</label>
        <label class="form-radio form-normal"><input type="radio" name="fr_send" class="radio_box" value="N" disabled> 사용안함</label>
        <label class="fix_width10"></label>   
        <label class="form-radio"><input type="radio" name="fr_send" class="radio_box" value="Y" disabled> 사용</label>
        (
         <label class="form-radio form-normal"><input type="radio" name="fr_send_sm" class="radio_box" value="Y" disabled> 배송친구메인</label>
         <label class="fix_width10"></label>   
         <label class="form-radio"><input type="radio" name="fr_send_sm" class="radio_box" value="N" disabled> 배송친구서브</label>
        )

        </div>
        </fieldset>

        </div>  

DlvrInfoHtml;

    return $html;
}

//회원정보 VIEW - 배송정보 - 나의배송지등록 팝업창
function makeMemberDlvrPopup($param) {

    $html = <<<PopHtml
        <!-- 나의배송지등록 팝업창 -->
        <dl>
        <dt class="tit">
        <h4>나의배송지 등록</h4>
        </dt>
        <dt class="cls">
        <button type="button" class="btn btn-sm btn-danger fa fa-times" onclick="hideRegiPopup();"></button>
        </dt>
        </dl>  
        <div class="pop-base">
        <div class="pop-content">
        <div class="form-group">
        <label class="control-label fix_width75 tar">배송지별칭</label><label class="fix_width10 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width150" placeholder="" value="$param[dlvr_name]" id="dlvr_name">
        <br />
        <label class="control-label fix_width75 tar">상명/상호</label><label class="fix_width10 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width150" placeholder="" value="$param[recei]" id="dlvr_recei"> <span class="fs12">(10자이내)</span>
        <br />
        <label class="control-label fix_width75 tar">전화번호</label><label class="fix_width10 fs14 tac">:</label>
        <select class="fix_width75" id="dlvr_tel_num1">
        <option value="02">02</option>
        <option value="031">031</option>
        <option value="032">032</option>
        <option value="033">033</option>
        <option value="041">041</option>
        <option value="042">042</option>
        <option value="043">043</option>
        <option value="044">044</option>
        <option value="051">051</option>
        <option value="052">052</option>
        <option value="053">053</option>
        <option value="054">054</option>
        <option value="055">055</option>
        <option value="061">061</option>
        <option value="062">062</option>
        <option value="063">063</option>
        <option value="064">064</option>
        </select> - <input type="text" class="input_co2 fix_width75" placeholder="" value="$param[tel_num2]" id="dlvr_tel_num2" maxlength="4" onkeyup="onlyNumber2(event);"> - <input type="text" class="input_co2 fix_width75" placeholder="" value="$param[tel_num3]" id="dlvr_tel_num3" maxlength="4" onkeyup="onlyNumber2(event);">
        <br />
        <label class="control-label fix_width75 tar">핸드폰</label><label class="fix_width10 fs14 tac">:</label>
        <select class="fix_width75" id="dlvr_cell_num1">
        <option>010</option>
        </select> - <input type="text" class="input_co2 fix_width75" placeholder="" value="$param[cell_num2]" id="dlvr_cell_num2" maxlength="4" onkeyup="onlyNumber2(event);"> - <input type="text" class="input_co2 fix_width75" placeholder="" value="$param[cell_num3]" id="dlvr_cell_num3" maxlength="4" onkeyup="onlyNumber2(event);">
        <br />
        <label class="control-label fix_width75"></label><label class="fix_width10 fs14 tac"> </label>
        <span class="fs12 red_text01">연락처번호와 휴대폰 중 하나는 반드시 입력해야합니다.</span>
        <br />
        <label class="control-label fix_width75 tar">주소</label><label class="fix_width10 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width63" placeholder="" id="dlvr_zipcode" value="$param[zipcode]" onkeydown="onlyNumber2(event);">
        <label class="btn btn_pu fix_width102 bgreen fs13" onclick="popPopZipLayer('getDlvrAddrInfo');">우편번호</label> 
        <br />
        <label class="control-label fix_width85 tar">&nbsp;</label>
        <input type="text" class="input_co2 fix_width288" placeholder="" id="dlvr_addr" value="$param[addr]">
        <br />
        <label class="control-label fix_width85 tar">&nbsp;</label>                       	          
        <input type="text" class="input_co2 fix_width288" placeholder="" id="dlvr_addr_detail" value="$param[addr_detail]">
        <br />
        <hr class="hr_bd2">
        <p class="tac mt15">
        <button type="button" class="btn btn-sm btn-success" onclick="regiDlvrAddrInfo('$param[member_seqno]', '$param[member_dlvr_seqno]');">저장</button>
          $param[del_html]
        <label class="fix_width5"> &nbsp; </label>
        <button type="button" class="btn btn-sm btn-primary" onclick="hideRegiPopup();">확인</button>
        </p>
        </div>												 	
        </div>
        </div>

PopHtml;

    return $html;
}

//회원정보 VIEW - 매출정보 
function makeMemberSalesInfoHtml($param) {
 
    $html = <<<SalesInfoHtml
        <fieldset>
        <legend> 매출 정보 리스트 </legend>	

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
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('order_num', this, 'sales');" class="blue_text01 sorting">인쇄물제목 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('order_detail', this, 'sales');" class="blue_text01 sorting">상품내역 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px">수량(건)</th>	
        <th class="bm2px">결제금액</th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('order_regi_date', this, 'sales');" class="blue_text01 sorting">주문일 <i class="fa fa-sort"></i></a></th>
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

SalesInfoHtml;

    return $html;
}

//회원정보 VIEW - 등급정보 
function makeMemberGradeInfoHtml($param) {
 
    $html = <<<GradeInfoHtml
        <div class="form-group">
        <select class="fix_width75">
          $param[year_html]
        </select> 
        <label class="control-label tar">년도 월별 회원등급 추이 </label>
        </div>

        <br />

        <fieldset>
        <legend> 회원등급 산정 </legend>	

        <div class="form-group">
        <label class="fix_width15"> &nbsp; </label>				                           
        <label class="form-radio form-normal fs12"><input type="checkbox" class="check_box" onclick="regiManual(this);"> 등급산정을 수동방식으로 전환합니다.</label>
        <div id="regi_manual" style="display:none;">
        <hr class="hr_bd3">
        <label class="control-label fix_width75 tar">회원등급</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width120" id="req_grade">
          $param[grade_html]
        </select> 

        <label class="control-label fix_width75 tar">사유</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2 fix_width440" placeholder="이유를 적으세요" id="req_reason">
        <label class="fix_width200"> &nbsp; </label>
        <label class="btn btn_pu fix_width102 co_blue fs13" onclick="regiGradeManul('$param[member_seqno]');">저장</label>
        </div>
        </div>

        <div class="table-body">
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px">No</th>
        <th class="bm2px">이전등급</th>
        <th class="bm2px">변경등급</th>
        <th class="bm2px">신청자</th>
        <th class="bm2px">승인자</th>
        <th class="bm2px">사유</th>
 <!--       <th class="bm2px">등록일</th>-->
        <th class="bm2px">상태</th>
        </tr>
        </thead>
        <tbody>	
          $param[grade_list_html]
        </tbody>
        </table>

        </div>
        </div>

        </fieldset>  

GradeInfoHtml;

    return $html;
}

//회원정보 VIEW - 포인트정보 
function makeMemberPointInfoHtml($param) {
 
    $html = <<<PointInfoHtml
        <fieldset>
        <legend> 회원포인트 </legend>	

        <div class="form-group">
        <label class="control-label fix_width81 tar">포인트지급</label><label class="fix_width20 fs14 tac">:</label>
        <select class="fix_width120" id="point_name">
        <option>소셜추천</option>
        </select> 
        <input type="text" class="input_co2" style="width:79px;" placeholder="" id="point" onkeydown="onlyNumber2(event);" maxlength="10"> Point

        <label class="control-label fix_width150 tar">사유</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_co2" style="width:559px;" placeholder="이유를 적으세요" id="point_reason">

        <br />
        <label class="control-label fix_width81 tar">포인트이미지</label><label class="fix_width20 fs14 tac">:</label>
        <!-- 파일 업로드 / 스크립이 하단에 있어야 작동함 -->
        <input class="disableInputField mt05" placeholder="Choose File" name="point_path" id="point_path" disabled="disabled" />

        <label class="fileUpload mt05">
        <input type="file" name="point_img" id="point_img" class="upload" onchange="fileSearchBtn(this.value, 'point');"/>
        <span class="btn btn-sm btn-info fa fa-folder-open">파일찾기</span>
        </label>
        <label style="width:584px;"> &nbsp; </label>
        <label class="btn btn_pu fix_width102 co_blue fs13" onclick="saveMemberPoint();">저장</label>
        </div>

        <div class="table-body">
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px">No</th>
        <th class="bm2px">포인트명</th>
        <th class="bm2px">포인트</th>
        <th class="bm2px">신청자</th>
        <th class="bm2px">승인자</th>
        <th class="bm2px">사유</th>
        <th class="bm2px">상태</th>
        </tr>
        </thead>
        <tbody id="member_point_req_list">	
        </tbody>
        </table>
        <p class="p_num_b fs12">
        Showing 1 to 5 of 30 entries
		<select name="detail_list_set" class="fix_width55" onchange="detailShowPageSetting(this.value, 'point_req');">
        <option>5</option>
        <option>10</option>
        <option>20</option>
	    <option selected="selected">30</option>
        </select>
        </p>
        <div class="tac clear" id="member_point_req_page">
        </div>
        </div>
        </div>

        </fieldset>  

        <br /><br />

        <fieldset>
        <legend> 포인트 정보리스트 </legend>	
        <div class="form-group">
        <label class="control-label fix_width110 tar">일자별 검색</label><label class="fix_width20 fs14 tac"> : </label>
         $param[date_picker_html]
        <p class="btn-lg red_btn">
        <a style="cursor: pointer;" onclick="searchMemberDetailInfo('point');">선택 조건으로 검색</a>
        </p>				                           
        </div>

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">

        </li>
        <li class="sel tar">
        <label for="point_search" class="con_label">Search(포인트명) : <input id="point_search" type="text" class="search_btn fix_width180" onkeydown="detailSearchKey(event, this.value, 'point');"><button type="button" class="btn btn-sm btn-info fa fa-search" onclick="detailSearchText('point');"></button></label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px"> No</th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('regi_date', this, 'point');" class="blue_text01 sorting">거래일<i class="fa fa-sort"></i></a></th>						                      					        
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('point_name', this, 'point');" class="blue_text01 sorting">포인트명<i class="fa fa-sort"></i></a></th>
        <th class="bm2px">적립포인트</th>
        <th class="bm2px">사용포인트</th>
        <th class="bm2px">잔여포인트</th>					                      					                       	  <th class="bm2px">주문금액</th>
        <th class="bm2px">비고</th>
        </tr>
        </thead>
        <tbody id="member_point_list">	
        </tbody>
        </table>
        <p class="p_num_b fs12">
        Showing 1 to 5 of 30 entries
		<select name="detail_list_set" class="fix_width55" onchange="detailShowPageSetting(this.value, 'point');">
        <option>5</option>
        <option>10</option>
        <option>20</option>
	    <option selected="selected">30</option>
        </select>
        </p>
        <div class="tac clear" id="member_point_page">
        </div>
        </div>
        </div>
        </fieldset>

PointInfoHtml;

    return $html;
}

//회원정보 VIEW - 쿠폰정보 
function makeMemberCouponInfoHtml($param) {
 
    $html = <<<CouponInfoHtml
        <fieldset>
        <div class="form-group">
        <label class="control-label fix_width110 tar">일자별 검색</label><label class="fix_width20 fs14 tac"> : </label>
         $param[date_picker_html]
        <p class="btn-lg red_btn">
        <a style="cursor: pointer;" onclick="searchMemberDetailInfo('coupon');">선택 조건으로 검색</a>
        </p>				                           
        </div>
        </fieldset>

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">

        </li>
        <li class="sel tar">
        <label for="coupon_search" class="con_label">Search(쿠폰명) : <input id="coupon_search" type="text" class="search_btn fix_width180" onkeydown="detailSearchKey(event, this.value, 'coupon');"><button type="button" class="btn btn-sm btn-info fa fa-search" onclick="detailSearchText('coupon');"></button></label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px"> No</th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('cp_name', this, 'coupon');" class="blue_text01 sorting">쿠폰명 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px">할인금액 </th>
        <th class="bm2px">사용조건 </th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('regi_date', this, 'coupon');" class="blue_text01 sorting">발급일 <i class="fa fa-sort"></i></a></th>	
        <th class="bm2px">사용기간 </th>					                      					        
        <th class="bm2px">상태 </th>
        </tr>
        </thead>
        <tbody id="member_coupon_list">	
        </tbody>
        </table>
        <p class="p_num_b fs12">
        Showing 1 to 5 of 30 entries
		<select name="detail_list_set" class="fix_width55" onchange="detailShowPageSetting(this.value, 'coupon');">
        <option>5</option>
        <option>10</option>
        <option>20</option>
	    <option selected="selected">30</option>
        </select>
        </p>
        <div class="tac clear" id="member_coupon_page">
        </div>
        </div>
        </div>

CouponInfoHtml;

    return $html;
}

//회원정보 VIEW - 이벤트정보 
function makeMemberEventInfoHtml($param) {
 
    $html = <<<EventInfoHtml
        <fieldset>
        <div class="form-group">
        <label class="control-label fix_width110 tar">일자별 검색</label><label class="fix_width20 fs14 tac"> : </label>
         $param[date_picker_html]
        <p class="btn-lg red_btn">
        <a style="cursor: pointer;" onclick="searchMemberDetailInfo('event');">선택 조건으로 검색</a>
        </p>				                           
        </div>
        </fieldset>

        <div class="table-body">
        <ul class="table_top">
        <li class="sel">

        </li>
        <li class="sel tar">
        <label for="search" class="con_label">Search : <input id="search" type="text" class="search_btn fix_width180"><button type="button" class="btn btn-sm btn-info fa fa-search"></button></label>
        </li>
        </ul>
        <div class="table_basic">
        <table class="fix_width100f">
        <thead>
        <tr>
        <th class="bm2px"> No</th>					                      					        
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('event_typ', this, 'event');" class="blue_text01 sorting">이벤트 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('prdt_name', this, 'event');" class="blue_text01 sorting">상품명 <i class="fa fa-sort"></i></a></th>
        <th class="bm2px">혜택 </th>
        <th class="bm2px"><a style="cursor: pointer;" onclick="sortList('regi_date', this, 'event');" class="blue_text01 sorting">등록일 <i class="fa fa-sort"></i></a></th>
        </tr>
        </thead>
        <tbody id="member_event_list">	
        </tbody>
        </table>
        <p class="p_num_b fs12">
        Showing 1 to 5 of 30 entries
		<select name="detail_list_set" class="fix_width55" onchange="detailShowPageSetting(this.value, 'event');">
        <option>5</option>
        <option>10</option>
        <option>20</option>
	    <option selected="selected">30</option>
        </select>
        </p>
        <div class="tac clear" id="member_event_page">
        </div>
        </div>
        </div>

EventInfoHtml;

    return $html;
}

//회원정보 VIEW - 탈퇴정보 
function makeMemberReduceInfoHtml($param) {
 
    $html = <<<ReduceInfoHtml
        <fieldset class="fix_width860 mauto">
        <legend> 탈퇴사유 </legend>	   

        <div class="form-group lh35">
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="1" id="reduce_1"> 상품종류 부족</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="2" id="reduce_2"> 상품가격 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="3" id="reduce_3"> 상품품질 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="4" id="reduce_4"> 반품/교환 서비스 불만</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="5" id="reduce_5"> 납기 및 배송 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="6" id="reduce_6"> AS서비스 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="7" id="reduce_7"> 상담원 고객응대 불만</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="8" id="reduce_8"> 쇼핑몰 불편 및 속도불만</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="9" id="reduce_9"> 이용빈도 낮음</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="10" id="reduce_10"> 타인 주민등록 도용</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="11" id="reduce_11"> 중복가입</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="12" id="reduce_12"> 이민</label>
        <br />
        <label class="form-radio form-normal fix_width40"></label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="13" id="reduce_13"> 재가입</label>
        <label class="form-radio form-normal fix_width200"><input type="checkbox" class="check_box" value="14" id="reduce_14"> 기타</label>
        </div>

        <div class="form-group">
        <textarea class="bs_noti3" style="width:840px;" id="withdraw_reason"></textarea>
        </div>

        <p class="btn-lg red_btn">
        <a style="cursor: pointer;" onclick="makeWithdrawal('$param[member_seqno]');">신청</a>
        </p>

        </fieldset>

ReduceInfoHtml;

    return $html;
}

//회원정보 VIEW - 정산정보 
function makeMemberCalculInfoHtml($param) {
 
    $html = <<<CalculInfoHtml
        <div class="form-group">
        <label class="control-label fix_width150 tar">선입금 금액</label><label class="fix_width20 fs14 tac">:</label>
        
        <input type="text" class="input_dis_co2 fix_width180" placeholder="" value="$param[prepay_price]원" disabled>
        <br />
        <label class="control-label fix_width150 tar">주문부족 금액</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width180" placeholder="" value="$param[order_lack_price]원" disabled>
        <br />
        <label class="control-label fix_width150 tar">가상계좌</label><label class="fix_width20 fs14 tac">:</label>
        <input type="text" class="input_dis_co2 fix_width100" placeholder="은행명" value="$param[bank_name]" disabled> 
        <input type="text" class="input_dis_co2 fix_width180" placeholder="계좌번호" value="$param[virt_ba_num]" disabled>
        <input type="text" class="input_dis_co2 fix_width100" placeholder="예금주" value="$param[member_name]" disabled>
        </div>

CalculInfoHtml;

    return $html;
}
?>
