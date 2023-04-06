<?
include_once(dirname(__FILE__)."/../_header.php");
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

switch($act)
{
	case "edit" :

		// $user_phone = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $user_phone);
		$row = $db->_fetch("select * from sw_member where idx='".$idx."'");


		$zip = sprintf("%s", ($zip ? $zip : $row['zip']));
		// $tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
	//	$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
		$mailing = ($mailing) ? $mailing : "Y";
		$bsms = ($bsms) ? $bsms : "Y";

		// if(!strcmp($chgpass, "Y"))
		// 	$addQry = sprintf(", pwd='%s'", $db->_password($pwd));

		// $usqry = sprintf("update %s set birthday='%s', pwd='%s', tel='%s' %s", "sw_member",  $birthday, $pwd, $tel);
		// $usqry .= sprintf(" where idx='%d'", $idx);

		// pwd  					= '"._password($_POST['newpw'])."',

	if($_POST['newpw'] != ""){	//새로운 비밀번호가 있으면

				if($_POST['newpw'] == $_POST['newpwck']){
// create_hash
// pwd					=	'"._password($_POST['newpw'])."' ,
					$usqry = "update sw_member set
									 birthday  = '".$birthday."',
									 pwd  		 = '".$db->_password($_POST['newpw'])."',
									 tel  		 = '".$tel."',
									 updt 		 = now()
									 where idx = '".$idx."'";
				}else{
						msgGoUrl("변경하려는 비밀번호가 일치하지 않습니다.", "./member.edit.php?encData=".$encData);
				}

	}else{
		//비밀번호 변경이 아니라면
		$usqry = "update sw_member set
						 birthday  = '".$birthday."',
						 tel  	   = '".$tel."',
						 updt 		 = now()
						 where idx = '".$idx."'";
	}

		 if($db->_execute($usqry))
		 		msgGoUrl("회원정보가 정상적으로 수정되었습니다.", "./member.edit.php?encData=".$encData);
		 else
			 msg("회원정보 수정도중 오류가 발생하였습니다.\n잠시후 다시 수정부탁드립니다.", "", true);
break;

	case "del" :
		$dsqry = sprintf("update sw_member set `leave` ='1', status='0', leave_date =now() where idx='".$idx."'");
		if($db->_execute($dsqry))
		{
 			msgGoUrl("회원이 정상적으로 삭제되었습니다.", "./index.php");
		}
		else
			ErrorHtml($dsqry);
	break;


	case "del2" :
		$row = $db->_fetch("select * from sw_member where idx='".$idx."'");
		@FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
		@FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

		//글삭제
			$db->_fetch("delete from sw_board where userid='".$row['userid']."'");
		//댓글삭제
			$db->_fetch("delete from sw_comment where userid='".$row['userid']."'");
		//좋아요 삭제
			$db->_fetch("delete from sw_like where mb_id='".$row['userid']."'");


		$dsqry = sprintf("delete  from sw_member  where idx='".$idx."'");
		if($db->_execute($dsqry))
		{
 			msgGoUrl("회원이 정상적으로 삭제되었습니다.", "./member.leave.php");
		}
		else
			ErrorHtml($dsqry);
	break;

 case "leave" :
	 $dsqry = sprintf("update  sw_member set `leave` ='1', status = 0 , leave_date =now()  ,updt=now()  where idx='".$idx."'");
	 if($db->_execute($dsqry))
	 {
			 msgGoUrl("회원이 정상적으로 탈퇴되었습니다.", "./index.php");
	 }
	 else
		 ErrorHtml($dsqry);
 break;

	case "recover" :
		$dsqry = sprintf("update sw_member set `leave` ='0', status = 1 ,leave_date =now() ,updt=now()  where idx='".$idx."'");
		if($db->_execute($dsqry))
		{
 			msgGoUrl("회원이 정상적으로 복구되었습니다.", "./index.php");
		}
		else
			ErrorHtml($dsqry);
	break;

	case "imgdel" :
		$row = $db->_fetch("select * from sw_member where idx='".$idx."'");

		$sql = "update sw_member set photo='' where idx='".$row['idx']."'";
		if($db->_execute($sql))
		{
			@FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
			@FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");
			msgGoUrl("사진이 삭제되었습니다.", "./member.edit.php?encData=".$encData);
		}
		else
		{
			ErrorHtml($sql);
		}
	break;

	default :


		$chk_id = sprintf("select * from %s where userid=TRIM('%s')", "sw_member", $userid);
		if($db->isRecodeExists($chk_id))
			msg("이미등록된 아이디 입니다.", -1, true);

			$user_phone = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $user_phone);



		if(!empty($_FILES['img1']['name']))
		{
			$imgName1 = FileUpload($_FILES['img1'], $_FILES['img1'], $_SERVER[DOCUMENT_ROOT].'/upload/member');
			crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/member/', $_SERVER[DOCUMENT_ROOT].'/upload/member/thum/',"300");
		}

		$zip = sprintf("%s", $zip);
		$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
	//	$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
		$mailing = ($mailing) ? $mailing : "Y";
		$bsms = ($bsms) ? $bsms : "Y";
		$isqry = "insert into sw_member set
					userid	=	'".$userid."',
					name	=	'".$name."',
					nick	=	'".$nick."',
					pwd		=	'".$db->_password($pwd)."',
					hp			=	'".$hp."',
					email			=	'".$email."',
					zip	=	'".$zip."',
					adr1	=	'".$adr1."',
					adr2	=	'".$adr2."',
					mailing	=	'".$mailing."',
					bsms	=	'".$bsms."',
					ip = '".$_SERVER['REMOTE_ADDR']."',
					vcnt = 0,
					status = 1,
					user_type = 1,
					photo	='".$imgName1."',
					regdt = now()
				";

		if($db->_execute($isqry))
		{
 			msgGoUrl("회원이 정상적으로 등록되었습니다.", "./index.php");
		}
		else
			ErrorHtml($isqry);

	break;
}

?>
