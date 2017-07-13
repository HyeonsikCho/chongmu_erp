$(document).ready(function() {

    loadDvsDetailList('N');

    //일자별 검색 datepicker 기본 셋팅
    $("#deal_date").datepicker({
        autoclose:true,
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        todayHighlight: true,
    });

    $("#deal_date").datepicker("setDate", new Date());

});
var member_seqno = "";
var page = "1";
var list_num = "30";
var adjust_seqno = "";

//팝업 검색된 종이명 클릭시
var nickClick = function(seq, name) {

    member_seqno = seq;
    $("#office_nick").val(name);
    hideRegiPopup();

    //$("#date_from").datepicker("setDate", new Date());

}

//팝업창 검색 버튼 클릭 검색시
var clickSearchNick = function(event, search_str, dvs) {

    loadSearchNick(event, $("#search_pop").val(), "click");

}

//회원 사내 닉네임 가져오기
var loadSearchNick = function(event, search_str, dvs) {

    if (dvs != "click") {
        if (event.keyCode != 13) {
            return false;
        }
    }

    showMask();
 
    $.ajax({
            type: "POST",
            data: {
                "search_str" : search_str,
                "sell_site"  : $("#sell_site").val(),
            },
            url: "/ajax/calcul_mng/adjust_regi/load_office_nick.php",
            success: function(result) {
                if (dvs == "") {

                    hideMask();
                    searchPopShow(event, 'loadSearchNick', 'clickOfficeNick');

                } else {

                    hideMask();
                    showBgMask();

                }
                $("#search_list").html(result);
            }   
    });
}

//입력 구분 상세 리스트
var loadDvsDetailList = function(detail) {
 
    $.ajax({
            type: "POST",
            data: {
                "dvs" : $("#dvs").val(),
            },
            url: "/ajax/calcul_mng/adjust_regi/load_dvs_detail.php",
            success: function(result) {
                $("#dvs_detail").html(result);
                //계정과목 상세정보가 있을때
                if (detail != "N") {

                    $("#dvs_detail").val(detail);

                }
            }   
    });
}

//조정 등록
var saveAdjust = function() {

    //회원 일련번호가 없을때
    if (member_seqno == "") {

        alert("사내 닉네임을 검색 후 선택해주세요");
        $("#office_nick").focus();
        
        return false;
    }

    //거래일자가 없을때
    if ($("#deal_date").val() == "") {

        alert("거래일자를 입력해주세요.");
        return false;
    }

    //금액이 없을때
    if ($("#price").val() == "") {

        alert("금액을 입력해주세요.");
	    $("#price").focus();
        return false;
    }

    var formData = new FormData($("#adjust_form")[0]);
        formData.append("member_seqno", member_seqno);

    $.ajax({
        type: "POST",
        data: formData,
	    processData : false,
	    contentType : false,
        url: "/proc/calcul_mng/adjust_regi/regi_adjust.php",
        success: function(result) {
            if($.trim(result) == "1") {

                alert("저장했습니다.");

            } else {

                alert("실패했습니다.");

            }
            loadAdjustList(page);
            resetRegiForm();
        },
        error: getAjaxError
    });
}

//조정 리스트
var loadAdjustList = function(pg) {

    page = pg;

    if (member_seqno == "" || $("#office_nick").val() == "") {

        member_seqno = "";
        alert("사내닉네임을 검색해주세요");
        $("#office_nick").focus();
        return false;

    }

    var formData = new FormData($("#adjust_form")[0]);
        formData.append("page", pg);
        formData.append("list_num", list_num);
        formData.append("member_seqno", member_seqno);

    $.ajax({

        type: "POST",
        data: formData,
	    processData : false,
	    contentType : false,
        url: "/ajax/calcul_mng/adjust_regi/load_adjust_list.php",
        success: function(result) {
		var list = result.split('♪♭@');
            if($.trim(list[0]) == "") {

                $("#adjust_list").html("<tr><td colspan='5'>" +
                    "검색된 내용이 없습니다.</td></tr>"); 

	    } else {

                $("#adjust_list").html(list[0]);
                $("#adjust_page").html(list[1]); 
                $('select[name=list_set]').val(list_num);

	    }
        }, 
        error: getAjaxError
    });
}

//조정 리스트 상세보기
var loadAdjustDetail = function(cont
                               ,dvs
                               ,dvs_detail
                               ,deal_date
                               ,price) {

    $("#cont").val(cont);
    $("#dvs").val(dvs);
    
    loadDvsDetailList(dvs_detail);

    $("#deal_date").val(deal_date);
    $("#price").val(price);

    $("#save_btn").hide();
    $("#cancle_btn").show();
}

//보기취소버튼 클릭시 등록으로 초기화
var resetRegiForm = function() {

    document.adjust_form.reset();

    $("#save_btn").show();
    $("#cancle_btn").hide();
    $("#deal_date").datepicker("setDate", new Date());
    loadDvsDetailList('N');

}

//보여 주는 페이지 갯수 설정
var showPageSetting = function(val) {

    list_num = val;
    loadAdjustList(1);
} 

//선택 조건으로 검색(페이징 클릭)
var searchResult = function(pg) {

    page = pg;
    loadAdjustList(page);
}


