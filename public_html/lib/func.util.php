<?
/**
* Utility Function
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-07-29
* @Description	:	PHP User Function
*/

## Only Number Check ##
if(!defined(_ONLY_NUMBER_))
	define(_ONLY_NUMBER_, "onKeyPress=\"if(event.keyCode==13){ event.returnValue=false; } else if((event.keyCode<48)||(event.keyCode>57)){ alert('숫자만 넣어주세요'); event.returnValue=false; }\"");

## Currently Page Name ##
$getCurPage = array_pop(explode("/", $_SERVER['PHP_SELF']));

## Prev Page Name ##
$getPrePage = array_pop(explode("/", $_SERVER['HTTP_REFERER']));

## Currently Directory Name ##
function getCurDir()
{
	$exdir = explode("/", dirname($_SERVER['SCRIPT_NAME']));
	return $exdir[count($exdir)-1];
}

## EUC-KR --> UTF-8로 변환 ##
function decode_utf8($str)
{
	if(function_exists("iconv"))
		return iconv("EUC-KR", "UTF-8", $str);
	else
		return mb_convert_encoding($str, "UTF-8", "EUC-KR");
}

## UTF-8 --> EUC-KR로 변환 ##
function decode_cp949($str)
{
	if(function_exists("iconv"))
		return iconv("UTF-8", "EUC-KR", $str);
	else
		return mb_convert_encoding($str, "EUC-KR", "UTF-8");
}

## addslashes ##
function getAddslashes($str)
{
	if(!get_magic_quotes_gpc())
		return addslashes($str);
	else
		return $str;
}

## stripslashes ##
function getStripslashes($str)
{
	if(get_magic_quotes_gpc())
		$str = stripslashes($str);

	return htmlspecialchars($str);
}

## Array Null 제거 ##
function getArrayNull($arr)
{
	if(!is_array($arr)) return;

	foreach($arr as $key => $val)
		if($val == "") unset($arr[$key]);

	return $arr;
}

## Array Debug ##
function Debug($var, $flag="")
{
	if(is_array($var))
	{
		echo("<div style=\"width:100%;background:#000000;\"><xmp style=\"font:8pt 'Courier New';color:#00ff00;padding:10\">");
		print_r($var);
		echo("</xmp></div>");
	}
	else
		echo($var);

	if(!$flag) exit;
}

## set value ##
function setValue($source, $target)
{
	$source = ($source) ? $source : $target;
	return $source;
}

## URL http:// 확인 ##
function setHttp($url)
{
	if(!trim($url)) return;

	if(!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
		$url = "http://".$url;

	return $url;
}

## base64 Encode ##
function getEncode64($data)
{
	return base64_encode($data);
}

## base64 Decode ##
function getDecode64($encode)
{
	$vars = explode("&", base64_decode($encode));
	$vars_num = count($vars);

	for($i=0; $i < $vars_num; $i++)
	{
		$elements = explode("=", $vars[$i]);
		$var[$elements[0]] = $elements[1];
	}

	return $var;
}

## String Cut ##
function getCutString($sub, $max, $flag=true, $charset="utf-8")
{
	$count = strlen($sub);

	if($count >= $max)
	{
		//for($pos = $max; $pos > 0 && ord($sub[$pos-1]) >= 127; $pos--);
		$s = substr($sub, 0, $max);
		$c = 0;
		for($i=0; $i < strlen($s); $i++)
			if(ord($s[$i]) >= 127) $c++;

		if($charset == "utf-8")
		{
			if($c % 3 == 0)
				$sub = substr($sub, 0, $max);
			else
				$sub = substr($sub, 0, $max + (3-($c % 3)));
		}
		else
		{
			if($c % 2 == 0)
				$sub = substr($sub, 0, $max);
			else
				$sub = substr($sub, 0, $max+1);
		}

		if($flag) $sub .= "...";
	}

	return $sub;
}

function getBankInfo()
{
	global $db;
		$arr_bank = array();
		$qry = $db->_execute("select * from ".SW_BANK." order by idx asc");
		while($row=mysql_fetch_array($qry))
			$arr_bank[] = sprintf("%s|%s|%s", $row['banknum'], $row['banknm'], $row['bankown']);

	return $arr_bank;
}
function getHangulLen($str)
{
	if($str)
	{
		$str = str_replace(".", "", $str);
		$hangul_jamo = '\x{1100}-\x{11ff}';
		$hangul_compatibility_jamo = '\x{3130}-\x{318f}';
		$hangul_syllables = '\x{ac00}-\x{d7af}';
		preg_match_all("/['.$hangul_jamo.$hangul_compatibility_jamo.$hangul_syllables.']+/u",$str,$descs);

		if(is_array($descs[0]))
			$len = mb_strlen(implode($descs[0]), "UTF-8");
		else
			$len = mb_strlen(implode($descs), "UTF-8");

		return $len;
	}
}


## 첨부파일 이미지 ##
function FileTypeImg($file)
{
	$exFile = explode(".", $file);
	$filetype = $exFile[sizeof($exFile)-1];
	$type = strtolower($filetype);			//확장자명을 소문자로 변경

	$exdir = explode("/", dirname($_SERVER['SCRIPT_NAME']));
	if(dirname($_SERVER['SCRIPT_NAME']) == '/')
		$dir = "./";
	else
		for($e=1; $e < count($exdir); $e++) $dir .= "../";

	$fullpath = $dir."images/icon/".$type.".gif";

	if(file_exists($fullpath))
		$icon = sprintf("<img src=\"%s\" align=\"absmiddle\" border=\"0\" alt=\"icon\" />", $fullpath);
	else
		$icon = "<img src=\"/image/icon/file.gif\" align=\"absmiddle\" border=\"0\" alt=\"icon\" />";

	return $icon;
}

## 첨부파일 용량 ##
function getFileSize($size)
{
	if($size >= 1073741824)
		return number_format($size/1073741824)."Gbyte";
	else if($size >= 1048576)
		return number_format($size/1048576)."Mbyte";
	else if($size >= 1024)
		return number_format($size/1024)."Kbyte";
	else
		return number_format($size)."byte";
}

## 백분율 계산 ##
function getPercent($total, $cnt)
{
	if($total > 0)
	{
		$per = ($cnt/$total) * 100;
		return round($per, 1);
	}
	return 0;
}

## 브라우져 정보 ##
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
    elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }

    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; }
    elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; }
    elseif(preg_match('/Chrome/i',$u_agent)) { $bname = 'Google Chrome'; $ub = "Chrome"; }
    elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; }
    elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; }
    elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; }

    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {

    }
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; }
        else { $version= $matches['version'][1]; }
    }
    else { $version= $matches['version'][0]; }

	if ($version==null || $version=="") {$version="?";}
    return array('userAgent'=>$u_agent, 'name'=>$bname, 'version'=>$version, 'platform'=>$platform, 'pattern'=>$pattern);
}

## Send Form ##
function sendForm($var, $url, $method="post", $target="")
{
	foreach($var as $key=>$val)
		$buffer .= sprintf("<input type=\"hidden\" name=\"%s\" value=\"%s\" />\n", $key, $val);

	if($target)
		$target = sprintf("document.ffm.target=\"%s\";", $target);

	echo <<< SCRIPT

		<html>
		<body>
		<form name="ffm" action="{$url}" method="{$method}">
		{$buffer}
		</form>

		<script type="text/javascript">
		{$target}
		document.ffm.submit();
		</script>
		</body>
		</html>

SCRIPT;

	exit;
}

/**
* member function
*/

## check login (유)##
function isLogin()
{
	if($_SESSION['SES_USERIDX'])
		return true;
	else
		return false;
}

### check login && href ###
function goLogin($referer="", $target="", $parm="")
{
	if(!isLogin())
	{
		msg("회원만 이용가능합니다.\\n\\n먼저 로그인 해주세요.");

		if(preg_match("/(\/m\/|\/mobile\/)/i", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])))
			$url = "/m/member/login.php";
		else
			$url = "/member/login.php";

		$referer = ($referer) ? $referer : $_SERVER['SCRIPT_NAME'];

		if($target)
		{
			$url .= sprintf("?referer=%s", $referer);
			if($parm) $url .= sprintf("&%s", $parm);

			$target .= ".location";

			printf("<script type=\"text/javascript\"> %s.replace('%s'); </script>", $target, $url);
		}
		else
			sendForm(array(referer => $referer), $url);
	}
}

### Member Information (ID로 검색) --- (유) ###
function getMember($userid="", $filed="*", $fb="")
{
	global $db;

	$userid = ($userid) ? $userid : $_SESSION['SES_USERID'];
	$fb = ($fb) ? $fb : $_SESSION['SES_FACEBOOK'];

	if($userid)
	{
		if($fb)
			$sqry = sprintf("select %s from %s where userid=TRIM('%s') order by idx desc limit 1", $filed, SW_FBUSER, $userid);
		else
			$sqry = sprintf("select %s from %s where userid=TRIM('%s') order by idx desc limit 1", $filed, SW_MEMBER, $userid);

		if($db->isRecodeExists($sqry))
			return $db->_fetch($sqry, 1);
		else
			return;
	}
}

### Member Information (idx로 검색) --- (유) 2014-11-25 ###
function getUser($idx, $filed="*")
{
	global $db;

	if($idx)
	{
		$sqry = sprintf("select %s from %s where idx='%d'", $filed, SW_MEMBER, $idx);
		if($db->isRecodeExists($sqry))
			return $db->_fetch($sqry, 1);
		else
			return;

	}
}

/**
* category function
*/

### 상품분류 위치(swadm) ###
function getCatePos($cate)
{
	global $db;

	$sqry = sprintf("select * from %s where code in(left('%s',3), left('%s',6), left('%s',9), '%s') order by code asc", SW_CATEGORY, $cate, $cate, $cate, $cate);
	$qry = $db->_execute($sqry);

	while($row=mysql_fetch_array($qry))
		$arr[] = $row['name'];

	return @implode(" > ", $arr);
}

### 카테고리 정보(front) ###
function getCateInfo($code)
{
	global $db;

	$sqry = sprintf("select * from %s where buse=1 and code='%s'", SW_CATEGORY, $code);
	$row = $db->_fetch($sqry, 1);

	if(!$row['topimg'] && strlen($row['code']) > 3)
	{
		for($i=strlen($row['code'])-3; $i >= 3; $i-=3)
		{
			$s = sprintf("select topimg from %s where buse=1 and code='%s'", SW_CATEGORY, substr($row['code'], 0, $i));
			$r = $db->_fetch($s, 1);

			if($r['topimg'])
			{
				$row['topimg'] = $r['topimg'];
				break;
			}
		}
	}

	return $row;
}

### 차수별 카테고리 정보(front) ###
function getCateDepth($cate, $depth=2)
{
	global $db;

	$cate = substr($cate, 0, 3);
	$length = $depth * 3;

	$sqry = sprintf("select code, name, titimg from %s where length(code)=%d and buse=1 and code like '%s%%' order by seq asc", SW_CATEGORY, $length, $cate);
	$qry = $db->_execute($sqry);

	while($row=mysql_fetch_assoc($qry))
		$arr[] = $row;

	return $arr;
}

### 하위카테고리가 있을경우 하위카테고리 정보를 아니면 같은 depth 카테고리정보(front - mobile) ###
function getRelaCate($cate)
{
	global $db;

	if($cate)
		$sqry = sprintf("select code, name from %s where code like '%s%%' and length(code)=%d order by seq asc", SW_CATEGORY, $cate, strlen($cate)+3);
	else
		$sqry = sprintf("select code, name from %s where length(code)=3 order by seq asc", SW_CATEGORY);

	if(!$db->isRecodeExists($sqry))
		$sqry = sprintf("select code, name from %s where length(code)=%d order by seq asc", SW_CATEGORY, strlen($cate));

	$qry = $db->_execute($sqry);
	while($row=mysql_fetch_array($qry))
		$arr[] = $row;

	return $arr;
}

### 카테고리 navi(front) ###
function getCateNavi($cate)
{
	global $db;

	$sqry = sprintf("select code, name from %s where code in(left('%s',3), left('%s',6), left('%s',9), '%s') order by code asc", SW_CATEGORY, $cate, $cate, $cate, $cate);
	$db->_affected($numrows, $sqry);
	$qry = $db->_execute($sqry);

	for($i=1; $row=mysql_fetch_array($qry); $i++)
		$arr[] = sprintf("<a href=\"/goods/goods.list.php?cate=%s\" %s>%s</a> ",$row['code'], (($numrows == $i) ? "class=\"current\"" : ""), $row['name']);

	return @implode(" &nbsp;&gt;&nbsp; ", $arr);
}

/**
* goods function
*/

### 상품코드 생성 ###
function getGoodsCode($len=8)
{
	for($i=ord('0'); $i <= ord('9'); $i++) $arr_no[] = chr($i);

	for($i=ord('A'); $i <= ord('Z'); $i++) $arr_alp[] = chr($i);

	$len_no = count($arr_no);
	$len_alp = count($arr_alp);


	for($i=0; $i < $len; $i++)
	{
		if(rand(0, 1) == 0) $result .= $arr_no[rand(0, $len_no-1)];
		else $result .= $arr_alp[rand(0, $len_alp-1)];
	}

	return $result;
}

### Icon View ###
function setGoodsIcon($icon)
{
	global $db;

	if($icon)
	{
		$sqry = sprintf("select * from %s where idx in(%s)", SW_ICON, $icon);
		$qry = $db->_execute($sqry);

		while($row = mysql_fetch_array($qry))
		{
			if($row['idx'] == 9) continue;

			$tmp[] = sprintf("<img src=\"/upload/goods/icon/%s\" alt=\"%s\" style=\"vertical-align:middle;\" />", $row['img'], $row['title']);
		}

		return @implode(" ", $tmp);
	}
}

### Icon Arr --- 2014-11-20(유) ###
function getArrIcon()
{
	global $db;

	$sqry = sprintf("select idx, name, img from %s where buse='Y' order by idx asc", SW_ICON);
	$qry = $db->_execute($sqry);
	while($row=mysql_fetch_array($qry))
		$arr_icon[] = $row;

	return $arr_icon;
}

### Paing Function (상품리뷰) ###
function Pagination($var)
{
	$totpage = ceil($var['total'] / $var['limit']);				//총페이지수
	$totblock = ceil($totpage / $var['pageblock']);				//총블럭수
	$curblock = ceil($var['page'] / $var['pageblock']);			//현재페이지 블럭
	$curstart = $var['pageblock'] * ($curblock - 1) + 1;		//시작페이지

	if($curblock > 1)
		$first_block = sprintf("<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_prev\"><img src=\"/img/icon/notice_prev.png\" alt=\"이전\"></a>&nbsp;",$var['cate'], 1);
	else
		$first_block = sprintf("<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_prev\"><img src=\"/img/icon/notice_prev.png\" alt=\"이전\"></a>&nbsp;",$var['cate'], $var['page']-1);

	if($var['page'] > 1)
		$pre_page = sprintf("<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_next\"><img src=\"/img/icon/notice_next.png\" alt=\"다음\"></a>&nbsp;", $var['cate'], $var['page']-1);
	else
		$pre_page = "<img src=\"/img/icon/notice_next.png\" alt=\"다음\">&nbsp;";

	if($totpage > $var['page'])
		$next_page = sprintf("&nbsp;<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_next\"><img src=\"/img/icon/notice_next.png\" alt=\"다음\"></a> ", $var['cate'], $var['page']+1);
	else
		$next_page = "<img src=\"/img/icon/notice_next.png\" alt=\"다음\">";

	if(($curblock != $totblock) && $totblock > 1)
		$last_block = sprintf("&nbsp;<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_next\"><img src=\"/img/icon/notice_next.png\" alt=\"다음\"></a>", $var['cate'], $totpage);
	else
		$last_block = sprintf("&nbsp;<a href=\"javascript:getPortf('%s', '%d');\" class=\"bt_next\"><img src=\"/img/icon/notice_next.png\" alt=\"다음\"></a>", $var['cate'], $totpage);

	$arr_pages[] = "";
	for($i = $curstart, $j = 1; $j <= $var['pageblock']; $i++, $j++)
	{
		if($i > $totpage)
			break;

		if($var['page'] == $i)
			$arr_pages[] = sprintf("<a href='#' class='num_on'><strong>%s</strong></a>", $i);
		else
			$arr_pages[] = sprintf("<a href=\"javascript:getPortf('%s', '%d');\" class='num_on'>%s</a>", $var['cate'], $i,$i);

		$pages = @implode("", $arr_pages);
	}
	$arr_pages[] = "";
	return array(
					FirstBlock	=>	$first_block,
					//PrevPage	=>	$pre_page,
					Pages		=>	$pages,
					//NextPage	=>	$next_page,
					LastBlock	=>	$last_block
				);

}

function PrintArray($arr)
{
	foreach($arr as $val)
		print($val);
}

### Send Mail ###
function SendMail($fromname, $frommail, $tomail, $subject, $content, $file="")
{
	$fromname   = "=?utf-8?B?" . base64_encode($fromname) . "?=";
    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

	//$header  = "Return-Path: <$frommail>\n";
    $header = "From: $fromname <$frommail>\n";
    $header .= "Reply-To: <$frommail>\n";
    $header .= "MIME-Version: 1.0\n";

	if($file)
	{
		$boundary = '----=='.uniqid(rand(),true);

		$header .= "Content-type: MULTIPART/MIXED; BOUNDARY=\"$boundary\"\n\n";
        $header .= "--$boundary\n";
	}

	$header .= "Content-Type: TEXT/HTML; charset=utf-8\n";
	$header .= "Content-Transfer-Encoding: BASE64\n\n";
	$header .= chunk_split(base64_encode($content)) . "\n";

	if($file)
	{
		foreach ($file as $f)
		{
			$header .= "\n--$boundary\n";
			$header .= "Content-Type: APPLICATION/OCTET-STREAM; name=\"$f[name]\"\n";
			$header .= "Content-Transfer-Encoding: BASE64\n";
			$header .= "Content-Disposition: inline; filename=\"$f[name]\"\n";
			$header .= "\n";
			$header .= chunk_split(base64_encode($f[data]));
			$header .= "\n";
		}

		$header .= "--$boundary--\n";
	}

	$send_mail = mail($tomail, $subject, "", $header);

	if($send_mail)
		return true;
	else
		return false;
}

function AttachFile($filename, $file)
{
	$fp = fopen($file, "r");
	$tfiles = array( "name"=>$filename, "data"=>fread($fp, filesize($file)));

	fclose($fp);

	return $tfiles;
}

### check login ###
function goLoginMyOrd($mode)
{
	if(!isLogin())
	{
		$url = "/member/login.php?mode=".$mode;
		printf("<script type=\"text/javascript\"> location.replace('%s'); </script>", $url);
	}
}

### 배송사 Array 생성 ###
function getArrDelivery()
{
	global $db;

	$arr_delivery = array();
	$dy_qry = $db->_execute("select code, name, url from sw_delivery order by idx asc");
	while($dy_row=mysql_fetch_array($dy_qry))
	{
		$arr_delivery[$dy_row['code']] = $dy_row;
	}

	return $arr_delivery;
}

### 주문상품 리스트 ###
function getOrdGoods($ordcode)
{
	global $db;

	$item = array();
	$arr_status = array();
	$sqry = sprintf("select a.*, b.img3 from sw_order_item a, sw_goods b where a.gidx=b.idx and a.ordcode='%s' order by a.idx asc", $ordcode);
	$qry = $db->_execute($sqry);

	while($row = mysql_fetch_array($qry))
	{
		if($row['optnm'])
		{
			$exoptnm = explode("」「", $row['optnm']);
			$exoptval = explode("」「", $row['optval']);

			if($exoptnm[0] && $exoptval[0])
				$row['coption'][] = sprintf("%s : %s", $exoptnm[0], $exoptval[0]);

			if($exoptnm[1] && $exoptval[1])
				$row['coption'][] = sprintf("%s : %s", $exoptnm[1], $exoptval[1]);
		}

		$arr_status[] = $row['istatus'];
		$item[] = $row;
	}

	if(count($item) > 1)
		$ordgoods = sprintf("%s 외 %d건", $item[0]['gname'], count($item)-1);
	else
		$ordgoods =  $item[0]['gname'];


	return array(
					"orditem"=>$item,
					"ordgoods"=>$ordgoods
				);
}


function getGoodsinfo($gidx)
{
	global $db;

	$sql = sprintf("select * from sw_goods where idx='%s'",$gidx);
	$rs = $db->_execute($sql);
	$row = mysql_fetch_array($rs);
	return $row;
}
### HelpBox Print ###
function HelpBoxPrint($arr, $tit='')
{
	if($arr)
	{
		$tit = ($tit) ? $tit : "간략설명";

		$strHelp = @implode("<br/>", $arr);

		$HelpBoxTag =<<< TAGS
			<div style="margin-top:20px;">
			<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#778AA3">
			<tr height="10">
				<td width="10"><img src="/swadm/img/common/exp1.gif" /></td>
				<td></td>
				<td width="10"><img src="/swadm/img/common/exp2.gif" /></td>
			</tr>
			<tr>
				<td></td>
				<td height="30" valign="top" style="padding:5px;color:#ffffff;">
					<div style="margin-bottom:5px;" class="bold">※ {$tit} </div>
					{$strHelp}
				</td>
				<td></td>
		</tr>
		<tr>
			<td width="10"><img src="/swadm/img/common/exp3.gif" /></td>
			<td></td>
			<td width="10"><img src="/swadm/img/common/exp4.gif" /></td>
		</tr>
		</table>
		</div>
TAGS;

		echo $HelpBoxTag;
	}
}

### Get Parameter ###
function getParse($referer)
{
	$parse = parse_url($referer);


	if($parse['query'])
		$parse['query'] = "?".$parse['query'];

	return $parse;
}

### PopUp View ###
function makePopUp()
{
	global $db;

	$popup_sqry = sprintf("select * from %s where buse='Y' and sday <= CURDATE() and eday >= CURDATE()", SW_POPUP);

	if($db->isRecodeExists($popup_sqry))
	{
		$popup_qry = $db->_execute($popup_sqry);
		while($popup_row=mysql_fetch_array($popup_qry))
		{
			if(!$_COOKIE['ck_popup_'.$popup_row['idx']])
			{
				if($popup_row['ptype'] == 1)
				{
					$popup_row['width'] += 20;
					$popup_row['height'] += 30;

					WinPopUp("/comm/popup.win.php?idx=".$popup_row['idx'], "popup_".$popup_row['idx'], "top=".$popup_row['ptop'].", left=".$popup_row['pleft'].", width=".$popup_row['width'].", height=".$popup_row['height'].", scrollbars=no");
				}
				else if($popup_row['ptype'] == 2)
				{
					$popup_id = "POPUP_ID_".$popup_row['idx'];
					$cookie_name = "ck_popup_".$popup_row['idx'];
					include("./comm/popup.layer.php");
				}
			}
		}
	}
}

### 임시비번 생성 ###
function getTempPwd($len=8)
{
	for($i=ord('0'); $i <= ord('9'); $i++) $arr_no[] = chr($i);
	for($i=ord('A'); $i <= ord('Z'); $i++) $arr_alp[] = chr($i);

	$len_no = count($arr_no);
	$len_alp = count($arr_alp);

	$result = $arr_alp[rand(0, $len_alp-1)];

	for($i=0; $i < $len; $i++)
	{
		if(rand(0, 1) == 0) $result .= $arr_no[rand(0, $len_no-1)];
		else $result .= $arr_alp[rand(0, $len_alp-1)];
	}

	return strtolower($result);
}

### EMPTY TD ###
function setEmptyTd($lTDCnt, $nTDCnt, $W="", $aTD="")
{
	if($nTDCnt%$lTDCnt != 0)
	{
		$eTDCnt = $lTDCnt - ($nTDCnt % $lTDCnt);

		for($i=1; $i <= $eTDCnt; $i++)
		{
			printf("<td width='%d' class='pr02'>&nbsp;</td>", $W);

			if($aTD && ($i < $eTDCnt)) echo($aTD);
		}
	}
}


### IP 치환 ###
function getipAddress($ip)
{
	$exip = explode(".", $ip);

	for($p=0; $p < count($exip); $p++)
		$ipArr[] = ($p == 2) ? "♡" : $exip[$p];

	return @implode(".", $ipArr);
}

### 시작일과 종료일사이의 날짜 차 ###
function getBetweenPeriod($sday, $eday)
{
	$sday = substr($sday, 0, 10);
	$eday = substr($eday, 0, 10);

	$exsday = explode("-", $sday);
	$exeday = explode("-", $eday);

	$smk = mktime(0,0,0,$exsday[1], $exsday[2], $exsday[0]);
	$emk = mktime(0,0,0,$exeday[1], $exeday[2], $exeday[0]);

	if($emk > $smk)
		$period = ($emk-$smk)/86400;
	else if($smk == $emk)
		$period = 0;
	else
		$period = -1;

	return $period;
}

### 한글아이디 별표 치환 ###
function getIdHidden($str='')
{
	$len = strlen($str)/2;
    $s = substr($str, 0, $len);
    $cnt = 0;
    for ($i=0; $i<strlen($s); $i++)
        if (ord($s[$i]) > 127)
            $cnt++;

    $s = substr($s, 0, $len - ($cnt % 2));

	$suffix = "";
	for ($i=0; $i<strlen($s); $i++)
		$suffix .= "*";

    return $s . $suffix;
}

### 아이디 별표시 ###
function setHidden($vlen, $str)
{
	$rstr = substr($str, 0, $vlen);
	for($i=strlen($str); $i > $vlen; $i-=1)
		$rstr .= "*";

	return $rstr;
}

function setHidden2($vlen, $str, $charset="utf-8")
{
	if($charset == "utf-8")
	{
		$s = substr($str, 0, ($vlen*3));
		$c = 0;
		for($i=0; $i < strlen($s); $i++)
			if(ord($s[$i]) >= 127) $c++;

		if($c % 3 == 0)
			$rstr = substr($str, 0, ($vlen*3));
		else
			$rstr = substr($str, 0, ($vlen*3)+(3-($c % 3)));

		for($i=strlen($str); $i > ($vlen*3); $i-=3)
			$rstr .= "*";
	}
	else
	{
		$s = substr($str, 0, ($vlen*2));
		$c = 0;
		for($i=0; $i < strlen($s); $i++)
			if(ord($s[$i]) >= 127) $c++;

		if($c % 2 == 0)
			$rstr = substr($str, 0, ($vlen*2));
		else
			$rstr = substr($str, 0, ($vlen*2)+1);

		for($s=strlen($str); $i > ($vlen*2); $i-=2)
			$rstr .= "*";
	}

	return $rstr;
}

### 오늘본 상품 ###
function setTodayGoods($arr)
{
	$max = 4;
	$gidx = $arr['goodsIdx'];
	$ex_gidx = @explode(",", $_COOKIE['ck_todaygidx']);
	$arr_today = unserialize(stripslashes($_COOKIE['ck_todayginfo']));

	if(!is_array($arr_today)) $arr_today = array();

	if(in_array($gidx, $ex_gidx))
	{
		$key = array_search($gidx, $ex_gidx);
		array_splice($ex_gidx, $key, 1);
		array_splice($arr_today, $key, 1);
	}
	array_unshift($ex_gidx, $gidx);
	array_unshift($arr_today, $arr);
	array_splice($arr_today, $max);

	$cktime = 24-date("H");
	$cktime = ($cktime) ? $cktime : 1;

	//setcookie('ck_todaygidx','',time() - 3600,'/');
	//setcookie('ck_todayginfo','',time() - 3600,'/');
	setCookie("ck_todaygidx", implode(",", $ex_gidx), time()+3600*$cktime, "/");
	setCookie("ck_todayginfo", serialize($arr_today), time()+3600*$cktime, "/");
}

### 특정폴더를 기준으로 상태경로 ###
function getRelativePath()
{
	$exdir = explode("/", dirname($_SERVER['SCRIPT_NAME']));
	for($i=1; $i < count($exdir); $i++)
	{
		if(strcmp("m", $exdir[count($exdir)-$i]))
			$path .= "../";
		else
			break;
	}

	if(!$path) $path = "./";

	return $path;
}

### 마이크로타입 ###
function _microtime()
{
	return array_sum(explode(" ", microtime()));
}

### /m/ 및 /mobile/ 폴더가 있으면 모바일버전 ###
function isMobile()
{
	if(preg_match("/(\/m\/|\/mobile)/i", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])))
		return true;
	else
		return false;
}

function getBoardImg($bidx, $ftype="image")
{
	global $db;

	if(!strcmp($ftype, "image"))
		$sqry = sprintf("select upfile from sw_boardfile where bidx='%d' and ftype='image' order by idx asc limit 1", $bidx);
	else
		$sqry = sprintf("select upfile from sw_boardfile where bidx='%d' and ftype <> 'image' order by idx asc limit 1", $bidx);

	$row = $db->_fetch($sqry, 1);
	return $row['upfile'];
}

function validate_password($password, $hash)
{
	// Split the hash into 4 parts.
	$params = explode(':', $hash);
	if (count($params) < 4) return false;

	// Recalculate the hash and compare it with the original.
	$pbkdf2 = base64_decode($params[3]);
	$pbkdf2_check = pbkdf2_default($params[0], $password, $params[2], (int)$params[1], strlen($pbkdf2));
	return slow_equals($pbkdf2, $pbkdf2_check);
}
?>
