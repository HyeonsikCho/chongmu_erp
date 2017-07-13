var search_loc = "";

//신규업체등록
var regiNewEtprs = function() {

    //매입업체가 비었을때
    if($("#manu_name").val() == "") {

        alert("매입업체명을 입력해주세요.");
	$("#manu_name").focus();
        return false;
    }

    //이메일 형식이 잘못되었을때
    if($("#email").val() != "") {

        var email_val = emailCheck($("#email").val());
        if (email_val === false) {

            alert("업체 메일 형식이 잘못되었습니다.");
	     $("#email").focus();
            return false;
        }
    }

     //매입기업 담당자 이메일 형식이 잘못되었을때
    if($("#etprs_email").val() != "") {

        var email_val = emailCheck($("#etprs_email").val());
        if (email_val === false) {

            alert("매입업체 담당자 메일 형식이 잘못되었습니다.");
	    $("#etprs_email").focus();
            return false;
        }
    }
    
    //회계 담당자 이메일 형식이 잘못되었을때
    if($("#accting_email").val() != "") {

            var email_val = emailCheck($("#accting_email").val());
            if (email_val === false) {

                alert("회계 담당자 메일 형식이 잘못되었습니다.");
            $("#accting_email").focus();
                return false;
            }
        }

        var formData = $("#pur_etprs_form").serialize();

        $.ajax({

            type: "POST",
            data: formData,
            url: "/proc/basic_mng/pur_etprs_regi/regi_pur_etprs.php",
            success: function(result) {
            if (result == "1") {
                alert("입력 되었습니다.");
                    $("form").each(function() {  
                        this.reset();  
                    });
            } else if (result == 2){

                alert("중복된 매입업체명이 존재합니다.");

            } else if (result == 3){

                alert("입력에 실패했습니다.");

            }
            }   
        });
}

//팝업 검색된 주소 클릭시
var etprsClick = function(str) {

    hideRegiPopup();
    
    var zip =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#zip").val(zip);
    $("#addr_front").val(addr);
    $("#addr_rear").focus();

}

//팝업 검색된 주소 클릭시
var blsClick = function(str) {
	
    hideRegiPopup();

    var zip =  str.substring(0,5);
    var addr =  str.substring(9);

    $("#bls_zip").val(zip);
    $("#bls_addr_front").val(addr);
    $("#bls_addr_rear").focus();

}

//회사 정보를 사업자 정보에 복사
var copyInfo = function(val) {

	if (val == "Y") {
		
		//회사명 복사
		$('#bls_cpn_name').val($('#cpn_name').val());
		//회사 우편번호 복사
		$('#bls_zip').val($('#zip').val());
		//앞 주소 복사
		$('#bls_addr_front').val($('#addr_front').val());
		//뒤 주소 복사
		$('#bls_addr_rear').val($('#addr_rear').val());

		//도로명여부 라디오 선택
		$("input:radio[name='bls_doro_yn']:radio[value=" + 
				$('input[name=doro_yn]:checked').val() + "]").attr("checked",true);
	} else {
		
		$('#bls_cpn_name').val('');
		//회사 우편번호 복사
		$('#bls_zip').val('');
		//앞 주소 복사
		$('#bls_addr_front').val('');
		//뒤 주소 복사
		$('#bls_addr_rear').val('');

		//도로명여부 라디오 선택
		$("input:radio[name='bls_doro_yn']:radio[value='N']").attr("checked", true);

	}

}

