//포인트 정책 저장
var savePointPolicy = function() {

    var formData = $("#point_form").serialize();

    $.ajax({

        type: "POST",
        data: formData,
        url: "/proc/mkt/point_mng/proc_point_policy.php",
        success: function(result) {
            if(result == "1") {

                alert("수정했습니다.");

            } else {

                alert("실패했습니다.");
            }
        }, 
        error: getAjaxError
    });
}

//포인트 정책 불러오기
var loadPointPolicy = function() {

    $.ajax({

        type: "POST",
        data: {},
        url: "/ajax/mkt/point_mng/load_point_policy.php",
        success: function(result) {
		var tmp = result.split('♪♭@');
        
        $("#join_point").val(tmp[0]);
        $("#order_rate").val(tmp[1]);

        }, 
        error: getAjaxError
    });

}
