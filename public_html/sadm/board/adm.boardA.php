<?
include_once(dirname(__FILE__)."/../_header.php");

switch($act)
{
	case "edit":

		$lAct = ($lAct) ? $lAct : 0;
		$rAct = ($rAct) ? $rAct : 0;
		$wAct = ($wAct) ? $wAct : 0;
		$cAct = ($cAct) ? $cAct : 0;
		$bspam = ($bspam) ? $bspam : 'N';
		$cutstr = ($cutstr) ? $cutstr : 45;
		$vlimit = ($vlimit) ? $vlimit : 20;
		$period = ($period) ? $period : 1;
		$imgclk = ($imgclk) ? $imgclk : 0;
		$vtype = ($vtype) ? $vtype : 0;
		$vip = ($vip) ? $vip : 0;
		$bCom = ($bCom) ? $bCom : 0;
		$bsecret = ($bsecret) ? $bsecret : 0;

		if($part > 20)
			$upcnt = ($upcnt) ? $upcnt : 1;
		else
			$upcnt = ($upcnt) ? $upcnt : 0;

		$bnotice = ($bnotice) ? $bnotice : 0;
		$beditor = ($beditor) ? $beditor : 0;
		$breply = ($breply) ? $breply : 0;
		$btel = ($btel) ? $btel : 0;
		$lsimg = ($lsimg) ? $lsimg : 0;
		$bemail = ($bemail) ? $bemail : 0;
		$bhome = ($bhome) ? $bhome : 0;
		$bevent = ($bevent) ? $bevent : 0;
		$bcate = ($bcate) ? $bcate : 0;
		$scate = ($bcate) ? $scate : '';
		$hhtml = addslashes($hhtml);
		$fhtml = addslashes($fhtml);

		$upsqry = "update sw_board_cnf set
					name = '$name',
					part = '$part',
					lAct = '$lAct',
					rAct = '$rAct',
					wAct = '$wAct',
					cAct = '$cAct',
					bspam = '$bspam',
					path = '$path',
					cutstr = '$cutstr',
					vlimit = '$vlimit',
					period = '$period',
					thumW = '$thumW',
					thumH = '$thumH',
					lsimg = '$lsimg',
					imgclk = '$imgclk',
					vtype = '$vtype',
					vip = '$vip',
					bCom = '$bCom',
					breply = '$breply',
					bsecret = '$bsecret',
					bnotice = '$bnotice',
					beditor = '$beditor',
					upcnt = '$upcnt',
					bemail = '$bemail',
					btel = '$btel',
					bhome = '$bhome',
					bevent = '$bevent',
					bcate = '$bcate',
					scate = '$scate',
					hhtml = '$hhtml',
					fhtml = '$fhtml'
				where code='".$code."'";

		if($db->_execute($upsqry))
			msgGoUrl("게시판설정 정보가 수정되었습니다.", "./adm.boardE.php?code=".$code);
		else
			ErrorHtml($upsqry);

	break;
	case "del":

		$dsqry = sprintf("delete from sw_board_cnf where code='%s'", $code);

		if($db->_execute($dsqry))
		{
			$data_sqry = sprintf("delete from sw_board where code='%s'", $code);
			if($db->_execute($data_sqry))
			{
				$fsqry = sprintf("select * from sw_boardfile where code='%s'", $code);
				$fqry = $db->_execute($fsqry);

				while($frow = mysql_fetch_array($fqry))
				{
					@FileDelete($frow['upfile'], "../../upload/board");
					$db->_execute("delete from sw_boardfile where code='".$code."' && idx='".$frow['idx']."'");
				}
			}

			msgGoUrl("게시판이 모두 삭제되었습니다.", "./adm.boardL.php");
		}
		else
			ErrorHtml($dsqry);

	break;
	default:

		$lAct = ($lAct) ? $lAct : 0;
		$rAct = ($rAct) ? $rAct : 0;
		$wAct = ($wAct) ? $wAct : 0;
		$cAct = ($cAct) ? $cAct : 0;
		$bspam = ($bspam) ? $bspam : 'N';
		$cutstr = ($cutstr) ? $cutstr : 45;
		$vlimit = ($vlimit) ? $vlimit : 20;
		$period = ($period) ? $period : 1;
		$imgclk = ($imgclk) ? $imgclk : 0;
		$vtype = ($vtype) ? $vtype : 0;
		$vip = ($vip) ? $vip : 0;
		$bCom = ($bCom) ? $bCom : 0;
		$bsecret = ($bsecret) ? $bsecret : 0;

		if($part > 20)
			$upcnt = ($upcnt) ? $upcnt : 1;
		else
			$upcnt = ($upcnt) ? $upcnt : 0;

		$beditor = ($beditor) ? $beditor : 0;
		$bnotice = ($bnotice) ? $bnotice : 0;
		$breply = ($breply) ? $breply : 0;
		$btel = ($btel) ? $btel : 0;
		$lsimg = ($lsimg) ? $lsimg : 0;
		$bemail = ($bemail) ? $bemail : 0;
		$bhome = ($bhome) ? $bhome : 0;
		$bevent = ($bevent) ? $bevent : 0;
		$bcate = ($bcate) ? $bcate : 0;
		$scate = ($bcate) ? $scate : '';
		$hhtml = addslashes($hhtml);
		$fhtml = addslashes($fhtml);

		$isqry = "insert into sw_board_cnf set
					code = '$code',
					name = '$name',
					part = '$part',
					lAct = '$lAct',
					rAct = '$rAct',
					wAct = '$wAct',
					cAct = '$cAct',
					bspam = '$bspam',
					path = '$path',
					cutstr = '$cutstr',
					vlimit = '$vlimit',
					period = '$period',
					thumW = '$thumW',
					thumH = '$thumH',
					lsimg = '$lsimg',
					imgclk = '$imgclk',
					vtype = '$vtype',
					vip = '$vip',
					bCom = '$bCom',
					breply = '$breply',
					bsecret = '$bsecret',
					bnotice = '$bnotice',
					beditor = '$beditor',
					upcnt = '$upcnt',
					bemail = '$bemail',
					btel = '$btel',
					bhome = '$bhome',
					bevent = '$bevent',
					bcate = '$bcate',
					scate = '$scate',
					hhtml = '$hhtml',
					fhtml = '$fhtml',
					regdt = now()";

		if($db->_execute($isqry))
			msgGoUrl("새로운 [".$name."] 게시판이 생성되었습니다.", "./adm.boardL.php");
		else
			ErrorHtml($isqry);

	break;
}
?>
