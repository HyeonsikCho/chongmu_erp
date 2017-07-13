/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 *
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/29 임종건 생성
 *=============================================================================
 *
 */

$(document).ready(function() {
    // 팀 별 검색에서 팀구분 값 로드
    loadDeparInfo();
    cndSearch.exec(30, 1);
});

//보여줄 페이지 수
var showPage = "";

var paperIdx = 1;
var outputIdx = 1;
var printIdx = 1;
var afterIdx = 1;
var etcIdx = 1;

//전체 선택
var allCheck = function() {
    //만약 전체선택 체크박스가 체크 된 상태일 경우
    if ($("#allCheck").prop("checked")) {
        $("#list input[type=checkbox]").prop("checked", true);
    } else {
        $("#list input[type=checkbox]").prop("checked", false);
    }
}

//체크박스 선택시 value값 가져오는 함수
var getselectedNo = function() {

    var selectedValue = "";

    $("#list input[name=chk]:checked").each(function() {
        selectedValue += ","+ $(this).val();
    });

    if (selectedValue != "") {
        selectedValue = selectedValue.substring(1);
    }

    return selectedValue;
}

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(listSize, page) {

        var url = "/ajax/business/esti_list/load_esti_list.php";
        var blank = "<tr><td colspan=\"9\">검색 된 내용이 없습니다.</td></tr>";
        var data = {
            "search_cnd"  : $("#search_cnd").val(),
            "date_from"   : $("#date_from").val(),
            "date_to"     : $("#date_to").val(),
            "time_from"   : $("#time_from").val(),
            "time_to"     : $("#time_to").val()
        };
        var callback = function(result) {
            var rs = result.split("♪");
            if (rs[0].trim() == "") {
                $("#list").html(blank);
                return false;
            }
            $("#list").html(rs[0]);
            $("#page").html(rs[1]);
        };

        data.sell_site     = $("#sell_site").val();
        data.depar_code    = $("#depar_code").val();
        data.office_nick   = $("#office_nick").val();
        data.status        = $("#status").val();
        data.listSize      = listSize;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

/**
 * @brief 검색
 */
var searchEsti = function() {
    cndSearch.exec(30, 1);
}

/**
 * @brief 보여줄 페이지 수 설정
 */
var showPageSetting = function(val) {
    showPage = val;
    cndSearch.exec(val, 1);
}

/**
 * @brief 페이지 이동
 */
var movePage = function(val) {
    cndSearch.exec(showPage, val);
}

/**
 * @brief 견적삭제
 */
var quiescenceProc = function() {

    showMask();
    var seqno = getselectedNo();
    $.ajax({
        type: "POST",
        data: {"seqno":seqno},
        url: "/proc/business/esti_list/del_esti_list.php",
        success: function(result) {
            hideMask();
            if (result == 1) {
                cndSearch.exec(30, 1);
                $(".check_box").prop("checked", false);
                alert("선택하신 견적을 삭제하였습니다.");
            } else {
                alert("견적삭제를 실패하였습니다.");
            }
        }
    });
}

/**
 * @brief 견적관리
 */
var getEsti = {
    "exec"       : function(seqno) {

        var url = "/ajax/business/esti_list/load_esti_info.php";
        var data = {
            "seqno" : seqno
        };
        var callback = function(result) {
            hideMask();
            cndSearch.exec(30, 1);
            $("#esti_cont").html(result);
            $("#expec_order_date").datepicker({
                autoclose:true,
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                todayHighlight: true,
            });
        };

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}

/**
 * @brief 견적등록 정보 로우 추가
 */
var addInfoGroup = {
    "exec"       : function(el, dvs, idx) {

        var url = "/ajax/business/esti_list/load_add_info.php";
        var newIdx = Number(idx) + 1;
        var data = {
            "dvs" : dvs,
            "idx" : newIdx
        };

        if (dvs === "paper") {
            paperIdx = newIdx;
        } else if (dvs === "output") {
            outputIdx = newIdx;
        } else if (dvs === "print") {
            printIdx = newIdx;
        } else if (dvs === "after") {
            afterIdx = newIdx;
        } else if (dvs === "etc") {
            etcIdx = newIdx;
        }

        var callback = function(result) {

            hideMask();
            $("." + dvs + "_plus").hide();
            $("." + dvs + "_minus").show();
            $("." + dvs + "_plus" + newIdx).show();
            $("." + dvs + "_minus" + newIdx).hide();
            $("#" + el).append(result);
        };

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}

/**
 * @brief 견적등록 정보 로우 삭제
 */
var delInfoGroup = function(el) {

    $("#" + el).remove();
}

/**
 * @brief 견적등록 종이 옵션 세팅
 */
var setPaperOption = function(result, dvs, idx) {

    var rs = result.split("♪");
    if (dvs == "NAME") {
        $("#paper_name" + idx).html(rs[0]);
        $("#paper_dvs" + idx).html(rs[1]);
        $("#ppaper_minusaper_color" + idx).html(rs[2]);
        $("#paper_basisweight" + idx).html(rs[3]);
    } else if (dvs == "DVS") {
        $("#paper_dvs" + idx).html(rs[0]);
        $("#paper_color" + idx).html(rs[1]);
        $("#paper_basisweight" + idx).html(rs[2]);
    } else if (dvs == "COLOR") {
        $("#paper_color" + idx).html(rs[0]);
        $("#paper_basisweight" + idx).html(rs[1]);
    } else if (dvs == "BASISWEIGHT") {
        $("#paper_basisweight" + idx).html(rs[0]);
    }
}

/**
 * @brief 견적등록 출력 옵션 세팅
 */
var setOutputOption = function(result, dvs, idx) {

    var rs = result.split("♪");
    if (dvs == "BOARD") {
        $("#output_board" + idx).html(rs[0]);
        $("#output_size" + idx).html(rs[1]);
    } else if (dvs == "SIZE") {
        $("#output_size" + idx).html(rs[0]);
    }
}

/**
 * @brief 견적등록 인쇄 옵션 세팅
 */
var setPrintOption = function(result, dvs, idx) {

    var rs = result.split("♪");
    if (dvs == "NAME") {
        $("#print_name" + idx).html(rs[0]);
        $("#print_purp" + idx).html(rs[1]);
    } else if (dvs == "PURP") {
        $("#print_purp" + idx).html(rs[0]);
    }
}

/**
 * @brief 견적등록 옵션 html 세팅
 */
var setOption = function(cont) {

    return "<option value=\"\">" + cont + "</option>";
}

/**
 * @brief 견적등록 후공정 옵션 세팅
 */
var setAfterOption = function(result, dvs, idx) {

    if (checkBlank($("#after_name" + idx).val())) {
        $("#after_depth_one" + idx).html(setOption("Depth1"));
        $("#after_depth_two" + idx).html(setOption("Depth2"));
        $("#after_depth_thr" + idx).html(setOption("Depth3"));
        return false;
    }

    var rs = result.split("♪");
    if (dvs == "DEPTH1") {
        $("#after_depth_one" + idx).html(rs[0]);
    } else if (dvs == "DEPTH2") {
        $("#after_depth_two" + idx).html(rs[0]);
    } else if (dvs == "DEPTH3") {
        $("#after_depth_thr" + idx).html(rs[0]);
    }
}

/**
 * @brief 견적등록 옵션 세팅
 */
var selectOptionVal = {
    "exec"       : function(sort, dvs, idx) {

        var url = "/ajax/business/esti_list/load_" + sort + "_info.php";
        var data = {
            "dvs" : dvs
        };

        var callback = function(result) {
            hideMask();
            if (sort === "paper") {
                setPaperOption(result, dvs, idx);
            } else if (sort === "output") {
                setOutputOption(result, dvs, idx);
            } else if (sort === "print") {
                setPrintOption(result, dvs, idx);
            } else if (sort === "after") {
                setAfterOption(result, dvs, idx);
            }
        };

        if (sort === "paper") {
            data.paper_name = $("#paper_name" + idx).val();
            data.paper_dvs = $("#paper_dvs" + idx).val();
            data.paper_color = $("#paper_color" + idx).val();
        } else if (sort === "output") {
            data.output_name = $("#output_name" + idx).val();
            data.output_board = $("#output_board" + idx).val();
        } else if (sort === "print") {
            data.cate_sortcode = $("#cate_sortcode" + idx).val();
            data.print_name = $("#print_name" + idx).val();
        } else if (sort === "after") {
            data.after_name = $("#after_name" + idx).val();
            data.after_depth1 = $("#after_depth_one" + idx).val();
            data.after_depth2 = $("#after_depth_two" + idx).val();
        }

        showMask();
        ajaxCall(url, "html", data, callback);
    },
    "price" :  function(sort, idx) {
        var url = "/ajax/business/esti_list/load_" + sort + "_price_info.php";
        var data = {};

        var callback = function(result) {
            hideMask();
            if (!checkBlank(result)) {
                result = Number(result) * Number($("#" + sort + "_amt" + idx).val());
                $("#" + sort + "_price" + idx).val(result.format());
            } else {
                $("#" + sort + "_price" + idx).val("가격정보가 없음");
            }
        };

        if (sort == "paper") {
            data.paper_name = $("#paper_name" + idx).val();
            data.paper_dvs = $("#paper_dvs" + idx).val();
            data.paper_color = $("#paper_color" + idx).val();
            data.paper_basisweight = $("#paper_basisweight" + idx).val();
            data.paper_unit = $("#paper_unit" + idx).val();
        } else if (sort == "output") {
            data.output_name = $("#output_name" + idx).val();
            data.output_board = $("#output_board" + idx).val();
            data.output_size = $("#output_size" + idx).val();
        } else if (sort == "print") {
            data.cate_sortcode = $("#cate_sortcode" + idx).val();
            data.print_name = $("#print_name" + idx).val();
            data.print_purp = $("#print_purp" + idx).val();
            data.print_unit = $("#print_unit" + idx).val();
        } else if (sort === "after") {
            data.after_name = $("#after_name" + idx).val();
            data.after_depth1 = $("#after_depth_one" + idx).val();
            data.after_depth2 = $("#after_depth_two" + idx).val();
            data.after_depth3 = $("#after_depth_thr" + idx).val();
            data.after_unit = $("#after_unit" + idx).val();
        }

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}

/**
 * @brief 견적등록
 */
var regiEsti = function(seqno) {

	var etc_cont = "";

    showMask();
    var formData = new FormData();
    formData.append("seqno", seqno);
    formData.append("memo", $("#memo").val());
    formData.append("supply_price", $("#supply_price").val());
    formData.append("vat", $("#vat").val());
    formData.append("sale_price", $("#sale_price").val());
    formData.append("esti_price", $("#esti_price").val());
    formData.append("answ_cont", $("#answ_cont").val());

	//기타
    for (var i = 1; i <= etcIdx; i++) {
        if ($("#etc_cont" + i).val() != "") {
			if(etc_cont != "") {
				etc_cont = etc_cont +  "|" + $("#etc_cont" + i).val();
			} else {
				etc_cont = $("#etc_cont" + i).val();
			}
        }
    }

	formData.append("etc_cont", etc_cont);

    if (!checkBlank($("#upload_path").val())) {
        formData.append("upload_file", $("#upload_file")[0].files[0]);
        formData.append("upload_yn", "Y");
    } else {
        formData.append("upload_yn", "N");
    }
    formData.append("expec_order_date", $("#expec_order_date").val());

    $.ajax({
        type: "POST",
        data: formData,
        url: "/proc/business/esti_list/regi_esti_list.php",
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                cndSearch.exec(30, 1);
                $("#esti_cont_ctrl").remove();
                alert("견적을 등록하였습니다.");
            } else {
                alert("견적등록을 실패하였습니다.#esti_list.js");
            }
        },
        error    : getAjaxError
    });
}

//파일찾기
var fileSearchBtn = function(val) {
    return $("#upload_path").val(val);
}

//공급가액 구하는 함수
var getSupply = function() {

    var paper_price = 0;
    var output_price = 0;
    var print_price = 0;
    var after_price = 0;
    var etc_price = 0;
    var spc_pattern = /[^(가-힣ㄱ-ㅎㅏ-ㅣa-zA-Z0-9)]/gi;

    //종이가격
    for (var i = 1; i <= paperIdx; i++) {
        if ($("#paper_price" + i).val() != "가격정보가 없음") {
            paper_price = paper_price + Number($("#paper_price" + i).val().replace(spc_pattern, ""));
        }
    }
    //출력가격
    for (var i = 1; i <= outputIdx; i++) {
        if ($("#output_price" + i).val() != "가격정보가 없음") {
            output_price = output_price + Number($("#output_price" + i).val().replace(spc_pattern, ""));
        }
    }
    //인쇄가격
    for (var i = 1; i <= printIdx; i++) {
        if ($("#print_price" + i).val() != "가격정보가 없음") {
            print_price = print_price + Number($("#print_price" + i).val().replace(spc_pattern, ""));
        }
    }
    //후공정가격
    for (var i = 1; i <= afterIdx; i++) {
        if ($("#after_price" + i).val() != "가격정보가 없음") {
            after_price = after_price + Number($("#after_price" + i).val().replace(spc_pattern, ""));
        }
    }
    //기타가격
    for (var i = 1; i <= etcIdx; i++) {
        if ($("#etc_price" + i).val() != "가격정보가 없음") {
            etc_price = etc_price + Number($("#etc_price" + i).val().replace(spc_pattern, ""));
        }
    }

    var supply_price = paper_price + output_price + print_price + after_price + etc_price;
    var vat = supply_price / 10;
    var esti_price = supply_price + vat - $("#sale_price").val().replace(spc_pattern, "");
    $("#supply_price").val(supply_price.format());
    $("#vat").val(vat.format());
    $("#esti_price").val(esti_price.format());
}

//견적가액 구하는 함수
var getEstimated = function(event, el) {
    event = event || window.event;

    var val = "";
    var spc_pattern = /[^(가-힣ㄱ-ㅎㅏ-ㅣa-zA-Z0-9)]/gi;
    var keyID = (event.which) ? event.which : event.keyCode;
    if (keyID == 46 || keyID == 37 || keyID == 39) {
        return;
    } else {
        event.target.value = event.target.value.replace(/[^0-9]/g, "").format();
        val = Number($("#supply_price").val().replace(spc_pattern, ""))
            + Number($("#vat").val().replace(spc_pattern, ""))
            - Number(el.value.replace(spc_pattern, ""));
        val = val.format();

        $("#esti_price").val(val);
    }
}

//첨부파일 삭제
var delAdminEstiFile = {
    "exec"       : function(seqno) {

        var url = "/proc/business/esti_list/del_esti_file.php";
        var data = {"seqno":seqno};
        var callback = function(result) {
            hideMask();
            if (result == 1) {
                getEsti.exec(seqno);
                alert("견적첨부파일을 삭제하였습니다.");
            } else {
                alert("견적첨부파일 삭제를 실패하였습니다.");
            }
        };

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}
