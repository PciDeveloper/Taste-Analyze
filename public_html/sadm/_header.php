<?
include_once dirname(__FILE__)."/../conf/config.php";
include_once(dirname(__FILE__)."/../conf/cfg.mall.php");
// include_once(dirname(__FILE__)."/_sys/_libs/libs.file.php");
// include_once(dirname(__FILE__)."/_sys/_libs/libs.pbkdf2.php");

$db = new MysqlHandler();
$db2 = new MysqliHandler();

if(!defined("_SW_SELECT_CFG_"))
{
	$swshop = $db->_fetch("select * from sw_config", 1);
	define("_SW_SELECT_CFG_", true);
}
 if(!$_SESSION['SES_USERID'])
{
	goUrl("/sadm/login/login.php", "", "P");
	exit;
}
if($_SESSION['SES_USERLV'] != "100"){
	msgGoUrl("접근권한이 없습니다.", "/sadm/login/login.php");
}

ob_start();
?>
