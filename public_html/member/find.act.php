<?
include_once(dirname(__FILE__)."/../inc/_header.php");

switch($act)
{
	case "id" :

		$sqry = sprintf("select * from sw_member where name=TRIM('%s') and email=TRIM('%s')", $name, $email);
		$row = $db->_fetch($sqry, 1);

		if($row['idx'])
		{
			goUrl("./update_id.php?idx=".$row['idx']); 
		}
		else
		{
			msg("찾으시는 회원님의 정보가 없습니다.");
			exit;
		}

	break;
	case "pwd" :

		$sqry = sprintf("select * from sw_member where name=TRIM('%s') and userid=TRIM('%s')", $name, $userid);
		$row = $db->_fetch($sqry,1);

		if($row['idx'])
		{
			$new_pwd = getTempPwd();
			$db->_execute("update sw_member set pwd='".$db->_password($new_pwd)."' , changepwd = 1 where idx='".$row['idx']."'");

     	msgGoUrl("임시 비밀번호가 발급되었습니다.", "./update_pwd.php?idx=".$row['idx']);
		}
		else
		{
			msg("찾으시는 회원님의 정보가 없습니다.");
			exit;
		}
	break;
}

?>
