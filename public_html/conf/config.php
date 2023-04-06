<?
//@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');
// ini_set("session.cookie_domain", ".abcde.co.kr"); // 'www.abcde.co.kr' 와 'abcde.co.kr' 쿠키를 공유시킬때 이렇게 지정함
header("Content-Type: text/html; charset=utf-8");
error_reporting(0);
session_start();
if(count($_GET)) extract($_GET);
if(count($_POST)) extract($_POST);
if(count($_SERVER)) extract($_SERVER);
if(count($_SESSION)) extract($_SESSION);
if(count($_COOKIE)) extract($_COOKIE);
if(count($_FILES))
{
	while(list($key,$value)=each($_FILES))
	{
		$$key = $_FILES[$key][tmp_name];
		$str = "$key"."_name";
		$$str = $_FILES[$key][name];
		$str = "$key"."_size";
		$$str = $_FILES[$key][size];
	}
}

define("_SW_URL_", "http://".$_SERVER['HTTP_HOST']);
define("_SW_PATH_", str_replace("conf/config.php", "", str_replace("\\", "/", __FILE__)));

if(!defined("_SW_LOADED_LIB_"))
{
	require(_SW_PATH_."conf/conf.db.php");
	require(_SW_PATH_."conf/conf.define.php");
	require(_SW_PATH_."lib/class.MysqlHandler.php");
	require(_SW_PATH_."lib/class.MysqliHandler.php");
	require(_SW_PATH_."lib/class.json.php");
	require(_SW_PATH_."lib/class.Board.php");
	require(_SW_PATH_."lib/func.file.php");
	require(_SW_PATH_."lib/func.util.php");
	require(_SW_PATH_."lib/func.js.php");
	// require(_SW_PATH_."lib/libs.pbkdf2.php");

	define("_SW_LOADED_LIB_", true);
}
?>
