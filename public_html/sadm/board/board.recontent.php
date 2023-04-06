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
	default :	/// 새글 등록 ////////////////////////////////////////////
 		$sqry = "update ".SW_BOARD." set
					status = 'Y',
          re_content = '".getAddslashes($content)."',
					updt = now()
          where
          idx = '".$encArr[idx]."'
				";
		if($db->_execute($sqry))
		{
			msgGoUrl($board->info[name]."답변이 등록되었습니다.", "./board.list.php?code=".$code);
		}
		else
			ErrorHtml($sqry);

	break;

}
?>
