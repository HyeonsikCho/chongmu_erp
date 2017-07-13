<?
/**
 * @brief 상품종이 리스트 HTML
 */
function makeCatePaperListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
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
                $i,
                $rs->fields["sort"],
                $rs->fields["name"],
                $rs->fields["dvs"],
                $rs->fields["color"],
                $rs->fields["basisweight"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품사이즈 리스트 HTML
 */
function makeCateSizeListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
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
                $i,
                $rs->fields["sort"],
                $rs->fields["name"],
                $rs->fields["typ"],
                $rs->fields["work_wid_size"] . "*" . $rs->fields["work_vert_size"],
                $rs->fields["cut_wid_size"] . "*" . $rs->fields["cut_vert_size"],
                $rs->fields["design_wid_size"] . "*" . $rs->fields["design_vert_size"],
                $rs->fields["tomson_wid_size"] . "*" . $rs->fields["tomson_vert_size"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품인쇄도수 리스트 HTML
 */
function makeCateTmptListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
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
                $i,
                $rs->fields["sort"],
                $rs->fields["name"],
                $rs->fields["side_dvs"],
                $rs->fields["beforeside_tmpt"],
                $rs->fields["aftside_tmpt"],
                $rs->fields["add_tmpt"],
                $rs->fields["tot_tmpt"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품후공정 리스트 HTML
 */
function makeCateAfterListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
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

        $basic_yn = "기본 후공정";
        if ($rs->fields["basic_yn"] == "N") {
            $basic_yn = "추가 후공정";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $basic_yn,
                $rs->fields["after_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품옵션 리스트 HTML
 */
function makeCateOptListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
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

        $basic_yn = "기본 옵션";
        if ($rs->fields["basic_yn"] == "N") {
            $basic_yn = "추가 옵션";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $basic_yn,
                $rs->fields["opt_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"]);

        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품옵션 리스트 HTML
 */
function makeGradeListHtml($rs) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td><input type=\"text\" class=\"input_co2 fix_width24\" id=\"grade_%s\" value=\"%s\" onkeyup=\"this.value == onlyNumber(event, this);\" maxlength=\"3\">%s</td>";
    $html .= "\n  </tr>";

    while ($rs && !$rs->EOF) {
    
        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["grade_name"],
                $rs->fields["grade"],
                $rs->fields["grade"],
                $rs->fields["rate"],
                "%");

        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
