<?
include_once(dirname(__FILE__)."/../_header.php");
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	if($idx)
		$row = $db->_fetch("select * from ".SW_GOODS." where idx='".$idx."'", 1);

	//$eximg = explode(",", $row['imgetc']);
}

switch($act)
{
	case "edit" :
  	$arr_img_path = array("", "big", "middle", "small", "main");
  		for($d=1; $d < 5; $d++)
  		{
  			if($del[$d])
  			{
  				@FileDelete($row['img'.$d], "../../upload/goods/".$arr_img_path[$d]);
  				$usqry = sprintf("update %s set img%d='' where idx='%d'", SW_GOODS, $d, $idx);
  				$db->_execute($usqry);
  				$row['img'.$d] = "";
  			}
  		}

			if($del[5])
			{
				@FileDelete($row['imgetc'], "../../upload/goods/slide");
				$usqry = sprintf("update %s set imgetc='' where idx='%d'", SW_GOODS,   $idx);

				$db->_execute($usqry);
				$row['imgetc'] = "";
			}

			if(!empty($_FILES['imgetc']['name']))
			{
				$imgSlideName = FileUpload($_FILES['imgetc'], $row['imgetc'], $_SERVER[DOCUMENT_ROOT]."/upload/goods/slide");
				@FileDelete($row['imgetc'], $_SERVER[DOCUMENT_ROOT]."/upload/goods/slide");
				crateThumImg2($imgSlideName, $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/', $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/',"1090" , "350");
				$usqry = sprintf("update %s set imgetc='%s' where idx='%d'", SW_GOODS, $imgSlideName, $idx);
				$db->_execute($usqry);
			}
  		if($imgtype == 1)
  		{
  			if(!empty($_FILES['img1']['name']))
  			{
  				$imgName1 = FileUpload($_FILES['img1'], $row['img1'], "../../upload/goods/big");
  				$imgName2 = $imgName3 = $imgName4 = "thum_".$imgName1;

  				### 기존 섬네일 이미지 삭제 ###
  				@FileDelete($row['img2'], "../../upload/goods/middle");
  				@FileDelete($row['img3'], "../../upload/goods/small");
  				@FileDelete($row['img4'], "../../upload/goods/main");


  				### 섬네일 이미지 생성 ###
  				CreateImageFile($imgName1, $imgName2, '../../upload/goods/big',  "540", "400", '../../upload/goods/middle', 'ratio', true);
  				CreateImageFile($imgName1, $imgName3, '../../upload/goods/big',  "540", "400", '../../upload/goods/small', 'ratio', true);
  				CreateImageFile($imgName1, $imgName4, '../../upload/goods/big',  "540", "400", '../../upload/goods/main', 'ratio', true);


  			}
  			else
  			{
  				$imgName1 = $row['img1'];
  				$imgName2 = $row['img2'];
  				$imgName3 = $row['img3'];
  				$imgName4 = $row['img4'];
					$imgSlideName = $row['imgetc'];
  			}
  		}
  		else if($imgtype == 2)
  		{
  			for($i=1; $i < 5; $i++)
  			{
  				if(!empty($_FILES['img'.$i]['name']))
  					${"imgName".$i} = FileUpload($_FILES['img'.$i], $row['img'.$i], '../../upload/goods/'.$arr_img_path[$i]);
  				else
  					${"imgName".$i} = $row['img'.$i];
  			}
  		}

  		for($e=0; $e < count($_FILES['etcimg']['name']); $e++)
  		{
  			if(!empty($_FILES['etcimg']['name'][$e]))
  			{
  				$etcImgName = ArrFileUpload($_FILES['etcimg']['name'][$e], $_FILES['etcimg']['tmp_name'][$e], $eximg[$e], "../../upload/goods/big");
  				$arImg[] = $etcImgName;
  				CreateImageFile($etcImgName, "thum_".$etcImgName, '../../upload/goods/big',  "540", "400", '../../upload/goods/middle', 'ratio', true);
  			}
  			else
  				$arImg[] = $eximg[$e];
  		}

  		if($arImg) $etcName = implode(",", $arImg);
  		if($icon) $strIcon = implode(",", $icon);
  		$display = ($display) ? $display : "N";
			$maindisplay = ($maindisplay) ? $maindisplay : "N";
  		$price = str_replace(",", "", $price);
  		$nprice = str_replace(",", "", $nprice);

  		$usqry = "update ".SW_GOODS." set
                  name	=	'".$name."',
                  display			=	'".$display."',
									maindisplay			=	'".$maindisplay."',
                  keyword = '".getAddslashes($keyword)."',
									subtitle = '".getAddslashes($subtitle)."',
                  category = '".$category."',
                  price = '$price',
                  nprice = '$nprice',
                  imgtype = '$imgtype',
                  img1 = '$imgName1',
                  img2 = '$imgName2',
                  img3 = '$imgName3',
                  img4 = '$imgName4',
                  etc1	=	'".$etc1."',
                  etc2	=	'".$etc2."',
                  etc3	=	'".$etc3."',
                  etc4	=	'".$etc4."',
                  sday	=	'".$sday."',
                  eday	=	'".$eday."',
                  address	=	'".$address."',
                  content = '".getAddslashes($content)."',
                  shortexp = '".getAddslashes($shortexp)."',
                  notice = '".getAddslashes($notice)."',
        					updt = now()
  				      where idx='$idx'";

  		if($db->_execute($usqry))
  		{
  			msgGoUrl("상품정보가 수정되었습니다.", "./goods.edit.php?encData=".$encData);
  		}
  		else
  			ErrorHtml($usqry);

	break;

	case "del" :
		$dsqry = sprintf("update  sw_member set `leave` ='1', status='0', leave_date =now() where idx='".$idx."'");
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
		$dsqry = sprintf("update  sw_member set `leave` ='0', status = 1 ,leave_date ='' ,updt=now()  where idx='".$idx."'");
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
  if($imgtype == 1)
  {
    $imgName1 = FileUpload($_FILES['img1'], '', '../../upload/goods/big');
    $imgName2 = $imgName3 = $imgName4 = "thum_".$imgName1;

    ### 섬네일이미지 생성 ###
    CreateImageFile($imgName1, $imgName2, '../../upload/goods/big', "540", "400", '../../upload/goods/middle', 'ratio', true);
    CreateImageFile($imgName1, $imgName3, '../../upload/goods/big', "540", "400", '../../upload/goods/small', 'ratio', true);
    CreateImageFile($imgName1, $imgName4, '../../upload/goods/big', "540", "400", '../../upload/goods/main', 'ratio', true);
		crateThumImg2($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/', $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/',"1090" , "350");
  }
  else if($imgtype == 2)
  {
    $imgName1 = FileUpload($_FILES['img1'], '', '../../upload/goods/big');
    $imgName2 = FileUpload($_FILES['img2'], '', '../../upload/goods/middle');
    $imgName3 = FileUpload($_FILES['img3'], '', '../../upload/goods/small');
    $imgName3 = FileUpload($_FILES['img4'], '', '../../upload/goods/main');
		$imgName5 = FileUpload($_FILES['etc1'], '', '../../upload/goods/slide');
  }


    for($f=0; $f <=5; $f++)
    {
      if(!empty($_FILES['etcimg']['name'][$f]))
      {
        $eImgName = ArrFileUpload($_FILES['etcimg']['name'][$f], $_FILES['etcimg']['tmp_name'][$f], "", "../../upload/goods/big");
        $aFile[] = $eImgName;
        CreateImageFile($eImgName, "thum_".$eImgName, '../../upload/goods/big', "540", "400", '../../upload/goods/big', 'ratio', true);
      }
    }

		if(!empty($_FILES['imgetc']['name']))
		{
			$imgSlideName = FileUpload($_FILES['imgetc'], '', $_SERVER[DOCUMENT_ROOT]."/upload/goods/slide");
			@FileDelete($row['imgetc'], $_SERVER[DOCUMENT_ROOT]."/upload/goods/slide");
			crateThumImg2($imgSlideName, $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/', $_SERVER[DOCUMENT_ROOT].'/upload/goods/slide/',"1090" , "350");
		}

		$display = ($display) ? $display : "Y";
		$maindisplay = ($maindisplay) ? $maindisplay : "N";
    $price = str_replace(",", "", $price);
    $nprice = str_replace(",", "", $nprice);
		$isqry = "insert into sw_goods set
          gcode = '".$gcode."',
					name	=	'".$name."',
					display			=	'".$display."',
					maindisplay			=	'".$maindisplay."',
          keyword = '".getAddslashes($keyword)."',
					subtitle = '".getAddslashes($subtitle)."',
          category = '".$category."',
          price = '$price',
          nprice = '$nprice',
          imgtype = '$imgtype',
					img1 = '$imgName1',
					img2 = '$imgName2',
					img3 = '$imgName3',
					img4 = '$imgName4',
          imgetc = '$imgSlideName',
					etc1	=	'".$etc1."',
          etc2	=	'".$etc2."',
          etc3	=	'".$etc3."',
          etc4	=	'".$etc4."',
          sday	=	'".$sday."',
          eday	=	'".$eday."',
					address	=	'".$address."',
          content = '".getAddslashes($content)."',
          shortexp = '".getAddslashes($shortexp)."',
          notice = '".getAddslashes($notice)."',
					regdt = now()
				";

		if($db->_execute($isqry))
		{
      	$db->_execute("update ".SW_GOODS." set seq=seq+1");
 			  msgGoUrl("새로운 상품이 등록되었습니다.", "./index.php");
		}
		else
			ErrorHtml($isqry);

	break;
}
?>
