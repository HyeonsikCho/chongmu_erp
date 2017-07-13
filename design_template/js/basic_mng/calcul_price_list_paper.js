/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/02 엄준현 생성(종이 탭 관련내용 추가)
 *=============================================================================
 *
 */

/**
 * @brief 카테고리 선택시 하위 카테고리 정보 검색
 *
 * @param paperType = 종이 선택 구분(SORT, NAME, DVS, COLOR)
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

        var url = "/json/basic_mng/calcul_price_list/load_paper_info.php";
        var data = {
            "type"        : paperType,
            "paper_sort"  : $("#paper_sort").val(),
            "paper_name"  : $("#paper_name").val(),
            "paper_dvs"   : $("#paper_dvs").val(),
            "paper_color" : $("#paper_color").val()
        };

        var callback = function(result) {
            if (paperSelect.type === "SORT") {
                $("#paper_name").html(result.name);
                $("#paper_dvs").html(result.dvs);
                $("#paper_color").html(result.color);
                $("#paper_basisweight").html(result.basisweight);
            }else if (paperSelect.type === "NAME") {
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

/**
 * @brief 종이 계열 선택시 사이즈 검색
 *
 * @param obj = 체크박스 객체
 * @param dvs = 클릭한 체크박스 구분
 */
var clickPaperAffil = {
    "affil" : {
        "46"  : false,
        "GUK" : false
    },
    "exec" : function(obj, dvs) {
        if($(obj).prop("checked")) {
            this.affil[dvs] = true;
        } else {
            this.affil[dvs] = false;
        }

        var url = "/ajax/basic_mng/calcul_price_list/load_paper_size.php";
        var callback = function(result) {
            $("#paper_size").html(result);
        };

        ajaxCall(url, "html", this.affil, callback);
    }
};

/**
 * @brief 종이 맵핑코드 검색어 생성
 */
var makePaperSearch = function() {
    var paperSort        = $("#paper_sort").val();
    var paperName        = $("#paper_name").val();
    var paperDvs         = $("#paper_dvs").val();
    var paperColor       = $("#paper_color").val();
    var paperBasisweight = $("#paper_basisweight").val();

    //var ret = paperSort + '|' + paperName;
    var ret = paperName;

    if (checkBlank(paperDvs) === false) {
        ret += '|' + paperDvs;
    }
    if (checkBlank(paperColor) === false) {
        ret += '|' + paperColor;
    }
    if (checkBlank(paperBasisweight) === false) {
        ret += '|' + paperBasisweight;
    }

    return ret;
};
