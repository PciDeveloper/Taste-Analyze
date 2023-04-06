<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FIlE__)."/../lib/class.Board.php");
include_once(dirname(__FILE__)."/../cap/zmSpamFree/zmSpamFree.php");

$board = new Board($code);

if($encData)
{
	$encArr = getDecode64($encData);
	$row = $db->_fetch("select * from sw_board where idx='$encArr[idx]' limit 1", 1);

	$eximg = explode(",", $row['imgetc']);
}

switch($act)
{
	case "edit" :
		if($arImg) $etcName = implode(",", $arImg);
		$bLock = ($bLock) ? $bLock : "N";
		$notice = ($notice) ? $notice : "N";
		$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
		$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);

		$mb = getMember($userid);

		$sqry = "update ".SW_BOARD." set ";
		$sqry .= "userid='".$mb['userid']."', ";
		$sqry .= "name='".$name."', ";
		$sqry .= "email = '$email', ";
		$sqry .= "home = '$home', ";
		$sqry .= "`url` = '$url', ";
		$sqry .= "title = '".getAddslashes($title)."', ";
		$sqry .= "subtitle = '".getAddslashes($subtitle)."', ";
		$sqry .= "nprice = '$nprice', ";
		$sqry .= "price = '$price', ";
		$sqry .= "sday = '".substr($sday,0,10)."', ";
		$sqry .= "eday = '".substr($eday ,0 ,10)."', ";
		$sqry .= "eday_time = '$eday_time', ";
		$sqry .= "cate = '$cate', ";
		$sqry .= "bLock = '$bLock', ";
		$sqry .= "notice = '$notice', ";
		$sqry .= "buse = '$buse', ";
		$sqry .= "content = '".getAddslashes($notice_write)."', ";
		$sqry .= "keyword = '".$keyword."' ";
		$sqry .= "where idx=$encArr[idx]";

		if($db->_execute($sqry))
		{
			/// 첨부파일 업로드 ///
				$board->_act($adata, "edit", $encData);

				for($f=1, $e=0; $f <= $board->info['upcnt']; $f++, $e++)
				{
					if(!empty($_FILES['upfile'.$f]['name']))
					{
						$filename = fileUpload($_FILES['upfile'.$f], $adata['file'][$e]['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');

						$orgname = $_FILES['upfile'.$f]['name'];

						if(preg_match("/^image/i", $_FILES['upfile'.$f]['type']))
						{
							$ftype = "image";
							$filetype = 1;


							@FileDelete($adata[$e]['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
							@FileDelete("thum_".$adata[$e]['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
							crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");

						}
						else
						{
							$ftype = $_FILES['upfile'.$f]['type'];
							$filetype = 2;
						}

						if($adata['file'][$e]['idx'])
							$isqry = sprintf("update %s set upfile='%s', upreal='%s',`filetype` ='%s' , ftype='%s', fsize='%d' where idx='%s'", SW_BOARDFILE, $filename, $orgname,$filetype, $ftype, $_FILES['upfile'.$f]['size'],   $adata['file'][$e]['idx']);
						else
							$isqry = "insert into ".SW_BOARDFILE." set
								bidx = $encArr[idx],
								code = '$code',
								upfile = '$filename',
								upreal = '$orgname',
								`filetype` = '".$filetype."',
								ftype = '$ftype',
								fsize = '".$_FILES['upfile'.$f]['size']."',
								regdt = now()
							";

						$db->_execute($isqry);
					}
				}

				$file_img = $db->_fetch("select * from sw_boardfile where bidx='".$row['idx']."' and filetype = 0");
				$video_img = $db->_fetch("select * from sw_boardfile where bidx='".$row['idx']."' and filetype = 1");
				$attach_img = $db->_fetch("select * from sw_boardfile where bidx='".$row['idx']."' and filetype = 2");

				if(!empty($_FILES['profileFile']['name']))
				{
					$filename = fileUpload($_FILES['profileFile'], $file_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');

					$orgname = $_FILES['profileFile']['name'];

					if(preg_match("/^image/i", $_FILES['profileFile']['type']))
					{
						$ftype = "image";

						@FileDelete($file_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
						@FileDelete("thum_".$file_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
						crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");
					}
					else
						$ftype = $_FILES['profileFile']['type'];

					if($file_img['idx'])
						$isqry = sprintf("update %s set upfile='%s', upreal='%s',`filetype` ='%s' , ftype='%s', fsize='%d' where idx='%s'", SW_BOARDFILE, $filename, $orgname,$filetype, $ftype, $_FILES['profileFile']['size'],   $file_img['idx']);
					else
						$isqry = "insert into ".SW_BOARDFILE." set
							bidx = '".$row[idx]."',
							code = '".$code."',
							upfile = '".$filename."',
							upreal = '".$orgname."',
							`filetype` = '0',
							ftype = '".$ftype."',
							fsize = '".$_FILES['profileFile']['size']."',
							regdt = now()
						";

					$db->_execute($isqry);
				}

				//video
				if(!empty($_FILES['VideoFile']['name']))
				{
					$filename2 = fileUpload($_FILES['VideoFile'], $video_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');

					$orgname2 = $_FILES['VideoFile']['name'];

						if(preg_match("/^image/i", $_FILES['VideoFile']['type']))
						{
							$ftype = "image";

							@FileDelete($video_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
							@FileDelete("thum_".$video_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
							crateThumImg1($filename2, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");
						}
						else
							$ftype = $_FILES['VideoFile']['type'];


					if($video_img['idx'])
						$isqry = sprintf("update %s set upfile='%s', upreal='%s',`filetype` ='%s' , ftype='%s', fsize='%d' where idx='%s'", SW_BOARDFILE, $filename2, $orgname2,$filetype, $ftype, $_FILES['VideoFile']['size'],   $video_img['idx']);
					else
						$isqry = "insert into ".SW_BOARDFILE." set
						bidx = '".$row[idx]."',
						code = '".$code."',
						upfile = '".$filename2."',
						upreal = '".$orgname2."',
						`filetype` = '1',
						ftype = '".$ftype."',
							fsize = '".$_FILES['VideoFile']['size']."',
							regdt = now()
						";

					$db->_execute($isqry);
				}

				//attach
				if(!empty($_FILES['AttachFile']['name']))
				{
					$filename3 = fileUpload($_FILES['AttachFile'], $attach_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');

					$orgname3 = $_FILES['AttachFile']['name'];
					if(preg_match("/^image/i", $_FILES['AttachFile']['type']))
					{
						$ftype = "image";

						@FileDelete($attach_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
						@FileDelete("thum_".$attach_img['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
						crateThumImg1($filename3, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");
					}
					else
						$ftype = $_FILES['AttachFile']['type'];

					if($attach_img['idx'])
						$isqry = sprintf("update %s set upfile='%s', upreal='%s',`filetype` ='%s' , ftype='%s', fsize='%d' where idx='%s'", SW_BOARDFILE, $filename3, $orgname3,$filetype, $ftype, $_FILES['AttachFile']['size'],   $attach_img['idx']);
					else
						$isqry = "insert into ".SW_BOARDFILE." set
						bidx = '".$row[idx]."',
						code = '".$code."',
						upfile = '".$filename3."',
						upreal = '".$orgname3."',
						`filetype` = '2',
						ftype = '".$ftype."',
						fsize = '".$_FILES['AttachFile']['size']."',
						regdt = now()
						";

					$db->_execute($isqry);
				}

			msgGoUrl("게시물이 수정되었습니다.", $rurl."?act=view&encData=".$encData);
		}
		else
			ErrorHtml($sqry);

	break;

	case "etcimgdel" :

		for($i =0; $i < count($eximg); $i++)
		{
			if($i == $etcidx)
				$arImg[] = "";
			else
				$arImg[] = $eximg[$i];
		}

		if($arImg) $etcName = implode(",", $arImg);

		for($k = 0; $k < count($arImg); $k++)
		{
			if($arImg[$k] !="")
				$newarImg[] = $arImg[$k];
		}

		if($newarImg) $etcName = implode(",", $newarImg);
		$sqry = "update sw_board set imgetc = '".$etcName."'  where idx=$encArr[idx]";
	 	if($db->_execute($sqry))
		{
			FileDelete($_REQUEST['etcurl'], "../upload/board");
 			@FileDelete("thum_".$_REQUEST['etcurl'], "../upload/board");
			msgGoUrl("첨부파일이 삭제되었습니다.", $rurl."?act=edit&code=".$code."&encData=".$encData);
		}
	break;
	case "imgdel" :	/// 첨부이미지 삭제 ////////////////////////////////////////////

		$sqry = sprintf("select * from %s where idx='%d'", SW_BOARDFILE, $imgidx);
		$imgrow = $db->_fetch($sqry,1);

		if($imgrow)
		{
			$dsqry = sprintf("delete from %s where idx='%d'", SW_BOARDFILE, $imgidx);

			if($db->_execute($dsqry))
			{
				FileDelete($imgrow['upfile'], "../upload/board");

				if(!strcmp($imgrow['ftype'], "image"))
					@FileDelete("thum_".$imgrow['upfile'], "../upload/board");

				msgGoUrl("첨부파일이 삭제되었습니다.", $rurl."?act=edit&code=".$code."&encData=".$encData);
			}
		}

	break;

	case "del" :

		$sqry = sprintf("delete from %s where idx=%d", SW_BOARD, $encArr['idx']);

		if($db->_execute($sqry))
		{
			$board->_act($adata, "del", $encData);
			/// 답변글 삭제처리 ///
			if(count($adata['reply']) > 0)
			{
				for($r=0; $r < count($adata['reply']); $r++)
				{
					if($adata['reply'][$r])
					{
						$rsqry = sprintf("delete from %s where idx='%d'",SW_BOARD, $adata['reply'][$r]);
						$db->_execute($rsqry);
					}
				}
			}
			//////////////////////

			for($f=0; $f < count($adata['file']); $f++)
			{
				FileDelete($adata['file'][$f]['upfile'], $_SERVER[DOCUMENT_ROOT]."/upload/board");

				if(!strcmp($adata['file'][$f]['ftype'], "image"))
					FileDelete("thum_".$adata['file'][$f]['upfile'], $_SERVER[DOCUMENT_ROOT]."/upload/board");
			}

			$file_img = $db->_fetch("select * from sw_boardfile where bidx='".$encArr['idx']."' and filetype = 0");
			$video_img = $db->_fetch("select * from sw_boardfile where bidx='".$encArr['idx']."' and filetype = 1");
			$attach_img = $db->_fetch("select * from sw_boardfile where bidx='".$encArr['idx']."' and filetype = 2");

			FileDelete($file_img['upfile'], "../upload/board");

			if(!strcmp($file_img['ftype'], "image"))
				FileDelete("thum_".$file_img['upfile'], "../upload/board");

			FileDelete($video_img['upfile'], "../upload/board");

			if(!strcmp($video_img['ftype'], "image"))
				FileDelete("thum_".$video_img['upfile'], "../upload/board");

			FileDelete($attach_img['upfile'], "../upload/board");

			if(!strcmp($attach_img['ftype'], "image"))
				FileDelete("thum_".$attach_img['upfile'], "../upload/board");


			msgGoUrl("게시물이 삭제되었습니다.", $rurl."?code=".$code."&encData=".$encData);
		}
		else
			ErrorHtml($sqry);
	break;
	case "cu" : //댓글수정

		$uqry = "update sw_comment set comment ='".$comment."'   where idx='".$bidx."'";
		if($db->_execute($uqry))
		{
			goUrl($board->info[path]."?act=view&code=".$code."&encData=".$encData, '', 'P');
		}
		else
			msg("댓글 수정중 오류가 발생하였습니다.", "", true);
	break;

	case "acmt" :

		$sqry = "insert into ".SW_COMMENT." set
					code = '$code',
					bidx = '$row[idx]',
					userid = '$_SESSION[SES_USERID]',
					pwd = '$pwd',
					name = '$name',
					comment = '$comment',
					ip = '$_SERVER[REMOTE_ADDR]',
					regdt = now()
				";

		if($db->_execute($sqry))
			goUrl($board->info[path]."?act=view&code=".$code."&encData=".$encData, '', 'P');
		else
			msg("댓글 등록도중 오류가 발생하였습니다.","",true);

	break;
	case "cmtd" :

		if(!strcmp($mode, 'chkpwd'))
		{
			$crow = $db->_fetch("select * from ".SW_COMMENT." where idx='".$idx."'", 1);

			if($crow['pwd'] && !strcmp($pwd, $crow['pwd']))
			{
				$sqry = sprintf("delete from %s where idx=%d", SW_COMMENT, $crow['idx']);
			}
			else if(strcmp($pwd, $crow['pwd']))
			{
				msg("비밀번호가 틀립니다.","",true);
				exit;
			}
		}
		else
		{
			$sqry = sprintf("delete from %s where idx=%d", SW_COMMENT, $idx);
		}

		if($db->_execute($sqry))
			ParentReload();
		else
			msg("댓글 삭제도중 오류가 발생하였습니다.","",true);

	break;
	default :

		/// 자동등록방지 코드를 사용할 경우 ///
		if(!strcmp($board->info['bspam'], "Y"))
		{
			if ( !zsfCheck( $_POST['zsfCode'] ) )
			{
				msg("입력한 자동등록 방지코드가 잘못되었습니다.", -1, true);
			}
		}

		$board->_act($adata, 'write', $encData);
		$bLock = ($bLock) ? $bLock : "N";
		$notice = ($notice) ? $notice : "N";
		$hp = sprintf("%s-%s-%s", $hp1, $hp2, $hp3);
		$tel = sprintf("%s-%s-%s", $tel1, $tel2, $tel3);
		$sqry = "insert into ".SW_BOARD." set
					code = '$code',
					hit = 0,
					userid = '".$_SESSION['SES_USERID']."',
					name = '$name',
					email = '$email',
					tel = '$tel',
					pwd = '$pwd',
					title = '".getAddslashes($title)."',
					bLock = '$bLock',
					lockid = '".$adata['lockid']."',
					notice = '$notice',
					ip = '$_SERVER[REMOTE_ADDR]',
					cate = '$cate',
					ref = ".$adata['ref'].",
					re_step = ".$adata['re_step'].",
					re_level = ".$adata['re_level'].",
					keyword = '".$keyword."',
					content = '".getAddslashes($notice_write)."',
					regdt = now()
				";

		if($db->_execute($sqry))
		{
			/// 첨부파일 업로드 ///
			if($_FILES && $board->info['upcnt'] > 0)
			{
				$bidx = $db->getLastID();

				for($f=1; $f <= $board->info['upcnt']; $f++)
				{
					if(!empty($_FILES['upfile'.$f]['name']))
					{
						$filename = fileUpload($_FILES['upfile'.$f], '', $_SERVER[DOCUMENT_ROOT].'/upload/board');
						$orgname = $_FILES['upfile'.$f]['name'];



							if(preg_match("/^image/i", $_FILES['upfile'.$f]['type']))
							{
								$ftype = "image";
								$filetype = 1;


								@FileDelete($adata[$e]['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
								@FileDelete("thum_".$adata[$e]['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
								crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");

							}
							else
							{
								$ftype = $_FILES['upfile'.$f]['type'];
								$filetype = 2;
							}

						$isqry = "insert into ".SW_BOARDFILE." set
									bidx = $bidx,
									code = '$code',
									upfile = '$filename',
									upreal = '$orgname',
									ftype = '$ftype',
									fsize = '".$_FILES['upfile'.$f]['size']."',
									dcnt = 0,
									regdt = now()
								";

						$db->_execute($isqry);
					}
				}


					if(!empty($_FILES['profileFile']['name']))
					{
						$filename = fileUpload($_FILES['profileFile'], '', $_SERVER[DOCUMENT_ROOT].'/upload/board');
						$orgname = $_FILES['profileFile']['name'];

						if(preg_match("/^image/i", $_FILES['profileFile']['type']))
						{
							$ftype = "image";

							@FileDelete($filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
							@FileDelete("thum_".$filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
							crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");

						}
						else
						{
							$ftype = $_FILES['profileFile']['type'];
						}

						$isqry = "insert into ".SW_BOARDFILE." set
									bidx = $bidx,
									code = '$code',
									upfile = '$filename',
									upreal = '$orgname',
									`filetype` = '0',
									ftype = '$ftype',
									fsize = '".$_FILES['profileFile']['size']."',
									dcnt = 0,
									regdt = now()
								";

						$db->_execute($isqry);
					}

					//video
					if(!empty($_FILES['VideoFile']['name']))
					{
						$filename = fileUpload($_FILES['VideoFile'], '', $_SERVER[DOCUMENT_ROOT].'/upload/board');
						$orgname = $_FILES['VideoFile']['name'];

						if(preg_match("/^image/i", $_FILES['VideoFile']['type']))
						{
							$ftype = "image";

							@FileDelete($filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
							@FileDelete("thum_".$filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
							crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");

						}
						else
						{
							$ftype = $_FILES['VideoFile']['type'];
						}

						$isqry = "insert into ".SW_BOARDFILE." set
									bidx = $bidx,
									code = '$code',
									upfile = '$filename',
									upreal = '$orgname',
									`filetype` = '1',
									ftype = '$ftype',
									fsize = '".$_FILES['VideoFile']['size']."',
									dcnt = 0,
									regdt = now()
								";

						$db->_execute($isqry);
					}

					//attach
					if(!empty($_FILES['AttachFile']['name']))
					{
						$filename = fileUpload($_FILES['AttachFile'], '', $_SERVER[DOCUMENT_ROOT].'/upload/board');
						$orgname = $_FILES['AttachFile']['name'];

						if(preg_match("/^image/i", $_FILES['AttachFile']['type']))
						{
							$ftype = "image";

							@FileDelete($filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
							@FileDelete("thum_".$filename['upfile'], $_SERVER[DOCUMENT_ROOT].'/upload/board/thum');
							crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");

						}
						else
						{
							$ftype = $_FILES['AttachFile']['type'];
						}

						$isqry = "insert into ".SW_BOARDFILE." set
									bidx = $bidx,
									code = '$code',
									upfile = '$filename',
									upreal = '$orgname',
									`filetype` = '2',
									ftype = '$ftype',
									fsize = '".$_FILES['AttachFile']['size']."',
									dcnt = 0,
									regdt = now()
								";

						$db->_execute($isqry);
					}

			}
				msgGoUrl($board->info['name']."게시판에 새로운 게시물이 등록되었습니다.", $rurl."?code=".$code);
		}
		else
			ErrorHtml($sqry);
	break;
}
?>
