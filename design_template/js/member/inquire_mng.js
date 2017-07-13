/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/28 생성
 * 2015/12/30 문의관리 부분 추가 
 *=============================================================================
 *
 */

$(document).ready(function() {
    loadDeparInfo();
    inquireListAjaxCall("", 30, 1, "");
});

//회원 일련번호
var memberSeqno = "";
//보여줄 페이지 수
var showPage = "";


/*
 * 1:1문의 리스트 호출
 */
var inquireListAjaxCall = function(txt, sPage, page, sorting) {
 
    showMask();
/*  var tmp = sorting.split('/');
    for (var i in tmp) {
        tmp[i];
    }
*/
    if ($("#date_from").val() > $("#date_to").val()) {
        hideMask();
        alert("선택하신 날짜 기간에 이상이 있습니다.");
        return false;
    }
 
    var data = {
    	"sell_site"   : $("#sell_site").val(),
    	"depar_code"  : $("#depar_code").val(),
    	"office_nick" : $("#office_nick").val(),
    	"search_cnd"  : $("#search_cnd").val(),
    	"date_from"   : $("#date_from").val(),
    	"date_to"     : $("#date_to").val(),
    	"time_from"   : $("#time_from").val(),
    	"time_to"     : $("#time_to").val(),
    	"answ_yn"     : $("#answ_yn").val(),
    	"showPage"    : sPage,
    	"page"        : page
//      "sorting"       : tmp[0],
//      "sorting_type"  : tmp[1]
    };
    var url = "/ajax/member/member_mng/inquire_list.php";

    var blank = "<tr><td colspan=\"9\">검색 된 내용이 없습니다.</td></tr>";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
//	console.log(result);
            hideMask();
            var rs = result.split("♪");

            if (rs[0] == "") {
                $("#member_list").html(blank);
            } else {
                $("#member_list").html(rs[0]);
            }

            $("#member_page").html(rs[1]);
            $("#member_total").html(rs[2]);
        }   
    });
}

//회원 검색
var searchMember = function() {

    inquireListAjaxCall("", 30, 1, "");
}

//회원 상세정보 페이지 보여주는수 
var showPageSetting = function(val) {

    showPage = val;
    inquireListAjaxCall("", val, 1, "");
}

//회원상세 정보 페이지 이동
var movePage = function(val) {

    inquireListAjaxCall("", showPage, val, "");
}

//관리 탭 열기
var showDetail = function(seqno) {
    showMask();

    var data = {
       "seqno"      : seqno
    }; 
    var url = "/ajax/member/member_mng/inquire_detail.php";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
            hideMask();
            console.log(result);
            var rs = result.split("♪");
            $("#oto_content").html(rs[0]);
	    }
    });
}

