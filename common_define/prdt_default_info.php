<?
/**
 * @file PrdtDefaultPosition.php
 *
 * @brief 상품 기본 자리수
 */
class PrdtDefaultInfo {
    // 전지기준 자리수
    const POSITION_NUMBER = array(
        "001001001" => array(
            // 국전지
            "86*52" => 168,
            "90*50" => 160
        ),
        "001001002" => array(
            // 국전지
            "86*52" => 168,
            "90*50" => 160
        ),
        "001001003" => array(
            // 국전지
            "86*54" => 160,
        ),
        "001001004" => array(
            // 국전지
            "86*52" => 168,
            "90*50" => 160
        ),
        "005001001" => array(
			"8절"  => 8,
            "16절" => 16,
            "32절" => 32,
            "A3" => 4,
            "A4" => 8,
            "A5" => 16
        )
    );

    // 카테고리별 수량
    // 낱장형은 합판가격 테이블에서 검색
    const AMT = array(
        "005001001" => array(
            50, 100, 200, 300, 400,
            500, 600, 700, 800, 900,
            1000/*, 1200, 1400, 1600, 1800,
            2000, 2500, 3000, 3500, 4000,
            4500, 5000, 6000, 7000, 8000,
            9000, 10000, 11000, 12000, 13000,
            14000, 15000, 16000, 17000, 18000,
            19000, 20000, 22000, 24000, 26000,
            28000, 30000, 32000, 34000, 36000,
            38000, 40000, 42000, 44000, 46000,
            48000, 50000*/
        )
    );

    // 카테고리 수량단위
    const AMT_UNIT = array(
        "001001001" => "매",
        "005001001" => "부"
    );

    // 페이지수
    // 낱장형은 무조건 표지 2p로 처리
    const PAGE_INFO = array(
        "FLAT" => array(
            "표지" => array(
                2
            )
        ),
        "005001001" => array(
            "표지" => array(
                "2!단면인쇄"/*,
                "4!양면인쇄",
                "6!양면인쇄 앞날개",
                "8!양면인쇄 뒷날개",
                "4!양면인쇄 뒷면홀더",
                "2!단면인쇄 뒷면홀더"*/
            ),
            "내지" => array(
                4, 8, 12, 16,
                20, 24, 28, 32, 36,
                40, 44, 48, 52, 56,
                60, 64, 68, 72, 76,
                80, 84, 88, 92, 96,
                100, 104, 108, 112, 116,
                120, 124, 128/*, 132, 136,
                140, 144, 148, 152, 156,
                160, 164, 168, 172, 176,
                180, 184, 188, 192, 196,
                200, 204, 208, 212, 216,
                220, 224, 228, 232, 236,
                240, 244, 248, 252, 256,
                260, 264, 268, 272, 276,
                280, 284, 288, 292, 296,
                300, 304, 308, 312, 316,
                320*/
            )
        )
    );

    // 여분지 수량
    const EXTRA_PAPER_AMT = array(
        "없음"     => 0,
        "단면 4도" => 25,
        "양면 5도" => 37,
        "양면 8도" => 50,
        "4도"      => 25,
        "1도"      => 10,
        "금별색"   => 25,
        "은별색"   => 25,
        "양면칼라" => 50,
        "양면단색" => 25,
        "양면칼라+별색1가지" => 75,
        "양면단색+별색1가지" => 75
    );
}
?>