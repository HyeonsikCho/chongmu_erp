/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/11/27 엄준현 생성(상세정보 초기화 추가)
 * 2015/11/30 엄준현 수정(일괄/개별수정, 엑셀 업/다운로드 추가)
 *=============================================================================
 *
 */

/**
 * @brief 상세검색정보(종이/사이즈/인쇄) 초기화
 *
 * @param cateSortcode = 정보검색용 카테고리 분류코드
 */
var initAftInfo = function(cateSortcode) {
    if (checkBlank(cateSortcode) === true) {
	    resetAftInfo(0);
	    return false;
    }

    var url = "/ajax/basic_mng/after_price_list/load_after_list.php";
    var data = {
	    "cate_sortcode" : cateSortcode
    };
    var callback = function(result) {
        $("#aft_name").html(result);
    };

    ajaxCall(url, "html", data, callback);
};

/**
 * @brief 상세검색정보 리셋
 *
 * @param depth = 초기화를 시작할 depth
 */
var resetAftInfo = function(depth) {
    $("#aft_name").html(makeOption("후공정명"));
    resetAftSelect(depth);
};

/**
 * @brief 후공정 Depth1, 2, 3 초기화
 *
 * @param depth = 초기화를 시작할 depth
 */
var resetAftSelect = function(depth) {
    var start = 1 + parseInt(depth);

    for (start; start <= 3; start++) {
        var optionStr = "Depth" + start 
        $("#aft_dep" + start).html(makeOption(optionStr));
    }
}

/**
 * @brief 후공정 셀렉트 박스 선택시
 *
 * @param depth = 선택한 후공정의 depth
 * @param val   = 선택한 후공정의 값
 */
var aftSelect = {
    "depth"   : null,
    "exec"    : function(depth, aft) {
        if (checkBlank(aft) === true) {
            resetAftSelect(depth);
            return false;
        }

        if (aft === '-') {
            return false;
        }

        this.depth = parseInt(depth) + 1;

        var url = "/ajax/basic_mng/after_price_list/load_after_list.php";
        var data = {
            "cate_sortcode" : $("#cate_bot").val(),
            "depth"         : depth,
            "after_name"    : $("#aft_name").val(),
            "dep1_val"      : $("#aft_dep1").val(),
            "dep2_val"      : $("#aft_dep2").val()
        };
        var callback = function(result) {
            $("#aft_dep" + aftSelect.depth).html(result);
        };

        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 선택 조건으로 검색 클릭시
 *
 * @param updateFlag = 가격 수정여부
 */
var cndSearch = {
    "data" : null,
    "exec" : function(updateFlag) {
	    hideModiPop();

        if (isSelectCateBot() === false) {
            return false;
        }

        if (checkBlank($("#aft_name").val()) === true) {
            alert("후공정명을 선택해주세요.");
            return false;
        }

        var url = "/ajax/basic_mng/after_price_list/load_after_price_list.php";
	    var data = null;
        var callback = function(result) {
            $("#aft_price_list").html(result);
            $("#aft_price_list").show();
        };

    	if (updateFlag === false) {
            data = {
                "cate_sortcode" : $("#cate_bot").val(),
                "sell_site"     : $("#sell_site").val(),
                "after_name"    : $("#aft_name").val(),
                "dep1_val"      : $("#aft_dep1").val(),
                "dep2_val"      : $("#aft_dep2").val(),
                "dep3_val"      : $("#aft_dep3").val()
            };
    	} else {
    	    data = this.data;
    	}

        this.data = data;

        showMask();

        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 제목 탭에서 요율, 적용금액을 클릭했을 경우 전체수정팝업 출력
 *
 * @param event = 좌표값을 얻기위한 이벤트 객체
 * @param dvs   = 어떤 항목을 클릭했는지 구분값
 * @param pos   = 몇 번째 가격항목인지 위치
 */
var modiPriceInfo = {
    "dvs"  : null,
    "pos"  : null,
    "exec" : function(event, dvs, pos) {
        var point = getPopupPoint(event);

        selectedModiAllPriceDvs(dvs);

        this.dvs = dvs;
        this.pos = pos;

        hideModiPop("modi_each_price");
        showModiPop("modi_all_price", point.x, point.y);
    }
};

/**
 * @brief 일괄수정 적용버튼 클릭시
 */
var aplyPriceInfo = function() {
    if (checkBlank($("#modi_all_price_val").val()) === true) {
        if (modiPriceInfo.dvs === "R") {
            alert("요율을 입력해주세요.");
            return false;
        } else {
            alert("적용금액을 입력해주세요.");
            return false;
        }
    }

    var pos = modiPriceInfo.pos;

    var $sellSite  = $("#sell_site_" + pos);
    var $aftMpcode = $("#mpcode_" + pos);

    var url = "/proc/basic_mng/after_price_list/update_after_price_list.php";
    var data = {
        "sell_site"  : $sellSite.attr("val"),
        "aft_mpcode" : $aftMpcode.attr("val"),
        "val"        : $("#modi_all_price_val").val(),
        "dvs"        : modiPriceInfo.dvs
    };
    var callback = function(result) {
	    if (result === "T") {
	        cndSearch.exec(true);
	    } else {
            alert("가격 수정에 실패했습니다.");
	    }

	    hideModiPop();
    };

    ajaxCall(url, "text", data, callback);
}

/**
 * @brief 내용에서 요율, 적용금액을 클릭했을 경우 개별수정팝업 출력
 *
 * @param event = 좌표값을 얻기위한 이벤트 객체
 * @param dvs   = 어떤 항목을 클릭했는지 구분값
 * @param seqno = 가격항목 seqno
 */
var modiPriceInfoEach = {
    "dvs"    : null,
    "seqno"  : null,
    "exec"   : function(event, dvs, seqno) {
        var point = getPopupPoint(event);

        this.dvs     = dvs;
        this.seqno   = seqno;

        hideModiPop("modi_all_price");
        showModiPop("modi_each_price", point.x, point.y);
    }
};

/**
 * @brief 개별수정 적용버튼 클릭시
 */
var aplyPriceInfoEach = function() {
    if (checkBlank($("#modi_each_price_val").val()) === true) {
        if (modiPriceInfoEach.dvs === "R") {
            alert("요율을 입력해주세요.");
            return false;
        } else {
            alert("적용금액을 입력해주세요.");
            return false;
        }
    }

    var url = "/proc/basic_mng/after_price_list/update_after_price_list.php";
    var data = {
        "val"         : $("#modi_each_price_val").val(),
        "dvs"         : modiPriceInfoEach.dvs,
        "price_seqno" : modiPriceInfoEach.seqno,
    };
    var callback = function(result) {
	    if (result === "T") {
			cndSearch.exec(true);
		    } else {
		    alert("가격 수정에 실패했습니다.");
		    }

		    hideModiPop();
	    };

	    ajaxCall(url, "text", data, callback);
	};

/**
 * @brief 엑셀 다운로드시 사용되는 함수
 */
var downloadFile = {
    "sellSite" : null,
    "exec"     : function() {
	    if (isSelectCateBot() === false) {
	        return false;
        }

        if (checkBlank($("#aft_name").val()) === true) {
            alert("후공정명을 선택해주세요.");
            return false;
        }

	    this.sellSite = $("#sell_site").val();

	    var url = "/ajax/basic_mng/after_price_list/down_excel_after_price_list.php";
	    var data = null;
	    var callback = function(result) {
	        if (result === "FALSE") {
		        alert("엑셀파일 생성에 실패했습니다.");
	        } else if (result === "NOT_INFO") {
    		    alert("엑셀로 생성할 정보가 존재하지 않습니다.");
	        } else {
		        var downUrl  = "/common/excel_file_down.php?name=" + result;
		            downUrl += "&sell_site=" + downloadFile.sellSite;

		        $("#file_ifr").attr("src", downUrl);
            }
        };

        if (cndSearch.data === null) {
            data = {
                "cate_sortcode" : $("#cate_bot").val(),
                "sell_site"     : downloadFile.sellSite,
                "after_name"    : $("#aft_name").val(),
                "dep1_val"      : $("#aft_dep1").val(),
                "dep2_val"      : $("#aft_dep2").val(),
                "dep3_val"      : $("#aft_dep3").val()
            };
        } else {
            data = cndSearch.data;
        }

        showMask();

        ajaxCall(url, "text", data, callback);
    }
};

/**
 * @brief 엑셀 업로드 할 때 사용하는 함수
 *
 * @param dvs = 어떤 엑셀 파일을 업로드 하는지 구분
 */
var uploadFile = function(dvs) {

    var formData = new FormData();

    formData.append("dvs", dvs);

    if(checkExt($("#aft_price_excel_path")) === false) {
        return false;
    }

    formData.append("file"     , $("#aft_price_excel")[0].files[0]);
    formData.append("sell_site", $("#sell_site").val());

    showMask();

    excelUploadAjax(formData);
};
