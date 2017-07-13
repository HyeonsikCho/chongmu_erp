<?
/**
 * @brief 상품종이 리스트 HTML
 */
function makePaperListHtml($rs, $param, $fields, $el) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"" . $el . "_chk\" value=\"%s\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields[$fields[0]],
                $rs->fields[$fields[1]],
                $rs->fields[$fields[2]],
                $rs->fields[$fields[3]],
                $rs->fields[$fields[4]],
                $rs->fields[$fields[5]] . $rs->fields[$fields[6]]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품사이즈 리스트 HTML
 */
function makeSizeListHtml($rs, $param, $fields, $el) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"" . $el . "_chk\" value=\"%s\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields[$fields[0]],
                $rs->fields[$fields[1]],
                $rs->fields[$fields[2]],
                $rs->fields[$fields[3]],
                $rs->fields[$fields[4]] . "*" . $rs->fields[$fields[5]],
                $rs->fields[$fields[6]] . "*" . $rs->fields[$fields[7]],
                $rs->fields[$fields[8]] . "*" . $rs->fields[$fields[9]],
                $rs->fields[$fields[10]] . "*" . $rs->fields[$fields[11]]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품인쇄도수 리스트 HTML
 */
function makeTmptListHtml($rs, $param, $fields, $el) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"" . $el . "_chk\" value=\"%s\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields[$fields[0]],
                $rs->fields[$fields[1]],
                $rs->fields[$fields[2]],
                $rs->fields[$fields[3]],
                $rs->fields[$fields[4]],
                $rs->fields[$fields[5]],
                $rs->fields[$fields[6]],
                $rs->fields[$fields[7]]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품후공정 리스트 HTML
 */
function makeAfterListHtml($rs, $param, $fields, $el, $flag=FALSE) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"" . $el . "_chk\" value=\"%s\"></td>";
    if ($flag) {
        $html .= "\n    <td>%s</td>";
    }
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }
        if ($flag) {

            $basic_yn = "기본 후공정";
            if ($rs->fields[$fields[6]] == "N") {
                $basic_yn = "추가 후공정";
            }

            $rs_html .= sprintf($html, $class, 
                    $rs->fields[$fields[0]],
                    $basic_yn,
                    $rs->fields[$fields[1]],
                    $rs->fields[$fields[2]],
                    $rs->fields[$fields[3]],
                    $rs->fields[$fields[4]],
                    $rs->fields[$fields[5]]);
        } else {
            $rs_html .= sprintf($html, $class, 
                    $rs->fields[$fields[0]],
                    $rs->fields[$fields[1]],
                    $rs->fields[$fields[2]],
                    $rs->fields[$fields[3]],
                    $rs->fields[$fields[4]],
                    $rs->fields[$fields[5]]);
        }
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품옵션 리스트 HTML
 */
function makeOptListHtml($rs, $param, $fields, $el, $flag=FALSE) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"checkbox\" class=\"check_box\" name=\"" . $el . "_chk\" value=\"%s\"></td>";
    if ($flag) {
        $html .= "\n    <td>%s</td>";
    }
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        if ($flag) {
            $basic_yn = "기본 옵션";
            if ($rs->fields[$fields[5]] == "N") {
                $basic_yn = "추가 옵션";
            }

            $rs_html .= sprintf($html, $class, 
                    $rs->fields[$fields[0]],
                    $basic_yn,
                    $rs->fields[$fields[1]],
                    $rs->fields[$fields[2]],
                    $rs->fields[$fields[3]],
                    $rs->fields[$fields[4]]);
        } else {
            $rs_html .= sprintf($html, $class, 
                    $rs->fields[$fields[0]],
                    $rs->fields[$fields[1]],
                    $rs->fields[$fields[2]],
                    $rs->fields[$fields[3]],
                    $rs->fields[$fields[4]]);
        }

        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
