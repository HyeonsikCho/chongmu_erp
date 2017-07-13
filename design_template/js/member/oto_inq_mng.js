/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2016/01/08 임종건 생성
 *=============================================================================
 *
 */

$(document).ready(function() {
    loadDeparInfo();
    cndSearch.exec(30, 1);
});

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

//보여줄 페이지 수
var showPage = "";

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(listSize, page) {
        
        var url = "/ajax/member/oto_inq_mng/load_oto_inq_list.php";
        var blank = "<tr><td colspan=\"9\">검색 된 내용이 없습니다.</td></tr>";
        var data = {
    	    "search_cnd"  : $("#search_cnd").val(),
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
            $("#list").html(rs[0]);
            $("#page").html(rs[1]);
        };

        data.sell_site     = $("#sell_site").val();
        data.depar_code    = $("#depar_code").val();
        data.office_nick   = $("#office_nick").val();
        data.status        = $("#status").val();
        data.claim_dvs     = $("#dvs").val();
        data.listSize      = listSize;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

/**
* @brief 검색
*/
var searchInquire = function() {
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

/**
* @brief 문의관리
*/
var getInq = {
    "exec"       : function(seqno) {
        var url = "/ajax/member/oto_inq_mng/load_oto_inq_info.php";
        var data = {
	        "seqno" : seqno
        };
        var callback = function(result) {
            var rs = result.split("♪");

            $("#oto_cont").html(rs[0]);


            if (rs[1] === "Y") {
                $("#reply_btn").hide();
                $("#reply_cont").attr("disabled", true);
                $("#file_search").attr("disabled", true);
                $("#upload_file").attr("disabled", true);
            }

            fnMove();
        };

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}

/**
* @brief 답변 등록
*/
var regiReply = {
     "exec"       : function(seqno) {
        var formData = new FormData();
        var url = "/proc/member/oto_inq_mng/regi_oto_inq_info.php";
        var data = formData;
        formData.append("seqno", seqno);
        formData.append("reply_cont", $("#reply_cont").val());
        formData.append("upload_file", $("#upload_file")[0].files[0]);
        showMask();
         
        $.ajax({
        type: "POST",
        data: data,
        url: url,
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                cndSearch.exec(30, 1);
	        getInq.exec(seqno);
                alert("답변을 등록 하였습니다.");
            } else {
                alert("답변등록을 실패하였습니다.");
            }
        },
        error    : getAjaxError   
        });
    }
}

//파일찾기 
var fileSearchBtn = function(val) {
    return $("#upload_path").val(val);
}

function fnMove(){
    var offset = $("#oto_cont").offset();
    $('html, body').animate({scrollTop : offset.top}, 400);
}