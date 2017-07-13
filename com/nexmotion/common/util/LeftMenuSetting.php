<?
class LeftMenuSetting {

    function __construct() {
    }

    //왼쪽 메뉴 생성
    // $sess : 세션
    // $left_arr : left define array
    // $menu_class_arr : left class define array
    function getLeftMenuSetting ($sess, $left_arr, $top, $menu_class_arr) {

        //차후 세션 개발후
        //if (!$sid) return false;
 
        $html  = "\n        <!-- LEFT NAVIGATION -->";
        $html .= "\n        <nav id=\"mainnav-container\">";
        $html .= $this->loginCheck($sess);       
        $html .= "\n            <div id=\"mainnav-menu\" class=\"pt05\">";
        $html .= "\n                   <dl class=\"list-group list-divider\">";

        $sub_count = count($left_arr["sub"]);
        
        foreach ($left_arr["sub"] as $key=>$value) {
 
            $html .= "\n                    <dt class=\"mid " . $key . "\" onclick=\"midCheckLeft(this);\"><p><i class=\"" .  $menu_class_arr[$key] . "\"></i> <span>" . $value  . " </span></p></dt>";

            $html .= $this->getSubMenu($left_arr[$key], $top, $key);
        }

        $html .= "\n                        <dt class=\"list-divider\"></dt>";
        $html .= "\n                   </dl>";
        $html .= "\n            </div>";
        $html .= "\n        </nav>";

        return $html;
    }

    // $sid : 세션
    function loginCheck($sess) {

        $html  = "\n            <!-- 로그인 정보 -->";
        $html .= "\n            <div class=\"menulist\">";
        $html .= "\n                    <div class=\"text-right\">";
        $html .= "\n                         <h3 class=\"name\">$sess[name]님 안녕하세요</h3>";
        $html .= "\n                          <a href=\"/common/logout.php\" class=\"btn btn-sm btn-primary\"> Logout</a>";
        $html .= "\n                    </div>";
        $html .= "\n                    <h4 class=\"log\">로그인시각</h4>";
        $html .= "\n                    <h4 class=\"date\">$sess[login_date]</h4>";
        //$html .= "\n                         <button class=\"btn btn-sm my_btn\" onclick=\"getDetail.memo('$sess[empl_seqno]');\">My Memo</button>";
        //$html .= "\n                         <button class=\"btn btn-sm my_btn\" onclick=\"getDetail.order('$sess[empl_seqno]');\">My OrderList</button>";
        //$html .= "\n                         <button class=\"btn btn-sm my_btn\" onclick=\"getDetail.member('$sess[empl_seqno]');\">My Member</button>";
        //$html .= "\n                         <button class=\"btn btn-sm my_btn\" onclick=\"getDetail.team('$sess[empl_seqno]');\">My Team</button>";
        $html .= "\n            </div>";

        return $html;
    }

    //왼쪽 2Depth 메뉴 생성
    function getSubMenu($sub_arr, $top, $key) {

        $html .= "\n                        <dd class=\"" . $key . "\">";
        $html .= "\n                             <ul>";

        foreach ($sub_arr as $key=>$value) {

            $html .= "\n                                 <li><a class=\"" . $key . "\" href=\"/" . $top . "/" . $key . ".html\">" . $value . " </a></li>";
        }
        
        $html .= "\n                             </ul>";
        $html .= "\n                        </dd>";

        return $html;
    }


}
?>
