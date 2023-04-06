<?php
/**
* PHP Function Library
*
* @Author		: seob
* @Update		: 2018-06-01
* @Description	: User PHP Function Library
*/

/**
* Required check
*/
function _chk_required($arr, $field, $flag=true, $msg="")
{
	$msg = ($msg) ? $msg : "필수정보가 누락되었습니다.";
	foreach($field as $v)
	{
		if(!$arr[$v])
		{
			if($flag === true)
				msg($msg, -1, true);
			else
				msg($msg, '', true);

			break;
		}
	}
}

/**
* page or directory
*/
$_get_curr_page = array_pop(explode("/", $_SERVER['PHP_SELF']));
$_get_prev_page = array_pop(explode("/", $_SERVER['HTTP_REFERER']));
function _get_curr_dir()
{
	$exdir = explode("/", dirname($_SERVER['SCRIPT_NAME']));
	return $exdir[count($exdir)-1];
}

/**
* get addslashes & get stripslashes
*/
function _get_addslashes($str)
{
	if(!get_magic_quotes_gpc())
		return addslashes($str);
	else
		return $str;
}

function _get_stripslashes($srr)
{
	if(get_magic_quotes_gpc())
		return stripslashes($str);
	else
		return $str;
}

/**
* Base64 Encode & Decode
*/
function _get_encode64($str)
{
	if($str)
		return base64_encode($str);
}

function _get_decode64($enc)
{
	if($enc)
	{
		$ex = explode("&", base64_decode($enc));
		$cnt = count($ex);
		for($i=0; $i < $cnt; $i++)
		{
			$el = explode("=", $ex[$i]);
			$v[$el[0]] = urldecode($el[1]);
		}
		return $v;
	}
}
function _get_re_encode64($encdata, $reval)
{
	$redata = array();
	$vars = explode("&", base64_decode($encode));
	for($i=0; $i < count($vars); $i++)
	{
		$elements = explode("=", $vars[$i]);
		if(in_array($elements[0], array_keys($reval)))
			$redata[] = sprintf("%s=%s", $elements[0], $reval[$elements[0]]);
		else
			$redata[] = sprintf("%s=%s", $elements[0], $elements[1]);
	}

	return _get_encode64(implode("&", $redata));
}

/**
* html 특수문자 엔티티문자로 변환
*/
function _set_text_convert($str)
{
	$source[] = "/</";
    $target[] = "&lt;";
    $source[] = "/>/";
    $target[] = "&gt;";
    $source[] = "/\"/";
    $target[] = "&#034;";
	//$source[] = "/\'/";
    //$target[] = "&#039;";
    //$source[] = "/}/";
	//$target[] = "&#125;";

	return preg_replace($source, $target, $str);
}
/**
* html 엔티티문자를 html 특수문자로 변환
* &nbsp; &amp; &middot; 등을 정상적 특수문자로 출력
*/
function _set_entity_convert($str)
{
	return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}

/**
* 시작일과 종료일사이의 날짜차
*/
function _get_between_period($sday, $eday)
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

/**
* 빈배열 제거
*/
function _get_array_null($arr)
{
	if(!is_array($arr)) return;

	foreach($arr as $k=>$v)
		if($v == "") unset($arr[$k]);

	return $arr;
}

/**
* url http://
*/
function _set_http($url)
{
	if(!trim($url)) return;
	if(!preg_match("/^(http|https|ftp|telnet|news|mms)\:\/\//i", $url))
		$url = "http://".$url;

	return $url;
}

/**
* string cut
*/
function _get_cut_string($str, $size=0, $flag=true, $charset="utf-8")
{
	$count = strlen($str);
	if($count > $size)
	{
		$s = substr($str, 0, $size);
		$c = 0;
		for($i=0; $i < strlen($s); $i++)
			if(ord($s[$i]) >= 127) $c++;

		if($charset == "utf-8")
		{
			if($c % 3 == 0)
				$str = substr($str, 0, $size);
			else
				$str = substr($str, 0, $size + (3-($c % 3)));
		}
		else
		{
			if($c % 2 == 0)
				$str = substr($str, 0, $size);
			else
				$str = substr($str, 0, $size+1);
		}

		if($flag) $str .= "...";
	}

	return $str;
}

/**
* 문자 인코딩(charset) 변환
*/
// euc-kr --> utf-8 //
function _decode_utf8($str)
{
	if(function_exists("iconv"))
		return iconv("EUC-KR", "UTF-8", $str);
	else
		return mb_convert_encoding($str, "EUC_KR", "UTF-8");
}
// utf-8 --> euc-kr //
function _decode_euckr($str)
{
	if(function_exists("iconv"))
		return iconv("UTF-8", "EUC-KR", $str);
	else
		return mb_convert_encoding($str, "UTF-8", "EUC-KR");
}

/**
* cookie & session get & set
*/
function _set_cookie($cknm, $ckval, $expire)
{
	setcookie(md5($cknm), base64_encode($ckval), time()+$expire, "/");
}

function _get_cookie($cknm)
{
	return base64_decode($_COOKIE[md5($cknm)]);
}

function _set_session($ssnm, $ssval)
{
	$_SESSION[$ssnm] = $ssval;
}

function _get_session($ssnm)
{
	return $_SESSION[$ssnm];
}

function _re_session($ar)
{
	foreach($ar as $k=>$v)
		if($_SESSION[$k]) $_SESSION[$k] = $v;
}

/**
* 삼항연산자
*/
function _set_value($source, $target)
{
	return ($source) ? $source : $target;
}

/**
* 아이디 숨기기 --- *표시
*
* @param : $len(표시할 string 갯수), $str(문자열)
*/
function _set_hidden($str, $len=3)
{
	$str_len = mb_strlen($str);
	if($str_len <= 3 ) $len = 1;

	$re = mb_substr($str, 0, $len);
	for($i=mb_strlen($str); $i > $len; $i-=1)
		$re .= "*";
	return $re;
	/*
	$re = substr($str, 0, $len);
	for($i=strlen($str); $i > $len; $i-=1)
		$re .= "*";
	return $re;
	*/
}

/**
* /m/ 또는 /mobile/ 폴더포함시 모바일버전
*/
function _is_dir_mobile()
{
	if(preg_match("/(\/m\/|\/mobile\/)/i", "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])))
		return true;
	else
		return false;
}

/**
* agent 체크로 모바일여부 확인
*/
function _is_agent_mobile()
{
	$is_mobile = false;
	$agentCheck = array('iPod', 'iPhone', 'Android', 'BlackBerry', 'SymbianOS', 'Bada', 'Tizen', 'Kindle', 'Wii', 'SCH-', 'SPH-', 'CANU-', 'Windows Phone', 'Windows CE', 'POLARIS', 'Palm', 'Dorothy Browser', 'Mobile', 'Opera Mobi', 'Opera Mini', 'Minimo', 'AvantGo', 'NetFront', 'Nokia', 'LGPlayer', 'SonyEricsson', 'HTC');
	foreach($agentCheck as $agent)
	{
		if(stripos($_SERVER['HTTP_USER_AGENT'], $agent) !== FALSE)
			$is_mobile = true;
	}

	return $is_mobile;
}

/**
* 로그인 여부
*/
function _is_login()
{
	if($_SESSION['SES_USERID'])
		return true;
	else
		return false;
}

/**
* 임시비번 생성
*/
function _get_temp_pass($len=8)
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

/**
* send mail
* @param : $fname(보내는이), $fmail(보내는메일), $tmail(받는메일), $subject(제목), $content(내용), $file(첨부파일)
*/
function _send_mail($fname, $fmail, $tmail, $subject, $content, $file="")
{
	$fname   = "=?utf-8?B?" . base64_encode($fname) . "?=";
    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

	$header  = "Return-Path: <$fmail>\n";
    $header .= "From: $fname <$fmail>\n";
	$header .= "Reply-To: <$fmail>\n";
    $header .= "MIME-Version: 1.0\n";
	$boundary = '----=='.uniqid(rand(),true);
	if($file)
	{
		$boundary = '----=='.uniqid(rand(),true);

		$header .= "Content-type: MULTIPART/MIXED; BOUNDARY=\"$boundary\"\n\n";
        $header .= "--$boundary\n";
	}
	$header .= "Content-Type: TEXT/HTML; charset=utf-8\n";
	$header .= "Content-Transfer-Encoding: BASE64\n\n";
	$mailbody .= chunk_split(base64_encode($content))."\r\n";

	if($file)
	{
		foreach ($file as $f)
		{
			$header .= "\n--$boundary\n";
			$header .= "Content-Type: APPLICATION/OCTET-STREAM; name=\"$f[name]\"\n";
			$header .= "Content-Transfer-Encoding: BASE64\n";
			$header .= "Content-Disposition: inline; filename=\"$f[name]\"\n";
			$header .= "\n";
			$header .= chunk_split(base64_encode($f['data']));
			$header .= "\n";
		}

		$header .= "--$boundary--\n";
	}

	$send_mail = mail($tmail, $subject, $mailbody, $header);
	if($send_mail)
		return true;
	else
		return false;
}

/**
* Send Mail function
* @param	: $fromname(보내는이), $frommail(보내는메일), $tomail(받는메일), $subject(제목), $content(내용)
*/
function _send_mail2($fromname, $frommail, $tomail, $subject, $content, $file="")
{
	$fromname   = "=?utf-8?B?" . base64_encode($fromname) . "?=";
    $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";

	$header  = "Return-Path: <$frommail>\n";
    $header .= "From: $fromname <$frommail>\n";
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

	$send_mail = mail($tomail, $subject, '', $header);

	if($send_mail)
		return true;
	else
		return false;
}

/**
* 알리고 문자발송 함수
* param : $sender(발송번호), $receiver(수신번호), $rname(수신자명), $msg(발신메세지)
*/
function _send_sms($sender, $receiver, $rname="", $msg)
{
	global $db, $cfg;

	$sms_url = "https://apis.aligo.in/send/";		// 전송요청 URL
	$sms['user_id'] = $cfg['sms_id'];				// SMS 아이디
	$sms['key'] = $cfg['sms_key'];					// 인증키

	$sender	= str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $sender))))));
	$receiver	= str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $receiver))))));
	$sms['sender'] = $sender;						// 발신번호
	$sms['rdate'] = "";								// 예약일자 - 20161004 : 2016-10-04일기준
	$sms['rtime'] = "";								// 예약시간 - 1930 : 오후 7시30분
	$sms['testmode_yn'] = "";						// Y 인경우 실제문자 전송X , 자동취소(환불) 처리

	$destination = sprintf("%s|%s", $receiver, $rname);
	$sms['msg'] = stripslashes($msg);
	$sms['receiver'] = $receiver;
	$sms['destination'] = $destination;
	$sms['title'] = "";
	$host_info = explode("/", $sms_url);
	$port = $host_info[0] == 'https:' ? 443 : 80;

	$oCurl = curl_init();
	curl_setopt($oCurl, CURLOPT_PORT, $port);
	curl_setopt($oCurl, CURLOPT_URL, $sms_url);
	curl_setopt($oCurl, CURLOPT_POST, 1);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
	$ret = curl_exec($oCurl);
	curl_close($oCurl);
	$retArr = json_decode($ret); // 결과배열

	if($retArr)
	{
		$isqry = sprintf("insert into %s set
							part	= 1,
							s_id	= '%s',
							r_id	= '',
							s_mobile	= '%s',
							r_mobile	= '%s',
							message		= '%s',
							rescd		= '%s',
							resmsg		= '%s',
							msg_id		= '%s',
							msg_type	= '%s',
							regdt	= now()", SW_SMS_LOG, $_SESSION['SES_ADM_ID'], $sender, $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

		$db->_execute($isqry);

		if($retArr->message == "success")
			return true;
		else
			return false;
	}
}


function AttachFile($filename, $file)
{
	$fp = fopen($file, "r");
	$tfiles = array("name"=>$filename, "data"=>fread($fp, filesize($file)));
	fclose($fp);
	return $tfiles;
}

/**
* 백분율 계산
*/
function _get_percent($t, $v)
{
	if($t > 0)
	{
		$per = ($v/$t) * 100;
		return round($per, 1);
	}
	return 0;
}

/**
* error message
*/
function _show_error($msg, $debug=true)
{
	if($debug === true)
	{
		echo <<< HTML
			<br />
			<div align="center">
			<form>
			<table width="400" cellpadding="3" cellspacing="1" border="0" bgcolor="#666666">
			<tr bgcolor="#bbbbbb">
				<td height="30" align="center" style="font-family:Tahoma;font-size:8pt;font-weight:bold;">[ ERROR ]</td>
			</tr>
			<tr bgcolor="#efefef">
				<td align="center" height="30" style="font-family:Tahoma;font-size:8pt;">
					<br />{$msg}<br /><br />
					<input type="button" value="Move Back" onClick="history.back();" style="border:1px solid #b0b0b0;background:#3d3d3d;color:#ffffff;font-size:8pt;height:23px;" /><br /><br />
				</td>
			</tr>
			</table>
			</form>
			</div>
HTML;
		exit;
	}
	else
		msg("처리도중 오류가 발생하였습니다.", -1, true);
}

/**
* make popup
*/
function _mk_popup()
{
	global $db, $is_mobile;


	$gbcd = ($is_mobile === true) ? "M" : "P";
	$sqry = sprintf("select * from %s where buse='Y' and gbcd='%s' and sday <= curdate() and eday >= curdate() order by idx asc", SW_POPUP, $gbcd);
	if($db->isRecodeExists($sqry))
	{
		$qry = $db->_execute($sqry);
		while($row=mysqli_fetch_assoc($qry))
		{
			if($_COOKIE['ck_popup_'.$row['idx']]) continue;
			if(!strcmp($gbcd, "M"))
			{
				$pp = $row;
				$popup_id = sprintf("popup_%d", $row['idx']);
				$ck_name = sprintf("ck_popup_%d", $row['idx']);
				include("./common/popup.layer.php");
			}
			else
			{
				if($row['ptype'] == 1)
				{
					_popup_open("./common/popup.win.php?idx=".$row['idx'], "popup_".$row['idx'], "top=".$row['pp_top'].", left=".$row['pp_left'].", width=".$row['width'].", height=".$row['height'].", scrollbars=no");
				}
				else if($row['ptype'] == 2)
				{
					$pp = $row;
					$popup_id = sprintf("popup_%d", $row['idx']);
					$ck_name = sprintf("ck_popup_%d", $row['idx']);
					include("./common/popup.layer.php");
				}
			}
		}
	}
}

/**
* SSL 보안서버 설정시 HTTPS Redirect
*/
function _ssl_redirect()
{
	global $cfg;

	// SSL --- 사용인경우 //
	if(!strcmp($cfg['conf']['bssl'], "Y"))
	{
		if($_SERVER['HTTPS'] != "on")
		{
			if($_SERVER['REQUEST_URI'] == "/")
				gourl("https://".$_SERVER['HTTP_HOST']."/");
			else
			{
				if(!file_exists(_get_abs_path($_SERVER['PHP_SELF'])))
					gourl("https://".$_SERVER['HTTP_HOST']."/");
				else
					gourl("https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			}
		}
	}
}

/**
* DEMO인 경우 insert, update, delete 막기
*/
function _is_demo_act()
{
	if(__DEMO__ === true)
	{
		msgreload("P", "데모사이트에선 등록, 수정, 삭제가되지 않습니다.");
		//msg("데모사이트에선 등록, 수정, 삭제가되지 않습니다.", "", true);
		exit;
	}
}

/**
* sinbiweb ip debug
*/
function _is_sinbiweb()
{
	$arIp = array("1.212.109.220");
	if(in_array($_SERVER['REMOTE_ADDR'], $arIp))
		return true;
	else
		return false;
}

/**
* array debug
*/
function _debug($vars, $flag=false)
{
	if(is_array($vars))
	{
		echo("<div style=\"width:100%;background-color:#000000;\"><xmp style=\"font:8pt 'Courier New';color:#00ff00;padding:10\">");
		print_r($vars);
		echo("</xmp></div>");
	}
	else
		echo($vars);

	if($flag === false) exit;
}


function utfCharToNumber($char)
{
	$convmap = array(0x80, 0xffff, 0, 0xffff);
	$number = mb_encode_numericentity($char, $convmap, 'UTF-8');
	return $number;
}

function strToArray($str)
{
	$result = array();
	$stop = mb_strlen($str, 'UTF-8');
	for( $idx = 0; $idx < $stop; $idx++) {
		$result[] = mb_substr($str, $idx, 1, 'UTF-8');
	}

	return $result;
}

function parseInt($string)
{
	if(preg_match('/(\d+)/', $string, $array))
		return $array[1];
	else
		return 0;
}

function _get_choseong($str)
{
	global $ar_cho_han;
	$ChoSeong = array (0x3131, 0x3132, 0x3134, 0x3137, 0x3138, 0x3139, 0x3141, 0x3142, 0x3143, 0x3145, 0x3146, 0x3147, 0x3148, 0x3149, 0x314a, 0x314b, 0x314c, 0x314d, 0x314e);
	$one_char_num = utfCharToNumber($str);
	$one_char_num = substr($one_char_num, 2, mb_strlen($one_char_num, 'UTF-8')-3);
	if($one_char_num >= 0xAC00 && $one_char_num <= 0xD7A3)
	{
		$i1 = 0;
		$i3 = 0;
		$i3 = $one_char_num - 0xAC00;
		$i1 = $i3 / (21 * 28);

		$result = $ar_cho_han[$ChoSeong[parseInt($i1)]];

		return $result;
	}
}

// xss 관련 태그제거 --- 그누보드참조 //
function _xss_tags_remove($str)
{
	$str = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $str);
	return $str;
}

function sendNotification($title = "", $body = "", $token = "", $serverKey = ""){
  $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
     $notification = array(
             'title' => $title,
             'body' => $body,
             'icon' =>'myIcon',
             'sound' => 'mySound'
         );
         $extraNotificationData = array("message" => $notification,"moredata" =>'dd');
         $fcmNotification = array(
             //'registration_ids' => $tokenList, //multple token array
             'to'        => $token, //single token
             'notification' => $notification,
             'data' => $extraNotificationData
         );
         $headers = array(
             'Authorization: key=' .$serverKey,
             'Content-Type: application/json'
         );


         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL,$fcmUrl);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
         $result = curl_exec($ch);
         curl_close($ch);
}
?>
