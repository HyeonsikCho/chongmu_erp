<?
/**
 * @brief 종이 리스트 HTML
 */
function makePaperListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"radio\" name=\"$param[el]\" value=\"%s\" onchange=\"selectRadio.exec('$param[el]', this.value);\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s*%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["paper_seqno"],
                $rs->fields["manu_name"],
                $rs->fields["brand_name"],
                $rs->fields["paper_name"],
                $rs->fields["affil"],
                $rs->fields["wid_size"],
                $rs->fields["vert_size"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 출력 리스트 HTML
 */
function makeOutputListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"radio\" name=\"$param[el]\" value=\"%s\" onchange=\"selectRadio.exec('$param[el]', this.value);\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s*%s</td>";
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
                $rs->fields["output_seqno"],
                $rs->fields["manu_name"],
                $rs->fields["brand_name"],
                $rs->fields["output_name"],
                $rs->fields["affil"],
                $rs->fields["wid_size"],
                $rs->fields["vert_size"],
                $rs->fields["board"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 인쇄 리스트 HTML
 */
function makePrintListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"radio\" name=\"$param[el]\" value=\"%s\" onchange=\"selectRadio.exec('$param[el]', this.value);\"></td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s</td>";
    $html .= "\n    <td>%s*%s</td>";
    $html .= "\n  </tr>";
    $i = 1 + $param["s_num"];

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $rs->fields["print_seqno"],
                $rs->fields["manu_name"],
                $rs->fields["brand_name"],
                $rs->fields["print_name"],
                $rs->fields["affil"],
                $rs->fields["wid_size"],
                $rs->fields["vert_size"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 후공정 리스트 HTML
 */
function makeAfterListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"radio\" name=\"$param[el]\" value=\"%s\" onchange=\"selectRadio.exec('$param[el]', this.value);\"></td>";
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
                $rs->fields["after_seqno"],
                $rs->fields["manu_name"],
                $rs->fields["brand_name"],
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
 * @brief 후공정 등록 리스트 HTML
 */
function makeRegiAfterListHtml($rs) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"bred btn_pu btn fix_height20 fix_width40\" onclick=\"delRegiList('%s', 'after');\">삭제</button></td>";
    $html .= "\n  </tr>";
    $i = 1;

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["manu_name"],
                $rs->fields["after_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"],
                $rs->fields["after_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 옵션 리스트 HTML
 */
function makeOptListHtml($rs, $param) {
  
    if (!$rs) {
        return false;
    }

    $rs_html = "";
    $html  = "\n  <tr class='%s'>";
    $html .= "\n    <td><input type=\"radio\" name=\"$param[el]\" value=\"%s\" onchange=\"selectRadio.exec('$param[el]', this.value);\"></td>";
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
                $rs->fields["opt_seqno"],
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
 * @brief 옵션 등록 리스트 HTML
 */
function makeRegiOptListHtml($rs) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"bred btn_pu btn fix_height20 fix_width40\" onclick=\"delRegiList('%s', 'opt');\">삭제</button></td>";
    $html .= "\n  </tr>";
    $i = 1;

    while ($rs && !$rs->EOF) {

        if ($i % 2 == 0) {
            $class = "cellbg";
        } else if ($i % 2 == 1) {
            $class = "";
        }

        $rs_html .= sprintf($html, $class, 
                $i,
                $rs->fields["opt_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"],
                $rs->fields["opt_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
