<?php
require(dirname(__FILE__)."/../conf/config.php");
require(_SW_PATH_."conf/cfg.mall.php");
$cfg = array_map("getStripslashes", $cfg);
$db = new MysqlHandler();
if(!defined("_SW_SELECT_CFG_"))
{
	$swshop = $db->_fetch("select * from sw_config", 1);
	$siteinfo = $db->_fetch("select * from sw_siteinfo", 1);
	define("_SW_SELECT_CFG_", true);
}
$dir = getCurDir();
?>
