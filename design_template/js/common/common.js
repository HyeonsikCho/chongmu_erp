/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 *
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/10/28 임종건 생성
 * 2015/11/20 임종건 팝업 공통 추가
 *=============================================================================
 *
 */

$(document).ready(function() {

    //일자별 검색 datepicker 기본 셋팅
    $("#date_from").datepicker({
        autoclose:true,
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        todayHighlight: true
    });

    $("#date_to").datepicker({
        autoclose:true,
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        todayHighlight: true
    });
});

/*
//팝업 스크롤 내릴시 유지
$(function(){
    var lastScroll = 0;
    var height = $(window).height();

    $(window).scroll(function(event){
        var st = $(window).scrollTop();
        var objHeight = $('#regi_popup').outerHeight();
        var topVal = (height - objHeight)/2 + st;

        if (height < objHeight) {
            topVal = (height - objHeight)/3 + st;
        }

        $('#regi_popup').css({position:'absolute'}).css({
            top : topVal + "px",
        });
        $('#pop_popup').css({position:'absolute'}).css({
            top : topVal + "px",
        });

        lastScroll = st;
    });
});
*/

/* div 드래그 */
var img_L = 0;
var img_T = 0;
var targetObj;

function getLeft(o){
    return parseInt(o.style.left.replace('px', ''));
}
function getTop(o){
    return parseInt(o.style.top.replace('px', ''));
}

function moveDrag(e){
    var e_obj = window.event? window.event : e;
    var dmvx = parseInt(e_obj.clientX + img_L);
    var dmvy = parseInt(e_obj.clientY + img_T);
    targetObj.style.left = dmvx +"px";
    targetObj.style.top = dmvy +"px";
    return false;
}

function startDrag(e, obj){
    targetObj = obj;
    var e_obj = window.event? window.event : e;
    img_L = getLeft(obj) - e_obj.clientX;
    img_T = getTop(obj) - e_obj.clientY;

    document.onmousemove = moveDrag;
    document.onmouseup = stopDrag;
    if(e_obj.preventDefault)e_obj.preventDefault();
}

function stopDrag(){
    document.onmousemove = null;
    document.onmouseup = null;
}
/* div 드래그 */

//Ajax error 공통 함수
var getAjaxError = function(request,status,error) {
    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
    console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
    hideBgMask();
    hideMask();
}

//Ajax Call 공통 함수
// 사용 예제 ajaxCall('호출주소', 'html', {data:data}, callback);
var ajaxCall  = function(url, dataType, data, sucCallback) {
    if (checkBlank(url) === true) {
        return false;
    }

    $.ajax({
        type     : "POST",
        url      : url,
        dataType : dataType,
        data     : data,
        success  : function(result) {
            hideMask();
            return sucCallback(result);
        },
        error: getAjaxError
    });
}
//반환하는 ajaxCall
var ajaxCallRet  = function(url, dataType, data, sucCallback) {
    if (checkBlank(url) === true) {
        return false;
    }

   return $.ajax({
        type     : "POST",
        url      : url,
        dataType : dataType,
        data     : data,
        success  : function(result) {
            hideMask();
            sucCallback(result);
        },
        error: getAjaxError
    });

}
//래프트 메뉴
var midCheckLeft = function(el) {

    $("#mainnav-menu .mid").removeClass("active");
    $(el).addClass("active");
}

//어떤 값이 공백값이거나 undefined 값이면 false 반환
var checkBlank = function(val) {
   if (val === ""
           || val === ''
           || typeof val === "undefined") {
       return true;
   } else {
       return false;
   }
};

//해당 함수가 존재하는지 확인하고 존재할경우 true 반환
var isFunc = function(funcName) {
   if (typeof(window[funcName]) === "function") {
       return true;
   } else {
       return false;
   }
};

//해당 변수가 존재하는지 확인하고 존재할경우 true 반환
var isVar = function(varName) {
   if (typeof(window[varName]) === "undefined") {
       return false;
   } else {
       return true;
   }
};

//정열 초기화
var sortInit = function() {

    $(".sorting").children().removeClass("fa-sort-desc");
    $(".sorting").children().removeClass("fa-sort-asc");
    $(".sorting").children().addClass("fa-sort");
}

/*
//경고메시지 width440 size show
var showMsg440 = function(msg) {

    showBgMask();

    var html = "";
    html += "\n     <dl> ";
    html += "\n         <dt class=\"tit\"> ";
    html += "\n               <h4>경고창</h4> ";
    html += "\n         </dt> ";
    html += "\n         <dt class=\"cls\"> ";
    html += "\n               <button type=\"button\" id=\"showMsg440\" class=\"btn btn-sm btn-danger fa fa-times\" onClick=\"hideMsg440();\"></button> ";
    html += "\n           </dt> ";
    html += "\n      </dl>   ";
    html += "\n      <div class=\"pop-base\"> ";
    html += "\n          <div class=\"pop-content tac\"> ";
    html += "\n              " + msg;
    html += "\n          </div> ";
    html += "\n      </div> ";

    $('#alert_msg_440').css({position:'absolute'}).css({
        left: ($(window).width() - $('#alert_msg_440').outerWidth())/2 + $(window).scrollLeft() + "px",
        top : ($(window).height() - $('#alert_msg_440').outerHeight())/2 + $(window).scrollTop() + "px"
    });

    $("#alert_msg_440").html(html);
    $("#showMsg440").focus();
    $("#alert_msg_440").show();
}

//경고메세지 width440 size hide
var hideMsg440 = function(msg) {

    $("#alert_msg_440").hide();
    hideBgMask();
}
*/

//로딩 중 이미지 보이기
var showMask = function() {

    showBgMask();

    $obj = $("#loading_img");
    $obj.css("position","absolute");
    $obj.css("top", Math.max(0, (($(window).height() - $obj.height()) / 2) + $(window).scrollTop()) + "px");
    $obj.css("left", Math.max(0, (($(window).width() - $obj.width()) / 2) + $(window).scrollLeft()) + "px");
    $("#loading_img").show();
}

//로딩 중 이미지 숨기기
var hideMask = function() {

    $("#loading_img").hide()
    hideBgMask();
}

//Background 마스크 show
var showBgMask = function() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
    $("#black_mask").css({'width':maskWidth,'height':maskHeight});
    $("#black_mask").show();
}

//Background 마스크 hide
var hideBgMask = function() {

    $("#black_mask").hide();
}

//Background 마스크 show
var showPopMask = function() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
    $("#pop_mask").css({'width':maskWidth,'height':maskHeight});
    $("#pop_mask").show();
}

//Background 마스크 hide
var hidePopMask = function() {

    $("#pop_mask").hide();
}

//Background 마스크 show
var showPopPopMask = function() {

    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    //마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
    $("#pop_pop_mask").css({'width':maskWidth,'height':maskHeight});
    $("#pop_pop_mask").show();
}

//Background 마스크 hide - 팝업의 팝업에서 검색 했을 경우 마스크
var hidePopPopMask = function() {

    $("#pop_pop_mask").hide();
}

//레이어 팝업 show
var popShow = function($obj) {

    $obj.css("position","absolute");
          $obj.css("top", Math.max(0, (($(window).height() - $obj.height()) / 2) + $(window).scrollTop()) + "px");
                $obj.css("left", Math.max(0, (($(window).width() - $obj.width()) / 2) + $(window).scrollLeft()) + "px");
    $obj.fadeIn();
}

//레이어 팝업 hide
var popHide = function($obj) {
    $obj.fadeOut();
}

//검색창 팝업 show
var searchPopShow = function(event, fn1, fn2) {

    var html = "";
    html += "\n  <dl>";
    html += "\n    <dt class=\"tit\">";
    html += "\n      <h4>검색창 팝업</h4>";
    html += "\n    </dt>";
    html += "\n    <dt class=\"cls\">";
    html += "\n      <button type=\"button\" onclick=\"hideRegiPopup();\" class=\"btn btn-sm btn-danger fa fa-times\">";
    html += "\n      </button>";
    html += "\n    </dt>";
    html += "\n  </dl>";
    html += "\n  <div class=\"pop-base\">";
    html += "\n    <div class=\"pop-content\">";
    html += "\n      <label for=\"search_pop\" class=\"con_label\">";
    html += "\n        Search : ";
    html += "\n        <input id=\"search_pop\" type=\"text\" class=\"search_btn fix_width180\" onkeydown=\"" + fn1 + "(event, this.value, 'select');\">";
    html += "\n        <button type=\"button\" class=\"btn btn-sm btn-info fa fa-search\" onclick=\"" + fn2 + "(event, this.value, 'select');\">";
    html += "\n        </button>";
    html += "\n      </label>";
    html += "\n      <hr class=\"hr_bd3\">";
    html += "\n      <div class=\"list_scroll fix_height120\" id=\"search_list\">";
                     //<ul style="ofh">
                     //  <li onclick=\"selectResult('%s');\" style=\"cursor: pointer;\"></li>
                     //</ul>
    html += "\n      </div>";
    html += "\n    </div>";
    html += "\n  </div>";
    html += "\n</div>";

    openRegiPopup(html, 440);
}

//마우스로 클릭한 위치에 인풋박스 레이어 팝업 출력
var showInputPop = function(event, $obj) {
    var ua = window.navigator.userAgent;
    var _x = null;
    var _y = null;

    //마우스로 선택한곳의 x축(화면에서 좌측으로부터의 거리)를 얻는다.
    //브라우저가 IE일 경우
    if (ua.indexOf("Chrome") === -1) {
        _x = event.clientX + document.documentElement.scrollLeft;

    //브라우저가 크롬일 경우
    } else {
        _x = event.clientX + document.body.scrollLeft;
    }

    //마우스로 선택한곳의 y축(화면에서 상단으로부터의 거리)를 얻는다.
    //브라우저가 IE일 경우
    if (ua.indexOf("Chrome") === -1) {
        _y = event.clientY + document.documentElement.scrollTop;
    //브라우저가 크롬일 경우
    } else {
        _y = event.clientY + document.body.scrollTop;
    }

    //마우스로 선택한 위치의 값이 -값이면 0으로 초기화. (화면은 0,0으로 시작한다.)
    if(_x < 0) _x = 0;
    //마우스로 선택한 위치의 값이 -값이면 0으로 초기화. (화면은 0,0으로 시작한다.)
    if(_y < 0) _y = 0;

    //레이어팝업의 좌측으로부터의 거리값을 마우스로 클릭한곳의 위치값으로 변경.
    $obj.css("left", _x+"px");
    //레이어팝업의 상단으로부터의 거리값을 마우스로 클릭한곳의 위치값으로 변경.
    $obj.css("top", _y+"px");

    $obj.css("display", "block");
};

//인풋박스 레이어 닫기
var hideInputPop = function($obj) {
    $obj.css("display", "none");
};

//업로드 할 파일의 확장자 체크
var checkExt = function($obj) {
    var val = $obj.val();
    	val = val.split('.');
    var ext = val[val.length - 1];

    if (ext !== "xlsx" && ext !== "xls") {
        alert("엑셀파일만 업로드 할 수 있습니다.");
        return false;
    }

    return true;
};

//옵션 html 생성
var makeOption =  function(str) {
    var html = "<option value=\"\" selected>" + str + "</option>";
    return html;
}

//검색 날짜 범위 설정
var dateSet = function(num) {

    var day = new Date();
    var time = day.getHours();
    var d_day = new Date(day - (num * 1000 * 60 * 60 * 24));
    var last = new Date(day - (365 * 1000 * 60 * 60 * 24));

    //전체 범위 검색시 날짜 범위 초기화
    if (num == "last") {
        $("#date_from").datepicker("setDate", last);
        $("#time_from").val("0");
        $("#date_to").datepicker("setDate", last);
        $("#time_to").val(time);
    } else if (num == "all"){
        $("#date_from").val("");
        $("#time_from").val("0");
        $("#date_to").val("");
        $("#time_to").val("0");
    } else {
        $("#date_from").datepicker("setDate", d_day);
        $("#time_from").val("0");
        $("#date_to").datepicker("setDate", '0');
        $("#time_to").val(time);
    }
};

/**
 * @brief 카테고리 선택시 하위 카테고리 정보 검색
 *
 * @param cateType     = 카테고리 선택 구분(top, mid)
 * @param cateSortcode = 카테고리 분류코드
 */
var cateSelect = {
    "type" : null,
    "exec" : function(cateType, cateSortcode) {
        //카테고리 분류코드가 빈값인 경우
        if (checkBlank(cateSortcode)) {
            var html = "";

            //카테고리 대분류
            if (cateType === "top") {
                html = makeOption("중분류(전체)");
                $("#cate_mid").html(html);
                html = makeOption("소분류(전체)");
                $("#cate_bot").html(html);
            } else if (cateType === "mid") {
                html = makeOption("소분류(전체)");
                $("#cate_bot").html(html);
            }

            // 상세 검색정보 초기화 하는 함수 있을경우 실행
            if (isFunc('resetDetailInfo') === true) {
                resetDetailInfo();
            }
            return false;
        }

        this.type = cateType;

        // 카테고리 대 변경시 카테고리 소 초기화
        if (cateType === "top") {
            html = makeOption("소분류(전체)");
            $("#cate_bot").html(html);
        }

        var url = "/ajax/common/load_cate_list.php";
        var data = {
            "cate_sortcode" : cateSortcode,
            "cate_type"     : cateType
        };
        var callback = function(result) {
            var html = "";
            if (cateSelect.type === "top") {
                $("#cate_mid").html(result);
            } else if (cateSelect.type === "mid") {
                $("#cate_bot").html(result);
            }
        }

        //ajax call 함수
        ajaxCall(url, "html", data, callback);
    },
    "pop" : function(cateType, cateSortcode) {
        //카테고리 분류코드가 빈값인 경우
        if (checkBlank(cateSortcode)) {
            var html = "";

            //카테고리 대분류
            if (cateType === "top") {
                html = makeOption("중분류(전체)");
                $("#cate_mid").html(html);
                html = makeOption("소분류(전체)");
                $("#cate_bot").html(html);
            } else if (cateType === "mid") {
                html = makeOption("소분류(전체)");
                $("#cate_bot").html(html);
            }

            // 상세 검색정보 초기화 하는 함수 있을경우 실행
            if (isFunc('resetDetailInfo') === true) {
                resetDetailInfo();
            }
            return false;
        }

        this.type = cateType;

        // 카테고리 대 변경시 카테고리 소 초기화
        if (cateType === "top") {
            html = makeOption("소분류(전체)");
            $("#cate_bot").html(html);
        }

        var url = "/ajax/common/load_cate_list.php";
        var data = {
            "cate_sortcode" : cateSortcode,
            "cate_type"     : cateType
        };
        var callback = function(result) {
            var html = "";
            if (cateSelect.type === "top") {
                $("#cate_mid").html(result);
            } else if (cateSelect.type === "mid") {
                $("#cate_bot").html(result);
            }
            showBgMask();
        }

        //ajax call 함수
        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 카테고리 소분류 선택했는지 검사
 */
var isSelectCateBot = function() {
    if (checkBlank($("#cate_bot").val())) {
        alert("카테고리를 소분류까지 선택해주세요.");
        return false;
    }

    return true;
};

/**
 * @brief 요율, 적용금액 입력시 숫자만 입력받도록 하는 함수
 *
 * @param 인풋박스 입력값
 */
var inputOnlyNumber = function(val) {
    // 숫자를 제외한 나머지만 반환하는 정규식
    // 12.34214asd -> asd만 반환
    var pattern1 = /[^-?\d+\.?\d+]+/gi;
    // 소수점 두 자리 까지만 유지하는 정규식
    // 123124.3214 -> 123124.32만 반환
    var pattern2 = /^[-]?\d*[\.]?\d{0,2}/gi;

    // 문자열 제거
    var temp1 = val.replace(pattern1, "");
    // 제거된 문자열에서 정수부분이 9자리 미만이 되도록 조정
    var temp2 = temp1.split('.');

    if (temp2[0].length > 9) {
        var i = temp2[0].substr(0, 9);
        temp1 = i + temp2[1];
    }

    return pattern2.exec(temp1);
};

//인풋박스 숫자만 가능
var onlyNumber = function(event, el) {

    var num_pattern = /^[0-9]*$/;
    var str_pattern = /[^-?\d+\.?\d+]+/gi;
    var spc_pattern = /[^(가-힣ㄱ-ㅎㅏ-ㅣa-zA-Z0-9)]/gi;

    if (!num_pattern.test(el.value)) {
        alert("숫자만 입력 가능합니다.");
        el.value = el.value.replace(str_pattern, "");
        el.value = el.value.replace(spc_pattern, "");
        el.focus();
        return false;
    }
}

//인풋박스 숫자만 가능
var onlyNumber2 = function(event) {

    event = event || window.event;

    var keyID = (event.which) ? event.which : event.keyCode;
    if (keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39) {
        return;
    } else {
        event.target.value = event.target.value.replace(/[^0-9]/g, "");
    }
}

//인풋박스 숫자(가격)만 가능
var onlyNumberPrice = function(event) {

    event = event || window.event;

    var keyID = (event.which) ? event.which : event.keyCode;
    if (keyID == 46 || keyID == 37 || keyID == 39) {
        return;
    } else {
        event.target.value = event.target.value.replace(/[^0-9]/g, "").format();
    }
}

/**
 *
 * @brief 등록 팝업
 * param html : 팝업열 html
 * param el_width : 팝업 html 가로사이즈
 *
*/
var openRegiPopup = function(html, el_width) {

    $("#regi_popup").html(html);
    $("#regi_popup").css("width", el_width + "px");

    var height = $(window).height();
    var width  = $(window).width();

    var st = $(window).scrollTop();
    var sl = $(window).scrollLeft();

    var objWidth  = $('#regi_popup').outerWidth();
    var objHeight = $('#regi_popup').outerHeight();

    var topVal = (height - objHeight)/2 + st;

    if (height < objHeight) {
        topVal = (height - objHeight)/3 + st;
    }

    showBgMask();
    if (objHeight > 550) {
        $("#regi_popup").css({position:'absolute'}).css({
            left: (width - objWidth)/2 + sl + "px",
            top : (height - 600)/2 + st + "px",
            width : el_width + "px"
        });

 	    $(".pop_add_box .pop-base").css({
            height : "550px"
        });

    } else {
        $("#regi_popup").css({position:'absolute'}).css({
            left: (width - objWidth)/2 + sl + "px",
            top : topVal + "px",
            width : el_width + "px"
        });
    }

    $("#regi_popup").focus();
    $("#regi_popup").show();
}

//등록창 닫기
var hideRegiPopup = function() {

    hideBgMask();
    $("#regi_popup").html("");
    $("#regi_popup").hide();
}

/**
 *
 * @brief 팝업 위 팝업
 * param html : 팝업열 html
 * param el_width : 팝업 html 가로사이즈
 *
*/
var openPopPopup = function(html, el_width) {

    $("#pop_popup").html(html);
    $("#pop_popup").css("width", el_width + "px");

    var height = $(window).height();
    var width  = $(window).width();

    var st = $(window).scrollTop();
    var sl = $(window).scrollLeft();

    var objWidth  = $('#pop_popup').outerWidth();
    var objHeight = $('#pop_popup').outerHeight();

    var topVal = (height - objHeight)/2 + st;

    if (height < objHeight) {
        topVal = (height - objHeight)/3 + st;
    }

    showBgMask();
    if (objHeight > 550) {
        $("#pop_popup").css({position:'absolute'}).css({
            left: (width - objWidth)/2 + sl + "px",
            top : (height - 600)/2 + st + "px",
            width : el_width + "px"
        });

 	$(".pop_add_box .pop-base").css({
            height : "550px"
        });

    } else {
        $("#pop_popup").css({position:'absolute'}).css({
            left: (width - objWidth)/2 + sl + "px",
            top : topVal + "px",
            width : el_width + "px"
        });
    }

    $("#pop_popup").focus();
    $("#pop_popup").show();
}

//팝업 위 팝업 닫기
var hidePopPopup = function() {

    hidePopMask();
    $("#pop_popup").html("");
    $("#pop_popup").hide();
}

/**
 *
 * @brief 숫자, backspace, delete, -, . 만 입력 받기
 *
*/
var checkNumber = function(event){

    event = event || window.event;

    var keyID = (event.which) ? event.which : event.keyCode;

    if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105)
            || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39
            || keyID == 109 || keyID == 173 || keyID == 190)
        return;
    else
        return false;
}

/**
 *
 * @brief 숫자, backspace, delete, -, . 외 문자 삭제
 *
*/
var removeChar = function(event) {

    event = event || window.event;

    var keyID = (event.which) ? event.which : event.keyCode;
    if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 )

        return;
    else
        event.target.value = event.target.value.replace(/[^0-9,.,-]/g, "");
}

//이메일 형식 체크
var emailCheck = function(str) {

    var reg = /[0-9a-zA-Z][_0-9a-zA-Z-]*@[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+){1,2}$/;

    //이메일 형식에 맞지않으면
    if (!str.match(reg)){
        return false;
    }

    return true;
}

/**
 *
 * @brief 주소 팝업 검색 관련 함수
 *
*/
var zip_click_func = "";

//우편번호 클릭시 주소검색 팝업
var popZipLayer = function(func) {

   zip_click_func = func;

    $.ajax({
            type: "POST",
            data: {
            },
            url: "/ajax/common/load_zip_html.php",
            success: function(result) {

                openRegiPopup(result, "440");
           }
    });
}

//팝업 우편번호 클릭시 주소검색 팝업
var popPopZipLayer = function(func) {

   zip_click_func = func;

    $.ajax({
            type: "POST",
            data: {
                type : 1
            },
            url: "/ajax/common/load_zip_html.php",
            success: function(result) {
                openPopPopup(result, "440");
                showPopMask();
           }
    });
}

//주소검색 팝업 검색
var searchZipStr = function() {

    var search_str = $("#zip_search").val();

    if ($.trim(search_str) == "") {

	    alert("검색창에 검색어를 입력해주세요.");
        return false;

    }

    showMask();

    $.ajax({
            type: "POST",
            data: {
                "val" : search_str,
                "type" : $("input[name=doro_yn]:checked").val(),
                "area" : $("#zipcode_area").val(),
		        "func" : zip_click_func
            },
            url: "/ajax/common/load_zip_list.php",
            success: function(result) {
                $("#search_result").html(result);
                hideMask();
                showBgMask();
           },
            error: getAjaxError
    });
}

//팝업 검색창 엔터 쳤을때 검색
var popZipEnterCheck = function(event) {

	if(event.keyCode == 13) {
	    searchZipStr();
        }
}

//팝업 주소검색 팝업 검색
var popSearchZipStr = function() {

    var search_str = $("#zip_search").val();

    if ($.trim(search_str) == "") {

	    alert("검색창에 검색어를 입력해주세요.");
        return false;

    }

    showMask();
    showPopPopMask();

    $.ajax({
            type: "POST",
            data: {
                "val" : search_str,
                "type" : $("input[name=doro_yn]:checked").val(),
                "area" : $("#zipcode_area").val(),
		        "func" : zip_click_func
            },
            url: "/ajax/common/load_zip_list.php",
            success: function(result) {
                $("#search_result").html(result);
                hideMask();
                hidePopPopMask();
                showBgMask();
                showPopMask();
           },
            error: getAjaxError
    });
}

//팝업의 주소 팝업 검색창 엔터 쳤을때 검색
var popPopZipEnterCheck = function(event) {

	if(event.keyCode == 13) {
	    popSearchZipStr();
        }
}

/**
 * @brief 회원명 검색할 때 사용하는 함수
 *
 * @param event = 키 이벤트
 * @param val   = 입력값
 * @param dvs   = 팝업 출력인지 재검색인지 구분값
 */
var searchOfficeNick = function(event, val, dvs) {
    if (event.keyCode != 13) {
        return false;
    }

    var url = "/ajax/common/load_office_nick.php";
    var data = {
        "sell_site"  : $("#sell_site").val(),
        "search_val" : val
    };
    var callback = function(result) {
        if (dvs !== "select") {
            searchPopShow(event, "searchOfficeNick", "searchOfficeNick");
        } else {
            showBgMask();
        }

        $("#search_list").html(result);
    };

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 회원명 검색창에서 결과값 클릭했을 경우 인풋에 값 입력
 *
 * @param val = 선택값
 */
var nameClick = function(val) {
    $("#user_id").val(val);
    hideRegiPopup();
};

/**
 * @brief 조건(인쇄물제목, 주문번호, 사내닉네임, 회원명) 검색할 때 사용하는 함수
 *
 * @param event = 키 이벤트
 * @param val   = 입력값
 * @param dvs   = 팝업 출력인지 재검색인지 구분값
 */
var searchCnd = function(event, val, dvs) {
    if(event.keyCode != 13){
        return false;
    }

    var url = "/ajax/common/load_cnd_search.php";
    var data = {
   	    "cnd_val"     : $("#cnd_val").val(),
   	    "search_val"  : $("#search_val").val()
    };
    var callback = function(result) {

        if (dvs !== "select") {
            searchPopShow(event, "searchCnd", "searchCnd");
        } else {
            showBgMask();
        }
        $("#search_cnd").val($("#cnd_val").val());
        $("#search_list").html(result);
    };

    ajaxCall(url, "html", data, callback);
}

/**
 * @brief 조건 검색창에서 결과값 클릭했을 경우 인풋에 값 입력
 *
 * @param val = 선택값
 */
var cndClick = function(val) {
    $("#search_txt").val(val);
    hideRegiPopup();
};

/**
 * @brief 회원아이디 검색할 때 사용하는 함수
 *
 * @param event = 키 이벤트
 * @param val   = 입력값
 * @param dvs   = 팝업 출력인지 재검색인지 구분값
 */
var searchMemberId = function(event, val, dvs) {
    if (event.keyCode != 13) {
        return false;
    }

    var url = "/ajax/common/load_member_id.php";
    var data = {
        "sell_site"  : $("#sell_site").val(),
        "search_val" : val
    };
    var callback = function(result) {

        if (dvs !== "select") {
            searchPopShow(event, "searchMemberId", "searchMemberId");
        } else {
            showBgMask();
        }

        $("#search_list").html(result);
    };

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 회원명 검색창에서 결과값 클릭했을 경우 인풋에 값 입력
 *
 * @param val = 선택값
 */
var idClick = function(val) {
    $("#member_id").val(val);
    hideRegiPopup();
};

// 숫자 타입에서 쓸 수 있도록 format() 함수 추가
Number.prototype.format = function(){
    if(this==0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
};

// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
String.prototype.format = function(){
    var num = parseFloat(this);
    if( isNaN(num) ) return "0";

    return num.format();
};

/**
 * @brief 판매채널에 해당하는 영업팀 검색
 */
var loadDeparInfo = function() {

    showMask();

    var url = "/ajax/common/load_depar_list.php";
    var data = {
    	"sell_site" : $("#sell_site").val()
    };
    var callback = function(result) {
        $("#depar_code").html(result);
    };

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 로그인
 */
var login = function() {

    showMask();

    var url = "/common/login.php";
    var data = {
    	"id" : $("#id").val(),
    	"pw" : $("#pw").val()
    };
    var callback = function(result) {

        var err_msg = "아이디 또는 비밀번호를 다시 확인하세요.</br>등록되지 않은 아이디이거>나, 아이디 또는 비밀번호를 잘못 입력하셨습니다.";
        if (result == "true") {
            location.href = "/business/order_hiprint.html";
        } else {
            $("#login_err_msg").html(err_msg);
        }
    };

    if (checkBlank($("#id").val())) {
        alert("아이디를 입력 해주세요.");
        $("#id").focus();
        return false;
    }

    if (checkBlank($("#pw").val())) {
        alert("암호를 입력 해주세요.");
        $("#pw").focus();
        return false;
    }

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 로그인
 */
var loginKey = function(event) {

    if (event.keyCode == 13) {
        login();
    }
}

/**
 * @brief 암호 입력란으로 이동
 */
var idkey = function(event) {
    if (event.keyCode == 13) {
        $("#pw").focus();
    }
}

/**
 * @brief 종이 정보 리셋
 */
var resetPaperInfo = function() {
    var paper = "paper";
    $("#" + paper + "_dvs").html("<option value=\"\">구분</option>");
    $("#" + paper + "_color").html("<option value=\"\">색상</option>");
    $("#" + paper + "_basisweight").html("<option value=\"\">평량</option>");
};

/**
 * @brief 카테고리 선택시 하위 카테고리 정보 검색
 *
 * @param paperType = 종이 선택 구분(NAME, DVS, COLOR)
 * @param val       = 선택한 값
 */
var paperSelect = {
    "type" : null,
    "exec" : function(paperType, val) {
        if (paperType === "name" && checkBlank(val) === true) {
            resetPaperInfo();
            return false;
        }

        this.type = paperType;

        var url = "/json/basic_mng/prdt_price_list/load_paper_info.php";
        var data = {
            "cate_sortcode" : $("#cate_bot").val(),
            "type"          : paperType,
            "paper_name"    : $("#paper_name").val(),
            "paper_dvs"     : $("#paper_dvs").val(),
            "paper_color"   : $("#paper_color").val()
        };

        var callback = function(result) {
            if (paperSelect.type === "NAME") {
                $("#paper_dvs").html(result.dvs);
                $("#paper_color").html(result.color);
                $("#paper_basisweight").html(result.basisweight);
            } else if (paperSelect.type === "DVS") {
                $("#paper_color").html(result.color);
                $("#paper_basisweight").html(result.basisweight);
            } else if (paperSelect.type === "COLOR") {
                $("#paper_basisweight").html(result.basisweight);
            }
        };

        ajaxCall(url, "json", data, callback);
    }
};
