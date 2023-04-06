<?
include_once(dirname(__FILE__)."/../_header.php");

switch($act)
{
	case "siteedit" :
		$isqry = "update  sw_siteinfo set
					sitename = '$sitename',
					AccountName = '$AccountName',
					AccountBank = '$AccountBank',
					AccountNum = '$AccountNum',
					naverClientID = '$naverClientID',
					naverSecret = '$naverSecret',
					kakaoClientID = '$kakaoClientID',
					kakaoSecret = '$kakaoSecret',
					ceoname = '".$ceoname."',
					address = '".$address."',
					tel = '".$tel."',
					BusinessNum = '".$BusinessNum."',
					updt = now()
			where
				idx ='1'
					";

		if($db->_execute($isqry))
			msgGoUrl("사이트 정보가 수정되었습니다.", "./index.php", "P");
		else
			ErrorHtml($upsqry);
	break;

	case "edit":
		$row = $db->_fetch("select * from sw_member where idx='".$idx."'");
		if(!empty($_FILES['img1']['name']))
		{
			@FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
			@FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");

			$imgName1 = FileUpload($_FILES['img1'], $row['photo'], $_SERVER[DOCUMENT_ROOT].'/upload/member');
			crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/member/', $_SERVER[DOCUMENT_ROOT].'/upload/member/thum/',"300");
		}
		else
		{
			$imgName1 = $row['photo'];
		}

		if(!strcmp($chgpass, 'Y'))
			$addQuery = sprintf(", pwd='%s'", $db->_password($admpw));

		$usqry = sprintf("update sw_member set name='%s',nick='%s',memo='%s', hp='%s', email='%s' ,photo ='%s' %s where idx='%s'",  $name, $nick,$memo, $hp, $email,  $imgName1, $addQuery , $idx);


		if($db->_execute($usqry))
			msgGoUrl("관리자정보가 수정되었습니다.", "./admin.list.php", "P");
		else
			ErrorHtml($usqry);


	break;

	case "imgdel" :
		$row = $db->_fetch("select * from sw_member where idx='".$idx."'");

		$sql = "update sw_member set photo='' where idx='".$row['idx']."'";
		if($db->_execute($sql))
		{
			@FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member");
			@FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/member/thum");
			msgGoUrl("사진이 삭제되었습니다.", "./admin.list.php");
		}
		else
		{
			ErrorHtml($sql);
		}
	break;

	case "del":

		$dsqry = sprintf("delete from %s where idx=%d", SW_MEMBER, $idx);

		if($db->_execute($dsqry))
			msgGoUrl("관리자정보가 삭제되었습니다.", "./admin.list.php", "P");
		else
			ErrorHtml($dsqry);

	break;

	default:

		$memo = getAddslashes($memo);
		$buse = ($buse) ? $buse : 0;

		$isqry = "insert into ".SW_MEMBER." set
					userid = '$admid',
					pwd = '".$db->_password($admpw)."',
					name = '$name',
					nick = '$nick',
					hp = '$hp',
					`email` = '$email',
					vcnt = 0,
					userlv = 100,
					memo = '$memo',
					regdt = now()";

		if($db->_execute($isqry))
			msgGoUrl("새로운 관리자가 등록되었습니다.", "./admin.list.php", "P");
		else
			ErrorHtml($upsqry);

	break;
}
?>
