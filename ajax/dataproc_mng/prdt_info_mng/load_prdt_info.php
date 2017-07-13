<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/entity/FormBean.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/set/PrdtInfoMngDAO.php");


$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();
$fb = new FormBean();
$prdtDAO = new PrdtInfoMngDAO();

//카테고리 분류코드
$cate_sortcode = $fb->form("cate_sortcode");
$param = array();
$param["table"] = "cate_info";
$param["col"] = "gen_yn, new_yn, soldout_yn, event_yn, prjt_yn,
                 recomm_yn, popular_yn, bun_yn";
$param["where"]["cate_sortcode"] = $cate_sortcode;
$ct_result = $prdtDAO->selectData($conn, $param);

//카테고리 사진 파일
$param = array();
$param["table"] = "cate_photo";
$param["col"] = "file_path, save_file_name, origin_file_name, seq,
                 cate_photo_seqno";
$param["where"]["cate_sortcode"] = $cate_sortcode;
$ph_result = $prdtDAO->selectData($conn, $param);

//카테고리 배너 파일
$param = array();
$param["table"] = "cate_banner";
$param["col"] = "file_path, save_file_name, origin_file_name,
                 url_addr, target_yn, cate_banner_seqno";
$param["where"]["cate_sortcode"] = $cate_sortcode;
$bn_result = $prdtDAO->selectData($conn, $param);


$param = array();
//파일 삭제 버튼 숨기기 초기화
$param["del_btn1"] = "style=\"display:none\"";
$param["del_btn2"] = "style=\"display:none\"";
$param["del_btn3"] = "style=\"display:none\"";
$param["del_btn4"] = "style=\"display:none\"";
$param["del_btn5"] = "style=\"display:none\"";
$param["del_btn_bn"] = "style=\"display:none\"";

//카테고리 배너가 있으면
$param["banner_file_name"] = $bn_result->fields["origin_file_name"];
$param["banner_seqno"] = $bn_result->fields["cate_banner_seqno"];
//파일 삭제 버튼 보이기
if ($param["banner_file_name"]) {

    $param["del_btn_bn"] = "";

}

$param["banner"] = $bn_result->fields["file_path"] . 
$bn_result->fields["save_file_name"];
$param["url_addr"] = $bn_result->fields["url_addr"];

//페이지 타겟 현재창일때
if ($bn_result->fields["target_yn"] == "Y") {

    $param["target_y"] = "checked=\"checked\"";

//페이지 새창일때
} else if ($bn_result->fields["target_yn"] == "N") {

    $param["target_n"] = "checked=\"checked\"";

}

//카테고리 사진
while ($ph_result && !$ph_result->EOF) {

    $seq = $ph_result->fields["seq"];

    $param["file_name" . $seq] = $ph_result->fields["origin_file_name"];
    $param["photo_seqno" . $seq] = $ph_result->fields["cate_photo_seqno"];
    $param["photo" . $seq] = $ph_result->fields["file_path"] .
                             $ph_result->fields["save_file_name"];
    
    $param["del_btn" . $seq] = "";
    $ph_result->moveNext();
}

//일반상품 여부
if ($ct_result->fields["gen_yn"] == "Y") {

    $param["gen_y"] = "checked=\"checked\"";
    
}
//신상품 여부
if ($ct_result->fields["new_yn"] == "Y") {

    $param["new_y"] = "checked=\"checked\"";

}
//품절상품 여부
if ($ct_result->fields["soldout_yn"] == "Y") {

    $param["soldout_y"] = "checked=\"checked\"";

}
//이벤트상품 여부
if ($ct_result->fields["event_yn"] == "Y") {

    $param["event_y"] = "checked=\"checked\"";

}
//기획상품 여부
if ($ct_result->fields["prjt_yn"] == "Y") {

    $param["prjt_y"] = "checked=\"checked\"";
    
}
//추천상품 여부
if ($ct_result->fields["recomm_yn"] == "Y") {

    $param["recomm_y"] = "checked=\"checked\"";
    
}
//인기상품 여부
if ($ct_result->fields["popular_yn"] == "Y") {

    $param["popular_y"] = "checked=\"checked\"";
    
}
//묶음 여부
if ($ct_result->fields["bun_yn"] == "Y") {

    $param["bun_y"] = "checked=\"checked\"";
    
} else if ($ct_result->fields["bun_yn"] == "N"){

    $param["bun_n"] = "checked=\"checked\""; 

}

$html = getPrdtInfoHtml($param);

echo $html;
?>
