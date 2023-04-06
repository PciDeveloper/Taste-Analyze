<?php
/**
* Shopping Mall Library
*
* @Author		: seob
* @Update		: 2019-06-07
* @Description	: PHP User Shopping Mall library
**/

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Goods Category Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/**
* category position
* @pos	: sadm
*/
function _get_category_pos($category)
{
	global $db;
	if($category)
	{
		$sqry = sprintf("select name from %s where code in(left('%s', 3), left('%s', 6), left('%s', 9), '%s') order by code asc", SW_CATEGORY, $category, $category, $category, $category);
		$qry = $db->_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$arr[] = $row['name'];

		return implode(" > ", $arr);
	}
}

/**
* All Category
* @pos	: user
*/
function _get_category(&$category)
{
	global $db;

	$sqry = sprintf("select code, pcode, name from %s where buse='Y' order by code asc, seq asc", SW_CATEGORY);
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
	{
		$depth = ceil(strlen($row['code'])/3);
		if($depth > 1)
			$category[$depth][$row['pcode']][] = $row;
		else
			$category[$depth][] = $row;
	}
}

/**
* 차수별 카데고리명
* @pos	: user(네이버페이)
*/
function _get_depth_category_name($category)
{
	global $db;

	if($category)
	{
		$sqry = sprintf("select name, code from %s where code in(left('%s', 3), left('%s', 6), left('%s', 9), '%s') order by code asc", SW_CATEGORY, $category, $category, $category, $category);
		$qry = $db->_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			$depth = ceil(strlen($row['code'])/3);
			$arr[$depth] = $row['name'];
		}

		return $arr;
	}
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// MemberShip Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/**
* membership
* @position	: sadm
* @param	: $data -- idx OR encData
* @des		: 회원정보 가져오기
*/
function _get_member($data, $filed="*")
{
	global $db;

	$encArr = _get_decode64($data);
	if(is_numeric($data))
		$idx = $data;
	else if($encArr['idx'])
		$idx = $encArr['idx'];
	else
		$userid = $data;

	if($idx)
		$sqry = sprintf("select %s from %s where idx='%d'", $filed, SW_MEMBER, $idx);
	else
		$sqry = sprintf("select %s from %s where userid='%s'", $filed, SW_MEMBER, $userid);

	return $db->_fetch($sqry, 1);
}

/**
* get member
* @param : $sdata -- idx OR userid
*/
function _get_member_inf($sdata, $filed="*")
{
	global $db;
	if(is_numeric($sdata) === true)
		$sqry = sprintf("select %s from %s where idx='%d'", $filed, SW_MEMBER, $sdata);
	else
		$sqry = sprintf("select %s from %s where userid=TRIM('%s')", $filed, SW_MEMBER, $sdata);

	return $db->_fetch($sqry, 1);
}


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Goods Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/**
* goods icon
* @pos	: user
* @des	: 상품이미지 위에 아이콘셋팅 --- NEW, SALE, BEST
*/
function _set_icon_gd($icon, $soldout=false)
{
	$ar_ico = array("B"=>"BEST", "S"=>"SALE", "N"=>"NEW");
	$keys_ico = array_keys($ar_ico);
	$ar_i = array();

	if($soldout === true)
		$ar_i[] = "<span class=\"O\">품절</span>";
	else if($icon)
	{
		$tmp = explode(",", $icon);
		for($i=0; $i < count($ar_ico); $i++)
		{
			if(!strcmp($tmp[$i], "Y"))
				$ar_i[] = sprintf("<span class=\"%s\">%s</span>", $keys_ico[$i], $ar_ico[$keys_ico[$i]]);
		}
	}

	if(is_array($ar_i) && count($ar_i) > 0)
		return sprintf("<div class=\"ico_wrap\">%s</div>", implode("\n", $ar_i));
}

function _set_icon_gd_old($icon)
{
	$ar_ico = array("new", "sale", "best");
	if($icon)
	{
		$tmp = explode(",", $icon);
		$ar_i = array();
		for($i=0; $i < count($ar_ico); $i++)
		{
			if(!strcmp($tmp[$i], "Y"))
				$ar_i[] = sprintf("<span class=\"%s\"></span>", $ar_ico[$i]);
		}

		if(is_array($ar_i) && count($ar_i) > 0)
			return sprintf("<div class=\"icon_area\">%s</div>", implode("\n", $ar_i));
	}
}


/**
* goods list & view 네비게이션
* @pos	: user
* @des	: 상품리스트, 상세페이지 상단 네이게이션
*/
function _set_goods_navi($category)
{
	global $db;

	$mobile_path = (_is_dir_mobile()) ? "/m" : "";
	$navi = "<ul class=\"sub_nav\">
				<li><a href=\"/\">HOME</a></li>";
	$sqry = sprintf("select code, name from %s where code in(left('%s', 3), left('%s', 6), left('%s', 9), '%s') order by code asc", SW_CATEGORY, $category, $category, $category, $category);
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
		$navi .= sprintf("<li><a href=\"%s/goods/?cate=%s\">%s</a></li>", $mobile_path, $row['code'], $row['name']);
	$navi .= "</ul>";

	return $navi;
}

/**
* goods list LNB (Local navigation bar)
* @pos	: user
* @des	: 상품리스트 LNB
*/
function _set_goods_lnb($category)
{
	global $db;

	$mobile_path = (_is_dir_mobile()) ? "/m" : "";
	$lnb = "<div class=\"sc_tit\">";
	$sqry = sprintf("select pcode, code, name from %s where code like '%s%%' and length(code) < 9 order by code asc", SW_CATEGORY, substr($category, 0, 3));
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
		$ar_category[] = $row;

	foreach($ar_category as $v)
	{
		if(strlen($v['code']) < 6)
		{
			$lnb .= sprintf("<h2>%s</h2>", $v['name']);
			if(count($ar_category) > 1)
				$lnb .= sprintf("<ul class=\"sub_gnb\"><li %s><a href=\"%s/goods/?cate=%s\">ALL</a></li>", (($category == $v['code']) ? "class=\"on\"" : ""), $mobile_path, $v['code']);
		}
		else
			$lnb .= sprintf("<li %s><a href=\"%s/goods/?cate=%s\">%s</a></li>", (($category == $v['code']) ? "class=\"on\"" : ""), $mobile_path, $v['code'], $v['name']);
	}

	if(count($ar_category) > 1) $lnb .= "</ul>";
	$lnb .= "</div>";


	/*
	for($i=1; $row=mysqli_fetch_assoc($qry); $i++)
	{
		if($i == 1)
		{
			$lnb .= sprintf("<h2>%s</h2>
							<ul class=\"sub_gnb\">
								<li %s><a href=\"%s/goods/?cate=%s\">ALL</a></li>", $row['name'], (($category == $row['code']) ? "class=\"on\"" : ""), $mobile_path, $row['code']);
		}
		else
		{
			$lnb .= sprintf("<li %s><a href=\"%s/goods/?cate=%s\">%s</a></li>", (($category == $row['code']) ? "class=\"on\"" : ""), $mobile_path, $row['code'], $row['name']);
		}
	}
	$lnb .= "</ul></div>";
	*/

	return $lnb;
}

/**
* 장바구니 상품등록 수량
*/
function _get_basket_count()
{
	global $db;

	if(_is_login())
	{
		$sqry = sprintf("select goods from %s where userid='%s'", SW_BASKET, $_SESSION['SES_USERID']);
		$row = $db->_fetch($sqry, 1);
		$count = ($row['goods']) ? count(unserialize(stripslashes(base64_decode($row['goods'])))) : 0;
	}
	else if($_COOKIE['basket'])
		$count = count(unserialize(stripslashes(base64_decode($_COOKIE['basket']))));

	return $count;
}

/**
* 최근본 상품 가져오기
*/
function _get_today_goods($cookie)
{
	global $db;

	$iidx = unserialize($cookie);
	if($iidx)
	{
		$sqry = sprintf("select idx, img3, name from %s where display='Y' and idx in(%s)", SW_GOODS, $iidx);
		$qry = $db->_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$goods[] = $row;

		return $goods;
	}
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Design Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/**
* main visual
*/
function _get_visual(&$visual, $gbcd="P")
{
	global $db;

	$sqry = sprintf("select title, scontent, img, target, url from %s where buse='Y' and gbcd='%s' order by seq asc", SW_VISUAL, $gbcd);
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
		$visual[] = $row;
}

/**
* main banner
*/
function _get_banner(&$banner, $gbcd="P")
{
	global $db;

	$sqry = sprintf("select title, scontent, img, target, url from %s where buse='Y' and gbcd='%s' order by seq asc limit 2", SW_BANNER, $gbcd);
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
		$banner[] = $row;
}

/**
* BANK ACCOUNT --- copyright
*/
function _get_bank_account(&$bank_account)
{
	global $db;

	$sqry = sprintf("select banknm, banknum, bankown from %s where buse='Y' order by idx asc", SW_BANK);
	$qry = $db->_execute($sqry);
	while($row=mysqli_fetch_assoc($qry))
		$bank_account[] = $row;
}


/**
* main best & new 상품 가져오기
*/
function _get_main_goods(&$goods, $pos='best')
{
	global $db, $cfg;

	if($cfg['goods'][$pos])
	{
		$sqry = sprintf("select idx, name, icon, nprice, dcrate, price, blimit, glimit, img3 from %s where idx in(%s) and display='Y' order by seq asc", SW_GOODS, $cfg['goods'][$pos]);
		$qry = $db->_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
			$goods[] = $row;
	}
}

/**
* 상품리뷰 별점
*/
function _set_review_star($point)
{
	$star = "";
	for($p=1; $p <= $point; $p++)
		$star .= "<span class=\"star\"><img src=\"/images/ico/ico_star.png\" alt=\"\" /></span>";
	return $star;
}


//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// shop emoney Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

/**
* emoney history insert & member emoney update
* @param : $user(회원아이디 또는 회원idx), $cash(적립금), $part(구분), $type(-, +), $reason(내역)
*/
function _set_emoney_history($user, $cash, $part, $type, $reason="")
{
	global $db;
	$point = ($type == "-") ? (int)($cash * -1) : (int)($cash * 1);
	$usinf = _get_member_inf($user, "userid, emoney");
	if(!strcmp($type, "-"))
	{
		if($cash > $usinf['emoney'])
		{
			$sumcash = 0;
			$usqry = sprintf("update %s set emoney=0 where userid='%s'", SW_MEMBER, $usinf['userid']);
		}
		else
		{
			$sumcash = $usinf['emoney'] - $cash;
			$usqry = sprintf("update %s set emoney=emoney-%d where userid='%s'", SW_MEMBER, $cash, $usinf['userid']);
		}
	}
	else if(!strcmp($type, "+"))
	{
		$sumcash = $usinf['emoney'] + $cash;
		$usqry = sprintf("update %s set emoney=emoney+%d where userid='%s'", SW_MEMBER, $cash, $usinf['userid']);
	}

	if($db->_execute($usqry))
	{
		$isqry = sprintf("insert into %s set
							part	= '%d',
							userid	= '%s',
							cash	= '%s',
							reason	= '%s',
							sumcash	= '%s',
							regdt	= now()", SW_EMONEY, $part, $usinf['userid'], $point, _get_addslashes($reason), $sumcash);

		return $db->_execute($isqry);
	}
	else
		return false;
}

/**
* 회원가입시 적립
*/
function _set_cash_join($userid)
{
	global $cfg;

	if(!strcmp($cfg['point']['jbuse'], 'Y') && $cfg['point']['jcash'] > 0 && $userid)
		_set_emoney_history($userid, $cfg['point']['jcash'], 3, '+', "가입축하 적립금 지급");
}

/**
* 카드번호 * 표시
*/
function _set_cardno_hidden($str)
{
	$tlen = strlen($str);
	$re = substr($str, 0, 6);
	for($i=($tlen-9); $i > 0; $i-=1)
		$re .= "*";
	$re .= substr($str, -3, 3);

	return $re;
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Debug & Log Files Library
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
/**
* Error Log File Make
*/
function _mk_log_write($str, $fnm="log.log")
{
	global $cfg;

	$fpath = sprintf("/_log/%s", date('Ym'));
	_mk_dir($fpath, $cfg['conf']['absPath']."/_sys");
	$path = dirname(__FIlE__)."/../_log/".date('Ym');
	$str = sprintf("[%s]---%s\r\n=======================================================\r\n", date('Y-m-d H:i:s'), $str);
	$str = _decode_euckr($str);
	$fp = fopen($path."/".$fnm, "a+");
	fwrite($fp, $str);
	fclose($fp);
}
?>
