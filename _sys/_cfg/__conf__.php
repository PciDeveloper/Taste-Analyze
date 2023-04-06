<?php
header("Content-Type: text/html; charset=utf-8");
//session_name("swmall");
//ini_set("session.cookie_domain", ".swmall.co.kr");
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if(count($_GET)) extract($_GET);
if(count($_POST)) extract($_POST);
if(count($_SERVER)) extract($_SERVER);
if(count($_SESSION)) extract($_SESSION);
if(count($_COOKIE)) extract($_COOKIE);
if(count($_FILES))
{
	foreach($_FILES as $key=>$value)
	{
		$$key = $_FILES[$key]['tmp_name'];
		$str = "$key"."_name";
		$$str = $_FILES[$key]['name'];
		$str = "$key"."_size";
		$$str = $_FILES[$key]['size'];
	}
}

define("_SW_URL_", "http://".$_SERVER['HTTP_HOST']);
define("_SW_PATH_", str_replace("_cfg/__conf__.php", "", str_replace("\\", "/", __FILE__)));
define("_DOCUMENT_ROOT_", $_SERVER['DOCUMENT_ROOT']);
define("_REMOTE_ADDR_", $_SERVER['REMOTE_ADDR']);
$today = date('Y-m-d');

if(!defined("_SW_LOADED_LIBS_"))
{
	require_once(_SW_PATH_."_cfg/__db__.php");
	require_once(_SW_PATH_."_cfg/__define__.php");
	require_once(_SW_PATH_."_libs/class.MysqliHandler.php");
	require_once(_SW_PATH_."_libs/libs.func.php");
	require_once(_SW_PATH_."_libs/libs.js.php");
	require_once(_SW_PATH_."_libs/libs.dir.php");
	require_once(_SW_PATH_."_libs/libs.file.php");
	require_once(_SW_PATH_."_libs/libs.shop.php");

	require_once(_SW_PATH_."_cfg/inf.shop.php");
	require_once(_SW_PATH_."_cfg/inf.conf.php");
	require_once(_SW_PATH_."_cfg/inf.lang.php");

	require_once(_SW_PATH_."_libs/class.BoardHandler.php");

	if(_is_sinbiweb()) define("__IS_SINBIWEB__", true);
	define("_SW_LOADED_LIBS_", true);
	// ip blocking //
	require_once(_SW_PATH_."_cfg/inf.ip.php");
	if($ip['blockingip'] && !__IS_SINBIWEB__)
	{
		$ar_blocking_ip = explode("|", $ip['blockingip']);
		if(is_array($ar_blocking_ip) && count($ar_blocking_ip) > 0)
		{
			if(in_array(_REMOTE_ADDR_, $ar_blocking_ip))
				gourl("/error/404.html");
		}
	}

	// 데모 설정 --- 신비웹은 제외 //
	if(!__IS_SINBIWEB__) define("__DEMO__", true);

	define("_CURR_DIR_", _get_curr_dir());
	define("_CUR_PAGE_NM_", $_get_curr_page);


	$is_mobile = (_is_agent_mobile()) ? true : false;
}
?>
