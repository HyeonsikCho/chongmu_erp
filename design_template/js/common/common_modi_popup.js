$(document).ready(function() {
    // 가격창을 스크롤 할 경우 팝업창 닫음
    $(".table_scroll").scroll(function() {
        hideModiPop();
    });
});

/**
 * @brief 팝업 출력용 좌표를 추출한다.
 */
var getPopupPoint = function(event) {
    if(!event) event = window.Event;

    event.stopPropagation();

    var x = event.clientX +
            (document.documentElement.scrollLeft ?
             document.documentElement.scrollLeft : document.body.scrollLeft);
    var y = event.clientY +
            (document.documentElement.scrollTop ?
             document.documentElement.scrollTop : document.body.scrollTop);
    x -= 327;
    y -= 49;

    return {"x" : x, "y" : y};
};

/**
 * @brief 수정 팝업창 출력 함수
 */
var showModiPop = function(obj, x, y) {
    $("#" + obj).css({"position" : "absolute",
                      "top"      : y,
                      "left"     : x});
    $("#" + obj).show();
};

/**
 * @brief 모든 수정팝업 hide
 */
var hideModiPop = function() {
    $(".pop_add_box").hide();
    $(".popover").hide();
    $("input[name='popup_val']").val("");
};

/**
 * @brief 일괄수정에서 셀렉트박스값 변경
 */
var selectedModiAllPriceDvs = function(dvs) {
    $("select[name='modi_all_price_dvs'] > option").each(function() {
        if (dvs === $(this).val()) {
            $(this).prop("selected", true);
            return false;
        }
    });
};
