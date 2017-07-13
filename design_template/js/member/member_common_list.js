/*
 *
 * Copyright (c) 2015 Nexmotion, Inc.
 * All rights reserved.
 * 
 * REVISION HISTORY (reverse chronological order)
 *=============================================================================
 * 2015/12/04 임종건 생성
 * 2015/12/08 임종건 기본정보 관련 함수 추가
 * 2015/12/09 임종건 요약정보 관련 함수 추가
 * 2015/12/10 임종건 회원정보 관련 함수 추가
 * 2015/12/11 임종건 정산 관련 함수 추가
 * 2015/12/15 임종건 추가회원정보 관련 함수 추가
 * 2015/12/17 임종건 배송관리 관련 함수 추가
 * 2015/12/20 임종건 매출정보 관련 함수 추가
 * 2015/12/21 임종건 등급 관련 함수 추가
 * 2015/12/22 임종건 포인트 관련 함수 추가
 * 2015/12/22 임종건 쿠폰 관련 함수 추가
 * 2015/12/22 임종건 이벤트 관련 함수 추가
 *=============================================================================
 *
 */

//회원 일련번호
var memberSeqno = "";
//보여줄 페이지 수
var showPage = "";
//회원 상세정보 리스트 보여줄 페이지 수
var detailShowPage = "";
//회원 상세정보 리스트 검색어
var detailSearchTxt = "";

//선택된 탭
var selectTab = "summary";

$(document).ready(function() {
    loadDeparInfo();
    memberListAjaxCall(30, 1);
});

//회원 리스트 호출
var memberListAjaxCall = function(sPage, page) {
 
    showMask();

    var data = {
    	"sell_site"   : $("#sell_site").val(),
    	"depar_code"  : $("#depar_code").val(),
    	"office_nick" : $("#office_nick").val(),
    	"search_cnd"  : $("#search_cnd").val(),
    	"date_from"   : $("#date_from").val(),
    	"date_to"     : $("#date_to").val(),
    	"time_from"   : $("#time_from").val(),
    	"time_to"     : $("#time_to").val(),
    	"grade"       : $("#grade").val(),
    	"member_typ"  : $("#member_typ").val(),
    	"showPage"    : sPage,
    	"page"        : page
    };

    var url = "/ajax/member/member_common_list/load_member_common_list.php";

    var blank = "<tr><td colspan=\"11\">검색 된 내용이 없습니다.</td></tr>";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {

            hideMask();
            var rs = result.split("♪");

            if (rs[0].trim() == "") {
                $("#member_list").html(blank);
            } else {
                $("#member_list").html(rs[0]);
            }

            $("#member_page").html(rs[1]);
        }   
    });
}

//회원 검색
var searchMember = function() {
    memberListAjaxCall(30, 1);
}

//페이지 이동
var movePage = function(val) {
    memberListAjaxCall(showPage, val);
}

//보여줄 페이지 수 설정
var showPageSetting = function(val) {
    showPage = val;
    memberListAjaxCall(val, 1);
}

// 회원 상세호출
var memberDetailAjaxCall = function(seqno, dvs) {

    showMask();

    var data = {
    	"seqno"      : seqno,
    	"dvs"        : dvs
    };
    var url = "/ajax/member/member_common_list/load_member_detail_" + dvs + "_info.php";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
            hideMask();
            var rs = result.split("♪");
	        $("#member_" + dvs + "_info").html(rs[0]);

            //기본정보
            if (dvs == "common") {
                $("#member_dvs").val(rs[1]);
                $("input:radio[name='new_yn']:radio[value='" + rs[2] + "']").attr("checked",true);
                $("input:radio[name='member_typ']:radio[value='" + rs[3] + "']").attr("checked",true);
		
                if (rs[3] == "예외업체") {
                    $("#oa").show();
                } else {
                    $("#oa").hide();
                }

                $("input:radio[name='onefile_etprs_yn']:radio[value='" + rs[4] + "']").attr("checked",true);
                $("input:radio[name='card_pay_yn']:radio[value='" + rs[5] + "']").attr("checked",true);

            //요약정보
            } else if (dvs == "summary") {
                $("#member_summary_info input:radio[name='mailing_yn']:radio[value='" + rs[1] + "']").attr("checked",true);
                $("#member_summary_info input:radio[name='sms_yn']:radio[value='" + rs[2] + "']").attr("checked",true);

            //회원정보
            } else if (dvs == "detail") {
                if (rs[1] == "기업") {
                   $("#licensee_info").show();
                   $("#mng_info").show();
                   $("#accting_mng").show();
                   $("#admin_licenseeregi").show();
                } else {
                   $("#licensee_info").hide();
                   $("#mng_info").hide();
                   $("#accting_mng").hide();
                   $("#admin_licenseeregi").hide();
                }
                
                $("#member_detail_info input:radio[name='mailing_yn']:radio[value='" + rs[2] + "']").attr("checked",true);
                $("#member_detail_info input:radio[name='sms_yn']:radio[value='" + rs[3] + "']").attr("checked",true);
                $("#biz_resp").val(rs[4]);
                $("#release_resp").val(rs[5]);
                $("#dlvr_resp").val(rs[6]);
                $("#tel_num1").val(rs[7]);
                $("#member_detail_info input:radio[name='certi_yn']:radio[value='" + rs[8] + "']").attr("checked",true);
                if (rs[8] == "Y") {
                    $("#certi_info").show();
                } else {
                    $("#certi_info").hide();
                }
                if (!checkBlank(rs[9])) {
                    $("#gene_resp").val(rs[9]);
		    var tmp = new Array();
		    tmp[0] = rs[10];
		    tmp[1] = rs[11];
		    tmp[2] = rs[12];
                    selectBizResp(rs[9], rs[17], "gene", tmp);
                }
                if (!checkBlank(rs[13])) {
                    $("#busi_resp").val(rs[13]);
		    var tmp = new Array();
		    tmp[0] = rs[14];
		    tmp[1] = rs[15];
		    tmp[2] = rs[16];
                    selectBizResp(rs[13], rs[17], "busi", tmp);
                }
  
            //추가회원정보
            } else if (dvs == "add") {
                $("#member_add_info input:radio[name='wd_yn']:radio[value='" + rs[1] + "']").attr("checked",true);

                if (rs[1] == "Y") {
                    $("#wd_anniv_info").show();
                } else {
                    $("#wd_anniv_info").hide();
                }

                if (!checkBlank(rs[2])) {
                    $("#occu1").val(rs[2]);
                }

                if (!checkBlank(rs[3])) {
                    $("#occu2").val(rs[3]);
                }

                if (!checkBlank(rs[4])) {
                    $("#interest_field1").val(rs[4]);
                }

                if (!checkBlank(rs[5])) {
                    $("#interest_field2").val(rs[5]);
                }

                for (var i = 1; i <= 12; i++) {
                    j = i + 5;
                    if (rs[j] == "Y") {
                        $("input:checkbox[id='inter_prdt" + i + "']").attr("checked", true);
                    }
                }

                for (var i = 1; i <= 6; i++) {
                    j = i + 17;
                    if (rs[j] == "Y") {
                        $("input:checkbox[id='inter_event" + i + "']").attr("checked", true);
                    }
                }
              
                if (rs[24] == "Y") {
                    $("input:checkbox[id='inter_design" + i + "']").attr("checked", true);
                }

                for (var i = 1; i <= 10; i++) {
                    j = i + 24;
                    if (rs[j] == "Y") {
                        $("input:checkbox[id='inter_needs" + i + "']").attr("checked", true);
                    }
                }

                $("#member_add_info input:radio[name='design_yn']:radio[value='" + rs[35] + "']").attr("checked",true);
                $("#member_add_info input:radio[name='produce_yn']:radio[value='" + rs[36] + "']").attr("checked",true);
                $("#member_add_info input:radio[name='use_pro']:radio[value='" + rs[37] + "']").attr("checked",true);

                if (!checkBlank(rs[38])) {
                    $("#interest_item1").val(rs[38]);
                }

                if (!checkBlank(rs[39])) {
                    $("#interest_item2").val(rs[39]);
                }

                $("#member_add_info input:radio[name='interest_prior']:radio[value='" + rs[40] + "']").attr("checked",true);
                $("#member_add_info input:radio[name='plural_deal_yn']:radio[value='" + rs[41] + "']").attr("checked",true);
                if (rs[41] == "Y") {
                    $("#plural_deal_info").show();
                } else {
                    $("#plural_deal_info").hide();
                }

                if (!checkBlank(rs[42])) {
                    $("#plural_deal_site_name1").val(rs[42]);
                }
                if (!checkBlank(rs[43])) {
                    $("#plural_deal_site_name2").val(rs[43]);
                }

                $('#wd_anniv').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true
                }); 
            
            //배송관리  
            } else if (dvs == "dlvr") {
                $("#member_dlvr_info input:radio[name='fr_send']:radio[value='" + rs[1] + "']").attr("checked",true);
                $("#member_dlvr_info input:radio[name='fr_send_sm']:radio[value='" + rs[2] + "']").attr("checked",true);

            //매출정보
            } else if (dvs == "sales") {
                $('#date_sales_from').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });   

                $('#date_sales_to').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });
                
                detailListAjaxCall(dvs, "", 30, 1, "");

            //등급
            } else if (dvs == "grade") {

            //포인트
            } else if (dvs == "point") {
                $('#date_point_from').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });   

                $('#date_point_to').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });

                memberPointReqListAjaxCall(30, 1);
                detailListAjaxCall(dvs, "", 30, 1, "");
            
            //쿠폰
            } else if (dvs == "coupon") {
                $('#date_coupon_from').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });   

                $('#date_coupon_to').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });
                
                detailListAjaxCall(dvs, "", 30, 1, "");

            //이벤트
            } else if (dvs == "event") {
                $('#date_event_from').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });   

                $('#date_event_to').datepicker({
                    autoclose:true,
                    format: "yyyy-mm-dd",
                    todayBtn: "linked",
                    todayHighlight: true,
                });
            
                detailListAjaxCall(dvs, "", 30, 1, "");
            } 
        }   
    });
}

//회원 상세보기
var showDetail = function(seqno) {
    memberSeqno = seqno;
    $("#member_info").show();
    memberDetailAjaxCall(seqno, "common");
    detailTabCtrl(selectTab);
}

//탭 초기화
var init = function() {
    detailShowPage = "";
    detailSearchTxt = "";
    $("select[name=detail_list_set]").val("30");
}

/*
 * 회원 상세탭 제어
 */
var detailTabCtrl = function(dvs) {
    init();
    selectTab = dvs;
    memberDetailAjaxCall(memberSeqno, dvs);
}

//업체구분 선택시
var selectMemberTyp = function(val) {

    if (val == "예외업체") {
        $("#oa").show();
    } else {
        $("#oa").hide();
    }
}

//인증절차 유무
var certiCtrl = function(val) {

    if (val == "Y") {
        $("#certi_info").show();
    } else {
        $("#certi_info").hide();
    }
}

//결혼 유무
var wdCtrl = function(val) {

    if (val == "Y") {
        $("#wd_anniv_info").show();
    } else {
        $("#wd_anniv_info").hide();
    }
}

//복수거래 유무
var dealCtrl = function(val) {

    if (val == "Y") {
        $("#plural_deal_info").show();
    } else {
        $("#plural_deal_info").hide();
    }
}

//기본정보 저장
var saveBasicInfo = function(seqno) {

    showMask();

    if (emailCheck($("#mail").val()) == false) {
	alert("이메일 형식이 올바르지 않습니다.");
        return false;
    }

    var data = {
    	"seqno"        : seqno,
    	"member_dvs"   : $("#member_dvs").val(),
        "cell_num"     : $("#cell_num").val(),	
        "mail"         : $("#mail").val(),	
        "birth"        : $("#birth").val()
    };

    data.member_typ = $(':radio[name="member_typ"]:checked').val();
    data.onefile_etprs_yn = $(':radio[name="onefile_etprs_yn"]:checked').val();
    data.card_pay_yn = $(':radio[name="card_pay_yn"]:checked').val();

    if ($(':radio[name="member_typ"]:checked').val() == "예외업체") {
        data.fix_oa = $("#fix_oa").val();
        data.bad_oa = $("#bad_oa").val();
        data.loan_limit_price = $("#loan_limit_price").val();
    }

    var url = "/proc/member/member_common_list/modi_member_basic_info.php";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
	
            hideMask();
            if (result == 1) {
                memberDetailAjaxCall(seqno, "common");
                detailTabCtrl(selectTab);
                alert("수정 되었습니다.");
            } else {
                alert("수정을 실패하였습니다.");
            }
        }   
    });
}

//파일찾기 
var fileSearchBtn = function(val, dvs) {
    return $("#" + dvs + "_path").val(val);
}

//회원정보 저장
var saveMemberDetailInfo = function(seqno, dvs) {

    showMask();
    var formData = new FormData();
    formData.append("seqno", seqno);

    //회원 기본정보
    if (dvs == "basic") {
        formData.append("nick", $("#nick").val());
        formData.append("mailing_yn", $(':radio[name="mailing_yn"]:checked').val());
        formData.append("sms_yn", $(':radio[name="sms_yn"]:checked').val());

        if ($(':radio[name="certi_yn"]:checked').val() == "Y") {
            formData.append("certi_yn", "Y");
            formData.append("certinum", $("#certinum").val());
            formData.append("file_img", $("#file_img")[0].files[0]);

            if (checkBlank($("#file_img")[0].files[0])) {
                formData.append("certi_upload_yn", "N");
            } else {
                formData.append("certi_upload_yn", "Y");
            }
        } else {
            formData.append("certi_yn", "N");
        }
        formData.append("eval_reason", $("#eval_reason").val());
        formData.append("biz_resp", $("#biz_resp").val());
        formData.append("release_resp", $("#release_resp").val());
        formData.append("dlvr_resp", $("#dlvr_resp").val());
        formData.append("gene_resp", $("#gene_resp").val());
        formData.append("gene_tel_receipt_mng", $("#gene_tel_receipt_mng").val());
        formData.append("gene_ibm_receipt_mng", $("#gene_ibm_receipt_mng").val());
        formData.append("gene_mac_receipt_mng", $("#gene_mac_receipt_mng").val());
        formData.append("busi_resp", $("#busi_resp").val());
        formData.append("busi_tel_receipt_mng", $("#busi_tel_receipt_mng").val());
        formData.append("busi_ibm_receipt_mng", $("#busi_ibm_receipt_mng").val());
        formData.append("busi_mac_receipt_mng", $("#busi_mac_receipt_mng").val());

    //현금 영수증
    } else if (dvs == "cashreceipt") {
        formData.append("cashreceipt_card_num", $("#cashreceipt_card_num").val());

    //사업자 정보
    } else if (dvs == "licensee") {
        formData.append("crn", $("#crn").val());
        formData.append("repre_name", $("#repre_name").val());
        formData.append("bc", $("#bc").val());
        formData.append("tob", $("#tob").val());
        formData.append("tel_num1", $("#tel_num1").val());
        formData.append("tel_num2", $("#tel_num2").val());
        formData.append("tel_num3", $("#tel_num3").val());
        formData.append("zipcode", $("#zipcode").val());
        formData.append("addr", $("#addr").val());
        formData.append("addr_detail", $("#addr_detail").val());
    }
    $.ajax({
        type: "POST",
        data: formData,
        url: "/proc/member/member_common_list/modi_member_detail_" + dvs + "_info.php",
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                detailTabCtrl(selectTab);
                alert("수정 되었습니다.");
            } else {
                alert("수정을 실패하였습니다.");
            }
        },
        error    : getAjaxError   
    });
}

//주소지 등록
var getAddrInfo = function(str) {
 
    hideRegiPopup();
    
    var zipcode =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#zipcode").val(zipcode);
    $("#addr").val(addr);
    $("#addr_detail").focus();
}

//영업팀 변경시
var selectBizResp = function(val, sell_site, el, rs) {
 
    showMask();
    var url = "/ajax/member/member_common_list/load_office_member_mng.php";
    var data = {
        "depar_code" : val,
        "sell_site"  : sell_site
    };

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
  
            hideMask();
	    $("#" + el + "_tel_receipt_mng").html(result);
	    $("#" + el + "_ibm_receipt_mng").html(result);
	    $("#" + el + "_mac_receipt_mng").html(result);

	    if (!checkBlank(rs)) {
                $("#" + el + "_tel_receipt_mng").val(rs[0]);
                $("#" + el + "_ibm_receipt_mng").val(rs[1]);
                $("#" + el + "_mac_receipt_mng").val(rs[2]);
	    }
        },
        error: getAjaxError 
    });
}

//체크박스 value 설정
var interValue = function(id) {

    if ($("input:checkbox[id='" + id + "']").is(":checked") == true) {
        return "Y";
    } else {
        return "N";
    }
}

//추가회원정보 저장
var saveMemberAddInfo = function(seqno) {

    showMask();
    var data = {
        "seqno"                   : seqno,
        "wd_yn"                   : $(':radio[name="wd_yn"]:checked').val(),
        "wd_anniv"                : $("#wd_anniv").val(),
        "occu1"                   : $("#occu1").val(),
        "occu2"                   : $("#occu2").val(),
        "occu_detail"             : $("#occu_detail").val(),
        "interest_field1"         : $("#interest_field1").val(),
        "interest_field2"         : $("#interest_field2").val(),
        "interest_field_detail"   : $("#interest_field_detail").val(),
        "design_yn"               : $(':radio[name="design_yn"]:checked').val(),
        "produce_yn"              : $(':radio[name="produce_yn"]:checked').val(),
        "use_pro"                 : $(':radio[name="use_pro"]:checked').val(),
        "interest_item1"          : $("#interest_item1").val(),
        "interest_item2"          : $("#interest_item2").val(),
        "interest_item_detail"    : $("#interest_item_detail").val(),
        "interest_prior"          : $(':radio[name="interest_prior"]:checked').val(),
        "plural_deal_yn"          : $(':radio[name="plural_deal_yn"]:checked').val(),
        "recomm_id"               : $("#recomm_id").val(),
        "recomm_id_detail"        : $("#recomm_id_detail").val(),
        "memo"                    : $("#memo").val()
    };

    if ($(':radio[name="wd_yn"]:checked').val() == "N") {
        data.wd_anniv = "";
    } else {
        data.wd_anniv = $("#wd_anniv").val();
    }

    if ($(':radio[name="plural_deal_yn"]:checked').val() == "N") {
        data.plural_deal_site_name1 = "";
        data.plural_deal_site_detail1 = "";
        data.plural_deal_site_name2 = "";
        data.plural_deal_site_detail2 = "";
    } else {
        data.plural_deal_site_name1 = $("#plural_deal_site_name1").val();
        data.plural_deal_site_detail1 = $("#plural_deal_site_detail1").val();
        data.plural_deal_site_name2 = $("#plural_deal_site_name2").val();
        data.plural_deal_site_detail2 = $("#plural_deal_site_detail2").val();
    }

    data.inter_prdt1 = interValue("inter_prdt1");
    data.inter_prdt2 = interValue("inter_prdt2");
    data.inter_prdt3 = interValue("inter_prdt3");
    data.inter_prdt4 = interValue("inter_prdt4");
    data.inter_prdt5 = interValue("inter_prdt5");
    data.inter_prdt6 = interValue("inter_prdt6");
    data.inter_prdt7 = interValue("inter_prdt7");
    data.inter_prdt8 = interValue("inter_prdt8");
    data.inter_prdt9 = interValue("inter_prdt9");
    data.inter_prdt10 = interValue("inter_prdt10");
    data.inter_prdt11 = interValue("inter_prdt11");
    data.inter_prdt12 = interValue("inter_prdt12");

    data.inter_event1 = interValue("inter_event1");
    data.inter_event2 = interValue("inter_event2");
    data.inter_event3 = interValue("inter_event3");
    data.inter_event4 = interValue("inter_event4");
    data.inter_event5 = interValue("inter_event5");
    data.inter_event6 = interValue("inter_event6");

    data.inter_design1 = interValue("inter_design1");

    data.inter_needs1 = interValue("inter_needs1");
    data.inter_needs2 = interValue("inter_needs2");
    data.inter_needs3 = interValue("inter_needs3");
    data.inter_needs4 = interValue("inter_needs4");
    data.inter_needs5 = interValue("inter_needs5");
    data.inter_needs6 = interValue("inter_needs6");
    data.inter_needs7 = interValue("inter_needs7");
    data.inter_needs8 = interValue("inter_needs8");
    data.inter_needs9 = interValue("inter_needs9");
    data.inter_needs10 = interValue("inter_needs10");

    $.ajax({
        type: "POST",
        data: data,
        url: "/proc/member/member_common_list/modi_member_add_info.php",
        success: function(result) {
            if (result == 1) {
                detailTabCtrl(selectTab);
                alert("수정 되었습니다.");
            } else {
                alert("수정을 실패하였습니다.");
            }
        },
        error: getAjaxError 
    });
}

//나의 배송지 등록 팝업
var regiMyDlvr = function(member_seqno, seqno) {
 
    showMask();
    var url = "/ajax/member/member_common_list/load_mydlvr_popup.php";
    var data = {
        "member_seqno"  : member_seqno,
        "seqno"         : seqno
    };

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {

            var rs = result.split("♪");

            hideMask();
            openRegiPopup(rs[0], 650);

            if (!checkBlank(rs[1])) {
                $("#dlvr_tel_num1").val(rs[1]);
            }

            if (!checkBlank(rs[2])) {
                $("#dlvr_cell_num1").val(rs[2]);
            }
        },
        error: getAjaxError 
    });
}

//회원배송지정보 저장
var regiDlvrAddrInfo = function(member_seqno, seqno) {

    showMask();
    var data = {
        "member_seqno"     : member_seqno,
        "seqno"            : seqno,
        "dlvr_tel_num1"    : $("#dlvr_tel_num1").val(),
        "dlvr_tel_num2"    : $("#dlvr_tel_num2").val(),
        "dlvr_tel_num3"    : $("#dlvr_tel_num3").val(),
        "dlvr_cell_num1"   : $("#dlvr_cell_num1").val(),
        "dlvr_cell_num2"   : $("#dlvr_cell_num2").val(),
        "dlvr_cell_num3"   : $("#dlvr_cell_num3").val()
    };

    var arr = new Array();
    arr[0] = "name";
    arr[1] = "recei";
    arr[2] = "zipcode";
    arr[3] = "addr";
    arr[4] = "addr_detail";

    var arr_alert = new Array();
    arr_alert[0] = "배송지별칭이 입력되지 않았습니다.";
    arr_alert[1] = "받으시는분이 입력되지 않았습니다.";
    arr_alert[2] = "우편번호가 입력되지 않았습니다.";
    arr_alert[3] = "주소지가 입력되지 않았습니다.";
    arr_alert[4] = "주소상세가 입력되지 않았습니다.";

    //validation
    for (var i = 0; i < arr.length; i++) {
        if ($.trim($("#dlvr_" + arr[i]).val()) == "") {
            $("#dlvr_" + arr[i]).focus();
            hideMask();
	    showBgMask();
            alert(arr_alert[i]);
            return false;
        }
    }

    if ($.trim($("#dlvr_tel_num2").val()) == "" 
            && $.trim($("#dlvr_tel_num3").val()) == "" 
            && $.trim($("#dlvr_cell_num2").val()) == ""
            && $.trim($("#dlvr_cell_num3").val()) == "") {
        hideMask();
        alert("전화번호와 휴대폰중 하나는 반드시 입력해야 합니다.");
        return false;
    }

    data.dlvr_name = $("#dlvr_name").val();
    data.recei = $("#dlvr_recei").val();
    data.dlvr_zipcode = $("#dlvr_zipcode").val();
    data.dlvr_addr = $("#dlvr_addr").val();
    data.dlvr_addr_detail = $("#dlvr_addr_detail").val();

    $.ajax({
        type: "POST",
        data: data,
        url: "/proc/member/member_common_list/modi_member_dlvr_info.php",
        success: function(result) {

            hideMask();
            if (result == 1) {
                detailTabCtrl(selectTab);
                hideRegiPopup();
                alert("수정 되었습니다.");
            } else {
                alert("수정을 실패하였습니다.");
            }
        },
        error: getAjaxError 
    });
}

//회원배송지정보 삭제 
var delDlvrAddrInfo = function(seqno) {
 
    showMask();
    var data = {
        "seqno"           : seqno
    };

    $.ajax({
        type: "POST",
        data: data,
        url: "/proc/member/member_common_list/del_member_dlvr_info.php",
        success: function(result) {
            hideMask();
            if (result == 1) {
                detailTabCtrl(selectTab);
                hideRegiPopup();
                alert("삭제 되었습니다.");
            } else {
                alert("삭제를 실패하였습니다.");
            }
        },
        error: getAjaxError 
    });
}

//나의 배송지 주소 등록
var getDlvrAddrInfo = function(str) {
 
    hidePopPopup();
    
    var zipcode =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#dlvr_zipcode").val(zipcode);
    $("#dlvr_addr").val(addr);
    $("#dlvr_addr_detail").focus();
}

//등급산정 수동 전환
var regiManual = function(el) {
   
    if ($(el).is(":checked")) {
        $("#regi_manual").show();
    } else {
        $("#regi_manual").hide();
    }
}

//등급산정 수동 등록
var regiGradeManul = function(seqno) {
 
    showMask();
    var data = {
        "seqno"            : seqno,
        "new_grade"        : $("#req_grade").val(),
        "reason"           : $("#req_reason").val()
    };

    $.ajax({
        type: "POST",
        data: data,
        url: "/proc/member/member_common_list/regi_member_grade_info.php",
        success: function(result) {

            hideMask();
            if (result == 1) {
                detailTabCtrl(selectTab);
                hideRegiPopup();
                alert("수정 되었습니다.");
            } else {
                alert("수정을 실패하였습니다.");
            }
        },
        error: getAjaxError 
    });
}

//회원탈퇴 신청
var makeWithdrawal = function(seqno) {

    showMask();
    var data = {
        "seqno"  : seqno,
        "reason" : $("#withdraw_reason").val()
    };

    var withdraw_code = "";

    for (var i = 1; i <= 14; i++) {
        if ($("input:checkbox[id='reduce_" + i + "']").is(":checked") == true) {
            withdraw_code += "," + i;   
        }
    }
  
    withdraw_code = withdraw_code.substring(1);
    data.withdraw_code = withdraw_code;

    $.ajax({
        type: "POST",
        data: data,
        url: "/proc/member/member_common_list/regi_member_reduce_info.php",
        success: function(result) {

            hideMask();
            if (result == 1) {
                memberListAjaxCall(30, 1);
                $("#member_info").hide();
                alert("탈퇴신청 되었습니다.");
            } else {
                alert("탈퇴신청을 실패 하였습니다.");
            }
        },
        error: getAjaxError 
    });
}

//매출정보 검색 날짜 범위 설정
var salesDateSet = function(num) {
    detailDateSet(num, "sales");
}

//포인트정보 검색 날짜 범위 설정
var pointDateSet = function(num) {
    detailDateSet(num, "point");
}

//쿠폰정보 검색 날짜 범위 설정
var couponDateSet = function(num) {
    detailDateSet(num, "coupon");
}

//이벤트정보 검색 날짜 범위 설정
var eventDateSet = function(num) {
    detailDateSet(num, "event");
}

//회원상세정보 리스트호출
var detailListAjaxCall = function(dvs ,txt, sPage, page, sorting) {
 
    showMask();
    var tmp = sorting.split('/');
    for (var i in tmp) {
        tmp[i];
    }

    if ($("#date_" + dvs + "_from").val() > $("#date_" + dvs + "_to").val()) {
        hideMask();
        alert("선택하신 날짜 기간에 이상이 있습니다.");
        return false;
    }
 
    var data = {
    	"seqno"       : memberSeqno,
    	"search_cnd"  : $("#" + dvs + "_search_cnd").val(),
    	"date_from"   : $("#date_" + dvs + "_from").val(),
    	"date_to"     : $("#date_" + dvs + "_to").val(),
    	"time_from"   : $("#time_" + dvs + "_from").val(),
    	"time_to"     : $("#time_" + dvs + "_to").val(),
        "searchTxt"   : txt,
    	"showPage"    : sPage,
    	"page"        : page,
        "sorting"       : tmp[0],
        "sorting_type"  : tmp[1]
    };
    var url = "/ajax/member/member_common_list/load_member_" + dvs + "_list.php";

    var blank = "<tr><td colspan=\"10\">검색 된 내용이 없습니다.</td></tr>";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {
            hideMask();
            var rs = result.split("♪");

            if (rs[0].trim() == "") {
                $("#member_" + dvs + "_list").html(blank);
            } else {
                $("#member_" + dvs + "_list").html(rs[0]);
            }

            $("#member_" + dvs + "_page").html(rs[1]);

            if (dvs == "sales") {
                $("#member_" + dvs + "_total").html(rs[2]);
            }
        }   
    });

}

//포인트 지급요청 리스트
var memberPointReqListAjaxCall = function(sPage, page) {

    showMask();
 
    var data = {
    	"seqno"       : memberSeqno,
    	"showPage"    : sPage,
    	"page"        : page
    };
    var url = "/ajax/member/member_common_list/load_member_point_req_list.php";

    var blank = "<tr><td colspan=\"7\">검색 된 내용이 없습니다.</td></tr>";

    $.ajax({
        type: "POST",
        data: data,
        url: url,
        success: function(result) {

            hideMask();
            var rs = result.split("♪");

            if (rs[0].trim() == "") {
                $("#member_point_req_list").html(blank);
            } else {
                $("#member_point_req_list").html(rs[0]);
            }

            $("#member_point_req_page").html(rs[1]);
        }   
    });
}


//회원상세정보 검색
var searchMemberDetailInfo = function(dvs) {

    detailListAjaxCall(dvs, "", 30, 1, "");
}

//회원 상세정보 페이지 보여주는수 
var detailShowPageSetting = function(val, dvs) {

    detailShowPage = val;

    if (dvs == "point_req") {
        memberPointReqListAjaxCall(val, 1);
    } else {
        detailListAjaxCall(dvs, detailSearchTxt, val, 1, "");
    }
}

//회원상세 정보 페이지 이동
var detailMovePage = function(val, dvs) {

    if (dvs == "point_req") {
        memberPointReqListAjaxCall(detailShowPage, val);
    } else {
        detailListAjaxCall(dvs, detailSearchTxt, detailShowPage, val, "");
    }
}

//회원상세정보 컬럼별 sorting
var sortList = function(val, el, dvs) {

    var flag = "";

    if ($(el).children().hasClass("fa-sort-desc")) {
        sortInit();
        $(el).children().addClass("fa-sort-asc");
        $(el).children().removeClass("fa-sort");
        flag = "ASC";
    } else {
        sortInit();
        $(el).children().addClass("fa-sort-desc");
        $(el).children().removeClass("fa-sort");
        flag = "DESC";
    }

    var sorting = val + "/" + flag;

    detailListAjaxCall(dvs, detailSearchTxt, detailShowPage, val, sorting);
}

//검색어 검색 엔터
var detailSearchKey = function(event, val, dvs) {

    if (event.keyCode == 13) {
        detailSearchTxt = val;
        detailListAjaxCall(dvs, detailSearchTxt, detailShowPage, 1, "");
    }
}

//검색어 검색 버튼
var detailSearchText = function(dvs) {

    detailSearchTxt = $("#" + dvs + "_search").val();
    detailListAjaxCall(dvs, detailSearchTxt, detailShowPage, 1, "");
}

//매출정보 상세보기
var showOrderDetail = function(seqno) {
    var url = "/ajax/common/load_order_info.php";
    var data = {
        "seqno" : seqno
    };
    var callback = function(result) {
        $("#regi_popup").css("height", "750px");
        openRegiPopup(result, "950");
    };

    ajaxCall(url, "html", data, callback);
}

//포인트 지급
var saveMemberPoint = function() {

    showMask();
    var formData = new FormData();
    formData.append("seqno", memberSeqno);
    formData.append("point_name", $("#point_name").val());
    formData.append("point", $("#point").val());
    formData.append("point_reason", $("#point_reason").val());
    formData.append("point_img", $("#point_img")[0].files[0]);

    $.ajax({
        type: "POST",
        data: formData,
        url: "/proc/member/member_common_list/modi_member_point_info.php",
        dataType : "html",
        processData : false,
        contentType : false,
        success: function(result) {
            hideMask();
            if (result == 1) {
                detailTabCtrl(selectTab);
                alert("등록 되었습니다.");
            } else {
                alert("등록을 실패하였습니다.");
            }
        },
        error    : getAjaxError   
    });
}
