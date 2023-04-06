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
		$row = $db->_fetch("select * from sw_taste where idx='".$idx."'");

		$point = str_replace(",", "", $point);
		if(!empty($_FILES['video']['name']))
		{
			@FileDelete($row['video'], $_SERVER['DOCUMENT_ROOT']."/upload/goods/big");

			$video = FileUpload($_FILES['video'], $row['video'], $_SERVER[DOCUMENT_ROOT].'/upload/goods/big');
		}
		else
		{
			if(${'video'})
			{
				$video = $row['video'];
			}
			else
			{
				@FileDelete($row['video'], $_SERVER['DOCUMENT_ROOT']."/upload/goods/big");

				$video = $row['video'];
			}
		}

		$zip = sprintf("%s", ($zip ? $zip : $row['zip']));
		$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
	//	$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
		$mailing = ($mailing) ? $mailing : "Y";
		$bsms = ($bsms) ? $bsms : "Y";

		if(!strcmp($chgpass, "Y"))
			$addQry = sprintf(", pwd='%s'", $db->_password($pwd));

		$emotion	= ($emotion) ? $emotion : 0;
		// $usqry = sprintf("update %s set hp='%s', name='%s', email='%s',photo='%s' ,zip='%s',adr1='%s',adr2='%s',mailing='%s',bsms='%s' ,nick='%s' %s", "sw_taste",  $hp, $name,$email, $imgName1, $zip, ($adr1 ? $adr1 : $row['adr1']), ($adr2 ? $adr2 : $row['adr2']), $mailing,$bsms,   $nick,  $addQry);
		// $usqry .= sprintf(" where idx='%d'", $idx);
    $usqry = "update sw_taste set
		 					title    	  = '".$title."',
		 					content 	  = '".$content."',
							video 		  = '".$video."',
		 					swhappy 		= '".$swhappy."',
		 					swsad 	 		= '".$swsad."',
		 					swangry 	  = '".$swangry."',
		 					swsurpr 	  = '".$swsurpr."',
		 					swscar 	    = '".$swscar."',
		 					swdisgus 	  = '".$swdisgus."',
		 					bhappy 		  = '".$bithappy."',
		 					bsad 	 		  = '".$bitsad."',
		 					bangry 	    = '".$bitangry."',
		 					bsurpr 	    = '".$bitsurpr."',
		 					bscar 	    = '".$bitscar."',
		 					bdisgus 	  = '".$bitdisgus."',
		 					slthappy 		= '".$sthappy."',
		 					sltsad 	 		= '".$stsad."',
		 					sltangry 	  = '".$stangry."',
		 					sltsurpr 	  = '".$stsurpr."',
		 					sltscar 	  = '".$stscar."',
		 					sltdisgus 	= '".$stdisgus."',
		 					sourhappy   = '".$sohappy."',
		 					soursad 	 	= '".$sosad."',
		 					sourangry 	= '".$soangry."',
		 					soursurpr 	= '".$sosurpr."',
		 					sourscar 	  = '".$soscar."',
		 					sourdisgus 	= '".$sodisgus."',
		 					spchappy 		= '".$sphappy."',
		 					spcsad 	 		= '".$spsad."',
		 					spcangry 	  = '".$spangry."',
		 					spcsurpr 	  = '".$spsurpr."',
		 					spcscar 	  = '".$spscar."',
		 					spcdisgus 	= '".$spdisgus."',
		 					emotion 		= '".$emotion."',
		 					sweetstp 		= '".$mood1."',
		 					bitstp 			= '".$mood2."',
		 					saltstp 	  = '".$mood3."',
		 					sourstp 	  = '".$mood4."',
		 					spicystp 	  = '".$mood5."',
		 					updt 		    = now()
							where idx   = '".$idx."'" ;

		if($db->_execute($usqry))
		{
			msgGoUrl("목록이 정상적으로 수정되었습니다.", "/sadm/product/history.edit.php?encData=".$encData);
		}
		else
			ErrorHtml($usqry);

	break;

	case "del" :

		$dsqry = sprintf("update sw_taste set updt = now() where idx='".$idx."'");
		if($db->_execute($dsqry))
		{
 			msgGoUrl("목록이 정상적으로 삭제되었습니다.", "/sadm/product/index.php");
		}
		else
			ErrorHtml($dsqry);
	break;


	case "del2" :
		$row = $db->_fetch("select * from sw_taste where idx='".$idx."'");
		@FileDelete($row['video'], $_SERVER['DOCUMENT_ROOT']."/upload/goods/big");

		$dsqry = sprintf("delete from sw_taste where idx='".$idx."'");
		if($db->_execute($dsqry))
		{
 			msgGoUrl("목록이 정상적으로 삭제되었습니다.", "/sadm/product/index.php");
		}
		else
			ErrorHtml($dsqry);
	break;

 // case "leave" :
	//  $dsqry = sprintf("update sw_member set `leave` ='1', status = 0 , leave_date =now()  ,updt=now()  where idx='".$idx."'");
	//  if($db->_execute($dsqry))
	//  {
	// 		 msgGoUrl("회원이 정상적으로 탈퇴되었습니다.", "./index.php");
	//  }
	//  else
	// 	 ErrorHtml($dsqry);
 // break;
 //
	// case "recover" :
	// 	$dsqry = sprintf("update  sw_member set `leave` ='0', status = 1 ,leave_date ='' ,updt=now()  where idx='".$idx."'");
	// 	if($db->_execute($dsqry))
	// 	{
 // 			msgGoUrl("회원이 정상적으로 복구되었습니다.", "./index.php");
	// 	}
	// 	else
	// 		ErrorHtml($dsqry);
	// break;

	case "imgdel" :
		$row = $db->_fetch("select * from sw_taste where idx='".$idx."'");

		$sql = "update sw_taste set video='' where idx='".$row['idx']."'";
		if($db->_execute($sql))
		{
			@FileDelete($row['video'], $_SERVER['DOCUMENT_ROOT']."/upload/goods/big");
			msgGoUrl("사진이 삭제되었습니다.", "/sadm/product/history.edit.php?encData=".$encData);
		}
		else
		{
			ErrorHtml($sql);
		}
	break;

	// default :
  //
	// 	$chk_id = sprintf("select * from %s where userid=TRIM('%s')", "sw_member", $userid);
	// 	if($db->isRecodeExists($chk_id))
	// 		msg("이미등록된 아이디 입니다.", -1, true);
  //
	// 		$user_phone = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $user_phone);
  //
  //
  //
	// 	if(!empty($_FILES['img1']['name']))
	// 	{
	// 		$imgName1 = FileUpload($_FILES['img1'], $_FILES['img1'], $_SERVER[DOCUMENT_ROOT].'/upload/member');
	// 		crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/member/', $_SERVER[DOCUMENT_ROOT].'/upload/member/thum/',"300");
	// 	}
  //
	// 	$zip = sprintf("%s", $zip);
	// 	$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
	// //	$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
	// 	$mailing = ($mailing) ? $mailing : "Y";
	// 	$bsms = ($bsms) ? $bsms : "Y";
	// 	$isqry = "insert into sw_member set
	// 				userid	=	'".$userid."',
	// 				name	=	'".$name."',
	// 				nick	=	'".$nick."',
	// 				pwd		=	'".$db->_password($pwd)."',
	// 				hp			=	'".$hp."',
	// 				email			=	'".$email."',
	// 				zip	=	'".$zip."',
	// 				adr1	=	'".$adr1."',
	// 				adr2	=	'".$adr2."',
	// 				mailing	=	'".$mailing."',
	// 				bsms	=	'".$bsms."',
	// 				ip = '".$_SERVER['REMOTE_ADDR']."',
	// 				vcnt = 0,
	// 				status = 1,
	// 				user_type = 1,
	// 				photo	='".$imgName1."',
	// 				regdt = now()
	// 			";
  //
	// 	if($db->_execute($isqry))
	// 	{
 	// 		msgGoUrl("회원이 정상적으로 등록되었습니다.", "./index.php");
	// 	}
	// 	else
	// 		ErrorHtml($isqry);
  //
	// break;
}
?>
