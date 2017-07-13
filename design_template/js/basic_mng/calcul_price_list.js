/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/01 엄준현 생성(종이 탭 관련내용 추가)
 * 2015/12/02 엄준현 수정(탭 별로 자바스크립트 분리)
 *=============================================================================
 *
 */

/**
 * @brief 엑셀 다운로드시 사용되는 함수
 */
var downloadFile = {
    "sellSite" : null,
    "exec"     : function(dvs) {
        if (searchValidate(dvs) === false) {
            return false;
        }

        this.sellSite = $("#" + dvs + "_sell_site").val();

        var url = "/ajax/basic_mng/calcul_price_list/down_excel_" + dvs + "_price_list.php";
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
            data = getCndSearchData(dvs);
	        data.sell_site = this.sellSite;
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
    var tabDvs = getTabDvs();

    formData.append("dvs", dvs);

    if(checkExt($("#" + tabDvs + "_price_excel_path")) === false) {
        return false;
    }

    formData.append("file"     , $("#" + tabDvs + "_price_excel")[0].files[0]);
    formData.append("sell_site", $("#" + tabDvs + "_sell_site").val());

    showMask();

    excelUploadAjax(formData);
};

/**
 * @brief 선택 조건으로 검색 클릭시
 *
 * @param updateFlag = 가격 수정여부
 * @param dvs        = 탭 별 구분값
 */
var cndSearch = {
    "data" : null,
    "dvs"  : null,
    "exec" : function(dvs, updateFlag) {
	    hideModiPop();

        if (searchValidate(dvs) === false) {
            return false;
        }

        this.dvs = dvs;

        var url = "/ajax/basic_mng/calcul_price_list/load_" + dvs + "_price_list.php";
        var data = null;
        var callback = function(result) {
            $("#" + cndSearch.dvs + "_price_list").html(result);
            $("#" + cndSearch.dvs + "_price_list").show();
        };

    	if (updateFlag === false) {
            data = getCndSearchData(dvs);
            data.sell_site = $("#" + dvs + "_sell_site").val();
    	} else {
    	    data = this.data;
    	}

        this.data = data;

        showMask();

        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 각 탭에 해당하는 validation 검사
 */
var searchValidate = function(dvs) {
    if (dvs === "paper") {
        if (checkBlank($("#paper_sort").val()) === true) {
            alert("종이 분류를 선택해주세요.");
            return false;
        }
        if (checkBlank($("#paper_name").val()) === true) {
            alert("종이명을 선택해주세요.");
            return false;
        }
    } else if (dvs === "output") {
        if (checkBlank($("#output_name").val()) === true) {
            alert("출력명을 선택해주세요.");
            return false;
        }
    } else if (dvs === "print") {
        if (checkBlank($("#cate_top").val()) === true) {
            alert("카테고리를 선택해주세요.");
            return false;
        }
        /*
        if (checkBlank($("#print_name").val()) === true) {
            alert("인쇄명를 선택해주세요.");
            return false;
        }
        */
    }

    return true;
}

/**
 * @brief 탭에 따라서 가격검색할 url 반환
 *
 * @param dvs = 탭 구분
 *
 * @return 가격검색 url
 */
var getCndSearchUrl = function(dvs) {
    var ret = null;

    return ret;
};

/**
 * @brief 탭에 따라서 가격검색할 파라미터 반환
 *
 * @param dvs = 탭 구분
 *
 * @return 가격검색용 파라미터
 */
var getCndSearchData = function(dvs) {
    var ret = null;

    if (dvs === "paper") {
        ret = {
            "paper_search" : makePaperSearch(),
            "paper_affil"  : clickAffil.affil[dvs],
            "paper_size"   : $("#paper_size").val()
        };
    } else if (dvs === "output") {
        ret = {
            "output_name"        : $("#output_name").val(),
            "output_board_dvs"   : $("#output_board_dvs").val(),
            "output_board_affil" : clickAffil.affil[dvs + "_board"],
            "output_board_size"  : $("#output_board_size").val()
        };
    } else if (dvs === "print") {
        ret = {
            "print_name"     : $("#print_name").val(),
            "print_purp_dvs" : $("#print_purp_dvs").val(),
            "print_affil"    : clickAffil.affil[dvs]
        };

	if (checkBlank($("#cate_mid").val()) === true) {
            ret.cate_sortcode = $("#cate_top").val();
	} else {
            ret.cate_sortcode = $("#cate_mid").val();
	}
    }

    return ret;
};

/**
 * @brief 제목 테이블에서 요율, 적용금액을 클릭했을 경우
 *
 * @param event = 좌표값을 얻기위한 이벤트 객체
 * @param dvs   = 어떤 항목을 클릭했는지 구분값
 * @param pos   = 몇 번째 가격항목인지 위치
 */
var modiPriceInfo = {
    "dvs"    : null,
    "seqno"  : null,
    "exec"   : function(event, dvs, pos) {
        var point = getPopupPoint(event);
	    var tabDvs = getTabDvs();

        selectedModiAllPriceDvs(dvs);

        this.dvs    = dvs;
        this.pos    = pos;

        hideModiPop("modi_each_" + tabDvs + "_price");
        showModiPop("modi_all_" + tabDvs + "_price", point.x, point.y);
    }
};

/**
 * @brief 내용에서 요율, 적용금액을 클릭했을 경우
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
        var tabDvs = getTabDvs();

        this.dvs    = dvs;
        this.seqno  = seqno;

        hideModiPop("modi_all_" + tabDvs + "_price");
        showModiPop("modi_each_" + tabDvs + "_price", point.x, point.y);
    }
};

/**
 * @brief 일괄수정 적용버튼 클릭시
 *
 * @param dvs = 어느 탭인지 구분값
 */
var aplyPriceInfo = {
    "tabDvs" : null,
    "exec"   : function(dvs) {
        if (checkBlank($("#modi_all_" + dvs + "_price_val").val()) === true) {
            if (modiPriceInfo.dvs === "R") {
                alert("요율을 입력해주세요.");
                return false;
            } else {
                alert("적용금액을 입력해주세요.");
                return false;
            }
        }

        this.tabDvs = dvs;
    
        var url = "/proc/basic_mng/calcul_price_list/update_" + dvs + "_price_list.php";
        var data =  getAplyPriceData(dvs);
        var callback = function(result) {
            if (result === "T") {
                cndSearch.exec(aplyPriceInfo.tabDvs, true);
            } else {
                alert("가격 수정에 실패했습니다.");
            }
    
            hideModiPop();
        };
    
        ajaxCall(url, "text", data, callback);
    }
};

/**
 * @brief 탭 별 가격 일괄수정시 넘길 파라미터 생성
 *
 */
var getAplyPriceData = function(dvs) {
    var ret = null;
    var pos = modiPriceInfo.pos;
    var val = $("#modi_all_" + aplyPriceInfo.tabDvs + "_price_val").val();

    if (dvs === "paper") {
        var $sellSite = $("#paper_sell_site_" + pos);
        var $info     = $("#paper_info_" + pos);
        var $affil    = $("#paper_affil_" + pos);
        var $size     = $("#paper_size_" + pos);

        ret = {
            "sell_site" : $sellSite.attr("val"),
            "info"      : $info.attr("val"),
            "affil"     : $affil.attr("val"),
            "size"      : $size.attr("val"),
            "val"       : val,
            "dvs"       : modiPriceInfo.dvs
        };
    } else if (dvs === "output") {
        var $sellSite = $("#output_sell_site_" + pos);
        var $mpcode   = $("#output_mpcode_" + pos);

        ret = {
            "sell_site" : $sellSite.attr("val"),
            "mpcode"    : $mpcode.attr("val"),
            "val"       : val,
            "dvs"       : modiPriceInfo.dvs
        };
    } else if (dvs === "print") {
        var $sellSite = $("#print_sell_site_" + pos);
        var $mpcode   = $("#print_mpcode_" + pos);

        ret = {
            "sell_site" : $sellSite.attr("val"),
            "mpcode"    : $mpcode.attr("val"),
            "val"       : val,
            "dvs"       : modiPriceInfo.dvs
        };
    }

    return ret;
}

/**
 * @brief 개별수정 적용버튼 클릭시
 *
 * @param dvs = 어느 탭인지 구분값
 */
var aplyPriceInfoEach = {
    "tabDvs" : null,
    "exec"   : function(dvs) {
        if (checkBlank($("#modi_each_" + dvs + "_price_val").val()) === true) {
            if (modiPriceInfoEach.dvs === "R") {
                alert("요율을 입력해주세요.");
                return false;
            } else {
                alert("적용금액을 입력해주세요.");
                return false;
            }
        }

	    this.tabDvs = dvs;
    
        var url = "/proc/basic_mng/calcul_price_list/update_" + dvs + "_price_list.php";
        var data = {
            "val"         : $("#modi_each_" + dvs + "_price_val").val(),
            "dvs"         : modiPriceInfoEach.dvs,
            "price_seqno" : modiPriceInfoEach.seqno,
        };
        var callback = function(result) {
            if (result === "T") {
                cndSearch.exec(aplyPriceInfoEach.tabDvs, true);
            } else {
                alert("가격 수정에 실패했습니다.");
            }
    
            hideModiPop();
        };
    
        ajaxCall(url, "text", data, callback);
    }
};

/**
 * @brief 현재 어떤 탭을 선택하고 있는지 반환
 *
 * @return 선택하고 있는 탭
 */
var getTabDvs = function() {
    var ret = null;

    $("#root_tab").children("li").each(function() {
        if (checkBlank($(this).attr("class")) === false) {
            ret = $(this).attr("dvs");
        }
    });

    return ret;
}

/**
 * @brief 계열 선택시 사이즈 검색
 *
 * @param obj   = 체크박스 객체
 * @param affil = 클릭한 체크박스 구분
 * @param dvs   = 사이즈 구분
 */
var clickAffil = {
    "affil" : {
        "paper"        : {"46"  : false, "GUK" : false},
        "output_board" : {"46"  : false, "GUK" : false},
        "print"        : {"46"  : false, "GUK" : false}
    },
    "dvs"  : null,
    "exec" : function(obj, affil, dvs) {
        if($(obj).prop("checked")) {
            this.affil[dvs][affil] = true;
        } else {
            this.affil[dvs][affil] = false;
        }

        this.dvs = dvs;

        // 인쇄 사이즈는 종이 사이즈랑 똑같은 값 가져옴
        if (dvs === "print") {
            dvs = "paper";
        }

        var url = "/ajax/basic_mng/calcul_price_list/load_" + dvs + "_size.php";
        var callback = function(result) {
            $("#" + clickAffil.dvs + "_size_width").val('*');
            $("#" + clickAffil.dvs + "_size_height").val('*');
            $("#" + clickAffil.dvs + "_size").html(result);
        };

        ajaxCall(url, "html", this.affil[this.dvs], callback);
    }
};

/**
 * @brief 사이즈 선택시 가로 사이즈, 세로 사이즈 변경
 *
 * @param dvs  = 탭 구분
 * @param size = 선택한 출력판 사이즈
 */
var selectSize = function(dvs, size) {
    var sizeTemp = size.split('*');

    $("#" + dvs + "_size_width").val(sizeTemp[0]);
    $("#" + dvs + "_size_height").val(sizeTemp[1]);
};
