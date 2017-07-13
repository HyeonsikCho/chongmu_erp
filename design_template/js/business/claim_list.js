/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/01/06 임종건 생성
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

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(listSize, page) {
        
        var url = "/ajax/business/claim_list/load_claim_list.php";
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
        data.claim_dvs     = $("#dvs").val();
        data.listSize      = listSize;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

/**
* @brief 검색
*/
var searchClaim = function() {
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
* @brief 클레임관리
*/
var getClaim = {
    "exec"       : function(seqno) {
        
        var url = "/ajax/business/claim_list/load_claim_info.php";
        var data = {
	        "seqno" : seqno
        };
        var callback = function(result) {
            hideMask();
            //cndSearch.exec(30, 1);
            var rs = result.split("♪");
            $("#claim_cont").html(rs[0]);
            $("#claim_dvs").val(rs[1]);
            $("#extnl_etprs").val(rs[2]);

            if (rs[3] === "Y") {
                $("#occur_price").attr("disabled", true);
                $("#occur_price").addClass("input_dis_co2");
                $("#occur_price").removeClass("input_co2");
                $("#refund_prepay").attr("disabled", true);
                $("#refund_prepay").addClass("input_dis_co2");
                $("#refund_prepay").removeClass("input_co2");
                $("#refund_money").attr("disabled", true);
                $("#refund_money").addClass("input_dis_co2");
                $("#refund_money").removeClass("input_co2");
                $("#cust_burden_price").attr("disabled", true);
                $("#cust_burden_price").addClass("input_dis_co2");
                $("#cust_burden_price").removeClass("input_co2");
                $("#extnl_etprs").attr("disabled", true);
                $("#extnl_etprs").addClass("input_dis_co2");
                $("#extnl_etprs").removeClass("input_co2");
                $("#outsource_burden_price").attr("disabled", true);
                $("#outsource_burden_price").addClass("input_dis_co2");
                $("#outsource_burden_price").removeClass("input_co2");
                $("#agree_btn").hide();
            }

            if (rs[4] === "Y") {
                $("#file_search").attr("disabled", true);
                $("#upload_file").attr("disabled", true);
                $("#count").attr("disabled", true);
                $("#count").addClass("input_dis_co2");
                $("#count").removeClass("input_co2");
                $("#order_btn").hide();
            }
        };

        showMask();
        ajaxCall(url, "html", data, callback);
    }
}

//클레임 처리
var procOrderClaim = {
     "save"       : function(seqno) {
        
        var url = "/proc/business/claim_list/regi_claim_save_info.php";
        var data = {"seqno":seqno};
        var callback = function(result) {
            hideMask();
            if (result == 1) {
	            getClaim.exec(seqno);
                alert("클레임 처리정보를 저장하였습니다.");
            } else {
                alert("클레임 처리정보를 저장실패하였습니다.");
            }
        };

        data.dvs = $("#claim_dvs").val();
        data.dvs_detail = $("#dvs_detail").val();
        data.mng_cont = $("#mng_cont").val();
        showMask();
        ajaxCall(url, "html", data, callback);
    },
     "agree"       : function(seqno) {
        
        var url = "/proc/business/claim_list/regi_claim_agree_info.php";
        var data = {"seqno":seqno};
        var callback = function(result) {
            hideMask();
            if (result == 1) {
	            getClaim.exec(seqno);
                alert("합의 하였습니다.");
            } else {
                alert("합의를 실패하였습니다.");
            }
        };

        if (checkBlank($("#occur_price").val())) {
            alert("발생비용이 빈값입니다.");
            $("#occur_price").focus();
            return false;
        }
        if (checkBlank($("#refund_prepay").val())) {
            alert("환불금액 선입금이 빈값입니다.");
            $("#refund_prepay").focus();
            return false;
        }
        if (checkBlank($("#refund_money").val())) {
            alert("환불금액 현금이 빈값입니다.");
            $("#refund_money").focus();
            return false;
        }
        if (checkBlank($("#cust_burden_price").val())) {
            alert("고객부담금이 빈값입니다.");
            $("#cust_burden_price").focus();
            return false;
        }
        if (checkBlank($("#extnl_etprs").val())) {
            alert("클레임처를 선택 해주세요.");
            $("#extnl_etprs").focus();
            return false;
        }
        if (checkBlank($("#outsource_burden_price").val())) {
            alert("클레임처 금액이 빈값입니다.");
            $("#outsource_burden_price").focus();
            return false;
        }

        data.occur_price = $("#occur_price").val();
        data.refund_prepay = $("#refund_prepay").val();
        data.refund_money = $("#refund_money").val();
        data.cust_burden_price = $("#cust_burden_price").val();
        data.extnl_etprs = $("#extnl_etprs").val();
        data.outsource_burden_price = $("#outsource_burden_price").val();

        showMask();
        ajaxCall(url, "html", data, callback);
    },
     "order"       : function(seqno) {
        
        var formData = new FormData();
        var url = "/proc/business/claim_list/regi_claim_order_info.php";
        var data = formData;
        if (checkBlank($("#upload_path").val())) {
            alert("첨부된 파일이 없습니다.");
            $("#upload_path").focus();
            return false;
        }
        if (checkBlank($("#count").val())) {
            alert("건수가 빈값입니다.");
            $("#count").focus();
            return false;
        }

        formData.append("seqno", seqno);
        formData.append("count", $("#count").val());
        formData.append("upload_file", $("#upload_file")[0].files[0]);
        showMask();
         
        $.ajax({
        type: "POST",
        data: data,
        url: url,
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
	            getClaim.exec(seqno);
                alert("주문을 하였습니다.");
            } else {
                alert("주문을 실패하였습니다.");
            }
        },
        error    : getAjaxError   
    });

    }
}

//파일찾기 
var fileSearchBtn = function(val) {
    return $("#upload_path").val(val);
}
