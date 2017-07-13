var search_loc = ""; //주소 검색
var page = "1"; //페이지
var list_num = "30"; //리스트 갯수
var pur_prdt = ""; //매입품목
var etprs_seqno = ""; //외부업체 일련번호
var brand_seqno = ""; //브랜드 일련번호
var member_seqno = ""; //외부업체 회원 일련번호
var chk_flag = false; //아이디 중복여부 체크 확인
var add_yn = "Y"; //외부업체 회원 추가,수정 여부

var popMngLayer = function(dvs) {

    add_yn = dvs;
    member_seqno = dvs;


    if (dvs == "Y") {

        initMemberData();
        $('#del_member').hide();
        $('#check_id').show();
        $('input').removeAttr("readonly");

        openRegiPopup($("#add_extnl_member").html(), 600);

    } else {

        chk_flag = true;

        $('#del_member').show();
        $('#check_id').hide();
        $('#mem_id').attr("readonly","readonly");

        modiExtnlMemberInfo(dvs);
    }

}

//매입업체에 해당하는 브랜드 가져오기
var loadExtnlBrand = function(val) {

    $.ajax({

        type: "POST",
        data: {
                "etprs_seqno" : val
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_extnl_brand.php",
        success: function(result) {
            $("#pur_brand").html(result);
        }, 
        error: getAjaxError
    });

}

//매입업체 리스트 검색
var searchEtprsList = function() {

    pur_prdt = $("select[name=pur_prdt]").val();
    etprs_seqno = $("select[name=pur_manu]").val();
    brand_seqno = $("select[name=pur_brand]").val();

    if (pur_prdt == "") {

	    alert("매입품을 선택해주세요");
	    return false;

    }

    $.ajax({

        type: "POST",
        data: {
        "pur_prdt" : pur_prdt,
        "etprs_seqno" : etprs_seqno,
        "pur_brand" : brand_seqno
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_etprs_list.php",
        success: function(result) {
            $("#pur_list").html(result);
        },
        error: getAjaxError
    });
}

//매입업체 수정 팝업 레이어
var editPopEtprs = function(val) {

    etprs_seqno = val

    $.ajax({

        type: "POST",
        data: {
                "etprs_seqno" : val,
                "brand_seqno" : brand_seqno,
		        "type" : "edit"
        
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_etprs_info.php",
        success: function(result) {

	    var list = result.split('★');
            $("#edit_list").html(list[0]);
	        $("#edit_pur_prdt").val(list[1]);
	        $("#bls_bank_name").val(list[2]);
            $("#edit_list").show();
        },
        error: getAjaxError

    });
}

//팝업창 검색
var searchZipPopStr = function() {

    var pop_search_str = $("#popup_zip_search").val();
    var search_type = "";

    if ($.trim(pop_search_str) == "") {

	    showMsg440("검색창에 검색어를 입력해주세요.");
        return false;

    }

    showMask();

    if(search_loc == "etprs") {
        
        search_type = $("input[name=doro_yn]:checked").val();

    } else if (search_loc == "bls") {

        search_type = $("input[name=bls_doro_yn]:checked").val();
    }
    
    $.ajax({
            type: "POST",
            data: {
                "val" : pop_search_str,
                "type" : search_type,
                "search_loc" : search_loc,
                "area" : $("#zipcode_area").val()
            },
            url: "/ajax/basic_mng/pur_etprs_regi/load_zip.php",
            success: function(result) {
                $("#search_zip_result").html(result);
    		hideMask();
           },
            error: getAjaxError
    });
}

//팝업 검색된 주소 클릭시
var etprsClick = function(str) {

    hideRegiPopup();
    
    var zip =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#zip").val(zip);
    $("#addr_front").val(addr);
    $("#addr_rear").focus();

}

//팝업 검색된 주소 클릭시
var blsClick = function(str) {

    hideRegiPopup();
    
    var zip =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#bls_zip").val(zip);
    $("#bls_addr_front").val(addr);
    $("#bls_addr_rear").focus();

}

//매입업체 정보 수정
var editEtprsInfo = function(seq) {

    var formData = $("#edit_form").serializeArray();
    formData.push({name: 'etprs_seqno', value: seq});

    $.ajax({
            type: "POST",
            data: formData,
            url: "/proc/basic_mng/pur_etprs_list/modi_etprs_info.php",
            success: function(result) {
	        alert(result);
		    searchEtprsList();
    		closeLayer('#edit_list');
           },
           error: getAjaxError
    });
}

//매입업체 상세 View
var viewPopEtprs = function(val) {

    etprs_seqno = val;

    $.ajax({

        type: "POST",
        data: {
                "etprs_seqno" : etprs_seqno,
		        "brand_seqno" : brand_seqno,
		        "type" : "view"
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_etprs_info.php",
        success: function(result) {
            $("#view_list").html(result);
	    supplyList('', '1');
        }, 
        error: getAjaxError
    });
}

//공급품 list
var supplyList = function(sort, page) {

    //sort 정보
    var sort_info = sort.split('/');
    for (var i in sort_info) {
        sort_info[i];
    }

    $.ajax({
        type: "POST",
        data: {
                "extnl_etprs_seqno" : etprs_seqno,
		        "brand_seqno" : brand_seqno,
                "sort" : sort_info[0],
                "sort_type" : sort_info[1],
                "pur_prdt" : pur_prdt,
                "page" : page,
                "list_num" : list_num
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_supply.php",
        success: function(result) {
	        var list = result.split('★');
	        if (list[0].trim() == "") {

                $("#prdt_list").html("<tr><td colspan='14'>검색된 내용이 없습니다.</td></tr>"); 

	        } else {

                $("#prdt_list").html(list[0]);
                $("#supply_page").html(list[1]); 
		        $('select[name=list_set]').val(list_num);

	        }
	        $("#view_list").show();
        },
        error: getAjaxError
    });
}

//공급품 상세 팝업
var supplyPopDetail = function(event, seqno, prdt) {

    $.ajax({

        type: "POST",
        data: {
                "extnl_etprs_seqno" : etprs_seqno,
		        "brand_seqno" : brand_seqno,
		        "seqno" : seqno,
		        "prdt" : prdt
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_supply_detail.php",
        success: function(result) {

            $("#prdt_view").html(result);
	    	layerPopup(event, '', 'large');

            //$("#prdt_view").show();
        },
        error: getAjaxError

    });


}

//보여 주는 페이지 갯수 설정
var showPageSetting = function(val) {

    list_num = val;
    supplyList('','1');
} 

//선택 조건으로 검색(페이징 클릭)
var searchResult = function(page) {
    supplyList('',page);
}

//레이어 팝업
var layerPopup = function(event, col, dvs) { 

    var layer = "";

    if (dvs == "zip"){

        //서울특별시 selected로 초기화
        $("#zipcode_area").val("seoul");
    	$("#popup_zip_search").val("");
    	$("#search_zip_result").empty();

    	layer = document.getElementById("search_zip_popup_layer");

    } else if (dvs == "large") {

    	layer = document.getElementById("prdt_view");
    
    }

    var ua = window.navigator.userAgent;

    //마우스로 선택한곳의 x축(화면에서 좌측으로부터의 거리)를 얻는다.
    var _x = null;

    if (ua.indexOf("Chrome") === -1) {
        _x = event.clientX + document.documentElement.scrollLeft;
    } else {
        _x = event.clientX + document.body.scrollLeft;
    }
    //마우스로 선택한곳의 y축(화면에서 상단으로부터의 거리)를 얻는다.
    var _y = event.clientY + document.documentElement.scrollTop;

    if (ua.indexOf("Chrome") === -1) {
        _y = event.clientY + document.documentElement.scrollTop;
    } else {
        _y = event.clientY + document.body.scrollTop;
    }

    //마우스로 선택한 위치의 값이 -값이면 0으로 초기화. (화면은 0,0으로 시작한다.)
    if(_x < 0) _x = 0;
    //마우스로 선택한 위치의 값이 -값이면 0으로 초기화. (화면은 0,0으로 시작한다.)
    if(_y < 0) _y = 0;

    if (dvs == "large") {

    	//레이어팝업의 좌측으로부터의 거리값을 마우스로 클릭한곳의 위치값으로 변경.
    	layer.style.left = _x-1100+"px";
    	//레이어팝업의 상단으로부터의 거리값을 마우스로 클릭한곳의 위치값으로 변경.
    	layer.style.top = _y-800+"px";

    } else {

    	layer.style.left = _x-120+"px";
    	layer.style.top = _y-180+"px";
    }

    if (dvs == "zip") {

        $('#search_zip_popup_layer').css("display", "block");
        $("#popup_zip_search").focus();

        search_loc = col;

    } else if (dvs == "large") {

    	$('#prdt_view').css("display", "block");

    }

};


//외부 업체 회원 정보 팝업에 입력
var modiExtnlMemberInfo = function(mem_seqno) {

    $.ajax({

        type: "POST",
        data: {
                "mem_seqno" : mem_seqno
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_extnl_member.php",
        success: function(result) {

        var mem_info = result.split('♪♥♭');

        openRegiPopup($("#add_extnl_member").html(), 600);

        $("#mem_id").val(mem_info[0]);
        $("#mem_passwd").val(mem_info[1]);
        $("#mem_name").val(mem_info[2]);
        $("#mem_job").val(mem_info[3]);
        $("#mem_task").val(mem_info[4]);
        $("#mem_mail_top").val(mem_info[5]);
        $("#mem_mail_btm").val(mem_info[6]);
        $("#mem_tel_top").val(mem_info[7]);
        $("#mem_tel_mid").val(mem_info[8]);
        $("#mem_tel_btm").val(mem_info[9]);
        $("#mem_cel_top").val(mem_info[10]);
        $("#mem_cel_mid").val(mem_info[11]);
        $("#mem_cel_btm").val(mem_info[12]);

        }, 
        error: getAjaxError
    });



}

//팝업 검색창 엔터 쳤을때 검색
var popEnterCheck = function(event) {

	if(event.keyCode == 13) {
		searchZipPopStr();
	}
}

//레이어 닫기
var closeLayer = function(layer) {

    list_num = "30";
    initMemberData();
    $(layer).css("display", "none");

}

//컬럼별 sort
var sortList = function(val, el) {

    var flag = "";

    if ($(el).children().hasClass("fa-sort-desc")) {
        sortInit();
        flag = "ASC";
    } else {
        sortInit();
        flag = "DESC";
    }

    var sort = val + "/" + flag;
    supplyList(sort, '1');
}

//외부업체 회원 아이디 중복 체크
var checkId = function() {

    var mem_id = $("#mem_id").val();

    $.ajax({

        type: "POST",
        data: {
                "mem_id" : mem_id
        },
        url: "/ajax/basic_mng/pur_etprs_list/check_extnl_member.php",
        success: function(result) {
            if(result == "1") {

                alert("사용가능한 아이디입니다.");
                chk_flag = true;

            } else {

                alert("중복된 아이디가 존재합니다.");
                chk_flag = false;

            }
        }, 
        error: getAjaxError
    });
}

//외부업체 회원 추가 및 수정
var saveExtnlMember = function() {

    //id가 비었을때
    if($("#mem_id").val() == "") {

        alert("아이디를 입력해주세요.");
	    $("#mem_id").focus();
        return false;
    }

    //접속코드가 비었을때
    if($("#mem_passwd").val() == "") {

        alert("접속코드를 입력해주세요.");
	    $("#mem_passwd").focus();
        return false;
    }

    //이름이 비었을때
    if($("#mem_name").val() == "") {

        alert("이름을 입력해주세요.");
	    $("#mem_name").focus();
        return false;
    }

    if (chk_flag == false) {

        alert("아이디 중복체크를 해주세요.");
        return false;
    }

    var memData = {
        'add_yn'      : add_yn,
        'etprs_seqno' : etprs_seqno,
        'mem_id'      : $("#mem_id").val(),
        'mem_passwd'  : $("#mem_passwd").val(),
        'mem_name'    : $("#mem_name").val(),
        'mem_job'     : $("#mem_job").val(),
        'mem_task'    : $("#mem_task").val(),
        'mem_mail_top': $("#mem_mail_top").val(),
        'mem_mail_btm': $("#mem_mail_btm").val(),
        'mem_tel_top' : $("#mem_tel_top").val(),
        'mem_tel_mid' : $("#mem_tel_mid").val(),
        'mem_tel_btm' : $("#mem_tel_btm").val(),
        'mem_cel_top' : $("#mem_cel_top").val(),
        'mem_cel_mid' : $("#mem_cel_mid").val(),
        'mem_cel_btm' : $("#mem_cel_btm").val()
    };

    $.ajax({
        type: "POST",
        data: memData,
        url: "/proc/basic_mng/pur_etprs_list/proc_extnl_member.php",
        success: function(result) {
            if($.trim(result) == "1") {

                alert("저장했습니다.");
                initMemberData();
                hideRegiPopup();
                loadExtnlMember();

            } else {

                alert("저장에 실패했습니다.");

            }
            chk_flag = false;
        }, 
        error: getAjaxError
    });
}

var loadExtnlMember = function() {

    $.ajax({

        type: "POST",
        data: {
                "etprs_seqno" : etprs_seqno
        },
        url: "/ajax/basic_mng/pur_etprs_list/load_extnl_member_list.php",
        success: function(result) {

            $("#extnl_member").html(result);
        }, 
        error: getAjaxError
    });
}

//외부업체 회원 인풋 비우기
var initMemberData = function() {

    $("#mem_id").val('');
    $("#mail_type").val('');
    $("#mem_passwd").val('');
    $("#mem_name").val('');
    $("#mem_job").val('');
    $("#mem_task").val('');
    $("#mem_mail_top").val('');
    $("#mem_mail_btm").val('');
    $("#mem_tel_top").val('');
    $("#mem_tel_mid").val('');
    $("#mem_tel_btm").val('');
    $("#mem_cel_top").val('');
    $("#mem_cel_mid").val('');
    $("#mem_cel_btm").val('');

}

//외부업체 회원 삭제
var delExtnlMember = function() {

    $.ajax({

        type: "POST",
        data: {
                "member_seqno" : member_seqno
        },
        url: "/proc/basic_mng/pur_etprs_list/del_extnl_member.php",
        success: function(result) {
            if(result == "1") {

                alert("삭제했습니다.");
                hideRegiPopup();
                loadExtnlMember();

            } else {

                alert("삭제에 실패했습니다.");

            }
        }, 
        error: getAjaxError
    });
}

//메일 타입 선택시
var changeMail = function(val) {

    if (val == "direct"){

        $("#mem_mail_btm").focus();

    } else {

        $("#mem_mail_btm").val(val);

    }
}

