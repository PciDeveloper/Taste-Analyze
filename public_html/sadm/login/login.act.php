<?
include_once dirname(__FILE__)."/../../conf/config.php";
$db = new MysqlHandler();
if(!strcmp($act, "logout"))
{
	unset($_SESSION['SES_USERID'], $_SESSION['SES_USEREM'], $_SESSION['SES_USERNM'], $_SESSION['SES_USERLV'], $_SESSION['SES_USERIDX'], $_SESSION['SES_GUEST']);
	msgGoUrl("관리자님 로그아웃 되었습니다.", "/sadm/");
}
else
{

	$sqry = sprintf("select * from sw_member where userlv='100' and userid=TRIM('%s') AND pwd=TRIM('%s')", $admid, $db->_password($admpw));
	$row = $db->_fetch($sqry);

	if($row)
	{
		$_SESSION['SES_USERID'] = $row['userid'];
		$_SESSION['SES_USERIDX'] = $row['idx'];
		$_SESSION['SES_USEREM'] = $row['email'];
		$_SESSION['SES_USERNM'] = $row['name'];
		$_SESSION['SES_USERLV'] = $row['userlv'];

 		$db->_execute("update sw_member set vcnt=vcnt+1, logdt=now() WHERE userid='".$row['admid']."'");

			goUrl("/sadm/index.php");
	}
	else
	{
		msg("관리자정보가 맞지 않습니다. 확인후 다시 로그인 해주세요.", -1);
		exit;
	}
}
?>
