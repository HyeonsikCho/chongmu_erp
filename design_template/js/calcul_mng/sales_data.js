$(document).ready(function() {

    loadDeparList();

});

//검색 날짜 범위 설정
var regiDateSet = function(num) {

    var day = new Date();
    var d_day = new Date(day - (num * 1000 * 60 * 60 * 24));

    $("#date_from").datepicker("setDate", d_day);
    $("#date_to").datepicker("setDate", '0');
};



//팀 리스트 불러오기
/*
var loadDeparList = function() {

    $.ajax({

        type: "POST",
        data: {
		    "sell_site" : $("#sell_site").val()
        },
        url: "/ajax/calcul_mng/cashbook_regi/load_depar_list.php",
        success: function(result) {
	    
	    	$("#depar_list").html(result);
        }, 
        error: getAjaxError
    });
}
*/


