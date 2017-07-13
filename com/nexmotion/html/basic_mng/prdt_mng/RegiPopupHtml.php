<?
/**
 * @brief 등록 팝업 공통 HTML
 */
function commonRegiPopupHtml($title) {
 
    $html  = "\n<dl>";
    $html .= "\n   <dt class=\"tit\">";
    $html .= "\n        <h4>" . $title . "</h4>";
    $html .= "\n   </dt>";
    $html .= "\n   <dt class=\"cls\">";
    $html .= "\n        <button type=\"button\" class=\"btn btn-sm btn-danger fa fa-times\" onclick=\"hideRegiPopup();\"></button>";
    $html .= "\n   </dt>";
    $html .= "\n</dl>";

    return $html;
}

/**
 * @brief 등록 팝업 공통 버튼 HTML
 */
function commonRegiPopupBtnHtml($el, $flag, $seqno) {
 
    $html  = "\n       <hr class=\"hr_bd3\">";
    $html .= "\n       <p class=\"tac mt15\">";
    $html .= "\n          <button type=\"button\" class=\"btn btn-sm btn-success\" onclick=\"insertInfo('" . $el . "', '" . $seqno . "');\">저장</button>";

    if ($flag) { 
        $html .= "\n          <label class=\"fix_width5\"> </label>";
        $html .= "\n          <button type=\"button\" id=\"delete_btn\" class=\"btn btn-sm btn-danger\" onclick=\"deleteInfo('" . $el . "', '" . $seqno . "');\">삭제</button>";
    }

    $html .= "\n          <label class=\"fix_width140\"> </label>";
    $html .= "\n          <button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"hideRegiPopup();\">닫기</button>";
    $html .= "\n       </p>";

    return $html;
}

/**
 * @brief 상품종이등록 팝업 HTML
 */
function paperRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);

    $html  = commonRegiPopupHtml("상품종이품목관리");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n       <div class=\"form-group\">";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">종이 대분류</label><label class=\"fix_width10 fs14 tac\">:</label>";                                               
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_paper_sort\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">종이명</label><label class=\"fix_width10 fs14 tac\">:</label>";                                                
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_paper_name\" value=\"" . $val["name"] . "\" maxlength=\"20\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">구분</label><label class=\"fix_width10 fs14 tac\">:</label>";                                              
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_paper_dvs\" value=\"" . $val["dvs"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">색상</label><label class=\"fix_width10 fs14 tac\">:</label>";                                              
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_paper_color\" value=\"" . $val["color"] . "\" maxlength=\"20\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">평량</label><label class=\"fix_width10 fs14 tac\">:</label>";                                              
    $html .= "\n           <input type=\"text\" class=\"input_co2\" style=\"width:73px;\" placeholder=\"\" id=\"pop_paper_basisweight\" value=\"" . $val["basisweight"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <select class=\"fix_width63\" id=\"pop_paper_basisweight_unit\">";
    $html .= "\n               <option value=\"g\">g </option>";
    $html .= "\n               <option value=\"μ\">μ</option>";
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width75 tar\" style=\"width:76px;\">계열</label><label class=\"fix_width10 fs14 tac\">:</label>";                                              
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_paper_affil\">";
    $html .= "\n               <option value=\"46\">46 </option>";
    $html .= "\n               <option value=\"국\">국</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">기준단위</label><label class=\"fix_width10 fs14 tac\">:</label>";                                               
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_paper_crtr_unit\">";
    $html .= "\n               <option value=\"장\">장 </option>";
    $html .= "\n               <option value=\"R\">R</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" id=\"pop_paper_wid_size\" maxlength=\"13\"> * <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" id=\"pop_paper_vert_size\" maxlength=\"13\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("paper", $tmp[1], $tmp[2]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 출력정보등록 팝업 HTML
 */
function outputRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);

    $html  = commonRegiPopupHtml("상품출력정보");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n        <div class=\"form-group\">";
    $html .= "\n               <label class=\"control-label fix_width75 tar\">출력명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_output_name\" value=\"" . $val["output_name"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">출력판</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_output_board_dvs\">";
    $html .= "\n               <option value=\"국산 일반판\">국산 일반판</option>";
    $html .= "\n               <option value=\"중국 재생판\">중국 재생판</option>";
	$html .= "\n               <option value=\"아그파 정판\">아그파 정판</option>";
    $html .= "\n               <option value=\"UV 특수판\">UV 특수판</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">계열</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_output_affil\">";
    $html .= "\n               <option value=\"46\">46 </option>";
    $html .= "\n               <option value=\"국\">국</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width75 tar\">사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_output_wid_size\" value=\"" . $val["wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\"> * <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_output_vert_size\" value=\"" . $val["vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("output", $tmp[0], $tmp[1]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 사이즈정보등록 팝업 HTML
 */
function sizeRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);
      
    $html  = commonRegiPopupHtml("상품사이즈품목관리");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n       <div class=\"form-group\">";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">사이즈 대분류</label><label class=\"fix_width10 fs14 tac\">:</label>  ";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_size_sort\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">계열</label><label class=\"fix_width10 fs14 tac\">:</label>  ";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_size_affil\">";
    $html .= "\n             <option value=\"46\">46</option>";
    $html .= "\n             <option value=\"국\">국</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">사이즈명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_name\" value=\"" . $val["name"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">사이즈유형</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_typ\" value=\"" . $val["typ"] . "\" maxlength=\"20\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">출력명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_size_output_name\">";
    $html .= $tmp[1];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">출력판구분</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_size_output_board_dvs\">";
    $html .= $tmp[2];
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">작업사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_cut_wid_size\" value=\"" . $val["work_wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"fix_width10 fs14 tac\">*</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_cut_vert_size\" value=\"" . $val["work_vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">재단사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_work_wid_size\" value=\"" . $val["cut_wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"fix_width10 fs14 tac\">*</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_work_vert_size\" value=\"" . $val["cut_vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">디자인사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_design_wid_size\" value=\"" . $val["design_wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"fix_width10 fs14 tac\">*</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_design_vert_size\" value=\"" . $val["design_vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width83 tar\">도무송사이즈</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_tomson_wid_size\" value=\"" . $val["tomson_wid_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"fix_width10 fs14 tac\">*</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" id=\"pop_size_tomson_vert_size\" value=\"" . $val["tomson_vert_size"] . "\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("size", $tmp[3], $tmp[4]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 상품인쇄정보등록 팝업 HTML
 */
function printRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);

    $html  = commonRegiPopupHtml("상품인쇄정보");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n        <div class=\"form-group\">";
    $html .= "\n               <label class=\"control-label fix_width100 tar\">인쇄명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2\" style=\"width:143px;\" placeholder=\"\" id=\"pop_print_name\" value=\"" . $val["print_name"] . "\" maxlength=\"20\">";
    $html .= "\n            <label class=\"control-label fix_width100 tar\">용도구분</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2\" style=\"width:143px;\" placeholder=\"\" id=\"pop_print_purp_dvs\" value=\"" . $val["purp_dvs"] . "\" maxlength=\"20\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">계열</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select class=\"fix_width150\" id=\"pop_print_affil\">";
    $html .= "\n               <option value=\"46\">46 </option>";
    $html .= "\n               <option value=\"국\">국</option>";
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">기준단위</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_print_crtr_unit\">";
    $html .= "\n             <option value=\"장\">장</option>";
    $html .= "\n             <option value=\"R\">R</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">카테고리</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select class=\"fix_width150\" id=\"pop_print_cate_top\" onchange=\"cateSelect(this.value);\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <select class=\"fix_width150\" id=\"pop_print_cate_mid\">";
    $html .= $tmp[1];
    $html .= "\n           </select>";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("print", $tmp[2], $tmp[3]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 상품인쇄도수정보등록 팝업 HTML
 */
function tmptRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);

    $html  = commonRegiPopupHtml("상품인쇄도수관리");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n       <div class=\"form-group\">";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">인쇄도수대분류</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_tmpt_sort\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">인쇄도수명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["name"] . "\" id=\"pop_tmpt_name\" maxlength=\"20\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">인쇄명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_tmpt_print_name\">";
    $html .= $tmp[1];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">용도구분</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_tmpt_purp_dvs\">";
    $html .= $tmp[2];
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">면구분</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select style=\"width:147px;\" id=\"pop_tmpt_side_dvs\">";
    $html .= "\n             <option value=\"단면\">단면</option>";
    $html .= "\n             <option value=\"양면\">양면</option>";
    $html .= "\n             <option value=\"전면\">전면</option>";
    $html .= "\n             <option value=\"후면\">후면</option>";
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">앞면인쇄</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["beforeside_tmpt"] . "\" id=\"pop_tmpt_beforeside_tmpt\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">뒷면인쇄</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["aftside_tmpt"] . "\" id=\"pop_tmpt_aftside_tmpt\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">추가인쇄</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["add_tmpt"] . "\" id=\"pop_tmpt_add_tmpt\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">총도수</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["tot_tmpt"] . "\" id=\"pop_tmpt_tot_tmpt\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">총판수</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width140\" placeholder=\"\" value=\"" . $val["output_board_amt"] . "\" id=\"pop_tmpt_output_board_amt\" onkeyup=\"onlyNumber2(event);\" maxlength=\"13\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("tmpt", $tmp[3], $tmp[4]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 후공정관리등록 팝업 HTML
 */
function afterRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);

    $html  = commonRegiPopupHtml("상품후공정관리");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n       <div class=\"form-group\">";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">후공정명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select class=\"fix_width100\" id=\"pop_after_name\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <label class=\"control-label tar\" style=\"width:95px;\">기준수량단위</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select class=\"fix_width100\" id=\"pop_after_crtr_unit\">";
    $html .= "\n               <option value=\"장\">장</option>";
    $html .= "\n               <option value=\"R\">R</option>";
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">Depth1</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width94\" placeholder=\"\" id=\"pop_after_depth1\" value=\"" . $val["depth1"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width94 tar\">Depth2</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width94\" placeholder=\"\" id=\"pop_after_depth2\" value=\"" . $val["depth2"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width94 tar\">Depth3</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width100\" placeholder=\"\" id=\"pop_after_depth3\" value=\"" . $val["depth3"] . "\" maxlength=\"20\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("after", $tmp[1], $tmp[2]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}

/**
 * @brief 옵션관리등록 팝업 HTML
 */
function optRegiPopupHtml($param, $val) {

    $tmp = explode("♪", $param);
    
    $html  = commonRegiPopupHtml("상품옵션관리");
    $html .= "\n<div class=\"pop-base\">";
    $html .= "\n   <div class=\"pop-content\">";
    $html .= "\n       <div class=\"form-group\">";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">옵션명</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <select class=\"fix_width100\" id=\"pop_opt_name\">";
    $html .= $tmp[0];
    $html .= "\n           </select>";
    $html .= "\n           <br />";
    $html .= "\n           <label class=\"control-label fix_width100 tar\">Depth1</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width94\" placeholder=\"\" id=\"pop_opt_depth1\" value=\"" . $val["depth1"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width94 tar\">Depth2</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width94\" placeholder=\"\" id=\"pop_opt_depth2\" value=\"" . $val["depth2"] . "\" maxlength=\"20\">";
    $html .= "\n           <label class=\"control-label fix_width94 tar\">Depth3</label><label class=\"fix_width10 fs14 tac\">:</label>";
    $html .= "\n           <input type=\"text\" class=\"input_co2 fix_width100\" placeholder=\"\" id=\"pop_opt_depth3\" value=\"" . $val["depth3"] . "\" maxlength=\"20\">";
    $html .= "\n       </div>";
    $html .= commonRegiPopupBtnHtml("opt", $tmp[1], $tmp[2]);
    $html .= "\n   </div>";
    $html .= "\n</div>";

    return $html;
}
?>
