<?
include_once(dirname(__FILE__)."/../_header.php");
if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);

	if($idx)
		$row = $db->_fetch("select * from ".SW_BOOKING." where idx='".$idx."'", 1);

}
switch($mode)
{
	case "status" :
		$usqry = sprintf("update %s set status='%s', updt=now() where idx='%d'", SW_BOOKING, $status, $row['idx']);
		if($db->_execute($usqry))
			msgGourl("거래상태가 [".$arr_booking_status[$part_booking_keys[$status]]."]로 변경되었습니다.", "./booking_status.php?encData=".$encData, "P");
	break;
	case "help" :
		if($idx)
			$help = $db->_fetch("select * from ".SW_HELP." where idx='".$idx."'");

		switch($act)
		{
			case "del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_HELP, $idx);
				if($db->_execute($dsqry))
				{
					FileDelete($help['upfile'], "../../upload/board");
					msgGoUrl("1:1문의 내용이 삭제되었습니다.", "./help.php?encData=".$encData);
				}
				else
					ErrorHtml($dsqry);
			break;
			case "sdel" :
				$ok = $err = 0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$help = $db->_fetch("select * from ".SW_HELP." where idx='".$chk[$i]."'");

						$dsqry = sprintf("delete from %s where idx='%d'", SW_HELP, $chk[$i]);
						if($db->_execute($dsqry))
						{
							FileDelete($help['upfile'], "../../upload/board");
							$ok++;
						}
						else
							$err++;
					}
				}
				msgGoUrl("총".$ok."건의 선택하신 1:1문의가 삭제되었습니다.", "./help.php?encData=".$encData);
			break;
			default :
				$usqry = sprintf("update %s set aname='%s', acontent='%s', status=2, aregdt=now() where idx='%d'", SW_HELP, $aname, getAddslashes($acontent), $idx);

				if($db->_execute($usqry))
				{
					if($help['status'] < 2 && $help['email'])
					{
						ob_start();
						include_once(dirname(__FILE__)."/../../email/email.help.php");
						$mail_body = ob_get_contents();
						ob_end_clean();
						SendMail($cfg['comnm'], $cfg['shopemail'], $help['email'], $cfg['shopnm']."1:1문의 답변이 등록되었습니다.", $mail_body);
					}

					ParentReload('O');
					msgGoUrl("1:1문의 답변이 등록되었습니다.", "./win.help.php?idx=".$idx);
				}
				else
					ErrorHtml($usqry);
			break;
		}
	break;
	case "qna" :
		switch($act)
		{
			case "del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_QNA, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("상품문의 내용이 삭제되었습니다.", "./qna.php?encData=".$encData);
				else
					ErrorHtml($dsqry);
			break;
			case "sdel" :
				$ok = $err = 0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$dsqry = sprintf("delete from %s where idx='%d'", SW_QNA, $chk[$i]);
						if($db->_execute($dsqry))
							$ok++;
						else
							$err++;
					}
				}

				msgGoUrl("총".$ok."건의 선택하신 1:1문의가 삭제되었습니다.", "./qna.php?encData=".$encData);
			break;
			default :
				$usqry = sprintf("update %s set auserid='%s', atitle='%s', aname='%s', acontent='%s', status=2, aregdt=now() where idx='%d'", SW_QNA, $_SESSION['SES_USERID'] , getAddslashes($atitle), $aname, getAddslashes($acontent), $idx);

				if($db->_execute($usqry))
				{
					ParentReload('O');
					msgGoUrl("상품문의 답변이 등록되었습니다.", "./win.qna.php?idx=".$idx);
				}
				else
					ErrorHtml($usqry);
			break;
		}
	break;
	case "review" :
		switch($act)
		{
			case "del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_REVIEW, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("상품평 내역이 삭제되었습니다.", "./review.php?encData=".$encData);
				else
					ErrorHtml($dsqry);
			break;
			case "sdel" :
				$ok = $err = 0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$dsqry = sprintf("delete from %s where idx='%d'", SW_REVIEW, $chk[$i]);
						if($db->_execute($dsqry))
							$ok++;
						else
							$err++;
					}
				}

				msgGoUrl("총".$ok."건의 선택하신 상품평내역이 삭제되었습니다.", "./review.php?encData=".$encData);
			break;
			case "edit" :
				$mview = ($mview) ? $mview : "N";
				$usqry = sprintf("update %s set mview='%s' where idx='%d'", SW_REVIEW, $mview, $idx);

				if($db->_execute($usqry))
				{
					//if($mview == "Y")
					//	$db->_execute("update ".SW_REVIEW." set mview='N' where idx <> '".$idx."'");

					msgGoUrl("상품리뷰정보가 수정되었습니다.", "./win.review.php?idx=".$idx);
				}
				else
					ErrorHtml($usqry);

			break;
		}
	break;
	case "member" :
		if($encData)
		{
			$encArr = getDecode64($encData);
			foreach($encArr as $k=>$v)
				${$k} = urldecode($v);
			$row = $db->_fetch("select * from ".SW_MEMBER." where idx='".$idx."'");
		}

		switch($act)
		{
			case "del" :
				$dsqry = sprintf("update %s set status=0, leave_ex='관리자 직권 탈퇴' where idx='%d'", SW_MEMBER, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("해당 회원을 삭제(탈퇴) 처리하였습니다.", "./index.php?encData=".$encData);
				else
					ErrorHtml($dsqry);
			break;
			case "sdel" :
				$ok=$err=0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$dsqry = sprintf("update %s set status=0, leave_ex='관리자 직권 탈퇴' where idx='%d'", SW_MEMBER, $chk[$i]);
						if($db->_execute($dsqry))
							$ok++;
						else
							$err++;
					}
				}
				msgGoUrl("총".$ok."명의 회원이 삭제(탈퇴) 처리되었습니다.", "./index.php?encData=".$encData);
			break;
		}
	break;
}
?>
