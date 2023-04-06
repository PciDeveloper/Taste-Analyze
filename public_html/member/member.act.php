<?
include_once(dirname(__FILE__)."/../inc/_header.php");
switch($act)
{
	case "edit" :
		$birthday = sprintf("%4d-%02d-%02d", $year, $month, $day);
		$zip = sprintf("%s-%s", $zip1, $zip2);
		$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
		$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
		$mailing = ($mailing) ? $mailing : "Y";
		$bsms = ($bsms) ? $bsms : "Y";

		if($_SESSION['SES_FACEBOOK'])
		{
			$usqry = sprintf("update %s set name='%s', birthday='%s', sex='%s', zip='%s', adr1='%s', adr2='%s', tel='%s', hp='%s' where userid='%s' ", SW_FBUSER, $name, $birthday, $sex, $zip, $adr1, $adr2, $tel, $hp, $_SESSION['SES_USERID']);
		}
		else
		{
			if(!strcmp($chgemail, "Y"))
			{
				$chk_email = sprintf("select * from %s where email=TRIM('%s') and userid <> '%s'", SW_MEMBER, $email, $_SESSION['SES_USERID']);
				if($db->isRecodeExists($chk_email))
					msg("이미등록된 메일주소 입니다.", -1, true);
			}

			$usqry = sprintf("update %s set name = '%s', birthday = '%s', birtype = '%s', sex = '%s', ", SW_MEMBER, $name, $birthday, $birtype, $sex);
			if(!strcmp($chgpass, "Y"))
				$usqry .= sprintf("pwd = '%s', ", $db->_password($pwd));

			if(!strcmp($chgemail, "Y"))
				$usqry .= sprintf("email = '%s', ", $email);

			$usqry .= sprintf("mailing='%s', zip='%s', adr1='%s', adr2='%s', tel='%s', hp='%s', bsms='%s' where userid='%s'", $mailing, $zip, $adr1, $adr2, $tel, $hp, $bsms, $_SESSION['SES_USERID']);
		}
		if($db->_execute($usqry))
			msgGoUrl("회원정보가 수정되었습니다.", "/mypage/myedit.php");
		else
			ErrorHtml($usqry);
	break;

	case "del" :
	break;

	default :

		$chk_id = sprintf("select * from sw_member where userid=TRIM('%s')", $userid);
		if($db->isRecodeExists($chk_id))
		  msg("이미등록된 아이디 입니다.",-1,true);

		$mailing = ($info_agree) ? $info_agree : "Y";
		$bsms = ($info_agree) ? $info_agree : "Y";

		$isqry = "insert into ".SW_MEMBER." set
					name = '$name',
					nick = '$nick',
					userid = '$userid',
					kakaoid = '$kakaoid',
					userlv = '20',
					pwd = '".$db->_password($pwd)."',
					email = '$email',
					hp = '$hp',
					ip = '".$_SERVER['REMOTE_ADDR']."',
					vcnt = 0,
					status = 1,
					mailing='".$mailing."',
					bsms='".$bsms."',
					regdt = now()
				";
		if($db->_execute($isqry))
		{
      $bidx = $db->getLastID();
      $row = $db->_fetch("select * from sw_member where idx='".$bidx."'");
      $_SESSION['SES_USERID'] = $row['userid'];
      $_SESSION['SES_USERIDX'] = $row['idx'];
      $_SESSION['SES_USEREM'] = $row['email'];
      $_SESSION['SES_USERNM'] = $row['name'];
      $_SESSION['SES_USERLV'] = $row['userlv'];
		 	msgGoUrl("회원가입을 축하드립니다.", "/index.php");
		}

	break;
}
?>
