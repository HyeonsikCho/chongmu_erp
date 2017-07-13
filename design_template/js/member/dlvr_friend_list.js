$(document).ready(function() {

    searchDlvrFriend('All');

});

var area = "";
var gugun = "";
var search_nick = "";
var main_seq = "";
var sub_main_seqno = "";
var sub_sub_seqno = "";
var main_member_seqno = "";
var doro_yn = "N";

/**********************************************************************
                         * 공통 부분 *
 **********************************************************************/

//구군 가져오기
var loadGugun = function(val) {
    if (val == "") {

        $("#gugun").html("<option value=''>-구/군-</option>");

        if (doro_yn == "Y") {

            $("#dorodong").html("<option value=''>-도로명-</option>");

        } else {

            $("#dorodong").html("<option value=''>-읍/면/동-</option>");

        }

        $("#dorodong").html("<option value=''>-읍/면/동-</option>");
        $("#ri").html("<option value=''>-리-</option>");

        return;
    }

    showMask();

    area = val;

    $.ajax({

        type: "POST",
        data: {
            "area" : val
        },
        url: "/ajax/member/dlvr_friend_list/load_gugun.php",
        success: function(result) {

            $("#gugun").html(result);

            if (doro_yn == "Y") {

            $("#dorodong").html("<option value=''>-도로명-</option>");

            } else {

            $("#dorodong").html("<option value=''>-읍/면/동-</option>");

            }

            $("#ri").html("<option value=''>-리-</option>");

            hideMask();
        }, 
        error: getAjaxError
    });
}

//도로명, 동 가져오기
var loadDoroDong = function(val) {
    if (val == "") {

        if (doro_yn == "Y") {

            $("#dorodong").html("<option value=''>-도로명-</option>");

        } else {

            $("#dorodong").html("<option value=''>-읍/면/동-</option>");

        }

        $("#ri").html("<option value=''>-리-</option>");

        return;
    }

    showMask();
    gugun = val;

    $.ajax({

        type: "POST",
        data: {
            "area"    : area,
            "gugun"   : val,
	        "doro_yn" : $('input[name=addr_type]:checked').val()
        },
        url: "/ajax/member/dlvr_friend_list/load_doro_dong.php",
        success: function(result) {

            $("#dorodong").html(result);

            $("#ri").html("<option value=''>-리-</option>");
            hideMask();

        }, 
        error: getAjaxError
    });
}

//리 가져오기
var loadRi = function(val) {

    //도로명주소 일때는 검색하지 않음
    if ($('input[name=addr_type]:checked').val() == "Y") {

        return;
    }

    if (val == "") {

        return;
    }

    showMask();

    $.ajax({

        type: "POST",
        data: {
            "area"    : area,
            "gugun"   : gugun,
            "eup"     : val,
	        "doro_yn" : $('input[name=addr_type]:checked').val()
        },
        url: "/ajax/member/dlvr_friend_list/load_ri.php",
        success: function(result) {

            $("#ri").html(result);
            hideMask();

        }, 
        error: getAjaxError
    });
}

//배송친구 검색
var searchDlvrFriend = function(type) {

    var area_str = document.getElementById("area").options
        [document.getElementById("area").selectedIndex].text;

    var search_str = "";
    //지역이 선택됐을때
    if ($("#area").val() != "") {
        search_str =  area_str;

        //구/군이 선택됐을때
        if ($("#gugun").val() != "") {
            search_str = search_str + " " + $("#gugun").val();

            //도로명 or 읍면동이 선택됐을때
            if ($("#dorodong").val() !="") {
                search_str = search_str + " " + $("#dorodong").val();
            }
        }
    } 
    
    var param = {
        "search": search_str,
        "search_detail" : $("#detail").val(),
        "type"       : $('input[name=dlvr_type]:checked').val()
    }

    if (type == "All") {

        dlvrFriendList(param);
        dlvrMainReqList(param);
        dlvrSubReqList(param);
	
    } else if (type == "Aprvl") {

        dlvrFriendList(param);

    }

}

//배송친구 승인 리스트
var dlvrFriendList = function(param) {

    showMask();

    $.ajax({
            type: "POST",
            data: param,
            url: "/ajax/member/dlvr_friend_list/load_dlvr_friend.php",
            success: function(result) {
                if ($.trim(result) == "") {

                    $("#friend_list").html("<tr><td colspan='6'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $("#friend_list").html(result);

                }
    		    hideMask();
            },
            error: getAjaxError
    });
}

//배송친구 신청 리스트 - Main
var dlvrMainReqList = function(param) {

    showMask();

    $.ajax({
            type: "POST",
            data: param,
            url: "/ajax/member/dlvr_friend_list/load_dlvr_main_req.php",
            success: function(result) {

                if ($.trim(result) == "") {

                    $("#main_req_list").html("<tr><td colspan='6'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $("#main_req_list").html(result);

                }
    		    hideMask();
            },
            error: getAjaxError
    });
}

//배송친구 신청 리스트 - Sub
var dlvrSubReqList = function(param) {

    $.ajax({
            type: "POST",
            data: param,
            url: "/ajax/member/dlvr_friend_list/load_dlvr_sub_req.php",
            success: function(result) {
                if ($.trim(result) == "") {

                    $("#sub_req_list").html("<tr><td colspan='9'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $("#sub_req_list").html(result);

                }
    		    hideMask();
            },
            error: getAjaxError
    });
}

//컬럼별 sort
var sortList = function(val, type, el) {

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

    var sort = val + "/" + flag;

    if (type == "main") {

        mainAprvlList(sort);

    } else {

        subMainAprvlList(sort);

    }
}

//주소 검색 타입 변경
var changeSearchType = function(val) {

    doro_yn = val;

    $("#zipcode_area").val('');
    $("#area").val("");
    $("#gugun").html("<option value=''>-구/군-</option>");

    if (val == "Y") {

        $("#dorodong").html("<option value=''>-도로명-</option>");
        $("#ri").html("<option value=''>-리-</option>");
        $("#ri").attr("disabled", "disabled");

    } else {

        $("#dorodong").html("<option value=''>-읍/면/동-</option>");
        $("#ri").removeAttr("disabled");

    }
}

//회원 페이지로 넘어가는 미개발
var popMemberPage = function() {

    alert("회원 페이지 새창");

}

/**********************************************************************
                         * 메인 부분 *
 **********************************************************************/

//배송친구 메인 리스트
var mainAprvlList = function(sort) {

    $("#loading_img").show();

    var sort_col = "";
    var sort_type = "";

    if (sort != "") {

	var sort_info = sort.split('/');
	sort_col = sort_info[0];
	sort_type = sort_info[1];
     
    }

    $.ajax({
            type: "POST",
            data: {
		            "sort_col" : sort_col,
		            "sort_type": sort_type
	        },
            url: "/ajax/member/dlvr_friend_list/load_main_aprvl_list.php",
            success: function(result) {
                $("#loading_img").hide();

                if ($.trim(result) == "") {

                    $("#main_list").html("<tr><td colspan='3'>검색된 내용이 없습니다.</td></tr>");

                } else {

		            $('#main_list').html(result);

                }
            },
            error: getAjaxError
    });
}

//배송친구 메인 요청 리스트
var mainReqList = function(seqno) {

    showMask();
    main_seq = seqno;

    $.ajax({
            type: "POST",
            data: {
	    	"seqno" : main_seq
	    },
            url: "/ajax/member/dlvr_friend_list/load_main_list.php",
            success: function(result) {

    		    hideMask();
                openRegiPopup($("#main_pop").html(), 700);
                var main_info = result.split('♪@♭');

                if ($.trim(result) == "") {

                    $("#main_list").html("<tr><td colspan='3'>검색된 내용이 없습니다.</td></tr>");
                } else {

                    $('#main_list').html(main_info[0]);

                }
                var member_info = main_info[1].split('♩§¶');

	    	    $('#main_regi_date').val(member_info[0]);
	    	    $('#main_name').val(member_info[1]);
	    	    $('#main_addr').val(member_info[2]);
	    	    $('#main_tel').val(member_info[3]);

            },
            error: getAjaxError
    });
}

//메인 업체 승인
var mainReqAprvl = function() {

    $.ajax({
            type: "POST",
            data: {"seqno" : main_seq,
	    	   "type"  : "2"
	    },
            url: "/proc/member/dlvr_friend_list/update_main_aprvl.php",
            success: function(result) {

                alert(result);
                hideRegiPopup();
		searchDlvrFriend("All");

            },
            error: getAjaxError
    });
}

//메인 업체 거절
var mainReqReject = function() {

    $.ajax({
            type: "POST",
            data: {
                   "seqno" : main_seq,
	    	       "type"  : "3"
                   },
            url: "/proc/member/dlvr_friend_list/update_main_aprvl.php",
            success: function(result) {

                alert(result);
                hideRegiPopup();
	    	searchDlvrFriend("All");

            },
            error: getAjaxError
    });
}

/**********************************************************************
                         * 서브 부분 *
 **********************************************************************/

//서브 팝업에 있는 배송친구 메인 리스트
var subMainAprvlList = function(sort) {

    $("#loading_img").show();

    var sort_col = "";
    var sort_type = "";

    if (sort != "") {

	var sort_info = sort.split('/');
	sort_col = sort_info[0];
	sort_type = sort_info[1];
     
    }

    $.ajax({
            type: "POST",
            data: {
		            "sort_col" : sort_col,
		            "sort_type": sort_type,
		            "search_nick": search_nick,
                    "main_member_seqno" : main_member_seqno
	    },
            url: "/ajax/member/dlvr_friend_list/load_sub_main_aprvl_list.php",
            success: function(result) {

                if ($.trim(result) == "") {

                    $("#sub_main_list").html("<tr><td colspan='4'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $('#sub_main_list').html(result);

                }

                $("#loading_img").hide();
            },
            error: getAjaxError
    });
}

//배송친구 서브 요청 리스트
var subReqList = function(mem_seqno, main, sub) {

    sub_main_seqno = main;
    sub_sub_seqno = sub;
    main_member_seqno = mem_seqno;

    $.ajax({
            type: "POST",
            data: {
                    "main_member_seqno" : main_member_seqno
            },
            url: "/ajax/member/dlvr_friend_list/load_sub_list.php",
            success: function(result) {

    		    hideMask();
                openRegiPopup($("#sub_pop").html(), 950);

                if ($.trim(result) == "") {

                    $("#sub_main_list").html("<tr><td colspan='4'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $('#sub_main_list').html(result);

                }
            },
            error: getAjaxError
    });
}

//서브 업체 승인
var subReqAprvl = function() {

    $.ajax({
            type: "POST",
            data: {
                   "member_seqno" : $('input[name=main_radio]:checked').val(),
                   "sub_seqno" : sub_sub_seqno,
	    	       "type"  : "2"
                  },
            url: "/proc/member/dlvr_friend_list/update_sub_aprvl.php",
            success: function(result) {

                alert(result);
                hideRegiPopup();
	    	    searchDlvrFriend("All");

            },
            error: getAjaxError
    });

}

//서브 업체 거절
var subReqReject = function() {

    $.ajax({
            type: "POST",
            data: {
                   "member_seqno" : $('input[name=main_radio]:checked').val(),
                   "sub_seqno" : sub_sub_seqno,
	    	       "type"  : "3"
                   },
            url: "/proc/member/dlvr_friend_list/update_sub_aprvl.php",
            success: function(result) {

                alert(result);
                hideRegiPopup();
	    	    searchDlvrFriend("All");
            },
            error: getAjaxError
    });

}

//팝업 안 검색 사내닉네임 가져오기
var loadMainNick = function(dvs, event) {
    
    if (dvs == "enter") {
        if (event.keyCode != 13) {
            return false;
        }
    }

    search_nick = "";
    if ($("#search_nick").val()) {

        search_nick = $.trim($("#search_nick").val());

    }

    showMask();

    $.ajax({
            type: "POST",
            data: {
		            "search_nick": search_nick,
                    "main_member_seqno" : main_member_seqno
	        },
            url: "/ajax/member/dlvr_friend_list/load_sub_main_aprvl_list.php",
            success: function(result) {
                if ($.trim(result) == "") {

                    $("#sub_main_list").html("<tr><td colspan='4'>검색된 내용이 없습니다.</td></tr>");

                } else {

                    $('#sub_main_list').html(result);

                }

    		    hideMask();
            },
            error: getAjaxError
    });
}


