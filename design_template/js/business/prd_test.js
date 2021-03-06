/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/23 엄준현 생성
 * 2015/12/29 임종건 일자 검색 관련 함수 수정
 * 2015/12/29 임종건 회원 팝업 검색 수정
 *=============================================================================
 *
 */

$(document).ready(function() {
    // 데이트 피커 초기화
    $("#date_team_from").datepicker({
        autoclose : true,
        format    : "yyyy-mm-dd",
        todayBtn  : "linked",
        todayHighlight: true,
    });
    $("#date_team_to").datepicker({
        autoclose : true,
        format    : "yyyy-mm-dd",
        todayBtn  : "linked",
        todayHighlight: true,
    });
    $("#date_memb_from").datepicker({
        autoclose : true,
        format    : "yyyy-mm-dd",
        todayBtn  : "linked",
        todayHighlight: true,
    });
    $("#date_memb_to").datepicker({
        autoclose : true,
        format    : "yyyy-mm-dd",
        todayBtn  : "linked",
        todayHighlight: true,
    });

    //일자 오늘로 세팅
    setDateMemb("0");
    setDateTeam("0");

    // 팀 별 검색에서 팀구분 값 로드
    loadDeparInfo();

    // 페이징 목록생성
    paging.exec(1);
	//alert($("#cate_top").val()+'//'+$("#cate_mid").val()+'//'+$("#cate_bot").val());
	//showPaperOption($("#cate_bot").val());

/*
	getPaperList($("#cate_bot").val(),'paper',null,null,null,'paperList');
	getPrintList($("#cate_bot").val(),'print',null,null,null,'printList');
	getStanList($("#cate_bot").val(),'stan',null,null,null,'stanList');
	
	getAmountList($("#cate_bot").val(),'amount',$("#paperList").val(),$("#printList").val(),$("#stanList").val(),'amountList');
*/  

	
	var d1 = $.Deferred();
	var d2 = $.Deferred();
	var d3 = $.Deferred();
	d1.resolve(getPaperList($("#cate_bot").val(),'paper',null,null,null,'paperList'));
	d2.resolve(getPrintList($("#cate_bot").val(),'print',null,null,null,'printList'));
	d3.resolve(getStanList($("#cate_bot").val(),'stan',null,null,null,'stanList'));
	
	$.when(d1,d2,d3).done(function(a1,a2,a3){
		 console.log($("#paperList").val());
	});
	

});
var f1 = function(){return 1;}
var f2 = function(){return 2;}
var f3 = function(){return 3;}
/**
 * @brief 날짜 범위 설정 - 공통
 *
 * @param num = 범위
 */
var setDateVal = function(num, dvs) {

    var day = new Date();
    var time = day.getHours();
    var d_day = new Date(day - (num * 1000 * 60 * 60 * 24));
    var last = new Date(day - (365 * 1000 * 60 * 60 * 24));

    if (num === "all") {
        $("#date_" + dvs + "_from").val("");
        $("#time_" + dvs + "_from").val("0");
        $("#date_" + dvs + "_to").val("");
        $("#time_" + dvs + "_to").val("0");

        return false;
    } else if (num === "last") {
        $("#date_" + dvs + "_from").datepicker("setDate", last);
        $("#time_" + dvs + "_from").val("0");
        $("#date_" + dvs + "_to").datepicker("setDate", last);
        $("#time_" + dvs + "_to").val(time);
        return false;
    }

    $("#date_" + dvs + "_from").datepicker("setDate", d_day);
    $("#time_" + dvs + "_from").val("0");
    $("#date_" + dvs + "_to").datepicker("setDate", '0');
    $("#time_" + dvs + "_to").val(time);
	
}

/**
 * @brief 회원별 검색 날짜 범위 설정
 *
 * @param num = 범위
 */
var setDateMemb = function(num) {
    setDateVal(num, "memb");
};

/**
 * @brief 팀별 검색 날짜 범위 설정
 *
 * @param num = 범위
 */
var setDateTeam = function(num) {
    setDateVal(num, "team");
};

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "tabDvs"     : "memb",
    "page"       : "1",
    "listSize"   : "30",
    "searchFlag" : false,
    "exec"       : function(dvs, val) {
        this.searchFlag = true;
        // 리스트 사이즈 변경시 마지막 seqno 초기화
        if (dvs === 'l') {
            this.listSize = val;
            this.page = 1;
            paging.exec(1);
        }
        
        // 페이지 변경시 활성화 변경
        if (dvs === 'p') {
            this.page = val;
            $("#paging").find("a.active").removeClass("active");
            $("#page_" + val).addClass("active");
        }
        
        var url = "/ajax/business/order_common_mng/load_order_list.php";
        var data = {
            "page"       : this.page,
            "list_size"  : this.listSize,
            "tab_dvs"    : this.tabDvs,
            "last_seqno" : $("#last_seqno").val()
        };
        var callback = function(result) {
            var rs = result.split("♪");
            $("#order_list").html(rs[0]);
            $("#order_total").html(rs[1]);
        };

        if (this.tabDvs === "memb") {
            data.sell_site     = $("#sell_site").val();
            data.cate_sortcode = $("#cate_bot").val();
            data.office_nick   = $("#office_nick").val();
            data.from_date     = $("#date_memb_from").val();
            data.from_time     = $("#time_memb_from").val();
            data.to_date       = $("#date_memb_to").val();
            data.to_time       = $("#time_memb_to").val();
            data.status        = $("#status_memb").val();
            data.status_proc   = $("#status_proc_memb").val();
        } else {
            data.depar_code  = $("#depar_code").val();
            data.from_date   = $("#date_team_from").val();
            data.from_time   = $("#time_team_from").val();
            data.to_date     = $("#date_memb_to").val();
            data.to_time     = $("#time_memb_to").val();
            data.status      = $("#status_team").val();
            data.status_proc = $("#status_proc_team").val();
        }

        showMask();

        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 주문 내용 조회팝업 출력
 *
 * @param seq = 주문일련번호
 */
var showOrderContent = function(seq) {
    var url = "/ajax/common/load_order_info.php";
    var data = {
        "seqno" : seq
    };
    var callback = function(result) {
        openRegiPopup(result, "950");
    };

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 주문 상태 상세 조회팝업 출력
 *
 * @param seq = 주문일련번호
 */
var showOrderDetail = function(seq) {
    var url = "/ajax/business/order_common_mng/load_order_detail.php";
    var data = {
    };
    var callback = function(result) {
        $("#regi_popup").css("height", "500px");
        openRegiPopup(result, "800");
    };

    ajaxCall(url, "html", data, callback);
};
/**
* @brief 소분류 카테고리 종이 출력
* @param cate_sort_code = 카테고리코드
* 
*/ 

var showOptionList = function(cate_sort_code,opt,papercode,printcode,stancode,target){

	var url = "/ajax/business/order_test/load_option_list.php";
	var data = {
		"cate_sort_code" : cate_sort_code,
		"opt" : opt,
		"papercode" : papercode || null,
		"printcode" : printcode || null,
		"stancode" : stancode || null
	};
	
	var callback = function(result){		
		$("#"+target).html(result);
		
	}
	return ajaxCallRet(url,"html",data,callback);
}

var getPaperList = function(cate_sort_code,opt,papercode,printcode,stancode,target){
	return showOptionList(cate_sort_code,opt,papercode,printcode,stancode,target);
}
var getPrintList = function(cate_sort_code,opt,papercode,printcode,stancode,target){
	return showOptionList(cate_sort_code,opt,papercode,printcode,stancode,target);
}
var getStanList = function(cate_sort_code,opt,papercode,printcode,stancode,target){
	return showOptionList(cate_sort_code,opt,papercode,printcode,stancode,target);
	
}
var getAmountList = function(cate_sort_code,opt,papercode,printcode,stancode,target){

	return showOptionList(cate_sort_code,opt,papercode,printcode,stancode,target);
}

function test1(obj){
	console.log($("#paperList"));
}