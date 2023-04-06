<?
include_once(dirname(__FILE__)."/../_header.php");
include_once(dirname(__FILE__)."/../../lib/class.FileHandler.php");

$fhan = new FileHandler();
$rejectkeys = array("x","y","mode");
/// number check --- 콤마(,)제거 칼럼 ///
$numchk = array("point", "mpoint", "hpoint", "minpoint", "maxpoint", "transM", "ntransM", "mprice1", "mprice2");
$arr_obj = array();

switch($mode)
{
	case "config" :

		$cfg = array_map("stripslashes", $cfg);
		$cfg = array_map("addslashes", $cfg);
		$cfg = array_merge($cfg, $_POST);

		$fhan->open("../../conf/cfg.mall.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg = array( \n");
		foreach($cfg as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;

			if(in_array($k, $numchk))
				$arr_obj[] = "'$k' => '".str_replace(",", "", $v)."'";
			else
				$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();

	break;
	case "adm" :

		if(!strcmp($chgpass, 'Y'))
			$addQuery = sprintf(", admpw='%s'", $db->_password($admpw));

		$usqry = sprintf("update %s set name='%s', tel='%s', hp='%s', email='%s' %s where idx=%d", SW_ADMIN, $name, $tel, $hp, $email, $addQuery, $idx);

		if($db->_execute($usqry))
			msgGoUrl("관리자정보가 수정되었습니다.", "./admin.php");
		else
			ErrorHtml($usqry);

	break;
	case "delivery" :

		switch($act)
		{
			case "edit" :

				$home = setHttp($home);
				$url = setHttp($url);
				$usqry = sprintf("update %s set name='%s', home='%s', tel='%s', url='%s' where idx='%d'", SW_DELIVERY, $name, $home, $tel, $url, $idx);

				if($db->_execute($usqry))
					msgGoUrl("택배사 정보가 수정되었습니다.", "./delivery.php", "P");
				else
					ErrorHtml($usqry);

			break;
			case "del" :
				$dsqry = sprintf("delete from %s where idx='%d'", SW_DELIVERY, $idx);

				if($db->_execute($dsqry))
					msgGoUrl("택배사가 삭제되었습니다.", "./delivery.php", "P");
				else
					ErrorHtml($dsqry);

			break;
			default :

				$home = setHttp($home);
				$url = setHttp($url);

				$isqry = "insert into ".SW_DELIVERY." set
							code = '$code',
							name = '$name',
							home = '$home',
							tel = '$tel',
							url = '$url',
							regdt = now()
						";

				if($db->_execute($isqry))
					msgGoUrl("새로운 택배사가 추가되었습니다.", "./delivery.php", "P");
				else
					ErrorHtml($isqry);

			break;
		}

	break;
	case "pg" :
		$_POST['card'] = ($_POST['card']) ? $_POST['card'] : "N";
		$_POST['bank'] = ($_POST['bank']) ? $_POST['bank'] : "N";
		$_POST['vcnt'] = ($_POST['vcnt']) ? $_POST['vcnt'] : "N";
		$_POST['sbank'] = ($_POST['sbank']) ? $_POST['sbank'] : "N";

		$cfg = array_map("stripslashes", $cfg);
		$cfg = array_map("addslashes", $cfg);
		$cfg = array_merge($cfg, $_POST);
		$fhan->open("../../conf/cfg.mall.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg = array( \n");
		foreach($cfg as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;

			if(in_array($k, $numchk))
				$arr_obj[] = "'$k' => '".str_replace(",", "", $v)."'";
			else
				$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();
	break;
	case "bank" :
		switch($act)
		{
			case "edit" :

				$usqry = sprintf("update %s set buse='%s', banknm='%s', banknum='%s', bankown='%s' where idx=%d", SW_BANK, $buse, $banknm, $banknum, $bankown, $idx);
				if($db->_execute($usqry))
					msgGoUrl("은행계좌정보가 수정되었습니다.", "./settlement.php", "P");
				else
					ErrorHtml($usqry);

			break;
			case "del" :

				$dsqry = sprintf("delete from %s where idx=%d", SW_BANK, $idx);
				if($db->_execute($dsqry))
					msgGoUrl("은행계좌정보가 삭제되었습니다.", "./settlement.php" , "P");
				else
					ErrorHtml($dsqry);

			break;
			default :

				$isqry = sprintf("insert into %s set buse='%s', banknm='%s', banknum='%s', bankown='%s', regdt=now()", SW_BANK, $buse, $banknm, $banknum, $bankown);
				if($db->_execute($isqry))
					msgGoUrl("은행계좌정보가 추가되었습니다.", "./settlement.php", "P");
				else
					ErrorHtml($isqry);

			break;
		}
	break;
	case "sms" :
		$cfg = array_map("stripslashes", $cfg);
		$cfg = array_map("addslashes", $cfg);
		$cfg = array_merge($cfg, $_POST);
		$fhan->open("../../conf/cfg.mall.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg = array( \n");
		foreach($cfg as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;

			if(in_array($k, $numchk))
				$arr_obj[] = "'$k' => '".str_replace(",", "", $v)."'";
			else
				$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();
	break;
	case "agreement" :

		$fhan->open("../../conf/agreement.txt");
		if(ini_get('magic_quotes_gpc') == 1)
			$_POST['agreement'] = stripslashes($_POST['agreement']);
		$fhan->write($_POST['agreement']);
		$fhan->close();

	break;
	case "privacy" :

		$fhan->open("../../conf/private.txt");
		if(ini_get('magic_quotes_gpc') == 1)
			$_POST['private'] = stripslashes($_POST['private']);
		$fhan->write($_POST['private']);
		$fhan->close();

	break;
	case "shipping" :

		$fhan->open("../../conf/shipping.txt");
		if(ini_get('magic_quotes_gpc') == 1)
			$_POST['shipping'] = stripslashes($_POST['shipping']);
		$fhan->write($_POST['shipping']);
		$fhan->close();

	break;
	case "refund" :

		$fhan->open("../../conf/refund.txt");
		if(ini_get('magic_quotes_gpc') == 1)
			$_POST['refund'] = stripslashes($_POST['refund']);
		$fhan->write($_POST['refund']);
		$fhan->close();

	break;
	/*
	case "delivery" :
		$cfg = array_map("stripslashes", $cfg);
		$cfg = array_map("addslashes", $cfg);
		$cfg = array_merge($cfg, $_POST);
		$fhan->open("../../conf/cfg.mall.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg = array( \n");
		foreach($cfg as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;

			if(in_array($k, $numchk))
				$arr_obj[] = "'$k' => '".str_replace(",", "", $v)."'";
			else
				$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();
	break;
	*/
	case "point":
		include_once(dirname(__FILE__)."/../../conf/cfg.point.php");

		$_POST['punit'] = ($_POST['punit']) ? $_POST['punit'] : "N";
		$cfg['point'] = array_map("stripslashes", $cfg['point']);
		$cfg['point'] = array_map("addslashes", $cfg['point']);
		$cfg['point'] = array_merge($cfg['point'], $_POST);

		$fhan->open("../../conf/cfg.point.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg['point'] = array( \n");
		foreach($cfg['point'] as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;

			if(in_array($k, $numchk))
				$arr_obj[] = "'$k' => '".str_replace(",", "", $v)."'";
			else
				$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();

	break;
	case "memset":
		include_once(dirname(__FILE__)."/../../conf/cfg.member.php");

		$cfg_m = array_map("stripslashes", $cfg_m);
		$cfg_m = array_map("addslashes", $cfg_m);
		$cfg_m = array_merge($cfg_m, $_POST);

		$fhan->open("../../conf/cfg.member.php");
		$fhan->write("<? \n");
		$fhan->write("\$cfg_m = array( \n");
		foreach($cfg_m as $k => $v)
		{
			if(in_array($k, $rejectkeys)) continue;
			$arr_obj[] = "'$k' => '$v'";
		}
		$fhan->write(@implode(", \n", $arr_obj));
		$fhan->write("\n ); \n");
		$fhan->write("?>");
		$fhan->close();

	break;
}

msgGoUrl("쇼핑몰 기본 환경설정이 수정되었습니다.", $_SERVER['HTTP_REFERER']);

?>
