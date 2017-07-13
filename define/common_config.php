<?
/* adodb 캐쉬저장경로 설정 */
$ADODB_CACHE_DIR = dirname(__FILE__) . '/cache';
define("ADODB_CACHE_DIR", $ADODB_CACHE_DIR);

/******************** 파일 저장 경로 ****************/
define("SITE_DEFAULT_IMG", "attach"); //사이트 기본정보
define("SITE_DEFAULT_TYPSET_FILE", "attach/typset_file"); //조판 파일
define("SITE_DEFAULT_CP_FILE", "attach/cp_file"); //쿠폰 파일
define("SITE_DEFAULT_ESTI_FILE", "attach/esti_file"); //견적 파일
define("SITE_DEFAULT_AFTER_OP_WORK_FILE", "attach/after_op_work_file"); //후공정 발주 작업 파일
define("SITE_DEFAULT_ORDER_DETAIL_PRINT_FILE", "attach/order_detail_print_file"); //주문 상세 인쇄 파일
define("SITE_DEFAULT_CLAIM_ORDER_FILE", "attach/claim_order_file"); //클레임 재주문 파일
define("SITE_DEFAULT_OTO_INQ_FILE", "attach/oto_inq_file"); //1:1문의 답변 파일
define("SITE_DEFAULT_OTO_INQ_REPLY_FILE", "attach/oto_inq_reply_file"); //1:1문의 답변 파일
define("SITE_DEFAULT_OEVENT_FILE", "attach/oevent_file"); //오특이 이벤트 파일
define("SITE_DEFAULT_NOWADAYS_FILE", "attach/nowadays_file"); //요즘바빠요 이벤트 파일
define("SITE_DEFAULT_OVERTO_FILE", "attach/overto_file"); //골라담기 이벤트 파일
define("SITE_DEFAULT_POINT_FILE", "attach/point_file"); //포인트 파일 저장
define("SITE_DEFAULT_MEMBER_CERTI_FILE", "attach/member_certi_file"); //회원 인증정보
define("SITE_DEFAULT_CATE_PHOTO_FILE", "attach/cate_photo_file"); //카테고리 사진 파일
define("SITE_DEFAULT_CATE_BANNER_FILE", "attach/cate_banner_file"); //카테고리배너 파일
define("SITE_DEFAULT_POPUP_FILE", "attach/popup_file"); //팝업 파일
define("SITE_DEFAULT_NOTICE_FILE", "attach/notice_file"); //공지사항 파일
define("ORDER_USERUPLOAD_FILE", "attach/order_file_2.0/IBM"); //견적 파일

?>
