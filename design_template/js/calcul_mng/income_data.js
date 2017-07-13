$(document).ready(function() {

    //loadAdjustList(1);

});

var page = "1";
var list_num = "30";
var member_seqno = "";

//팝업 검색된 종이명 클릭시
var nickClick = function(seq, name) {

    member_seqno = seq;
    $("#office_nick").val(name);
    hideRegiPopup();

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
            url: "/ajax/calcul_mng/adjust_data/load_office_nick.php",
            success: function(result) {
                if (dvs == "") {

                    hideMask();
                    searchPopShow(event, 'loadSearchNick', 'clickSearchNick');

                } else {

                    hideMask();
                    showBgMask();

                }
                $("#search_list").html(result);
            }   
    });
}

//입출금경로 상세 불러오기
var loadPathDetail = function() {

    //입출금경로 미선택시
    if ($("#depo_path").val() == "") {

        $("#depo_path_detail").html("<option value=\"\">선택</option>");
        return false;

    }

    $.ajax({

        type: "POST",
        data: {
		    "depo_path" : $("#depo_path").val()
        },
        url: "/ajax/calcul_mng/cashbook_regi/load_path_detail.php",
        success: function(result) {
	    
	    	$("#depo_path_detail").html(result);
        }, 
        error: getAjaxError
    });
}

//수입자료 리스트 불러오기
var loadIncomeList = function(pg) {

    //회원명 인풋창 비었을경우  회원일련번호 초기화
    if ($("#office_nick").val() == "") {

        member_seqno = "";

    }

    var formData = new FormData($("#income_form")[0]);
        formData.append("page", pg);
        formData.append("list_num", list_num);
        formData.append("member_seqno", member_seqno);

    $.ajax({

        type: "POST",
        data: formData,
	    processData : false,
	    contentType : false,
        url: "/ajax/calcul_mng/income_data/load_income_list.php",
        success: function(result) {
		var list = result.split('♪♭@');
            if($.trim(list[0]) == "") {

                $("#income_list").html("<tr><td colspan='6'>검색된 내용이 없습니다.</td></tr>"); 
                $("#cash_sum").html("0원");
                $("#bankbook_sum").html("0원");
                $("#card_sum").html("0원");
                $("#etc_sum").html("0원");

	    } else {

                $("#income_list").html(list[0]);
                $("#income_page").html(list[1]); 
                $('select[name=list_set]').val(list_num);
                $("#cash_sum").html(list[2]);
                $("#bankbook_sum").html(list[3]);
                $("#card_sum").html(list[4]);
                $("#etc_sum").html(list[5]);

	    }
        }, 
        error: getAjaxError
    });
}

//보여 주는 페이지 갯수 설정
var showPageSetting = function(val) {

    list_num = val;
    loadIncomeList(1);
} 

//선택 조건으로 검색(페이징 클릭)
var searchResult = function(pg) {

    page = pg;
    loadIncomeList(page);
}

