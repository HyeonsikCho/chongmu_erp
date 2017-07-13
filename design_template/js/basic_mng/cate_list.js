/* * * Copyright (c) 2015 Nexmotion, Inc.  * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/11/13 임종건 생성
 * 2015/12/03 임종건 탭, 카테고리트리 추가
 * 2016/01/12 임종건 loadCateTree('') 주석처리
 *=============================================================================
 *
 */

//선택 된 탭
var selectEl = "paper";
//선택 된 카테고리 코드
var selectCode = "";
//검색어
var searchTxt = "";
//리스트 갯수
var showPage = "30";
//현재 페이지
var nowPage = "1";
//선택 된 대분류
var selectSort = "";
//선택 카테고리 레벨
var selectLevel = "";

//이전선택된 카테고리 선택을 위한 변수
var one_val = "";
var one_code = "";
var two_val = "";
var two_code = "";
var thr_val = "";
var thr_code = "";

var open_code = "";
var open_code_sub = "";

/*
$(document).ready(function(){
    loadCateTree(''); 
    treeClickInit();
});
*/

//리스트 초기화
var init = function() {

    searchTxt = "";
    showPage = 30;
    nowPage = 1
    selectSort = "";
}

//트리 초기화
var treeClickInit = function() {
    $(".one").removeClass("red_text01");   
    $(".two").removeClass("red_text01");   
    $(".thr").removeClass("on");   
    $(".one").removeClass("fwb");   
    $(".two").removeClass("fwb");   
    $(".thr").removeClass("fwb");   
    $("#cate_top").css("color", "");
    $("#cate_mid").css("color", "");
    $("#cate_btm").css("color", "");
    $("#select_cate").attr("disabled", true);
    $("#select_cate").addClass("input_dis_co2");
    $("#select_cate").removeClass("input_co2");
    $("#mono_n").attr("disabled", true);
    $("#mono_y").attr("disabled", true);
    $("#flattyp_y").attr("disabled", true);
    $("#flattyp_n").attr("disabled", true);
    $("#save_btn").hide();
    $("#update_btn").show();
}

//이전에 선택된 카테고리 선택
var beforeSelectCate = function() {

    var oneC = one_code;
    var oneV = one_val;
    var twoC = two_code;
    var twoV = two_val;
    var thrC = thr_code;
    var thrV = thr_val;

    if (selectLevel == 1) {
        oneLevelTreeClick("#" + oneC, oneV, oneC, "select");
    } else if (selectLevel == 2) {
        oneLevelTreeClick("#" + oneC, oneV, oneC, "select");
        twoLevelTreeClick("#" + twoC, twoV, twoC, "select");
    } else if (selectLevel == 3) {
        oneLevelTreeClick("#" + oneC, oneV, oneC, "select");
        twoLevelTreeClick("#" + twoC, twoV, twoC, "select");
        thrLevelTreeClick("#" + thrC, thrV, thrC, "select");
    }
}

//카테고리 트리 호출
var loadCateTree = function(type) {

    showMask();

    $.ajax({
	type: "POST",
        data: {},
        url: "/ajax/basic_mng/cate_list/load_cate_tree.php",
        success: function(result) {
	    $("#tree_box").html(result);
            hideMask();
            //이전에 트리를 선택한 기록이있을때 선택한 폴더를 열어준다
            if (type == 'select') {
                beforeSelectCate();
            }
	},
        error: getAjaxError 
    }); 
 
}

//선택 카테고리 별 계산방식 리스트
//리스트 종이 사이즈 인쇄도수 후공정 옵션
var cateDetail = function(code) {
    
    showMask();
    $.ajax({
	type: "POST",
      	data: {
              "sortcode" : code
        },
      	url: "/ajax/basic_mng/cate_list/load_cate_info.php",
      	success: function(result) {

            hideMask();
            var cate_info = result.split("♪");

	        //전체
            if (cate_info[0] == 1) {
	            $("#mono_n").prop("checked", true);
	            $("#mono_y").prop("checked", true);
	        //합판만(확정형)
	        } else if (cate_info[0] == 2) {
	            $("#mono_n").prop("checked", true);
                $("#mono_y").prop("checked", false);
	        //독판만(계산형)
	        } else if (cate_info[0] == 3) {
                $("#mono_n").prop("checked", false);
	            $("#mono_y").prop("checked", true);
	        }

            //책자형
            if (cate_info[1] == "N") {
                $("#flattyp_y").prop("checked", false);
	            $("#flattyp_n").prop("checked", true);
            //낱장형 
            } else if (cate_info[1] == "Y") {
                $("#flattyp_y").prop("checked", true);
	            $("#flattyp_n").prop("checked", false);
            }
			$("#c_rate").val(cate_info[2]);
			$("#c_user_rate").val(cate_info[3]);
            init();
            cateOptionAjaxCall(selectEl);
            cateInfoAjaxCall(selectEl, code, searchTxt, showPage, nowPage, selectSort, "");
       	},   
        error: getAjaxError 
    });
}

//첫번째 트리 클릭
var oneLevelTreeClick = function(el, val, code, type) {
   
    one_val = val;
    one_code = code;
    two_val = "";
    two_code = "";
    thr_val = "";
    thr_code = "";
 
    selectCode = code;
    selectLevel = 1;
    treeClickInit();
    $(el).addClass("red_text01");
    $(el).addClass("fwb");
    cateDetail(code);
    $("#select_cate").val(val);
     
    //이전에 트리를 선택한 기록이있을때 선택한 폴더를 열어준다
    if (type == 'select') {
    	$("#" + code).parent().trigger( "click" );
        $("#" + $("#" + code).parent().attr("for")).prop("checked", true);
    }
}

//두번째 트리 클릭
var twoLevelTreeClick = function(el, val, code, type) {
    
    two_val = val;
    two_code = code;
    thr_val = "";
    thr_code = "";

    selectCode = code;
    selectLevel = 2;
    treeClickInit();
    $(el).addClass("red_text01");
    $(el).addClass("fwb");
    cateDetail(code);
    $("#select_cate").val(val);
        
    //이전에 트리를 선택한 기록이있을때 선택한 폴더를 열어준다
    if (type == 'select') {
    	$("#" + code).parent().trigger( "click" );
        $("#" + $("#" + code).parent().attr("for")).prop("checked", true);
    }
}

//세번째 트리 클릭
var thrLevelTreeClick = function(el, val, code, type) {
 
    thr_val = val;
    thr_code = code;

    selectCode = code;
    selectLevel = 3;
    treeClickInit();
    $(el).addClass("on");
    $(el).addClass("fwb");
    cateDetail(code);
    $("#select_cate").val(val);
        
    //이전에 트리를 선택한 기록이있을때 선택한 폴더를 열어준다
    if (type == 'select') {
     	$("#" + code).parent().trigger( "click" );
        $("#" + $("#" + code).parent().attr("for")).prop("checked", true);
    }
}

//카테고리 수정 버튼 눌렀을때
var editCateInfo = function() {
 
    //카테고리가 선택 안되었을 경우
    if (selectCode == "") {
        alert('선택 된 카테고리가 없습니다.');
        return false;
    }

    $("#select_cate").removeAttr("disabled");
    $("#select_cate").addClass("input_co2");
    $("#select_cate").removeClass("input_dis_co2");
    $("#select_cate").focus();
    $("#c_rate").removeAttr("disabled");
    $("#c_rate").addClass("input_co2");
    $("#c_rate").removeClass("input_dis_co2");
	$("#c_rate").focus();
	$("#c_user_rate").removeAttr("disabled");
    $("#c_user_rate").addClass("input_co2");
    $("#c_user_rate").removeClass("input_dis_co2");
    
    $("#mono_n").removeAttr("disabled");
    $("#mono_y").removeAttr("disabled");
    $("#flattyp_y").removeAttr("disabled");
    $("#flattyp_n").removeAttr("disabled");
    $("#update_btn").hide();
    $("#save_btn").show();
}

//카테고리 변경된 정보 저장
var saveCateInfo = function() {

    showMask();
    var mono_dvs = "";
    var flattyp = "";
    var cate_name = $("#select_cate").val();
	var c_rate = $("#c_rate").val() || 0;
	var c_user_rate = $("#c_user_rate").val() || 0;
    //전체
    if ($("input:checkbox[id='mono_n']").is(":checked") && $("input:checkbox[id='mono_y']").is(":checked")) {
        mono_dvs = 1;
    //합판만(확정형)
    } else if ($("input:checkbox[id='mono_n']").is(":checked")) {
        mono_dvs = 2;
    //독판만(계산형)
    } else if ($("input:checkbox[id='mono_y']").is(":checked")) {
        mono_dvs = 3;
    }


    if ($("input:radio[id='flattyp_y']").is(":checked")) {
        flattyp = "Y";
    } else if ($("input:radio[id='flattyp_n']").is(":checked")) {
        flattyp = "N";
    }

    $.ajax({
	type: "POST",
      	data: {
            "cate_name" : cate_name,
            "sortcode"  : selectCode,
            "flattyp_yn": flattyp,
            "mono_dvs"  : mono_dvs,
			"c_rate" : c_rate,
			"c_user_rate" : c_user_rate
        },
      	url: "/proc/basic_mng/cate_list/modi_cate_info.php",
      	success: function(result) {

            hideMask();
	        if (result) {
	            $("#select_cate").attr("disabled", true);
                $("#select_cate").addClass("input_dis_co2");
                $("#select_cate").removeClass("input_co2");
	            $("#c_rate").attr("disabled", true);
                $("#c_rate").addClass("input_dis_co2");
                $("#c_rate").removeClass("input_co2");
	            $("#c_user_rate").attr("disabled", true);
                $("#c_user_rate").addClass("input_dis_co2");
                $("#c_user_rate").removeClass("input_co2");
                $("#mono_n").attr("disabled", true);
                $("#mono_y").attr("disabled", true);
                $("#flattyp_y").attr("disabled", true);
                $("#flattyp_n").attr("disabled", true);
                $("#update_btn").show();
                $("#save_btn").hide();
	        	//loadCateTree("select");
 
         		//카테고리 레벨이 1인 경우
	        	if (selectLevel == 1) {
                    one_val = cate_name;
	        	//커테고리 레벨이 2인 경우
	        	} else if (selectLevel == 2) {
                    two_val = cate_name;
	        	//카테고리 레벨이 3인 경우 
	        	} else if (selectLevel == 3) {
                    thr_val = cate_name;
	        	}
	            alert("수정 되었습니다.");
	        } else {
	            alert("수정을 실패 하였습니다.");
     	    }
       	},   
        error: getAjaxError 
    });
}

//카테고리 대메뉴 html추가
var addCateTop = function() {
 
    $(".add_cate").hide();
    $(".add_cate").html("");

    var html = "";
    html += "<li class=\"ptb05\">";
    html += "<input class=\"input_co2 fix_width120 \" style=\"margin-left: 2px;margin-right: 4px;\" id=\"cate_one_name\" type=\"text\" placeholder=\"추가명:\">";
    html += "<button class=\"btn btn-sm btn-primary fa fa-check\" type=\"button\" onClick=\"addCateTopProc();\">";
    html += "</button>";
    html += "<button class=\"blue_text01 btn btn-sm btn-default fa fa-times\" type=\"button\" onClick=\"delCateTop();\"></button></li>";
   
    $("#add_cate_one").show(); 
    $("#add_cate_one").html(html); 
} 

//카테고리 중메뉴 html추가
var addCateMid = function(arg, el, val) {
 
    if (open_code != arg) {
        oneLevelTreeClick(el, val, arg, "select");
        open_code = arg;
    } else {
        oneLevelTreeClick(el, val, arg, "");
    }
 
    $(".add_cate").hide();
    $(".add_cate").html("");
 
    var html = "";
    html += "<li class=\"ptb05\">&nbsp;&nbsp;&nbsp;";
    html += "<input class=\"input_co2 fix_width120 \" style=\"margin-left: 2px;margin-right: 4px;\" id=\"cate_two_name_" + arg + "\" type=\"text\" placeholder=\"추가명:\">";
    html += "<button class=\"btn btn-sm btn-primary fa fa-check\" type=\"button\" onClick=\"addCateMidProc('" + arg + "');\"></button>";
    html += "<button class=\"blue_text01 btn btn-sm btn-default fa fa-times\" type=\"button\" onClick=\"delCateMid('" + arg + "');\"></button></li>";
   
    $("#add_cate_two_" + arg).show(); 
    $("#add_cate_two_" + arg).html(html); 
} 

//카테고리 하메뉴 html추가
var addCateBtm = function(arg, el, val) {
 
    if (open_code_sub != arg) {
         twoLevelTreeClick(el, val, arg, "select");
         open_code_sub = arg;
    } else {
         twoLevelTreeClick(el, val, arg, "");
    }

    $(".add_cate").hide();
    $(".add_cate").html("");

    var html = "";
    html += "<li class=\"file\">";
    html += "<a><input type=\"text\" id=\"cate_thr_name_" + arg + "\" class=\"input_co2 fix_width120 \" style=\"margin-left: 2px;margin-right: 4px;\" placeholder=\"추가명:\"></a> ";
    html += "<button type=\"button\" class=\"btn btn-sm btn-primary fa fa-check\" onClick=\"addCateBtmProc('" + arg + "');\"></button> ";
    html += "<button type=\"button\" class=\"blue_text01 btn btn-sm btn-default fa fa-times\" onClick=\"delCateBtm('" + arg + "');\"></button>";
    html += "</li>";

    $("#add_cate_thr_" + arg).show(); 
    $("#add_cate_thr_" + arg).html(html); 
} 

//카테고리 대메뉴 추가 html 제거
var delCateTop = function() {

    $("#add_cate_one").html(''); 
    $("#add_cate_one").hide(); 
}

//카테고리 중메뉴 추가 html 제거
var delCateMid = function(arg) {

    $("#add_cate_two_" + arg).html(''); 
    $("#add_cate_two_" + arg).hide(); 
}

//카테고리 소메뉴 추가 html 제거
var delCateBtm = function(arg) {

    $("#add_cate_thr_" + arg).html(''); 
    $("#add_cate_thr_" + arg).hide(); 
}

//카테고리 추가 DB Proc 
var insertCateProc = function(cate_name, cate_level, high_sortcode) {

    //생성하려는 카테고리 이름이 없을 경우
    if (cate_name == "") {
        alert('카테고리 이름을 입력해 주세요');
        return false;
    }

    var check_text = /[~!@\#$%^&*\-=+_']/gi;
    if(check_text.test(cate_name)){
        alert('특수문자는 입력 하실 수 없습니다.');
	    return false;
    } 

    showMask(); 

    $.ajax({
	type: "POST",
        data: {
              "cate_name"     : cate_name, 
              "cate_level"    : cate_level,
              "high_sortcode" : high_sortcode
        }, 
        url: "/proc/basic_mng/cate_list/regi_cate_list.php",
        success: function(result) {
            hideMask();
            if (result) {
                loadCateTree("select");
                alert("카테고리가 생성 되었습니다. 중복된 카테고리는 생성 되지 않습니다.");
            } else {
                alert("카테고리를 생성 실패하였습니다.");
            }
        },
        error: getAjaxError 
    }); 
} 

//카테고리 대분류 추가
var addCateTopProc = function() {

    var cate_name = $("#cate_one_name").val().trim();

    //카테고리명과 레벨을 Parameter를 넘긴다.
    insertCateProc(cate_name, 1, '');
} 

//카테고리 중분류 추가
var addCateMidProc = function(arg) {

    var cate_name = $("#cate_two_name_" + arg).val().trim();

    //카테고리명과 레벨을 Parameter를 넘긴다.
    insertCateProc(cate_name, 2, arg);
} 

//카테고리 소분류 추가
var addCateBtmProc = function(arg) {

    var cate_name = $("#cate_thr_name_" + arg).val().trim();

    //카테고리명과 레벨을 Parameter를 넘긴다.
    insertCateProc(cate_name, 3, arg);
}

//카테고리 별 상품 구성 아이템 리스트
var cateInfoAjaxCall = function(el, code, txt, sPage, page, sSort, sort) {
  
    if (el == "grade" && code.length < 9) {
	$("#grade_list").html("<tr><td colspan=\"3\">카테고리별 등급할인은 소분류에만 적용 됩니다.</td></tr>");
	$("#grade_btn").hide();
        return false;
    } else {
	$("#grade_btn").show();
    }

    //카테고리가 선택 안되었을 경우
    if (code == "") {
        alert('선택 된 카테고리가 없습니다.');
        return false;
    }

    showMask();
    var tmp = sort.split('/');
    for (var i in tmp) {
        tmp[i];
    }

    var emptyCheck = "";
    var data = {
    	"selectEl"      : el,
       	"cate_sortcode"      : code,
        "searchTxt"     : txt,
    	"showPage"      : sPage,
    	"page"          : page,
    	"select_sort"   : sSort,
        "sort"          : tmp[0],
        "sort_type"     : tmp[1]
    };
    var url = "/ajax/basic_mng/cate_list/cate_list.php";

    var col = 6;
    //탭이 사이즈 혹은 인쇄도수 인경우
    if (el === "size" || el === "print") {
        col = 8;
    } else if (el == "grade") {
        col = 3;
    }

    var blank = "<tr><td colspan=\"" + col + "\">검색 된 내용이 없습니다.</td></tr>";
    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {

            hideMask();
            var rs = result.split("♪");

            //탭이 등급할인이 아닌 경우
            if (el != "grade") {

                if (rs[0] == "") {
                    $("#" + el + "_list").html(blank);
                } else {
                    $("#" + el + "_list").html(rs[0]);
                }
                $("#" + el + "_page").html(rs[1]);
            } else {
                if (result == "") {
                    $("#" + el + "_list").html("<tr><td colspan=\"3\">카테고리별 등급할인은 소분류에만 적용 됩니다.</td></tr>");
                } else {
                    $("#" + el + "_list").html(result);
                }
            }
        }   
    });
}

//카테고리 별 대분류 선택박스 호출
var cateOptionAjaxCall = function(el) {
 
    //카테고리가 선택 안되었을 경우
    if (selectCode == "") {
        return false;
    }

    //탭이 등급인경우
    if (el == "grade") {
        return false;
    }

    showMask();
    var url = "/ajax/basic_mng/cate_list/load_sort_option.php";
    var data = {
    	"selectEl"      : el,
        "cate_sortcode" : selectCode
    };

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
            hideMask();
            $("#" + el + "_sort").html(result);
        }   
    });
}

//탭 선택시 제어 함수
var tabCtrl = function(el) {

    selectEl = el;
    $("#" + el + "_search").val("");
    $("select[name=list_set]").val("30");
    sortInit();
    init();
    cateOptionAjaxCall(el);
    cateInfoAjaxCall(el, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//option 선택
var selectSortOption = function(el) {

    selectEl = el;
    selectSort = $("#" + el + "_sort").val();
    cateInfoAjaxCall(el, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//키워드 엔터 검색
var searchKey = function(event, val) {
 
    if(event.keyCode != 13){
        return false;
    }

    searchTxt = val;
    cateInfoAjaxCall(selectEl, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//키워트 검색버튼 클릭 검색
var searchText = function(el) {

    searchTxt = $("#" + el + "_search").val();
    cateInfoAjaxCall(el, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//컬럼별 정렬
var sortList = function(arg, el) {

    var flag = "";

    if ($(el).children().hasClass("fa-sort-desc")) {
        sortInit();
        $(el).children().addClass("fa-sort-asc");
        $(el).children().removeClass("fa-sort");
        flag = "ASC";
    } else {
        sortInit();
        $(el).children().addClass("fa-sort-desc");
        $(el).children().removeClass("fa-sort");
        flag = "DESC";
    }
    
    var sort = arg + "/" + flag;
    cateInfoAjaxCall(selectEl, selectCode, searchTxt, showPage, nowPage, selectSort, sort);
}

//보여 주는 페이지 갯수 설정
var showPageSetting = function(arg, el) {

    showPage = arg;
    cateInfoAjaxCall(el, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//페이징 검색
var movePage = function(arg, el) {

    nowPage = arg;
    cateInfoAjaxCall(el, selectCode, searchTxt, showPage, nowPage, selectSort, "");
}

//카테고리별 회원등급 할인 등록 
var insertCateMemberGradeRate = function() {
 
    showMask(); 

    $.ajax({
	type: "POST",
    data: {
          "cate_sortcode" : selectCode,
          "grade_1"       : $("#grade_1").val(),
          "grade_2"       : $("#grade_2").val(),
          "grade_3"       : $("#grade_3").val(),
          "grade_4"       : $("#grade_4").val(),
          "grade_5"       : $("#grade_5").val(),
          "grade_6"       : $("#grade_6").val(),
          "grade_7"       : $("#grade_7").val(),
          "grade_8"       : $("#grade_8").val(),
          "grade_9"       : $("#grade_9").val(),
          "grade_10"      : $("#grade_10").val()
    }, 
    url: "/proc/basic_mng/cate_list/regi_grade_rate.php",
    success: function(result) {

        hideMask();
	    if (result) {
            cateInfoAjaxCall(selectEl, selectCode, searchTxt, showPage, nowPage, selectSort, "");
            alert('카테고별 등급할인이 등록되었습니다.');
        } else {
            alert('등록을 실패하였습니다.');
        }
	},
        error: getAjaxError 
    }); 

}
