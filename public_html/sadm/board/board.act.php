<?
include_once dirname(__FILE__)."/../_header.php";
include_once(dirname(__FIlE__)."/../../lib/class.Board.php");
include_once(dirname(__FIlE__)."/../../lib/lib.cash.php");
$board = new Board($code);
if($encData)
{
	$encArr = getDecode64($encData);
	$row = $db->_fetch("select * from ".SW_BOARD." where idx='$encArr[idx]' limit 1");
}
switch($act)
{
	case "edit" :	/// 게시물 수정 ////////////////////////////////////////////

		$bLock = ($bLock) ? $bLock : "N";
		$notice = ($notice) ? $notice : "N";
		$notice2 = ($notice2) ? $notice2 : "N";
		$buse = ($buse) ? $buse : "N";
		$home = setHttp($home);
		$url = setHttp($url);
		$price = str_replace(",", "", $price);
		$nprice = str_replace(",", "", $nprice);

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
		$sqry .= "notice2 = '$notice2', ";
		$sqry .= "buse = '$buse', ";
		$sqry .= "content = '".getAddslashes($content)."' ";
		$sqry .= "where idx=$encArr[idx]";

		if($db->_execute($sqry))
		{
			/// 첨부파일 업로드 ///

				$board->_act($adata, "edit", $encData);

				for($f=1, $e=0; $f <= $board->info['upcnt']; $f++, $e++)
				{
					if(!empty($_FILES['upfile'.$f]['name']))
					{
						$filename = fileUpload($_FILES['upfile'.$f], $adata['file'][$e]['upfile'], '../../upload/board');

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


			msgGoUrl("게시물이 수정되었습니다.", "./board.view.php?code=".$code."&encData=".$encData);
		}
		else
			ErrorHtml($sqry);

	break;
	case "del" :	/// 게시물 삭제 ////////////////////////////////////////////

		$sqry = sprintf("delete from %s where idx=%d", SW_BOARD, $encArr['idx']);
		if($db->_execute($sqry))
		{
			$board->_act($adata, "del", $encData);
			for($f=0; $f < count($adata['file']); $f++)
			{
				FileDelete($adata['file'][$f]['upfile'], "../../upload/board");

				if(!strcmp($adata['file'][$f]['ftype'], "image"))
				{
					FileDelete("thum_".$adata['file'][$f]['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");
				}
			}

			msgGoUrl("게시물이 삭제되었습니다.", "./board.list.php?code=".$code."&encData=".$encData);
		}
		else
			ErrorHtml($sqry);

	break;
	case "sdel" :		/// 게시물 선택 삭제 ////////////////////////////////////

		$ok = $err = 0;
		for($i=0; $i < count($chk); $i++)
		{
			if($chk[$i])
			{
				$dsqry = sprintf("delete from %s where idx='%d'", SW_BOARD, $chk[$i]);

				if($db->_execute($dsqry))
				{
					$sqry = sprintf("select upfile from %s where bidx='%d'", SW_BOARDFILE, $chk[$i]);
					$qry = $db->_execute($sqry);

					while($frow = mysql_fetch_array($qry))
					{
						FileDelete($frow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board");
						FileDelete("thum_".$frow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");
					}

					$db->_execute("delete from ".SW_BOARDFILE." where bidx='".$chk[$i]."'");
					$db->_execute("delete from ".SW_COMMENT." where bidx='".$chk[$i]."'");
					$ok++;
				}
			}
		}

		msgGoUrl($ok."개의 게시물이 삭제 되었습니다.", "./board.list.php?code=".$code);

	break;

	case "imgdel" :	/// 첨부이미지 삭제 ////////////////////////////////////////////

		$sqry = sprintf("select * from %s where idx='%d'", SW_BOARDFILE, $imgidx);
		$imgrow = $db->_fetch($sqry);

		if($imgrow)
		{
			$dsqry = sprintf("delete from %s where idx='%d'", SW_BOARDFILE, $imgidx);

			if($db->_execute($dsqry))
			{
				FileDelete($imgrow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board");

				if(!strcmp($imgrow['ftype'], "image"))
				{
					@FileDelete("thum_".$imgrow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");
				}

				msgGoUrl("첨부파일이 삭제되었습니다.", "./board.edit.php?code=".$code."&encData=".$encData);
			}
		}

	break;

	case "cu" : //댓글수정
		$row = $db->_fetch("select * from sw_comment where idx='".$bidx."'");

		if(!empty($_FILES['photo']['name']))
		{
			@FileDelete($row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/board");
			@FileDelete("thum_".$row['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");

			$imgName1 = FileUpload($_FILES['photo'], $_FILES['photo'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
			crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"300");
		}
		else
		{
			$imgName1 = $row['photo'];
		}

		$uqry = "update sw_comment set comment ='".$comment."' , photo='".$imgName1."' where idx='".$bidx."'";
		if($db->_execute($uqry))
		{
			goUrl("./board.view.php?code=".$code."&encData=".$encData, '', 'P');
		}
		else
			msg("댓글 수정중 오류가 발생하였습니다.", "", true);
	break;

	case "acmt" :	/// 댓글 등록 ////////////////////////////////////////////
	 if($encData)
	{
		$encArr = getDecode64($encData);
		$R = $db->_fetch("select * from ".SW_BOARD." where idx='$encArr[idx]' limit 1");

	}

  	$wr = $db->_fetch("select * from sw_board where idx='".$R['idx']."'");

    // 댓글 답변
    if ($bidx)
    {
        $sql = " select idx, bidx, wr_comment, wr_comment_reply from sw_comment
                    where idx = '$bidx'";

        $reply_array = $db->_fetch($sql);
        if (!$reply_array['idx'])
		{
			msg("답변할 댓글이 없습니다. 답변하는 동안 댓글이 삭제되었을 수 있습니다.", "", true);
		}



        $tmp_comment = $reply_array['wr_comment'];


        $reply_len = strlen($reply_array['wr_comment_reply']) + 1;

		$begin_reply_char = 'A';
		$end_reply_char = 'Z';
		$reply_number = +1;
		$sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
				from sw_comment
				where bidx = '$R[idx]'
				and wr_comment = '$tmp_comment'
				and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";

        if ($reply_array['wr_comment_reply'])
            $sql .= " and wr_comment_reply like '{$reply_array['wr_comment_reply']}%' ";

        $row2 = $db->_fetch($sql);
        if (!$row2['reply'])
            $reply_char = $begin_reply_char;
        else if ($row2['reply'] == $end_reply_char) // A~Z은 26 입니다.
			msg("더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.", "", true);
        else
            $reply_char = chr(ord($row2['reply']) + $reply_number);

        $tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;


    }
    else
    {
        $sql = " select max(wr_comment) as max_comment from sw_comment
                    where bidx ='".$R['idx']."'  ";

        $row2 = $db->_fetch($sql);
        $row2['max_comment'] += 1;
        $tmp_comment = $row2['max_comment'];
        $tmp_comment_reply = '';
    }

		if(!empty($_FILES['photo']['name']))
		{
			@FileDelete($_FILES['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/board");
			@FileDelete("thum_".$_FILES['photo'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");

			$imgName1 = FileUpload($_FILES['photo'], $_FILES['photo'], $_SERVER[DOCUMENT_ROOT].'/upload/board');
			crateThumImg1($imgName1, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"300");
		}
		else
		{
			$imgName1 = "";
		}
		$sqry = "insert into ".SW_COMMENT." set
					code = '$code',
					bidx = '$R[idx]',
					userid = '".$_SESSION['SES_ADMID']."',
					photo = '".$imgName1."',
					name = '$name',
					comment = '$comment',
					wr_comment = '$tmp_comment',
					wr_comment_reply = '$tmp_comment_reply',
					ip = '$_SERVER[REMOTE_ADDR]',
					regdt = now()
				";

		if($db->_execute($sqry))
		{

			goUrl("./board.view.php?code=".$code."&encData=".$encData, '', 'P');
		}
		else
			msg("댓글 등록도중 오류가 발생하였습니다.", "", true);

		exit;

	break;
	case "cmtd" :	/// 댓글 삭제 ////////////////////////////////////////////

		$sqry = sprintf("delete from %s where idx=%d", SW_COMMENT, $num);

		if($db->_execute($sqry))
			goUrl("./board.view.php?code=".$code."&encData=".$encData, '', 'P');
		else
			msg("댓글 삭제도중 오류가 발생하였습니다.", "", true);

	break;

	case "chkdel" :		/// 게시물 선택 삭제 ////////////////////////////////////

		$ok = $err = 0;
		for($i=0; $i < count($chk); $i++)
		{
			if($chk[$i])
			{
				$dsqry = sprintf("delete from %s where idx='%d'", SW_BOARD, $chk[$i]);

				if($db->_execute($dsqry))
				{
					$sqry = sprintf("select upfile from %s where bidx='%d'", SW_BOARDFILE, $chk[$i]);
					$qry = $db->_execute($sqry);

					while($frow = mysql_fetch_array($qry))
					{
						FileDelete($frow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board");
						FileDelete("thum_".$frow['upfile'], $_SERVER['DOCUMENT_ROOT']."/upload/board/thum");
					}

					$db->_execute("delete from ".SW_BOARDFILE." where bidx='".$chk[$i]."'");
					$db->_execute("delete from ".SW_COMMENT." where bidx='".$chk[$i]."'");
					$ok++;
				}
			}
		}

		msgGoUrl($ok."개의 게시물이 삭제 되었습니다.", "./board.list.php?code=".$code);

	break;


	default :	/// 새글 등록 ////////////////////////////////////////////

		$board->_act($adata, 'write', $encData);
		$bLock = ($bLock) ? $bLock : "N";
		$notice = ($notice) ? $notice : "N";
		$notice2 = ($notice2) ? $notice2 : "N";
		$buse = ($buse) ? $buse : "N";
		$home = setHttp($home);
		$url = setHttp($url);
		$price = str_replace(",", "", $price);
		$nprice = str_replace(",", "", $nprice);
		$mb = getMember($userid);

		$sqry = "insert into ".SW_BOARD." set
					code = '$code',
					hit = 0,
					userid = '".$mb['userid']."',
					name = '".$mb['name']."',
					email = '$email',
					home = '$home',
					`url` = '$url',
					pwd = '$pwd',
					title = '".getAddslashes($title)."',
					subtitle = '".getAddslashes($subtitle)."',
					price = '$price',
					nprice = '$nprice',
					sday = '".substr($sday , 0,10)."',
					eday = '".substr($eday , 0,10)."',
					eday_time = '$eday_time',
					bLock = '$bLock',
					buse = '$buse',
					lockid = '".$adata['lockid']."',
					notice = '$notice',
					notice2 = '$notice2',
					ip = '$_SERVER[REMOTE_ADDR]',
					cate = '$cate',
					ref = '".$adata['ref']."',
					re_step = '".$adata['re_step']."',
					re_level = '".$adata['re_level']."',
					content = '".getAddslashes($content)."',
					regdt = now()
				";


		if($db->_execute($sqry))
		{
			$bidx = $db->getLastID();

			/// 첨부파일 업로드 ///
			if($_FILES && $board->info['upcnt'] > 0)
			{

				for($f=1; $f <= $board->info['upcnt']; $f++)
				{
					if(!empty($_FILES['upfile'.$f]['name']))
					{
						$filename = fileUpload($_FILES['upfile'.$f], '', $_SERVER[DOCUMENT_ROOT].'/upload/board');
						crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/board/', $_SERVER[DOCUMENT_ROOT].'/upload/board/thum/',"500");
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
									`filetype` = '".$filetype."',
									ftype = '$ftype',
									fsize = '".$_FILES['upfile'.$f]['size']."',
									dcnt = 0,
									regdt = now()
								";

						$db->_execute($isqry);
					}
				}
			}


			msgGoUrl($board->info[name]."게시판에 새로운 게시물이 등록되었습니다.", "./board.list.php?code=".$code);
		}
		else
			ErrorHtml($sqry);

	break;

}
?>
