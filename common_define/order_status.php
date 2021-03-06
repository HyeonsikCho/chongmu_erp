<?
class OrderStatus {
    const STATUS = array(
        "주문",
        "입금",
        "접수",
        "조판",
        "종이발주",
        "출력",
        "인쇄",
        "후공정",
        "입고"
    );

    const STATUS_PROC = array(
        "주문" => array(
            "대기" => "110"
        ),
        "입금" => array(
            "대기" => "210"
        ),
        "접수" => array(
            "대기" => "310",
            "중"   => "320",
            "교정" => "330",
            "보류" => "340"
        ),
        "조판" => array(
            "대기" => "410",
            "중"   => "420",
            "누락" => "430"
        ),
        "종이발주" => array(
            "대기" => "510",
        ),
        "출력" => array(
            "준비" => "605",
            "대기" => "610"
        ),
        "인쇄" => array(
            "준비" => "705",
            "대기" => "710"
        ),
        "후공정" => array(
            "준비" => "805",
            "대기" => "810"
        ),
        "입고" => array(
            "대기" => "910"
        ),
        "출고" => array(
            "대기" => "010"
        )
    );
	const ORDER_STATUS_ARR = array(
			'100'=>'주문완료',
			'320'=>'접수중',
			'330'=>'시안확인',
			'390'=>'접수완료',
			'400'=>'생산',
			'500'=>'배송준비중',
			'600'=>'배송완료');
}
?>
