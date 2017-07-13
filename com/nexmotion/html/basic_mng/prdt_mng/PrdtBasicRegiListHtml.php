<?
/**
 * @brief 상품종이 리스트 HTML
 */
function makePaperListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('paper', '%s');\">수정</button></td>";
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
                $rs->fields["basisweight"],
                $rs->fields["affil"],
                $rs->fields["size"],
                $rs->fields["prdt_paper_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 출력정보 리스트 HTML
 */
function makeOutputListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('output', '%s');\">수정</button></td>";
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
                $rs->fields["output_name"],
                $rs->fields["affil"],
                $rs->fields["output_board_dvs"],
                $rs->fields["size"],
                $rs->fields["prdt_output_info_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품사이즈 리스트 HTML
 */
function makeSizeListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('size', '%s');\">수정</button></td>";
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
                $rs->fields["tomson_wid_size"] . "*" . $rs->fields["tomson_vert_size"],
                $rs->fields["prdt_stan_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 인쇄정보 리스트 HTML
 */
function makePrintListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('print', '%s');\">수정</button></td>";
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
                $rs->fields["cate_name"],
                $rs->fields["print_name"],
                $rs->fields["purp_dvs"],
                $rs->fields["affil"],
                $rs->fields["prdt_print_info_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품인쇄도수 리스트 HTML
 */
function makeTmptListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('tmpt', '%s');\">수정</button></td>";
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
                $rs->fields["tot_tmpt"],
                $rs->fields["prdt_print_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품후공정 리스트 HTML
 */
function makeAfterListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('after', '%s');\">수정</button></td>";
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
                $rs->fields["after_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"],
                $rs->fields["crtr_unit"],
                $rs->fields["prdt_after_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}

/**
 * @brief 상품옵션 리스트 HTML
 */
function makeOptListHtml($rs, $param) {
  
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
    $html .= "\n    <td><button type=\"button\" class=\"orge btn_pu btn fix_height20 fix_width40\" onclick=\"showRegiPopup('opt', '%s');\">수정</button></td>";
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
                $rs->fields["opt_name"],
                $rs->fields["depth1"],
                $rs->fields["depth2"],
                $rs->fields["depth3"],
                $rs->fields["prdt_opt_seqno"]);
        $i++;
        $rs->moveNext();
    }

    return $rs_html;
}
?>
