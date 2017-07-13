/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2016/01/12 임종건 생성
 *=============================================================================
 *
 */

$(document).ready(function() {
    cndSearch.exec(30, 1);
});

//보여줄 페이지 수
var showPage = "";
var showPopPage = "";

//접수창 left 크기
var popLeftSize = "";

/**
 * @brief 선택조건으로 검색 클릭시
 */
var cndSearch = {
    "exec"       : function(showPage, page) {
        
        var url = "/ajax/produce/receipt_list/load_receipt_list.php";
        var blank = "<tr><td colspan=\"13\">검색 된 내용이 없습니다.</td></tr>";
        var data = {
    	    "search_cnd"  : $("#search_cnd").val(),
    	    "search_txt"  : $("#search_txt").val(),
    	    "search_cnd2" : $("#search_cnd2").val(),
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

        data.depar_code    = $("#depar_code").val();
        data.cate_sortcode = $("#cate_bot").val();
        data.order_state   = $("#order_state").val();
        data.showPage      = showPage;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    },
    "pop"       : function(showPage, page) {
        
        var url = "/ajax/produce/receipt_list/load_status_receipt_list.php";
        var blank = "<tr><td colspan=\"13\">검색 된 내용이 없습니다.</td></tr>";
        var data = {
    	    "search_txt"  : $("#pop_search_txt").val()
	    };
        var callback = function(result) {
            showBgMask();
            var rs = result.split("♪");
            if (rs[0].trim() == "") {
                $("#pop_list").html(blank);
                return false;
            }
            $("#pop_list").html(rs[0]);
            $("#pop_page").html(rs[1]);
        };

        data.order_state   = $("#pop_order_state").val();
        data.showPage      = showPage;
        data.page          = page;

        showMask();
        ajaxCall(url, "html", data, callback);
    }
};

//보여줄 페이지 수 설정
var showPageSetting = function(val, dvs) {
    if (dvs === "nomal") {
        showPage = val;
        cndSearch.exec(val, 1);
    } else if (dvs === "pop") {
        showPopPage = val;
        cndSearch.pop(val, 1);
    }
}

//페이지 이동
var movePage = function(val) {
    cndSearch.exec(showPage, val);
}

//페이지 이동
var movePopPage = function(val) {
    cndSearch.pop(showPopPage, val);
}

//팀변경 시
var changeDeparCode = function() {
    cndSearch.exec(30, 1);
}

//상세검색
var searchReceipt = function() {
    cndSearch.exec(30, 1);
}

//검색 인푹 초기화
var changeSearchCnd = function() {
    $("#search_txt").val("");
}

//상태변경관리
var showStatusMng = function() {
 
    showMask();
    var url = "/ajax/produce/receipt_list/load_status_popup.php";
    var data = {};
    var callback = function(result) {
        openRegiPopup(result, 800);
    }

    ajaxCall(url, "html", data, callback);
}

//상태변경관리 리스트 상태 변경
var changeStatus = function(seqno, state, pop_yn) {
 
    showMask();
    var url = "/proc/produce/receipt_list/modi_status.php";
    var data = {
        "seqno" : seqno,
        "state" : state
    };
    var callback = function(result) {
        if (result == 1) {
	    if (pop_yn === "Y") {
                hideRegiPopup();
                hidePopPopup();
                cndSearch.exec(30, 1);
	    } else {
                cndSearch.pop(30, 1);
	    }
            alert("상태가 변경되었습니다.");
        } else {
            alert("상태변경을 실패하였습니다.");
        }
    }

    ajaxCall(url, "html", data, callback);
}

//상태변경관리 리스트 상태콤보박스 바뀔시
var changeStatusOption = function() {
    cndSearch.pop(30, 1);
}

//검색어 검색 엔터
var searchKey = function(event) {

    if (event.keyCode == 13) {
        cndSearch.pop(30, 1);
    }
}

//검색어 검색 버튼
var searchText = function() {
    cndSearch.pop(30, 1);
}

//접수 팝업
var showReceiptPop = function(seqno, state) {

    showMask();
    var url = "/ajax/produce/receipt_list/load_receipt_popup.php";
    var data = {
        "seqno" : seqno,
        "state" : state
    };
    var callback = function(result) {
        openRegiPopup(result, 650);
        popLeftSize = $("#regi_popup").css("left");
    }

    ajaxCall(url, "html", data, callback);
}

//접수 상태 대기로 변경
var changeReceiptStandbyState = function(seqno) {
    var url = "/proc/produce/receipt_list/modi_receipt_standby.php";
    var data = {
        "seqno" : seqno
    };
    var callback = function(result) {
        if (result == 1) {
            hideRegiPopup();
            hidePopPopup();
        } else {
            alert("상태변경을 실패 하였습니다.");
        }
    }
    ajaxCall(url, "html", data, callback);
}

//접수창 닫기
var hideReceiptPopup = function(seqno) {
    changeReceiptStandbyState(seqno);
}

//추가 후공정 순서 변경 - 위로
var getSeqUp = function(seqno, seq) {
    //showMask();
    var url = "/proc/produce/receipt_list/modi_after_sequp.php";
    var data = {
        "seqno" : seqno,
        "seq"   : seq
    };
    var callback = function(result) {
        showBgMask();
        if (result == 1) {
            getAfterInfo(seqno);
        } else {
            alert("변경을 실패 하였습니다.");
        }
    }
    ajaxCall(url, "html", data, callback);
}

//추가 후공정 순서 변경 - 아래로
var getSeqDown = function(seqno, seq) {
    //showMask();
    var url = "/proc/produce/receipt_list/modi_after_seqdown.php";
    var data = {
        "seqno" : seqno,
        "seq"   : seq
    };
    var callback = function(result) {
        showBgMask();
        if (result == 1) {
            getAfterInfo(seqno);
        } else {
            alert("변경을 실패 하였습니다.");
        }
    }
    ajaxCall(url, "html", data, callback);
}

//추가 후공정 정보
var getAfterInfo = function(seqno) {
    //showMask();
    var url = "/ajax/produce/receipt_list/load_after_info.php";
    var data = {
        "seqno" : seqno
    };
    var callback = function(result) {
        $("#after_info").html(result);
        showBgMask();
    }
    ajaxCall(url, "html", data, callback);
}

//추가 후공정 정보 등록 팝업 오픈
var getAfterPop = function(seqno, after_seqno) {
 
    showMask();
    var url = "/ajax/produce/receipt_list/load_add_after_popup.php";
    var data = {
        "seqno"       : seqno,
        "after_seqno" : after_seqno
    };
    var callback = function(result) {
        var width  = $(window).width();
        openPopPopup(result, 550);
        $("#regi_popup").css({left: width/6 + "px"});
        $("#pop_popup").css({left : width/1.8 + "px"});
    }

    ajaxCall(url, "html", data, callback);
}

//추가 후공정 정보 팝업창 닫기
var hideAddAfterPopup = function() {
    hidePopPopup();
    $("#regi_popup").css({left: popLeftSize});
}

//접수 - 업로더를 제외하고 개발
var getReceipt = function(seqno) {

    showMask();
    var formData = new FormData();
    formData.append("seqno", seqno);
   // formData.append("upload_file", $("#upload_file")[0].files[0]);

    $.ajax({
        type: "POST",
        data: formData,
        url: "/proc/produce/receipt_list/regi_receipt.php",
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                hideRegiPopup();
                hidePopPopup();
                cndSearch.exec(30, 1);
                alert("접수 되었습니다.");
            } else {
                alert("접수를 실패하였습니다.");
            }
        },
        error    : getAjaxError   
    });
}

//주문삭제(취소)
var delOrder = function(seqno) {

    showMask();
    var url = "/proc/produce/receipt_list/del_order.php";
    var data = {
        "seqno"       : seqno
    };
    var callback = function(result) {
        if (result == 1) {
            hideReceiptPopup();
            cndSearch.exec(30, 1);
            alert("주문을 취소 하였습니다.");
        } else {
            alert("주문취소를 실패하였습니다.");
        }
    }

    ajaxCall(url, "html", data, callback);
}

//후공정 발주(생산지시서)  저장
var saveAfterOp = function() {

    showMask();
    var formData = new FormData();
    formData.append("order_common_seqno", $("#order_common_seqno").val());
    formData.append("after_seqno", $("#after_seqno").val());
    formData.append("title", $("#title").val());
    formData.append("after_name", $("#after_name").val());
    formData.append("amt", $("#amt").val());
    formData.append("amt_unit_dvs", $("#amt_unit_dvs").val());
    formData.append("extnl_etprs_seqno", $("#extnl_etprs_seqno").val());
    formData.append("memo", $("#memo").val());
    formData.append("seq", $("#seq").val());
    formData.append("op_typ", $("#op_typ").val());
    formData.append("op_typ_detail", $("#op_typ_detail").val());
    formData.append("upload_file", $("#upload_file")[0].files[0]);

    $.ajax({
        type: "POST",
        data: formData,
        url: "/proc/produce/receipt_list/regi_after_op.php",
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                alert("저장 되었습니다.");
            } else {
                alert("저장을 실패하였습니다.");
            }
        },
        error    : getAjaxError   
    });
}

//파일찾기 
var fileSearchBtn = function(val) {
    return $("#upload_path").val(val);
}
