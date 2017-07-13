/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/29 임종건 생성
 *=============================================================================
 *
 */

$(document).ready(function() {
    cndSearch.exec(30, 1);
});

//보여줄 페이지 수
var showPage = "";

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(listSize, page) {
        
        var url = "/ajax/business/order_hand_regi/load_member_list.php";
        var blank = "<tr><td colspan=\"8\">검색 된 내용이 없습니다.</td></tr>";
        var data = {};
        var callback = function(result) {
            var rs = result.split("♪");
            if (rs[0].trim() == "") {
                $("#list").html(blank);
                return false;
            }
            $("#list").html(rs[0]);
            $("#page").html(rs[1]);
        };

        data.sell_site   = $("#sell_site").val();
        data.office_nick = $("#office_nick").val();
        data.member_id   = $("#member_id").val();
        data.listSize    = listSize;
        data.page        = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

/**
* @brief 검색
*/
var searchMember = function() {
    cndSearch.exec(30, 1);
}

/**
* @brief 보여줄 페이지 수 설정
*/
var showPageSetting = function(val) {
    showPage = val;
    cndSearch.exec(val, 1);
}

/**
* @brief 페이지 이동
*/
var movePage = function(val) {
    cndSearch.exec(showPage, val);
}
