<?
ob_start();    

//총게시물수 , 현재 페이지 , 블록갯수 , 블록당게시물수, js함수명, js함수 param
function mkDotAjaxPage($totalCnt , $page , $SCALE , $LIST_NUM , $func, $param=""){

	//총게시물 수가 1개 미만이면 빈값 리턴
	if ($totalCnt < 1) return "";
	
	$totalpage = @ceil($totalCnt / $LIST_NUM); //게시판 총 페이지수
	

	//페이지로직 처음 보여줄 페이지수
	//$first = $page - $SCALE;
	$first = ((ceil($page/$SCALE)-1) * $SCALE)+1;
	
	if ($first <= 1) $first = 1;
	
	//페이지로직 마지막 보여줄 페이지수
	$last = ceil($page /$SCALE) * $SCALE;
	if ($last > $totalpage) $last = $totalpage;

	$prev = $first - $SCALE;
	$nxt = $first + $SCALE;

    $ret = "\n<ul class=\"pagination\">";

    //처음 앞으로 이동
    if ($param == "") {
	    $prevurl = "onClick=\"" . $func . "(1)\"";
    } else {
	    $prevurl = "onClick=\"" . $func . "(1, '" . $param . "')\"";
    }

    if ($page == 1) {
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-double-left\"></i></li>";
    } else {
        $ret .= "\n<li><a style=\"cursor:pointer;\" " . $prevurl . " class=\"fa fa-angle-double-left\"></a></li>";

    }

    //1블록 앞으로 이동
	if ($prev > 0) {
        if ($param == "") {
            $prevurl = "onClick=\"" . $func . "(" . $prev . ")\"";
        } else {
            $prevurl = "onClick=\"" . $func . "(" . $prev . ", '" . $param . "')\"";
        }
    } else {
        if ($param == "") {
            $prevurl = "onClick=\"" . $func . "(1)\"";
        } else {
            $prevurl = "onClick=\"" . $func . "(1, '" . $param . "')\"";
        }
    }

    if ($page == 1) 
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-left\"></i></li>";
    else 
        $ret .= "\n<li><a style=\"cursor:pointer;\" " . $prevurl . " class=\"fa fa-angle-left\"></a></li>";
 

    if ($SCALE < $totalpage) {
        if ($SCALE < $page) {
            if ($param == "") {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(1);\">1</a></li>"; 
            } else {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(1, '" . $param . "');\">1</a></li>"; 
            }
            $ret .= "\n<li><a>...</a></li>";
        }
    }

	for ($x = $first; $x <= $last; $x++) {
		if ($x == $page) {
            $ret .= "\n<li><a class=\"active\" style=\"cursor:pointer;\">" . $x . "</a></li>";
		} else {
            if ($param == "") {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $x . ");\">" . $x . "</a></li>";
            } else {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $x . ", '" . $param . "');\">" . $x . "</a></li>";

            }
		}
	}

    if ($SCALE < $totalpage) {

        if ($SCALE < $page && $page < $totalpage - $SCALE) {
            $ret .= "\n<li><a>...</a></li>";
            if ($param == "") {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $totalpage . ");\">" . $totalpage . "</a></li>";
            } else {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $totalpage . ", '" . $param . "');\">" . $totalpage . "</a></li>";
            }
        }

        if ($SCALE >= $page) {
            $ret .= "\n<li><a>...</a></li>";
            if ($param == "") {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $totalpage . ");\">" . $totalpage . "</a></li>";
            } else {
                $ret .= "\n<li><a style=\"cursor:pointer;\" onclick=\"" . $func  . "(" . $totalpage . ", '" . $param . "');\">" . $totalpage . "</a></li>";
            }
        }

    }
	
    //1블록 뒤로 이동
	if ($nxt <= $totalpage) {
        if ($param == "") {
	        $nexturl = "onClick=\"" . $func . "(" . $nxt . ")\"";
        } else {
	        $nexturl = "onClick=\"" . $func . "(" . $nxt . ", '" . $param . "')\"";
        }
    } else {
        if ($param == "") {
            $nexturl = "onClick=\"" . $func . "(" . $totalpage . ")\"";
        } else {
            $nexturl = "onClick=\"" . $func . "(" . $totalpage . ", '" . $param . "')\"";
        }
    }

    if ($nxt == $totalpage) {
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-right\"></i></li>";
    } else if ($totalpage < $SCALE) {
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-right\"></i></li>";
    } else if ($totalpage == $page) {
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-right\"></i></li>";
    } else {
        $ret .= "\n<li><a style=\"cursor:pointer;\" " . $nexturl . " class=\"fa fa-angle-right\"></a></li>";
    }

    //맨뒤로 이동
    if ($param == "") {
	    $nexturl = "onClick=\"" . $func . "(" . $totalpage . ")\"";
    } else {
	    $nexturl = "onClick=\"" . $func . "(" . $totalpage . ", '" . $param . "')\"";
    }

    if ($page == $totalpage) {
        $ret .= "\n<li class=\"disabled\"><i class=\"fa fa-angle-double-right\"></i></li>";
    } else {
        $ret .= "\n<li><a style=\"cursor:pointer;\" " . $nexturl . " class=\"fa fa-angle-double-right\"></a></li>";
    }

    $ret .= "\n</ul>";

	return $ret;
}
?>
