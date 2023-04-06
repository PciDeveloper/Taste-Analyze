<?
include_once(dirname(__FILE__)."/../inc/_header.php");

switch($mode)
{
	case "idchk" :  
		$sqry = sprintf("select * from %s where userid='%s'", "sw_member", $_POST['userid']);
		if($db->isRecodeExists($sqry))
		{
			echo("002");
			exit;
		}
		else
		{
			echo("000");
			exit;
		}

	break;


	case "email" :
		$sqry = sprintf("select * from %s where email='%s'", SW_MEMBER, $_POST['email']);
		if($db->isRecodeExists($sqry))
		{
			echo("002");
			exit;
		}
		else
		{
			echo("000");
			exit;
		}
	break;
	case "update_email" :
		$sqry = sprintf("select * from %s where email='%s' and idx <> '%s'", "sw_member", $_POST['email'], $idx);
		if($db->isRecodeExists($sqry))
		{
			echo("002");
			exit;
		}
		else
		{
			echo("000");
			exit;
		}
	break;
	case "nick" :
		if(!preg_match("/^[A-Za-z0-9_가-힣\x20\-]+$/", $_POST['nick']))
		{
			echo("001");
			exit;
		}

		$sqry = sprintf("select * from %s where nick='%s'", "sw_member", $_POST['nick']);

		if($db->isRecodeExists($sqry))
		{
			echo("002");
			exit;
		}
		else
		{
			echo("000");
			exit;
		}
	break;
}
?>
