<?php
require(dirname(__FILE__)."/../../conf/config.php");
$db = new MysqlHandler();
$db2 = new MysqliHandler();

define('G5_SERVER_TIME',    time());
define('G5_TIME_YMDHIS',    date('Y-m-d H:i:s', G5_SERVER_TIME));
define('G5_TIME_YMD',       substr(G5_TIME_YMDHIS, 0, 10));
define('G5_TIME_HIS',       substr(G5_TIME_YMDHIS, 11, 8));
// ssl //
?>
