//검색날짜 범위 설정
var detailDateSet = function(num, dvs) {
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
