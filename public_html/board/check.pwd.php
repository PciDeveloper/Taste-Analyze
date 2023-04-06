<?
include_once(dirname(__FILE__)."/../inc/_header.php");
include_once(dirname(__FIlE__)."/../lib/class.Board.php");

$board = new Board($code);
$row = $board->getBoardData($encData);

//Debug($row);

if(!strcmp($pwd, $row['pwd']))
{
	if(!strcmp($mode, "del"))
	{
		$delsqry = sprintf("delete from %s where idx=%d", SW_BOARD, $row['idx']);

		if($db->_execute($delsqry))
		{
			$fdata = $board->getFileData($row['idx']);
			for($f=0; $f < count($fdata); $f++)
			{
				FileDelete($fdata[$f]['upfile'], "../../upload/board");

				if($board->info['part'] > 30)
					FileDelete("thum_".$fdata[$f]['upfile'], "../../upload/board");
			}

			$db->_execute("delete from ".SW_BOARDFILE." where bidx='".$row['idx']."' and code='".$code."'");

			msg("게시물이 삭제되었습니다.");
			goUrl($board->info['path']."?code=".$code."&encData=".$encData, "", "P");
		}
	}
	else if(!strcmp($mode, "lock"))
	{
		setCookie("LOCK_".$row['idx'], true, time()+3600, "/");
		goUrl($board->info['path']."?act=view&code=".$code."&encData=".$encData, "", "P");
	}
	else if(!strcmp($mode, "edit"))
	{
		setCookie("EDIT_".$row['idx'], true, time()+3600, "/");
		goUrl($board->info['path']."?act=edit&code=".$code."&encData=".$encData, "", "P");
	}
}
else
{
	echo <<< SCRIPT

		<script type="text/javascript">
		alert("비밀번호가 틀립니다.");
		parent.Common.layerPassFormClose();
		parent.Common.layerPassForm('{$mode}', '{$code}', '{$encData}');
		</script>

SCRIPT;
}
?>