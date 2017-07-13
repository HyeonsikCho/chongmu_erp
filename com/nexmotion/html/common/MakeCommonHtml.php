<?
//콤보박스 option 생성
function option($str, $val="") {
    return "\n  <option value=\"" . $val . "\">" . $str . "</option>";
}
function ChongOption($str, $val="",$selected = null) {
	if($selected != null){
		return "\n  <option value=\"" . $val . "\"selected>" . $str . "</option>";
	}else{
		return "\n  <option value=\"" . $val . "\">" . $str . "</option>";
	}

}

/**
 * @brief 옵션 html 생성
 *
 * @param $rs   = 검색결과
 * @param $val  = option value에 들어갈 필드값
 * @param $dvs  = option에 표시할 필드값
 * @param $base = 기본으로 추가할 option 값
 * @param $flag = $base를 사용할지 flag
 * @param $idx = selected를 사용할 비교값
 */
 function ChongMakeOptionHtml($rs, $val, $dvs, $base="전체", $flag="Y",$idx=null) {
	$selected = null;
    if ($flag == "Y") {
        $html = "\n" . option($base);

    } else {
        $html = "";
    }

    while ($rs && !$rs->EOF) {

        $fields = $rs->fields[$dvs];

        //만약 $val 빈값이면
        if ($val === "") {
            $value = $fields;
        } else {
			$value = $rs->fields[$val];
		}

	    if($idx == $value) $selected = 'selected';
		else               $selected = null;

		$html .= "\n" . ChongOption($fields, $value, $selected);



        $rs->MoveNext();
    }

    return $html;
}

function makeOptionHtml($rs, $val, $dvs, $base="전체", $flag="Y") {

    if ($flag == "Y") {
        $html = "\n" . option($base);

    } else {
        $html = "";
    }

    while ($rs && !$rs->EOF) {

        $fields = $rs->fields[$dvs];

        //만약 $val 빈값이면
        if ($val === "") {
            $value = $fields;
        } else {
			$value = $rs->fields[$val];
		}

        $html .= "\n" . option($fields, $value);

        $rs->MoveNext();
    }

    return $html;
}

/**
 * @brief 옵션 html 생성
 *
 * @param $rs   = 검색결과
 * @param $arr["flag"]  = "기본 값 존재여부"
 * @param $arr["def"]  = "기본 값(ex:전체)"
 * @param $arr["def_val"]  = "기본 값의 option value"
 * @param $arr["val"]  = "option value에 들어갈 필드 값"
 * @param $arr["dvs"]  = "option에 표시할 필드값"
 * @param $arr["dvs_tail"]  = "option 값 뒤에 붙일 단어"
 *
 */
function makeSelectOptionHtml($rs, $arr) {

    if ($arr["flag"] == "Y") {
        $html = "\n" . option($arr["def"], $arr["def_val"]);

    } else {
        $html = "";
    }

    while ($rs && !$rs->EOF) {

        $fields = $rs->fields[$arr["dvs"]];

        //필드 값 뒤에 붙일 단어
        if ($arr["dvs_tail"]) {

            $fields = $fields . $arr["dvs_tail"];

        }

        //만약 $val 빈값이면
        if ($arr["val"] === "" || $arr["val"] === NULL) {
            $value = $fields;
        } else {
			$value = $rs->fields[$arr["val"]];
        }

        $html .= "\n" . option($fields, $value);

        $rs->MoveNext();
    }

    return $html;
}

//일자별 검색 버튼 생성
function makeDateSetBtn($param, $str, $fn="dateSet", $wid="40") {

    $html  = "<a style=\"cursor: pointer;\" onclick=\"" . $fn;
    $html .= "('" . $param . "')\" class=\"btn btn_md fix_width";
    $html .= $wid . "\">" . $str . "</a>";

    return $html;
}

//일자별 검색
function makeDateInfo($id) {

    $html .= "\n<input type=\"text\" id=\"date_" . $id . "\"";
    $html .= "class=\"input_co2 fix_width83 date\" placeholder=\"yyyy-MM-dd\">";

    $html .= "<select id=\"time_" . $id . "\" class=\"fix_width55\" style=\"margin-left:5px;\">";

    for ($i=0; $i<24; $i++) {
        $html .= option($i, $i);
    }

    $html .= "</select>";
    return $html;
}

/**
 * @brief 날짜일 검색 html 생성
 *
 * @param $param["value"]  = option value에 들어갈 필드값 - 배열
 * @param $param["fields"]  = option에 표시할 필드값 - 배열
 * @param $param["id"] = id 값
 * @param $param["flag"] = 검색조건여부
 *
 */
function makeDatePickerHtml($param) {

    $html = "";

    if ($param["flag"] == true) {
        $html .= "\n<select id=\"" . $param["id"] . "\" class=\"fix_width150\">";

        for ($i=0; $i < count($param["fields"]); $i++) {
            $html .= "\n" . option($param["fields"][$i], $param["value"][$i]);
        }
        $html .= "\n</select>";
    }

    if (!$param["func"]) {
        $param["func"] = "dateSet";
    }

    $html .= "\n" . makeDateInfo($param["from_id"]);
    $html .= "\n" . makeDateInfo($param["to_id"]);
    $html .= "\n" . makeDateSetBtn(1, "어제", $param["func"], 40);
    $html .= "\n" . makeDateSetBtn(0, "오늘", $param["func"], 40);
    $html .= "\n" . makeDateSetBtn(7, "일주일", $param["func"], 55);
    $html .= "\n" . makeDateSetBtn(30, "한달", $param["func"], 40);
    $html .= "\n" . makeDateSetBtn("last", "작년동기", $param["func"], 63);
    $html .= "\n" . makeDateSetBtn("all", "전체", $param["func"], 40);

    return $html;
}

/*
 * 검색 list 생성
 *
 * @param $arr["col"]  = "컬럼 값"
 * @param $arr["val"]  = "컬럼에 해당하는 value 값"
 * @param $arr["type"]  = "검색 한 필드(함수명에 들어갈 이름)"
 *
 * return : list
 */
function makeSearchList($result, $arr) {

    $buff = "";

    while ($result && !$result->EOF) {

        $data = $result->fields[$arr["col"]];
        $data_val = $result->fields[$arr["val"]];

        $opt_arr[$data_val] = $data;
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $val => $key) {

            $buff .= "<a href=\"#\" onclick=\"" . $arr["type"];
            $buff .= "Click('" . $val;
            $buff .= "')\"><li>" . $key . "</li></a>";

        }
    }

    return $buff;
}

/*
 * 검색 list 생성
 *
 * @param $arr["opt"]  = "옵션값"
 * @param $arr["opt_val"]  = "옵션 value 값"
 * @param $arr["func"]  = "함수명에 들어갈 이름"
 *
 * return : list
 */
function makeSearchListSub($result, $arr) {

    $buff = "";

    while ($result && !$result->EOF) {

        $data = $result->fields[$arr["opt"]];
        $data_val = $result->fields[$arr["opt_val"]];

        $opt_arr[$data_val] = $data;
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" .  $arr["func"];
            $buff .= "Click('" . $key;
            $buff .= "', '" . $val . "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}



/*
 * 우편번호 팝업
 *
 * return : list
 */
function makeZipPopupHtml($func, $func2, $func3) {

	$html  = "\n								<dl>";
	$html .= "\n								    <dt class=\"tit\">";
	$html .= "\n								        <h4>주소 검색창</h4>";
	$html .= "\n								    </dt>";
    $html .= "\n									    <dt class=\"cls\">";
    $html .= "\n									        <button type=\"button\" onclick=\"$func(); return false;\" class=\"btn btn-sm btn-danger fa fa-times\"></button>";
    $html .= "\n									    </dt>";
    $html .= "\n									    </dl>";
    $html .= "\n 									    <div class=\"pop-base\">";
    $html .= "\n									        <div class=\"pop-content\">";
    $html .= "\n                                        <label class=\"form-radio form-normal\"><input type=\"radio\" name=\"doro_yn\" value=\"N\" class=\"check_box\" checked> 지번주소</label>";
    $html .= "\n                                        <label class=\"form-radio form-normal\"><input type=\"radio\" name=\"doro_yn\" value=\"Y\" class=\"check_box\"> 도로명주소</label>";
    $html .= "\n									            <hr class=\"hr_bd3\">";

    $html .= "\n							                    <select id=\"zipcode_area\" name=\"zipcode_area\" class=\"fix_width120\">";
    $html .= "\n							                    <option value=\"seoul\" selected=\"selected\">서울특별시</option>";
    $html .= "\n	                                            <option value=\"busan\">부산광역시</option>";
    $html .= "\n                                                 <option value=\"daegu\">대구광역시</option>";
    $html .= "\n                                                 <option value=\"incheon\">인천광역시</option>";
    $html .= "\n                                                 <option value=\"gwangju\">광주광역시</option>";
    $html .= "\n                                                 <option value=\"daejeon\">대전광역시</option>";
    $html .= "\n                                                 <option value=\"ulsan\">울산광역시</option>";
    $html .= "\n                                                 <option value=\"sejong\">세종특별자치시</option>";
    $html .= "\n                                                 <option value=\"gangwon\">강원도</option>";
    $html .= "\n                                                 <option value=\"gyeonggi\">경기도</option>";
    $html .= "\n                                                 <option value=\"gyeongsangnam\">경상남도</option>";
    $html .= "\n                                                 <option value=\"gyeongsangbuk\">경상북도</option>";
    $html .= "\n                                                 <option value=\"jeollanam\">전라남도</option>";
    $html .= "\n                                                 <option value=\"jeollabuk\">전라북도</option>";
    $html .= "\n                                                 <option value=\"jeju\">제주특별자치도</option>";
    $html .= "\n                                                 <option value=\"chungchengnam\">충청남도</option>";
    $html .= "\n                                                 <option value=\"chungchengbuk\">충청북도</option>";
    $html .= "\n                                             </select>";
    $html .= "\n									            <input id=\"zip_search\" onkeydown=\"$func2(event)\" type=\"text\" class=\"search_btn fix_width180\"><button type=\"button\" onclick=\"$func3();\" class=\"btn btn-sm btn-info fa fa-search\"></button></label>";
    $html .= "\n									            <hr class=\"hr_bd3\">";
    $html .= "\n									               <div class=\"list_scroll fix_height120\">";
    $html .= "\n						                  <ul id=\"search_result\" style=\"ofh\">";
    $html .= "\n								                  </ul>";
    $html .= "\n								               </div>";
    $html .= "\n									        </div>";
    $html .= "\n									    </div>";
    $html .= "\n					   </div>";

    return $html;
}

/*
 * 주소 검색 list 생성
 *
 * return : list
 */
function makeSearchAddrList($result, $type, $click_func) {

    $buff = "";

    while ($result && !$result->EOF) {

        $addr = "";
        $detail = "";

        $zipcode = $result->fields["zipcode"];
        $sido = $result->fields["sido"];
        $gugun = $result->fields["gugun"];

        //지번 주소 검색일때
        if ($type == "N") {

            //동 검색일때
            if ($result->fields["dong"] != "") {

                $detail = $result->fields["dong"] . " ";

            //읍면 검색일때
            } else if ($result->fields["eup"] != ""){

                $detail = $result->fields["eup"] . " ";

            }

            //읍면일때 리 포함
            if ($result->fields["eup"]) {

                $detail .= $result->fields["ri"] . " ";

            }

            $detail .= $result->fields["jibun_bonbun"];

            //지번 부번이 0이 아닐 때
            if ($result->fields["jibun_bubun"] != "0") {

                $detail .= "-" . $result->fields["jibun_bubun"] . " ";
            }

            $detail .= " " . $result->fields["bldg"];

        //도로명 주소 검색일때
        } else {

            $detail  = $result->fields["doro"] . " ";
            $detail .= $result->fields["bldg_bonbun"];

            //건물 부번이 0이 아닐 때
            if ($result->fields["bldg_bubun"] != "0") {

                $detail .= "-" . $result->fields["bldg_bubun"];

            }

            $detail .= " " . $result->fields["bldg"];

        }

        $addr  = $zipcode . "&nbsp;&nbsp;&nbsp;&nbsp;" . $sido . " ";
        $addr .= $gugun . " " . $detail;

        $opt_arr[] = $addr;

        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" style=\"cursor: pointer;\" onclick=\"" . $click_func . "('" . $val;
            $buff .= "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}

/**
 * @brief 시간 select 박스 option 생성
 *
 * @param $start_num   = 처음 숫자
 * @param $end_num   = 마지막 숫자
 *
 */
function makeOptionTimeHtml($start_num, $end_num) {

    $html = "";
    for($i=$start_num; $i<$end_num+1; $i++) {

        if (strlen($i) == "1") $i = "0" . $i;

        $html .= "\n  <option value=\"" . $i . "\">" . $i . "</option>";

    }

    return $html;
}


?>
