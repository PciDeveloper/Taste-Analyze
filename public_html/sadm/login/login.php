<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$cfg[shopnm]?> 관리자 로그인</title>
<link href="../css/css.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("input[name='admid']").focus();
});
</script>
</head>
<body style="margin:0px;">
<form name="fm" method="post" action="./login.act.php" onSubmit="return chkForm(this);" autocomplete="off">
<input type="hidden" name="returnUrl" value="<?=$_REQUEST['returnUrl']?>">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="50%"></td>
			<td align="center" >
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td valign="top" height="100%" style="padding:0 0 150px 0;">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr><td><img src="../img/login/login_top.gif" alt="" /></td></tr>
						<tr>
							<td>
								<table cellpadding="5" cellspacing="0" border="0">
								<tr>
									<td height="28"><img src="../img/login/login_id.gif" alt="아이디" /></td>
									<td class="lp10" style="background:url('../img/login/login_linebg.gif') repeat-x center;">
										<input type="text" name="admid" style="ime-mode:inactive;width:214px;background:transparent;border:0px;font:8pt verdana;color:333333" exp="관리자 아이디를" />
									</td>
								</tr>
								<tr>
									<td height="28"><img src="../img/login/login_password.gif" alt="패스워드" /></td>
									<td class="lp10" style="background:url('../img/login/login_linebg.gif') repeat-x center;">
										<input type="password" name="admpw" style="ime-mode:inactive;width:214px;background:transparent;border:0px;font:8pt verdana;color:333333" exp="관리자 비밀번호를" chktype="passchk" />
									</td>
								</tr>
								<tr><td colspan="2" height="10"></td></tr>
								<tr>
									<td></td>
									<td><input type="image" src="../img/login/login_btn.gif" alt="로그인" /></td>
								</tr>
								</table>
							</td>
						</tr>
						<tr><td height="40"></td></tr>
						<tr>
							<td align="center" style="font:8pt Dotum;letter-spacing:0px;padding-top:3px;color:#616161;">Copyright <?=$cfg[shopnm]?>. All rights reserved. Design by Wooriyo</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
			</td>
			<td width="50%" style="background:url('../img/login/login_bg_right.gif') repeat-x left top;"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</form>
</body>
</html>
