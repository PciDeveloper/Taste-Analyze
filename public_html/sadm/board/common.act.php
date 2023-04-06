<?
include_once(dirname(__FILE__)."/../_header.php");

if($encData)
{
	$encArr = getDecode64($encData);

	foreach($encArr as $k=>$v)
		${$k} = urldecode($v);
}

switch($mode)
{
	case "config" :
		switch($act)
		{ 
			//게시판 카테고리 & 게시판순서 변경
			case "rank" :
				$ok=$err=0;
 
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$usqry = sprintf("update sw_board_cnf set `name`='%s', `scate`='%s' , `seq`='%s' , `push`='%s'  where idx='%d'",   $name[$chk[$i]], $scate[$chk[$i]], $seq[$chk[$i]] ,$push[$chk[$i]] , $chk[$i]);
						if($db->_execute($usqry))
							$ok++;
					}
				}

				msgGoUrl("선택하신 ".$ok."개의 게시판 정보가 수정되었습니다.", $_SERVER['HTTP_REFERER']);
			break;
		}
	break;
 

	case "singo" :  
		switch($act)
		{
			case "del" : 
				if($idx)
					$help = $db->_fetch("select * from ".SW_SINGO." where idx='".$idx."'");

				$dsqry = sprintf("update  %s set `valid` ='0' where idx='%d'", SW_SINGO, $idx);
				if($db->_execute($dsqry))
				{ 
					$db->_execute("update sw_board set buse='N' where idx='".$help['gidx']."'");

					msgGoUrl("신고내역이 삭제되었습니다.", "./singo.php?encData=".$encData);
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
						$help = $db->_fetch("select * from ".SW_SINGO." where idx='".$chk[$i]."'");

						$dsqry = sprintf("update %s set `valid` =0 where idx='%d'", SW_SINGO, $chk[$i]);
						if($db->_execute($dsqry))
						{ 
							$db->_execute("update sw_board set buse='N' where idx='".$help['gidx']."'");
							$ok++;
						}
						else
							$err++;
					}
				}
				msgGoUrl("총".$ok."건의 선택하신 신고내역이 삭제되었습니다.", "./singo.php?encData=".$encData);
			break; 
		}
	break;

	case "icon" :
		if($idx)
			$icon = $db->_fetch("select * from sw_board_cnf where idx='".$idx."'");

		switch($act)
		{
			case "edit" : 
				if(!empty($_FILES['img']['name']))
				{
					$filename = FileUpload($_FILES['img'], $icon['icon'], $_SERVER['DOCUMENT_ROOT'].'/upload/icon');
					crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/icon/', $_SERVER[DOCUMENT_ROOT].'/upload/icon/thum/',"100");
					$aQry = sprintf(", icon='%s'", $filename);
				}

				$usqry = sprintf("update sw_board_cnf set   name='%s' %s where idx='%d'",  $name, $aQry, $idx);
				if($db->_execute($usqry))
					msgGoUrl("아이콘 정보가 수정되었습니다.", "./board.config.php","P");
				else
					ErrorHtml($usqry);
			break;
			case "del" :
				$dsqry = sprintf("update sw_board_cnf set img='' where idx='%d'",   $idx);
				if($db->_execute($dsqry))
				{
					@FileDelete($icon['img'], $_SERVER['DOCUMENT_ROOT'].'/upload/icon');
					@FileDelete("thum_".$icon['img'], $_SERVER['DOCUMENT_ROOT'].'/upload/icon/thum');
					msgGoUrl("아이콘 정보가 삭제되었습니다.", "./board.config.php","P");
				}
				else
					ErrorHtml($dsqry);
			break;
  
			default : 

				if(!empty($_FILES['img']['name']))
				{
					$filename = FileUpload($_FILES['img'], '', $_SERVER['DOCUMENT_ROOT'].'/upload/icon');
					crateThumImg1($filename, $_SERVER[DOCUMENT_ROOT].'/upload/icon/', $_SERVER[DOCUMENT_ROOT].'/upload/icon/thum/',"100");
				}
 
				$isqry = "insert into sw_board_cnf set  
							name = '$name', 
							icon = '$filename'
						";

				if($db->_execute($isqry))
					msgGoUrl("아이콘이 추가되었습니다.", "./board.config.php","P");
				else
					ErrorHtml($isqry);
			break;
		}
	break;
}

?>