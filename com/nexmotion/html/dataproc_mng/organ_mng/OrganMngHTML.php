<?
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/common/util/ConnectionPool.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/job/dataproc_mng/organ_mng/OrganMngDAO.php");
include_once($_SERVER["DOCUMENT_ROOT"] . "/com/nexmotion/doc/dataproc_mng/organ_mng/OrganMngDOC.php");

/* 
 * 부서 list  생성 
 * $result : $result->fields["depar_name"] = "부서명" 
 * $result : $result->fields["high_depar_code"] = "상위 부서 코드" 
 * $result : $result->fields["depar_admin_seqno"] = "부서 관리 일련번호" 
 * 
 * return : list
 */
function makeDeparList($result) {

    $ret = "";
    $connectionPool = new ConnectionPool();
    $conn = $connectionPool->getPooledConnection();

    $organDAO = new OrganMngDAO();
    
    $i = 1;

    while ($result && !$result->EOF) {

        $depar_name = $result->fields["depar_name"];
        $depar_admin_seqno = $result->fields["depar_admin_seqno"];
        $sell_site = $result->fields["sell_site"];
        $cpn_admin_seqno = $result->fields["cpn_admin_seqno"];

        $param = array();
        $param["table"] = "depar_admin";
        $param["col"] = "depar_name";
        $param["where"]["depar_code"] = $result->fields["high_depar_code"];
        $h_result = $organDAO->selectData($conn, $param);

        $high_depar_name = $h_result->fields["depar_name"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" onclick=\"popDeparView(%d, %d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">수정</button></td>";
        $list .= "\n    </tr>";

        $ret .= sprintf($list, $i, $sell_site, $depar_name, $high_depar_name, $depar_admin_seqno, $cpn_admin_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/**
 * @brief 선택된 값으로 셋팅되는  콤보박스  html 생성
 *
 */
function makeSelectedOptionHtml($rs, $selected, $key, $val) {

    $html = "";

    while ($rs && !$rs->EOF) {

        $fields = $rs->fields[$key]; 
        $value = $rs->fields[$val]; 

        if ($selected == $value) {

            $html .= "\n  <option value=\"" . $value . "\" selected=\"selected\">" . $fields. "</option>";

        } else {

            $html .= "\n  <option value=\"" . $value . "\">" . $fields. "</option>";
        }

        $rs->MoveNext();
    }

    return $html;
}

/* 
 * 관리자 list  생성 
 * $result : $result->fields["name"] = "관리자명" 
 * $result : $result->fields["empl_seqno"] = "직원 일련번호" 
 * $result : $result->fields["empl_id"] = "직원 id" 
 * $result : $result->fields["sell_site"] = "판매 채널" 
 * $result : $result->fields["depar_name"] = "부서명" 
 * $result : $result->fields["high_depar_code"] = "상위 부서 코드" 
 * $result : $result->fields["depar_admin_seqno"] = "부서 관리 일련번호" 
 * 
 * return : list
 */
function makeMngList($conn, $result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $name = $result->fields["name"];
        $empl_seqno = $result->fields["empl_seqno"];
        $empl_id = $result->fields["empl_id"];
        $sell_site = $result->fields["sell_site"];
        $cpn_admin_seqno = $result->fields["cpn_admin_seqno"];
        $depar_name = $result->fields["depar_name"];
        $job_name = $result->fields["job_name"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" onclick=\"popMngView(%d, %d)\" class=\"orge btn_pu btn fix_height20 fix_width40\">수정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $sell_site, $depar_name, $name, 
                $job_name, $empl_id, $empl_seqno, $cpn_admin_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/* 
 * 관리자 권한 list  생성 
 * $result : $result->fields["name"] = "관리자명" 
 * $result : $result->fields["empl_seqno"] = "직원 일련번호" 
 * $result : $result->fields["empl_id"] = "직원 id" 
 * $result : $result->fields["sell_site"] = "판매 채널" 
 * $result : $result->fields["depar_name"] = "부서명" 
 * $result : $result->fields["high_depar_code"] = "상위 부서 코드" 
 * $result : $result->fields["depar_admin_seqno"] = "부서 관리 일련번호" 
 * 
 * return : list
 */
function makeMngAuthList($result, $list_count) {

    $ret = "";
    $i = 1 * ($list_count+1);

    while ($result && !$result->EOF) {

        $depar_name = $result->fields["depar_name"];
        $name = $result->fields["name"];
        $empl_id = $result->fields["empl_id"];
        $empl_seqno = $result->fields["empl_seqno"];
        $sell_site = $result->fields["sell_site"];
        $cpn_admin_seqno = $result->fields["cpn_admin_seqno"];

        if ($i%2 == 1) {
            $list  = "\n  <tr>";
        } else {
            $list  = "\n  <tr class=\"cellbg\">";
        }
        $list .= "\n    <td>%d</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td>%s</td>";
        $list .= "\n    <td><button type=\"button\" onclick=\"popMngAuthView(%d)\" class=\"orge btn_pu btn fix_height20 fix_width85\">접근권한설정</button></td>";
        $list .= "\n  </tr>";

        $ret .= sprintf($list, $i, $sell_site, $depar_name, $name, 
                $empl_id, $empl_seqno); 

        $result->moveNext();
        $i++;
    }

    return $ret;
}

/*
 * 검색 list 생성
 *
 * @param $arr["col"]  = "컬럼 값"
 * @param $arr["val"]  = "컬럼에 해당하는 value 값"
 * @param $arr["type"]  = "검색 한 필드(함수명에 들어갈 이름)"
 *
 * return : list
 */
function makeSearchSeqList($result, $type) {

    $buff = "";

    while ($result && !$result->EOF) {

        $name = $result->fields["name"]; 
        $empl_seqno = $result->fields["empl_seqno"]; 

        $opt_arr[$empl_seqno . "♪@♭" . $name] = $name; 
        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" . $type . "Click('" . $key;
            $buff .= "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}



?>
