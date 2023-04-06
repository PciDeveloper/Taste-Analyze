<?
include_once(dirname(__FILE__)."/../_header.php");

//Debug($_POST);

switch($mode)
{
	case "popup" :

		if($encData)
		{
			$encArr = getDecode64($encData);

			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);

			if($idx)
				$row = $db->_fetch("select * from ".SW_POPUP." where idx='".$idx."'", 1);
		}


		switch($act)
		{
			case "edit" :

				if($imgdel)
				{
					@FileDelete($row['bgimg'], $_SERVER['DOCUMENT_ROOT']."/upload/design");
					@FileDelete("thum_".$row['bgimg'], $_SERVER['DOCUMENT_ROOT']."/upload/design/thum");
				}
				if(!empty($_FILES['bgimg']['name']))
				{
					$fileName = FileUpload($_FILES['bgimg'], $row['bgimg'], $_SERVER['DOCUMENT_ROOT'].'/upload/design');
					crateThumImg1($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"500");
				}
				$buse = ($buse) ? $buse : 0;
				$ptop = ($ptop) ? $ptop : 0;
				$pleft = ($pleft) ? $pleft : 0;

				$usqry = "update ".SW_POPUP." set
							buse = '$buse',
							title = '".getAddslashes($title)."',
							sday = '$sday',
							eday = '$eday',
							width = '$width',
							height = '$height',
							ptop = '$ptop',
							pleft = '$pleft',
							ptype = '1',
							content = '".getAddslashes($content)."' ";

				if(!empty($_FILES['bgimg']['name']))
					$usqry .= ", bgimg='$fileName'";
				else if($imgdel)
					$usqry .= ", bgimg=''";

				$usqry .= " where idx='".$idx."'";


				if($db->_execute($usqry))
					msgGoUrl("팝업창 정보가 수정되었습니다.", "./popup.edit.php?encData=".$encData);
				else
					ErrorHtml($usqry);

			break;
			case "del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_POPUP, $idx);

				if($db->_execute($dsqry))
				{
					@FileDelete($row['bgimg'], $_SERVER['DOCUMENT_ROOT']."/upload/design");
					@FileDelete("thum_".$row['bgimg'], $_SERVER['DOCUMENT_ROOT']."/upload/design/thum");
					msgGoUrl("팝업창 삭제되었습니다.", "./index.php?encData=".$encData);
				}
				else
					ErrorHtml($isqry);

			break;
			default :
				if(!empty($_FILES['bgimg']['name']))
				{
					$fileName = FileUpload($_FILES['bgimg'], '', $_SERVER['DOCUMENT_ROOT'].'/upload/design');
					crateThumImg1($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"500");
				}
				$buse = ($buse) ? $buse : 0;
				$ptop = ($ptop) ? $ptop : 0;
				$pleft = ($pleft) ? $pleft : 0;

				$isqry = "insert into ".SW_POPUP." set
							buse = '$buse',
							title = '".getAddslashes($title)."',
							sday = '$sday',
							eday = '$eday',
							ptype = '1',
							width = '$width',
							height = '$height',
							ptop = '$ptop',
							pleft = '$pleft',
							content = '".getAddslashes($content)."',
							bgimg = '$fileName',
							regdt = now()
						";

				if($db->_execute($isqry))
					msgGoUrl("새로운 팝업창이 생성되었습니다.", "./index.php");
				else
					ErrorHtml($isqry);
			break;
		}

	break;
	case "banner" :

		if($encData)
		{
			$encArr = getDecode64($encData);

			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);

			if($idx)
				$row = $db->_fetch("select * from ".SW_BANNER." where idx='".$idx."'", 1);
		}

		switch($act)
		{
			case "grp_del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_BANNER_GRP, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("해당 배너그룹이 삭제되었습니다.", "./banner.list.php");
				else
					ErrorHtml($dsqry);

			break;
			case "grp_reg" :
				$isqry = sprintf("insert into %s set code='%s', name='%s', urltype='%s' , regdt=now()", SW_BANNER_GRP, $code, getAddslashes($name) , $urltype);
				if($db->_execute($isqry))
					msgGoUrl("새로운 배너그룹이 생성되었습니다.", "./win.banner.php");
				else
					ErrorHtml($isqry);
			break;
			case "grp_sdel" :
				$ok = $err = 0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$dsqry = sprintf("delete from %s where idx='%d'", SW_BANNER_GRP, $chk[$i]);
						if($db->_execute($dsqry))
							$ok++;
						else
							$err++;
					}
				}
				msgGoUrl("총".$ok."건의 배너그룹이 삭제되었습니다.", "./win.banner.php");
			break;
			case "edit" :
				if($imgdel)
					@FileDelete($row['img'], "../../upload/design");

				if(!empty($_FILES['img']['name']))
					$fileName = FileUpload($_FILES['img'], $row['img'], $_SERVER[DOCUMENT_ROOT].'/upload/design');

				crateThumImg2($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"1090" , "200");

				$buse = ($buse) ? $buse : 'Y';
				if(!strcmp($target, "_blank")) $url = setHttp($url);

				$usqry = sprintf("update %s set buse='%s', name='%s', sday='%s', eday='%s', ", SW_BANNER, $buse, getAddslashes($name), $sday, $eday );
				if(!empty($_FILES['img']['name']))
					$usqry .= sprintf("img='%s', ", $fileName);
				else if($imgdel)
					$usqry .= "img='', ";
				$usqry .= sprintf("target='%s', url='%s' where idx=%d", $target, $url, $idx);

				if($db->_execute($usqry))
					msgGoUrl("해당 배너정보가 수정되었습니다.", "./banner.edit.php?encData=".$encData);
				else
					ErrorHtml($usqry);
			break;
			case "del" :

				$dsqry = sprintf("delete from %s where idx='%d'", SW_BANNER, $idx);
				if($db->_execute($dsqry))
				{
					@FileDelete($row['img'], "../../upload/design");
					msgGoUrl("배너정보가 삭제되었습니다.", "./banner.list?encData=".$encData);
				}
				else
					ErrorHtml($dsqry);

			break;
			default :
				if(!empty($_FILES['img']['name']))
					$fileName = FileUpload($_FILES['img'], '', $_SERVER[DOCUMENT_ROOT].'/upload/design');

				crateThumImg2($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"1090" , "200");

				$buse = ($buse) ? $buse : 'Y';
				if(!strcmp($target, "_blank")) $url = setHttp($url);

				$isqry = "insert into ".SW_BANNER." set
							code='$code',
							buse='$buse',
							name='".getAddslashes($name)."',
							sday = '$sday',
							eday = '$eday',
							img = '$fileName',
							target = '$target',
							url = '$url',
							regdt = now()
						";

				if($db->_execute($isqry))
					msgGoUrl("새로운 배너가 추가되었습니다.", "./banner.list.php");
				else
					ErrorHtml($isqry);

			break;
		}
	break;
	case "visual" :
		if($idx)
			$row = $db->_fetch("select * from ".SW_VISUAL." where idx='".$idx."'");

		switch($act)
		{
			case "edit" :
				if($imgdel)
				{
						@FileDelete($row['img'], "../../upload/design");
						@FileDelete("thum_".$row['img'], "../../upload/design/thum");
				}

				if(!empty($_FILES['img']['name']))
				{
					$fileName = FileUpload($_FILES['img'], $row['img'], $_SERVER[DOCUMENT_ROOT].'/upload/design');
					crateThumImg1($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"500");
				}

				$buse = ($buse) ? $buse : 'Y';
				if(!strcmp($target, "_blank")) $url = setHttp($url);

				$sqry = sprintf("update %s set buse='%s', gubun='%s', title='%s', ", SW_VISUAL, $buse, $gubun, getAddslashes($title));
				if(!empty($_FILES['img']['name']))
					$sqry .= sprintf("img='%s', ", $fileName);
				else if($imgdel)
					$usqry .= "img='', ";
				$sqry .= sprintf("target='%s', url='%s' where idx=%d", $target, $url, $idx);

				if($db->_execute($sqry))
				{
					if($gubun = 'P')
						msgGoUrl("메인이미지가 수정되었습니다.", "./visual.list.php", "P");
					else
						msgGoUrl("출석 배너 이미지가 수정되었습니다.", "./visual.list2.php", "P");
				}
				else
					ErrorHtml($sqry);
			break;
			case "del" :
				$sqry = sprintf("delete from %s where idx=%d", SW_VISUAL, $idx);

				if($db->_execute($sqry))
				{
					@FileDelete($row['img'], "../../upload/design");
					@FileDelete("thum_".$row['img'], "../../upload/design/thum");
					msgGoUrl("메인이미지가 삭제되었습니다.", "./visual.list.php");
				}
				else
					ErrorHtml($sqry);
			break;
			case "visualdel" :
				$sqry = sprintf("delete from %s where idx=%d", SW_VISUAL, $idx);

				if($db->_execute($sqry))
				{
					@FileDelete($row['img'], "../../upload/design");
					@FileDelete("thum_".$row['img'], "../../upload/design/thum");
					msgGoUrl("출석배너 이미지가 삭제되었습니다.", "./visual.list2.php");
				}
				else
					ErrorHtml($sqry);
			break;
			case "change" :
				if(!strcmp($mode, "up"))
				{
					if($row['rank'] == 1)
						msg("최상위 메인이미지 입니다.", '', true);
					else
					{
						/*
						print("update ".SW_VISUAL." set rank=rank-1 where idx='".$row['idx']."'<br/>");
						print("update ".SW_VISUAL." set rank=rank+1 where rank='".($row['rank']-1)."'");

						exit;
						*/
						$db->_execute("update ".SW_VISUAL." set seq=seq+1 where seq='".($row['seq']-1)."'");
						$db->_execute("update ".SW_VISUAL." set seq=seq-1 where idx='".$row['idx']."'");
					}
				}
				else
				{
					list($minrank) = $db->fetch("select max(seq) from ".SW_VISUAL);

					if($minrank == $row['seq'])
						msg("최하위 메인이미지 입니다.", '', true);
					else
					{
						$db->_execute("update ".SW_VISUAL." set seq=seq-1 where seq='".($row['seq']+1)."'");
						$db->_execute("update ".SW_VISUAL." set seq=seq+1 where idx='".$row['idx']."'");
					}
				}

				msgGoUrl("메인이미지 노출순위가 변경되었습니다.", "./visual.list.php", "P");
			break;
			default :
				if(!empty($_FILES['img']['name']))
				{
					$fileName = FileUpload($_FILES['img'], '', $_SERVER[DOCUMENT_ROOT].'/upload/design');
					crateThumImg1($fileName, $_SERVER[DOCUMENT_ROOT].'/upload/design/', $_SERVER[DOCUMENT_ROOT].'/upload/design/thum/',"500");
				}
				if(!strcmp($target, "_blank")) $url = setHttp($url);

				$buse = ($buse) ? $buse : 'Y';
				$rank = $db->getMaxNum(SW_VISUAL, "seq", "gubun='".$gubun."'");

				$sqry = "insert into ".SW_VISUAL." set
							buse = '$buse',
							gubun='$gubun',
							seq = '$rank',
							title = '".getAddslashes($title)."',
							img = '$fileName',
							target = '$target',
							url = '$url',
							regdt = now()
						";

				if($db->_execute($sqry))
				{
					if($gubun == "P")
						msgGoUrl("새로운 메인이미지가 추가되었습니다.", "./visual.list.php", "P");
					else
						msgGoUrl("새로운 출석배너 이미지가 추가되었습니다.", "./visual.list2.php", "P");
				}
				else
					ErrorHtml($sqry);
			break;
		}
	break;
}
?>
