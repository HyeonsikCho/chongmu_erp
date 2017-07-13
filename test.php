#! /usr/local/bin/php -f
<?
/*
include_once('/home/dprinting/public_html/define/order_info_html.php');
include_once('/home/dprinting/public_html/engine/common/ConnectionPool.php');

$connectionPool = new ConnectionPool();
$conn = $connectionPool->getPooledConnection();

echo $conn->qstr(OrderInfoHtml::ORDER_PAY_INFO, get_magic_quotes_gpc()) . "\n";

$conn->Close();
*/

$t = array(1,2,3,4,5,6,7,8);

foreach ($t as $v) {
    echo $v . "\n";
}

echo "---------- \n";

foreach ($t as $v) {
    echo $v . "\n";
}

?>
