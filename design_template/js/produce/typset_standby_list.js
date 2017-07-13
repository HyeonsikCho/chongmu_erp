/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2016/01/28 임종건 생성
 *=============================================================================
 *
 */

$(document).ready(function() {
 //   cndSearch.exec(30, 1);
});

//보여줄 페이지 수
var showPage = "";

/**
 * @brief 상세검색정보(종이/사이즈/인쇄) 초기화
 *
 * @param cateSortcode = 정보검색용 카테고리 분류코드
 */
var initPaperInfo = function(cateSortcode) {
    if (checkBlank(cateSortcode) === true) {
        resetPaperInfo();
        $("#paper_name").html(makeOption("종이명(전체)"));
        $("#paper_dvs").html(makeOption("구분(전체)"));
        $("#paper_color").html(makeOption("색상(전체)"));
        $("#paper_basisweight").html(makeOption("평량(전체)"));
        return false;
    }

    var url = "/json/produce/typset_standby_list/load_paper_name.php";
    var data = {
        "cate_sortcode" : cateSortcode
    };
    var callback = function(result) {
        $("#paper_name").html(result.paper);
    };

    ajaxCall(url, "json", data, callback);
};

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(el, showPage, page) {
        
        var url = "/ajax/produce/typset_standby_list/load_typset_standby_" + el + "_list.php";
        var blank = "<tr><td colspan=\"13\">검색 된 내용이 없습니다.</td></tr>";
        var data = {
    	    "search_cnd"  : $("#search_cnd").val(),
    	    "search_txt"  : $("#search_txt").val(),
    	    "search_cnd2" : $("#search_cnd2").val(),
       	    "date_from"   : $("#date_from").val(),
    	    "date_to"     : $("#date_to").val(),
    	    "time_from"   : $("#time_from").val(),
    	    "time_to"     : $("#time_to").val()
	    };
        var callback = function(result) {
            var rs = result.split("♪");
            if (rs[0].trim() == "") {
                $("#list").html(blank);
                return false;
            }
            $("#" + el + "list").html(rs[0]);
            $("#" + el + "page").html(rs[1]);
        };

        //카테고리 종이 일련번호 가져오는 것 
        data.paper_name        = $("#paper_name").val();
        data.paper_dvs         = $("#paper_dvs").val();
        data.paper_color       = $("#paper_color").val();
        data.paper_basisweight = $("#paper_basisweight").val();
        //여기까지

        data.cate_sortcode = $("#cate_bot").val();
        data.sell_site     = $("#sell_site").val();
        data.showPage      = showPage;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

//보여줄 페이지 수 설정
var showPageSetting = function(val, dvs) {
    showPage = val;
    cndSearch.exec(val, 1);
}

//페이지 이동
var movePage = function(val) {
    cndSearch.exec(showPage, val);
}
