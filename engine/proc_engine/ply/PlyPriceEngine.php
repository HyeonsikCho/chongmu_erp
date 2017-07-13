#! /usr/local/bin/php -f
<?
/**
 * @file PlyPriceEngine.php
 *
 * @brief 합판 판매가격 엑셀 등록 엔진
 */

$excel_path = $argv[1]; // 엑셀파일 경로
$base_path  = $argv[2]; // include용 기본경로
$sell_site  = $argv[3]; // 판매채널

include_once($base_path . '/common/ConnectionPool.php');
include_once($base_path . '/common/PlyPriceExcelUtil.php');
include_once($base_path . '/dao/PlyPriceRegiDAO.php');
include_once($base_path . '/dao/EngineDAO.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

$priceDAO = new PlyPriceRegiDAO();
$engineDAO = new EngineDAO();

$excelUtil = new PlyPriceExcelUtil();

$excelUtil->initExcelFileReadInfo($excel_path, 6, 4, 1);

$insert_ret = NULL;

//$conn->debug = 1;

$table_name = $priceDAO->selectPlyPriceTableName($conn, $sell_site);
$table_name = $table_name->fields["price_tb_name"];
$table_name = explode('|', $table_name)[0];

$insert_ret = $excelUtil->insertSellPriceInfo($conn, $table_name, $priceDAO);

// 결과로그 생성
$fp = fopen($base_path . "/log/PlyPrice.log", "w");
fwrite($fp, $insert_ret);
fclose($fp);
?>
