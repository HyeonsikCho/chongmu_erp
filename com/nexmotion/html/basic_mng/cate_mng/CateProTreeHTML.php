<?
//카테고리 대분류 트리
function getProCateTopTree($one_level, $two_level, $func) {

    $i = 1;

    $html.= "\n    <ol class=\"tree\">";
    $html.= "\n         <li id=\"cate\" class=\"fwb\" style=\"margin-bottom: 10px;magin-top: 2px;\"> 카테고리 </li> ";
    foreach ($one_level as $key=>$value) {

        $html .= "\n         <li class=\"ptb05\">"; 
        $html .= "\n             <label onclick=\"" . $func[1] . "('#" . $key . "');\" for=\"folder" . $i . "\"><span class=\"one\" id=\"" . $key . "\">" . $value. "</span>";
        $html .= "\n             </label>";
        $html .= "\n             <input class=\"bt3\" type=\"checkbox\" id=\"folder" . $i . "\" /> "; 
        $html .= getTypsetTree($key, $two_level, $func, $i);
        $html .= "\n        </li>";
        $i++;
    }
    $html .= "\n    </ol>";

    return $html;
}

//조판 판형 트리
function getTypsetTree($key, $two_level, $func) {
 
    $html = "\n                    <ol>";

    if ($two_level[$key]) { 
        foreach ($two_level[$key] as $arr_key=>$value) {


            $str = explode("♪§♭", $value);
            $color = "";

            if ($str[0] === "Y") {
                $color = "color: #0096ff;";
            }

            $html .= "\n                        <li class=\"file\"><a style=\"cursor:pointer;" . $color . "\" class=\"two\" id=\"" . $arr_key ."\" onclick=\"" . $func[2] . "(this, '" . $arr_key . "');\">" . $str[1] . "</a></li>";
        }
    }
    $html .= "\n                    </ol>";

    return $html;
}
?>
