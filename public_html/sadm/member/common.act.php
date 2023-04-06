<?
include_once(dirname(__FILE__)."/../_header.php");

switch($mode)
{ 
	case "refund" :
		$refund = $db->_fetch("select * from sw_refund where idx='".$idx."'");

			$sqry = "update sw_refund set		
							confirm_date	=now(),
							msg	='".getAddslashes($content)."',
							`status` ='".$status."',
							recnt = 1
						where idx	='".$idx."' ";
	if($db->_execute($sqry))
	{
		if($refund['recnt'] <> 1)
		{
			if($status == 3)
			{
				//반려일때만 다시 돌려주기
				$usqry = sprintf("update %s set point=point + %d    where idx='%d'", SW_MEMBER, $refund['price'],   $refund['user_no']);
				$db->_execute($usqry);
			}
		}

		ParentReload('O');
		msgGoUrl("환급내역 확인 되었습니다.", "./win.refund.php?idx=".$idx);
	}
	else
	{
		ErrorHtml($sqry);
	}
	break;

 	case "emoney" : 
		include_once(dirname(__FIlE__)."/../../lib/lib.cash.php");
		switch($act)
		{
			case "all_plus" : 
				$ok = $err = 0;
				$cash = str_replace(",", "", $cash);
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						if(setCash($chk[$i], $cash, 5, "+", $reason))
							$ok++;
					}
				}
 
				ParentReload('O');
				msgGoUrl("총".$ok."명 회원에게 적립금을 지급하였습니다.", "./win.emoney.php?encData=".$encData);
			break;
			case "all_minus" : 
				$ok = $err = 0;
				$cash = str_replace(",", "", $cash);
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						if(setCash($chk[$i], $cash, 6, "-", $reason))
							$ok++;
					}
				}

				ParentReload('O');
				msgGoUrl("총".$ok."명 회원에게 적립금을 차감하였습니다.", "./win.emoney.php?encData=".$encData);
			break;
			case "plus" : 
				$cash = str_replace(",", "", $cash);
				if($idx)
				{
					if(setCash($idx, $cash, 5, "+", $reason))
					{
						ParentReload('O');
						msgGoUrl("해당 회원에게 적립금을 지급하였습니다.", "./win.emoney.php?encData=".$encData);
					}
				}
			break;
			case "minus" : 
				$cash = str_replace(",", "", $cash);
				if($idx)
				{
					if(setCash($idx, $cash, 6, "-", $reason))
					{
						ParentReload('O');
						msgGoUrl("해당 회원에게 적립금을 차감하였습니다.", "./win.emoney.php?encData=".$encData);
					}
				}
			break;
			case "del" : 
 				$dsqry = sprintf("delete from %s where idx='%d'", SW_EMONEY, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("해당 적립금 내역을 삭제하였습니다.", "./emoney.list.php?encData=".$encData);

			break;
			case "sdel" :  
				$ok = $err = 0;
				for($i=0; $i < count($chk); $i++)
				{
					if($chk[$i])
					{
						$dsqry = sprintf("delete from %s where idx='%d'", SW_EMONEY, $chk[$i]);
					
						if($db->_execute($dsqry))
							$ok++;
					}
				} 
				msgGoUrl("총".$ok."건의 적립금 내역을 삭제하였습니다.", "./emoney.list.php?encData=".$encData);
			break;
			case "setemoney" :
				$upoint = ($upoint) ? $upoint : "N";
				$punit = ($punit) ? $punit : "N";

				$usqry = "update ".SW_CONFIG." set
							upoint = '$upoint', 
							punit = '$punit', 
							point = '".str_replace(",", "", $point)."', 
							hpoint = '".str_replace(",", "", $hpoint)."', 
							minpoint = '".str_replace(",", "", $minpoint)."', 
							maxrefund = '".str_replace(",", "", $maxrefund)."', 
							maxpoint = '".str_replace(",", "", $maxpoint)."', 
							jbuse='$jbuse', 
							jcash='".str_replace(",", "", $jcash)."', 
							bbuse='$bbuse', 
							bcash='".str_replace(",", "", $bcash)."', 
							fbuse='$fbuse', 
							fcash='".str_replace(",", "", $fcash)."',  
							fbuse2='$fbuse2', 
							fcash2='".str_replace(",", "", $fcash2)."',  
							fcontent='".getAddslashes($fcontent)."',  
							mcash='".str_replace(",", "", $mcash)."',  
							ocash='".str_replace(",", "", $ocash)."', 
							rbuse='$rbuse', 
							rcash='".str_replace(",", "", $rcash)."', 
							updt=now()
						";

				if($db->_execute($usqry))
					msgGoUrl("적립금 자동지급 설정이 수정되었습니다.", "./emoney.set.php");
				else
					ErrorHtml($usqry);
			break;
		}
	break;
}
?>