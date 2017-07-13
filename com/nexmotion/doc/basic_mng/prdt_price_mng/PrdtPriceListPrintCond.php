<?
/**
 * @brief 인쇄 검색조건 책자형 html 반환
 *
 * @param $conn  = connection identifier
 * @param $dao   = 쿼리를 수행할 dao
 * @param $param = 검색조건 파라미터
 *
 * @return 생성된 html
 */
function makePrintCondHtmlBooklet($conn, $dao, $param) {
    $param["side_dvs"] = "전면";
    $print_front = $dao->selectCateTmptHtml($conn, $param);

    $param["side_dvs"] = "후면";
    $print_back  = $dao->selectCateTmptHtml($conn, $param);

    $purp = $dao->selectCatePrintPurpHtml($conn, $param);

    $disabled = "";
    if ($param["mono_yn"] === "0") {
        $disabled = "disabled=\"disabled\"";
    }

    $html = <<<html
        <div class="form-group">
            <label class="control-label fix_width150 tar">전면 인쇄도수</label><label class="fix_width20 fs14 tac"> : </label>
            <select id="print_tmpt_front" class="fix_width180">
                <option value="">전체</option>
                $print_front
            </select>
        </div>
        <div class="form-group">
            <label class="control-label fix_width150 tar">후면 인쇄도수</label><label class="fix_width20 fs14 tac"> : </label>
            <select id="print_tmpt_back" class="fix_width180">
                <option value="">전체</option>
                $print_back
            </select>
        </div>
        <div class="form-group">
            <label class="control-label fix_width150 tar">인쇄방식</label><label class="fix_width20 fs14 tac"> : </label>
            <select id="print_purp" class="fix_width180" $disabled>
                <option value="">전체</option>
                $purp
            </select>
        </div>
html;

    return $html;
};

/**
 * @brief 인쇄 검색조건 낱장형 html 반환
 *
 * @param $conn  = connection identifier
 * @param $dao   = 쿼리를 수행할 dao
 * @param $param = 검색조건 파라미터
 *
 * @return 생성된 html
 */
function makePrintCondHtmlSheet($conn, $dao, $param) {
    $param["side_dvs"] = "단면";
    $print  = $dao->selectCateTmptHtml($conn, $param);

    $param["side_dvs"] = "양면";
    $print .= $dao->selectCateTmptHtml($conn, $param);

    $purp = $dao->selectCatePrintPurpHtml($conn, $param);

    $disabled = "";
    if ($param["mono_yn"] === "0") {
        $disabled = "disabled=\"disabled\"";
    }

    $html = <<<html
        <div class="form-group">
            <label class="control-label fix_width150 tar">인쇄</label><label class="fix_width20 fs14 tac"> : </label>
            <select id="print_tmpt" class="fix_width180">
                <option value="">전체</option>
                $print
            </select>
            <select id="print_purp" class="fix_width180" $disabled>
                <option value="">전체</option>
                $purp
            </select>
        </div>
html;

    return $html;
};
?>
