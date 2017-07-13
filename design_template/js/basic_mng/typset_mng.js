/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/04 왕초롱 생성
 * 2016/01/19 임종건 수정 
 *=============================================================================
 *
 */

var page = "1"; //페이지
var list_num = "30"; //리스트 갯수
var search_col = ""; //검색어
var add_yn = "Y";//추가/수정 여부
var typset_seqno = "";

$(document).ready(function() {

    selectSearch(1);

});

//조판명 가져오기
var loadTypsetName = function(event, search_str, dvs) {
    
    if (event.keyCode != 13) {
        return false;
    }

    showMask();

    $.ajax({
            type: "POST",
            data: {
                "search_str" : search_str
            },
            url: "/ajax/basic_mng/typset_mng/load_typset_name.php",
            success: function(result) {
                if (dvs != "select") {

                    searchPopShow(event, 'loadTypsetName', 'loadTypsetName');

                } else {

                    showBgMask();

                }
                hideMask();
                $("#search_list").html(result);
           }   
    });
}

//조판파일 가져오기
var loadTypsetFile = function(event, search_str, dvs) {
 
    if (event.keyCode != 13) {
        return false;
    }

    showMask();
    
    $.ajax({
            type: "POST",
            data: {
                "search_str" : search_str
            },
            url: "/ajax/basic_mng/typset_mng/load_typset_file.php",
            success: function(result) {
                 if (dvs != "select") {

                    searchPopShow(event, 'loadTypsetFile', 'loadTypsetFile');

                } else {

                    showBgMask();

                }
                hideMask();
                $("#search_list").html(result);
           }   
    });
}

//팝업 검색된 조판명 클릭시
var nameClick = function(val) {

    hideRegiPopup();
    $("#typset_name").val(val);

}

//팝업 검색된 파일명 클릭시
var fileClick = function(val) {

    hideRegiPopup();
    $("#typset_file").val(val);

}

//조판 리스트 가져오기
var selectSearch = function(page) {

    $.ajax({

        type: "POST",
        data: {
                "page"      : page,
                "list_num"  : list_num,
                "name"      : $("#typset_name").val(),
                "affil_fs"  : $("input[name=affil_fs]:checked").val(),
                "affil_guk" : $("input[name=affil_guk]:checked").val(),
                "affil_spc" : $("input[name=affil_spc]:checked").val(),
                "file"      : $("#typset_file").val()
        },
        url: "/ajax/basic_mng/typset_mng/load_typset_list.php",
        success: function(result) {

            var list = result.split('★');

	        if ($.trim(list[0]) == "") {

                $("#typset_list").html("<tr><td colspan='9'>검색된 내용이 없습니다.</td></tr>"); 

	        } else {

                $("#typset_list").html(list[0]);
                $("#typset_page").html(list[1]); 
		        $('select[name=list_set]').val(list_num);

	        }
        }, 
        error: getAjaxError
    });

}

//조판 정보 팝업에 입력
var loadTypsetInfo = function(seq) {

    typset_seqno = seq;
    showMask();

    $.ajax({

        type: "POST",
        data: {
                "typset_seqno" : seq
        },
        url: "/ajax/basic_mng/typset_mng/load_typset_info.php",
        success: function(result) {

            var tmp = result.split('♪♥♭');
            var typset_info = tmp[1].split('♪♡♭');

            hideMask();

            openRegiPopup(tmp[0], 650);
            $("#affil").val(typset_info[0]);
            $("#subpaper").val(typset_info[1]);
            $("#dscr").val(typset_info[2]);
            $("#cate_top").val(typset_info[3]);
            $("#cate_mid").val(typset_info[4]);
            $("#cate_bot").val(typset_info[5]);
            $("#purp").val(typset_info[6]);
            $("#dlvrboard").val(typset_info[7]);
            $("#extnl_etprs_seqno").val(typset_info[8]);
            $("#pur_prdt").val(typset_info[9]);
        }, 
        error: getAjaxError
    });
}

//조판 팝업 인풋 비우기
var initTypsetData = function() {

    $("#pop_typset_name").val('');
    $("#affil").val('46');
    $("#subpaper").val('2절');
    $("#upload_file").val('');
    $("#upload_btn").val('');
    $("#wid_size").val('');
    $("#vert_size").val('');
    $("#dscr").val('');

}

//보여 주는 페이지 갯수 설정
var showPageSetting = function(val) {

    list_num = val;
    selectSearch('1');
} 

//선택 조건으로 검색(페이징 클릭)
var searchResult = function(page) {
    selectSearch(page);
}

//전체 선택
var allCheck = function() {

    //만약 전체선택 체크박스가 체크 된 상태일 경우
    if ($("#all_check").prop("checked")) {
        $("#typset_list input[type=checkbox]").prop("checked", true);
    } else {
        $("#typset_list input[type=checkbox]").prop("checked", false);
    }
}

//조판 추가 팝업
var popAddTypset = function() {

    $.ajax({
        type: "POST",
        data: {},
        url: "/ajax/basic_mng/typset_mng/load_typset_pop.php",
        success: function(result) {

            openRegiPopup(result, 650);
            $('#del_typset').hide();
        }, 
        error: getAjaxError
    });
}

//조판 품목 저장
var saveTypset = function(type) {

    //조판명이 비었을때
    if(checkBlank($("#pop_typset_name").val())) {

        alert("조판명을 입력해주세요.");
        $("#pop_typset_name").focus();
        return false;
    }

    //카테고리
    if(checkBlank($("#cate_bot").val())) {

        alert("카테고리 소분류까지 선택해주세요.");
        $("#cate_bot").focus();
        return false;
    }

    var formData = new FormData($("#typset_form")[0]);
        formData.append("add_yn", type);
        formData.append("typset_seqno", typset_seqno);
        formData.append("honggak_yn", $(':radio[name="honggak_yn"]:checked').val());

    $.ajax({
        type: "POST",
        data: formData,
	    processData : false,
	    contentType : false,
        url: "/proc/basic_mng/typset_mng/proc_typset.php",
        success: function(result) {
         	if($.trim(result) == "1") {
          	    alert("저장했습니다.");
		        hideRegiPopup();
    	    	selectSearch(page);

      	    } else {
        	    alert("실패했습니다.");
            }
        }   
    });
}

//조판 선택 삭제
var delTypset = function() {

    var select_typset = getselectedNo();

    if (select_typset == "") {
        alert("삭제할 목록을 선택해주세요");
        return false;
    }

    $.ajax({
            type: "POST",
            data: {
                "select_typset" : select_typset
            },
            url: "/proc/basic_mng/typset_mng/del_typset.php",
            success: function(result) {
            if($.trim(result) == "1") {

                alert("삭제했습니다.");

            } else {

                alert("삭제에 실패했습니다.");

            }
            selectSearch("1");
           }   
    });
}

//조판 개별 삭제
var delPopTypset = function() {

    $.ajax({
            type: "POST",
            data: {
                "select_typset" : typset_seqno,
            },
            url: "/proc/basic_mng/typset_mng/del_typset.php",
            success: function(result) {
            if($.trim(result) == "1") {

                alert("삭제했습니다.");
    		hideRegiPopup();
                selectSearch("1", "1");

            } else {

                alert("삭제에 실패했습니다.");

            }
        }   
    });
}

//체크박스 선택시 value값 가져오는 함수
var getselectedNo = function(el) {

    var selectedValue = ""; 
    
    $("#typset_list input[name=typset_chk]:checked").each(function() {
        selectedValue += ","+ $(this).val();		    
    });

    if (selectedValue != "") {
        selectedValue = selectedValue.substring(1);
    }

    return selectedValue;
}

