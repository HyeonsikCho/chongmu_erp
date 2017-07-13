<?

/*
 * 검색 list 생성
 * 
 * return : list
 */
/*
function makeSearchAddrList($result, $type, $click_func) {

    $buff = "";

    while ($result && !$result->EOF) {

        $addr = "";
        $detail = "";

        $zipcode = $result->fields["zipcode"]; 
        $sido = $result->fields["sido"]; 
        $gugun = $result->fields["gugun"]; 

        //지번 주소 검색일때
        if ($type == "N") {

            //동 검색일때
            if ($result->fields["dong"] != "") {

                $detail = $result->fields["dong"] . " ";

            //읍면 검색일때
            } else if ($result->fields["eup"] != ""){

                $detail = $result->fields["eup"] . " ";

            //리 검색일때
            } else {

                $detail = $result->fields["ri"] . " ";

            }

            $detail .= $result->fields["jibun_bonbun"];

            //지번 부번이 0이 아닐 때
            if ($result->fields["jibun_bubun"] != "0") {

                $detail .= "-" . $result->fields["jibun_bubun"] . " ";
            }

            $detail .= " " . $result->fields["bldg"];

        //도로명 주소 검색일때
        } else {

            $detail  = $result->fields["doro"] . " ";
            $detail .= $result->fields["bldg_bonbun"]; 

            //건물 부번이 0이 아닐 때
            if ($result->fields["bldg_bubun"] != "0") {

                $detail .= "-" . $result->fields["bldg_bubun"]; 

            }

            $detail .= " " . $result->fields["bldg"];

        }

        $addr  = $zipcode . "&nbsp;&nbsp;&nbsp;&nbsp;" . $sido . " ";
        $addr .= $gugun . " " . $detail;

        $opt_arr[] = $addr; 

        $result->moveNext();
    }

    //옵션 값을 셋팅
    if (is_array($opt_arr)) {

        foreach($opt_arr as $key => $val) {

            $buff .= "<a href=\"#\" onclick=\"" . $click_func . "Click('" . $val;
            $buff .= "')\"><li>" . $val . "</li></a>";

        }
    }

    return $buff;
}


*/


?>
