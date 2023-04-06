<?
include_once(dirname(__FILE__)."/../_header.php");
header("Content-Type: text/html; charset=utf-8");

if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

switch($mode)
{
	case "idchk" :
		if(!preg_match("/^([A-Za-z0-9_]{4,20})$/", $_POST['admid']))
		{
			echo("001");
			exit;
		}

		if($cfg['unid'])
		{
			$unid = explode(",", $cfg['unid']);
			if(in_array($_POST['admid'], $unid))
			{
				echo("001");
				exit;
			}
		}

		$sqry = sprintf("select * from %s where userid='%s'", SW_MEMBER, $_POST['admid']);
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
		$sqry = sprintf("select * from %s where email='%s' and idx <> '%s'", SW_MEMBER, $_POST['email'], $idx);
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

		$sqry = sprintf("select * from %s where nick='%s'", SW_MEMBER, $_POST['nick']);
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
