<?
if (!$fb->session("empl_seqno")) {
    header("Location: /login.html");
}

//직원이 권한 가능한 페이지 체크
$commonDAO->checkAuth($conn, $fb->session("empl_seqno"), $_SERVER["PHP_SELF"]);

//메인 메뉴
$template->reg("main_title" , TOP_MENU_ARR[$top]);

//서브 메뉴
$template->reg("sub_title" , LEFT_MENU_ARR[$top]["sub"][$left]);

//메뉴
$template->reg("title" , LEFT_MENU_ARR[$top][$left][$left_sub]);

//왼쪽 메뉴 로딩시 선택
$template->reg("top" , $top);

//왼쪽 메뉴 로딩시 선택
$template->reg("active" , $left);

//왼쪽 메뉴 글씨 on 
$template->reg("on" , $left_sub);

//탑메뉴 로딩시 선택
$template->reg($top , "active-link");

$sess = array();
$sess["empl_seqno"] = $fb->session("empl_seqno");
$sess["id"] = $fb->session("id");
$sess["name"] = $fb->session("name");
$sess["login_date"] = $fb->session("login_date");

//왼쪽 메뉴 생성
$template->reg("left", $leftSetting->getLeftMenuSetting($sess, 
                       LEFT_MENU_ARR[$top], 
                       $top, 
                       LEFT_MENU_CLASS_ARR));

//design_dir 경로
$template->reg("design_dir" , "/design_template"); 
$template->htmlPrint($_SERVER["PHP_SELF"]); 
?>
