

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

var orderInsert = function(){
        var url = "/proc/business/order_insert/order_insert.php";
		if($('#user_id').val() == ''){
			alert('아이디를 입력하세요');
			return;
		}
		if($('#cart_comment').val() == ''){
			alert('주문내용을 입력하세요');
			return;
		}
		if($('#amount').val() == ''){
			alert('가격을 입력하세요');
			return;
		}
		if($('#c_rate').val() == ''){
			alert('총무팀요율을 입력하세요');
			return;
		}
		if($('#c_user_rate').val() == ''){
			alert('총무팀고객요율을 입력하세요');
			return;
		}
        var data = {
			"user_id" : $('#user_id').val(),
			"cart_comment" : $('#cart_comment').val(),
			"amount" : $('#amount').val(),
			"c_rate" : $('#c_rate').val(),
			"c_user_rate" : $('#c_user_rate').val()
			
        };
        var callback = function(data) {
            if(data.result == 'true'){
				alert('빈주문 성공');
			}else{
				alert('빈주문 실패');
			}
			return;
        };
		showMask();
        ajaxCall(url, "json", data, callback);

}