#! /usr/local/bin/php -f
<?
include_once('/home/dprinting/nimda/engine/common/ConnectionPool.php');
include_once(dirname(__FILE__) . '/dao/EngineDAO.php');

/** 
 * @brief 회원 등급별 매달 지급포인트, 사용포인트 통계 
 *
 * @param $dvs 지급포인트 or 사용포인트 여부
 */ 

function main() {

    $connectionPool = new ConnectionPool();
    $conn = $connectionPool->getPooledConnection();
    $engineDAO = new EngineDAO();

    /**
     * 엔진 돌리는 현재 년/월을 저장
     */
    $today = date("Y-m-d H:i:s", time());
    
    $year = substr($today, 0, 4);
    $mon = substr($today, 5, 2);
    $day = substr($today, 8, 2);

    $param = array();
    $param["table"] = "mon_member_grade_set";
    $param["col"]  = "m1, m2, m3, m4, m5, m6, m7";
    $param["col"] .= ",m8, m9, m10, m11, m12, day";

    $result = $engineDAO->selectData($conn, $param);

    /**
     *$year = "년도";
     *$mon = "월";
     *$day = "일";
     */
    if ($result->fields["m1"] == "Y") $m1 = "01";
    if ($result->fields["m2"] == "Y") $m2 = "02";
    if ($result->fields["m3"] == "Y") $m3 = "03";
    if ($result->fields["m4"] == "Y") $m4 = "04";
    if ($result->fields["m5"] == "Y") $m5 = "05";
    if ($result->fields["m6"] == "Y") $m6 = "06";
    if ($result->fields["m7"] == "Y") $m7 = "07";
    if ($result->fields["m8"] == "Y") $m8 = "08";
    if ($result->fields["m9"] == "Y") $m9 = "09";
    if ($result->fields["m10"] == "Y") $m10 = "10";
    if ($result->fields["m11"] == "Y") $m11 = "11";
    if ($result->fields["m12"] == "Y") $m12 = "12";

    for($i = 1; $i < 13; $i++) {

        if ($mon == $m . $i) {

            if ($day == $result->fields["day"]) {

                updateMemberGrade();

            }
        }
    }

    $conn->close();
}

function updateMemberGrade() {

    $connectionPool = new ConnectionPool();
    $conn = $connectionPool->getPooledConnection();
    $engineDAO = new EngineDAO();

    exit;

}

/**
 * 매월 1일마다 함수를 실행
 */
main();

?>
