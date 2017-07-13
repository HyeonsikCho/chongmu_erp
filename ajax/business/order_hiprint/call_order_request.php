<?php

/********************************************************************
 ***** 배열정의
 ********************************************************************/
$post_data = array();
/*
$post_data = array(
    "after_H06" => "",
    "after_H06_sub" => "",
    "after_H07" => "",
    "after_price[0]" => "3300",
    "after_price[1]" => "5500",
    "after_price[2]" => "5500",
    "after_price[3]" => "5500",
    "after_price[4]" => "16000",
    "after_price[5]" => "0",
    "after_price[6]" => "0",
    "after_price[7]" => "0",
    "After_TPrice"   => "3300",
    "after_W06"      => "",
    "after_W06_sub"  => "",
    "after_W07"      => "",
    "AGroup_1[0]"    => "01",
    "AGroup_1[1]"    => "02",
    "AGroup_1[2]"    => "03",
    "AGroup_1[3]"    => "04",
    "AGroup_1[4]"    => "05",
    "AGroup_1[5]"    => "06",
    "AGroup_1[6]"    => "07",
    "AGroup_1[7]"    => "08",
    "AGroup_1_Sel[]" => "01",
    "AGroup_2[0]"    => "01",
    "AGroup_2[1]"    => "01",
    "AGroup_2[2]"    => "01",
    "AGroup_2[3]"    => "01",
    "AGroup_2[4]"    => "01",
    "AGroup_2[5]"    => "01",
    "AGroup_2[6]"    => "01",
    "AGroup_2[7]"    => "01",
    "Basic_Price"    => "3190",
    "Ca_Code"        => "N11",
    "Color_Code"     => "4",
    "CS_MaxSizeH"    => "",
    "CS_MaxSizeW"    => "",
    "CS_MinSizeH"    => "",
    "CS_MinSizeW"    => "",
    "CutSizeH"       => "52",
    "CutSizeW"       => "86",
    "Digits"         => "1",
    "direct"         => "Y",
    "EditSizeH"      => "54",
    "EditSizeW"      => "88",
    "GD_LB"          => "Y",
    "GD_LT"          => "Y",
    "GD_RB"          => "Y",
    "GD_RT"          => "Y",
    "isNonStand"     => "N",
    "mode"           => "to_cart",
    "Num"            => "1",
    "Page_CaCode"    => "N10",
    "Paper_Code"     => "AT/B/216",
    "Pressure2"      => "76",
    "Price"          => "6490",
    "Pro_Code"       => "N11ATB216N014S1",
    "Pro_Code_basic" => "N11ATB216N014S1",
    "Qty"            => "200.0",
    "S_Code"         => "N01",
    "Side_Code"      => "S",
    "Standard"       => "SEL",
    "TK_Num"         => "4",
    "DSFile"         => "ddddddd.png",
    "DSOriFile"      => "event.png",
    "Memo"           => "hi",
    "Subject"        => "987",
    "DataGubun"      => "0"
);
*/
/********************************************************************
 ***** 주문 데이터 전송
 ********************************************************************/
$rs = file_get_contents('http://www.dprinting.biz:8090/ISAF/Libs/php/doquery_joochong.php');


/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://www.dprinting.biz:8090/ISAF/Libs/php/doquery_joochong.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
$rs = curl_exec($ch);

print_r(curl_getinfo($ch));

curl_close($ch);
*/
/********************************************************************
 ***** 리턴값
 ********************************************************************/

echo $rs;

?>