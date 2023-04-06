<?
include_once(dirname(__FILE__)."/../inc/_header.php");

if(!strcmp($act, 'logout'))
{
	unset($_SESSION['SES_USERID'], $_SESSION['SES_USEREM'], $_SESSION['SES_USERNM'], $_SESSION['SES_USERLV'], $_SESSION['SES_USERIDX'], $_SESSION['SES_GUEST'], $_SESSION['$user_info_json'] , $_SESSION['SES_KAKAO'] , $_SESSION['SES_NAVER']);
	goUrl("/index.php");
}
else
{
	if(!preg_match("/^[a-zA-Z0-9]{1}[a-zA-Z0-9_-]{3,12}$/", $pwd))
		msg("회원비밀번호는 공백없이 영문자, 숫자, _ 만 사용 가능합니다.", -1, true);

	$sqry = sprintf("select * from %s where status=1 and userid=TRIM('%s')", SW_MEMBER, $userid);
	if($db->isRecodeExists($sqry))
	{
		$row = $db->_fetch($sqry, 1);

		if ($row['changepwd'] == 1){
				$_SESSION['SES_USERID'] = $row['userid'];
				$_SESSION['SES_USERIDX'] = $row['idx'];
				$_SESSION['SES_USEREM'] = $row['email'];
				$_SESSION['SES_USERNM'] = $row['nick'];
				$_SESSION['SES_USERLV'] = $row['userlv'];
				msgGoUrl("비밀번호 변경 후 이용가능합니다.", "/mypage/chagepwd.php");
		}else{
			if(!strcmp($db->_password($pwd), $row['pwd']))
			{
				/// 아이디 저장 /////////////////////////////////////////////////////////////
				if($saveid)
					setCookie("CK_USERID", $row['userid'], time() + 60 * 60 * 24, "/");
				else if($_COOKIE['CK_USERID'])
					SetCookie("CK_USERID", "", 0, "/");


				/// 비밀번호저장 쿠키 저장 //////////////////////////////////////////////////
				if($savepwd)
					setCookie("CK_PWD", $row['pwd'], time() + 60 * 60 * 24, "/");
				else if($_COOKIE['CK_PWD'])
					SetCookie("CK_PWD", "", 0, "/");

				$_SESSION['SES_NAVER'] = false;
				$_SESSION['SES_KAKAO'] = false;
				$_SESSION['SES_USERID'] = $row['userid'];
				$_SESSION['SES_USERIDX'] = $row['idx'];
				$_SESSION['SES_USEREM'] = $row['email'];
				$_SESSION['SES_USERNM'] = $row['nick'];
				$_SESSION['SES_USERLV'] = $row['userlv'];

				$db->_execute("update ".SW_MEMBER." set logdt=now(), vcnt=vcnt+1 where idx='".$row['idx']."'");
				$rurl = ($referer) ? $referer : "/index.php";
				unset($_SESSION['SES_GUEST']);
				goUrl($rurl);
			}
			else
				msgGoUrl("회원님의 비밀번호가 틀립니다.\\n확인 후 다시 로그인 해주세요.", "../index.php");
		}


	}
	else
		msgGoUrl("회원정보가 맞지 않습니다.\\n확인후 다시 로그인 해주세요.", "../index.php");

}
?>
