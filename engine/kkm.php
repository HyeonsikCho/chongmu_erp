#! /usr/local/bin/php -f
<?

include_once('/home/dprinting/public_html/engine/common/ConnectionPool.php');

/** 
 * @brief 데이터 삽입 쿼리 함수 (공통)<br>
 *        param 배열 설명<br>
 *        $param : $param["table"] = "테이블명"<br>
 *        $param["col"]["컬럼명"] = "데이터" (다중)<br>
 * @param $conn DB Connection
 * @param $param 파라미터 인자 배열
 * @return boolean
 */ 


print_r($argv);
