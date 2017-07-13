<?
/*
 * select 옵션 값 생성
 * 
 * return : list
 */
function makeOptSeqSetting($result, $type, $name) {

    $buff = "";

    $cnt = $result->recordCount();

    while ($result && !$result->EOF) {

        $data = $result->fields[$type]; 
        $seqno = $result->fields[$name . "_seqno"]; 
        
        if ($data == "") {

        } else {

            $opt_arr[$seqno] = $data; 
        }

        $result->moveNext();
    }

    //후공정 옵션 값을 셋팅
    if (is_array($opt_arr)) {

        $buff .= "<option value=\"\">전체</option>";   
        foreach($opt_arr as $key => $val) {

            $buff .= "<option value=\"" . $key . "\">";
            $buff .= $val . "</option>";
        }
    } else {

        $buff = "<option value=\"\">전체</option>";   
    }

    return $buff;
}

/*
 * select 옵션 값 생성
 * 
 * return : list
 */
function makeOptSetting($result, $type) {

    $buff = "";

    while ($result && !$result->EOF) {

        $data = $result->fields[$type]; 

        if ($type == "depth3") { 

            if ($data == "") {

            } else {

                $opt_arr[$data] = $data; 
            }
        } else {

            $opt_arr[$data] = $data; 

        }
        $result->moveNext();
    }

    //후공정 옵션 값을 셋팅
    if (is_array($opt_arr)) {

        $buff .= "<option value=\"\">전체</option>";   
        foreach($opt_arr as $key => $val) {

            $buff .= "<option value=\"" . $val . "\">";
            $buff .= $key . "</option>";
        }
    } else {

        $buff = "<option value=\"\">전체</option>";   
    }

    return $buff;
}



?>
