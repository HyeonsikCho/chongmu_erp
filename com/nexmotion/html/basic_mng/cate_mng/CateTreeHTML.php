<?
//카테고리 대분류 추가/수정 트리 생성
function getCateTopTree($one_level, $two_level, $thr_level, $func, $flag=TRUE) {

    $i = 1;

    $html.= "\n    <ol class=\"tree\">";
    $html.= "\n         <li id=\"cate\" class=\"fwb\"> 카테고리 ";

    if ($flag === TRUE) {
        $html.= "<button type=\"button\" class=\"blue_text01 btn btn-xs btn-default fa fa-plus\" onClick=\"addCateTop();\">추가</button></li>";

        $html .= "\n<li id=\"add_cate\" style=\"display:none;\" class=\"ptb05\"><input class=\"input_co2 fix_width120 \" type=\"text\" placeholder=\"추가명:\">";
        $html .= "\n<button class=\"btn btn-sm btn-primary fa fa-check\" type=\"button\"></button>";
        $html .= "\n<button class=\"blue_text01 btn btn-sm btn-default fa fa-times\" type=\"button\"></button>";
        $html .= "\n</li>";
    }
    foreach ($one_level as $key=>$value) {

        $html .= "\n         <li class=\"ptb05\">"; 
        $html .= "\n             <label onclick=\"" . $func[1] . "('#" . $key . "', '" . $value . "', '" . $key . "' ,'');\" for=\"folder" . $i . "\"><span class=\"one\" id=\"" . $key . "\">" . $value. "</span>";

        if ($flag === TRUE) {
            $html .= "\n             <button type=\"button\" class=\"blue_text01 btn btn-xs btn-default fa fa-plus\" onclick=\"addCateMid('" . $key . "', '#" . $key . "', '" . $value ."');\">추가</button> ";
        }
        $html .= "\n             </label>";
        $html .= "\n             <input class=\"bt2\" type=\"checkbox\" id=\"folder" . $i . "\" /> "; 
        $html .= getMidTree($key, $two_level, $thr_level, $func, $i, $flag);
        $html .= "\n        </li>";
        $i++;
    }
    
    if ($flag === TRUE) {
        $html .= "\n    <li class=\"add_cate\" id=\"add_cate_one\" style=\"display:none\"></li>";
    }
    $html .= "\n    </ol>";

    return $html;
}

//카테고리 중분류 추가/수정 트리 생성
function getMidTree($key, $two_level, $thr_level, $func, $i, $flag) {

    $html.= "\n             <ol>";

    $j = $i * 1000;
    if ($two_level[$key]) {
        foreach ($two_level[$key] as $arr_key=>$value) { 

            $html.= "\n                 <li>";
            $html.= "\n                     <label for=\"subfolder" . $j . "\"onclick=\"" . $func[2] . "('#" . $arr_key . "', '" . $value . "', '" . $arr_key . "', '');\"><span class=\"two\" id=\"" . $arr_key . "\">" . $value . "</span>"; 
            if ($flag === TRUE) {
                $html .= "\n                 <button type=\"button\" class=\"blue_text01 btn btn-xs btn-default fa fa-plus\" onclick=\"addCateBtm('" . $arr_key . "', '#" . $arr_key . "', '" . $value ."')\">추가</button>";
            }
            $html .= "\n             </label>";
            $html .= "\n             <input class=\"bt2\" type=\"checkbox\" id=\"subfolder" . $j . "\" /> "; 
            $html .= getBtmTree($arr_key, $thr_level, $func, $flag);
            $html .= "\n                </li>";
            $j++;
        }
    }
    if ($flag === TRUE) {
        $html .= "\n             <li class=\"add_cate\" id=\"add_cate_two_" . $key . "\" style=\"display:none\"></li>";
    }
    $html .= "\n            </ol>";

    return $html;
}

//카테고리 소분류 추가/수정 트리 생성
function getBtmTree($key, $thr_level, $func, $flag) {
 
    $html = "\n                    <ol>";

    if ($thr_level[$key]) { 
        foreach ($thr_level[$key] as $arr_key=>$value) {

            $html .= "\n                        <li class=\"file\"><a style=\"cursor:pointer;\" class=\"thr\" id=\"" . $arr_key ."\" onclick=\"" . $func[3] . "(this, '" . $value . "', '" . $arr_key . "');\">" . $value . "</a></li>";
        }
    }

    if ($flag === TRUE) {
        $html .= "\n                    <li class=\"add_cate\" id=\"add_cate_thr_" . $key . "\" style=\"display:none\"></li>";
    }
    $html .= "\n                    </ol>";

    return $html;

}
?>
