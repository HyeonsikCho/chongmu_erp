/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/11/27 엄준현 수정(카테고리 선택 여기로 이동)
 * 2015/11/27 엄준현 수정(카테고리 선택 삭제, 엑셀 업로드 이동)
 * 2016/01/13 임종건 수정(매입품에 해당하는 매입업체 이동)
 *=============================================================================
 *
 */

/**
 * @brief 엑셀 업로드 공통처리 ajax 함수
 *
 * @param data = multipart form 데이터
 */
var excelUploadAjax = function(data) {
    $.ajax({
        type        : "POST",
        data        : data,
        url         : "/proc/basic_mng/common/excel_upload.php",
        dataType    : "text",
        processData : false,
        contentType : false,
        success     : function(data) {
            hideMask();

            data = data.trim();

            if (data !== "TRUE") {
                alert(data);
            }
        },
        error    : getAjaxError   
    });
};

//매입품에 해당하는 매입업체 가져오기
var loadExtnlEtprs = function(val, el) {

    $.ajax({
        type: "POST",
        data: {"val" : val},
        url: "/ajax/basic_mng/pur_etprs_list/load_extnl_etprs.php",
        success: function(result) {
            $("#" + el).html(result);
        }, 
        error: getAjaxError
    });
}
