<?
/**
* common Library
*
* @Author		:	kkang(sinbiweb)
* @Update		:	2014-11-26
* @Description	:	common function
*/

/**
* banner group list
*/
function listBannerGrp()
{
	global $db;

	$sqry = sprintf("select * from %s order by idx asc", SW_BANNER_GRP);
	$qry = $db->_execute($sqry);
	while($row=mysql_fetch_array($qry))
		$arr_banner[] = $row;

	return $arr_banner;
}

/**
* banner group name
*/
function getBannerGrpNM($code)
{
	global $db;

	$sqry = sprintf("select name from %s where code='%s'", SW_BANNER_GRP, $code);
	$row = $db->_fetch($sqry, 1);

	return $row['name'];
}

/**
* 오늘방문자수
*/
function getTodayVisit()
{
	global $db;

	list($total) = $db->_fetch("select count(*) from ".SW_COUNTER." where left(regdt, 10) >= DATE_FORMAT(CURDATE(), '%Y-%m-%d')");
	return $total;
}

/**
* 오늘 가입자
*/
function getTodayJoin()
{
	global $db;

	list($total) = $db->_fetch("select count(*) from ".SW_MEMBER." where left(regdt, 10) >= DATE_FORMAT(CURDATE(), '%Y-%m-%d')");
	return $total;
}

/**
* 전체 회원수
*/
function getTotMember()
{
	global $db;

	list($total) = $db->_fetch("select count(*) from ".SW_MEMBER);
	return $total;
}

/**
* 배너 정보
*/
function getBanner($code)
{
	global $db;

	if($code)
	{
		$sqry = sprintf("select * from %s where code='%s' and buse='Y' and sday <= CURDATE() and eday >= CURDATE()", SW_BANNER, $code);
		$qry = $db->_execute($sqry);
		while($row=mysql_fetch_array($qry))
			$arr_banner[] = $row;

		return $arr_banner;
	}
}

/**
* 타임세일
*/
function getTimesale()
{
	global $db;

	$sqry = sprintf("select * from %s where sday <= CURDATE() and eday >= CURDATE() and status=1 order by idx asc limit 1", SW_SALE);
	$row = $db->_fetch($sqry);
	if($row)
	{
		$now = time();
		$exsday = explode("-", $row['sday']);
		$exeday = explode("-", $row['eday']);
		$smk = mktime($row['shour'], $row['smin'], 0, $exsday[1], $exsday[2], $exsday[0]);
		$emk = mktime($row['ehour'], $row['emin'], 0, $exeday[1], $exeday[2], $exeday[0]);

		if($now >= $smk && $now <= $emk)
		{
			$flag = true;
			$config = array('targetDate' => array(
													'day'		=> $exeday[2],
													'month'		=> $exeday[1],
													'year'		=> $exeday[0],
													'hour'		=> $row['ehour'],
													'minute'	=> $row['emin'],
													'second'	=> 0
												));
			$target = $emk;
			$diffSecs = $target - $now;
			$date = array();
			$date['secs'] = $diffSecs % 60;
			$date['mins'] = floor($diffSecs/60)%60;
			$date['hours'] = floor($diffSecs/60/60)%24;
			$date['days'] = floor($diffSecs/60/60/24)%7;
			$date['weeks']	= floor($diffSecs/60/60/24/7);
			foreach ($date as $i => $d)
			{
				$d1 = $d%10;
				$d2 = ($d-$d1) / 10;
				$date[$i] = array((int)$d2, (int)$d1, (int)$d);
			}

			$goods = $db->_fetch("select * from ".SW_GOODS." where idx='".$row['gidx']."'");
		}
		else
		{
			$flag = false;
			$time_banner = getBanner('timesale');

		}
	}
	else
	{
		$flag = false;
		$time_banner = getBanner('timesale');
	}

	if(isMobile())
	{
		if($flag)
			include_once(dirname(__FILE__)."/../m/inc/timesale.php");
	}
	else
		include_once(dirname(__FILE__)."/../inc/timesale.php");
}

/**
* 기획상품(타임세일) 기간체크
*/
function chkGoodsSale()
{
	global $db, $swshop;

	if($_SESSION['SES_SALE'])
	{
		$sqry = sprintf("select * from %s where sday <= CURDATE() and eday >= CURDATE() and status > 0 order by idx asc", SW_SALE);
		$qry = $db->_execute($sqry);
		$flag = false;
		while($row=mysql_fetch_array($qry))
		{
			$status = chkSalePeriod($row['sday'], $row['shour'], $row['smin'], $row['eday'], $row['ehour'], $row['emin']);
			if($row['status'] == 1)
			{
				if($status == -1)
				{
					$db->_execute("update ".SW_SALE." set status=0 where idx='".$row['idx']."'");
					$db->_execute("update ".SW_GOODS." set bsale=0 where idx='".$row['gidx']."'");
				}
				else if($status == 1)
					$flag = true;
			}
			else if($row['status'] == 2)
			{
				if($status == 1 && !$flag)
				{
					$db->_execute("update ".SW_SALE." set status=1 where idx='".$row['idx']."'");
					$db->_execute("update ".SW_GOODS." set bsale='".$row['idx']."' where idx='".$row['gidx']."'");
				}
			}
		}

		setSession("SES_SALE", true);
	}
}

/**
* 기획상품 세일기간 체크
*/
function chkSalePeriod($sday, $shour=0, $smin=0, $eday, $ehour=0, $emin=0)
{
	$exsday = explode("-", $sday);
	$exeday = explode("-", $eday);

	$now = time();
	$smk = mktime($shour, $smin, 0, $exsday[1], $exsday[2], $exsday[0]);
	$emk = mktime($ehour, $emin, 0, $exeday[1], $exeday[2], $exeday[0]);

	if($now > $emk)
		return -1;			//종료일이 현재보다 이전날짜일경우
	else if($smk > $emk)
		return -2;			//시작일이 종료일보다 크면
	else if($now >= $smk)
		return 1;			//현재날짜가 시작일보다 이후날짜일 경우 진행중상태
	else if($now < $smk)
		return 2;			//현재날짜가 시작일보다 이전날짜일 경우 진행예정상태
	else
		return 0;			//예상치 못한 에러
}

/**
* 주문상태별 count
*/
function getCntOrder($status)
{
	global $db;

	$sqry = sprintf("select count(idx) as cnt from %s where status in ('%d')", SW_ORDER, $status);
	$row = $db->_fetch($sqry);
	return $row['cnt'];
}

/**
* 상품정보 구하기
*/
function getGoods($gidx)
{
	global $db;

	$sqry = sprintf("select * from %s where idx='%d'", SW_GOODS, $gidx);
	$row = $db->_fetch($sqry, 1);

	return $row;
}

/**
* 세션 생성
*/
function setSession($ses_nm, $val)
{
	$_SESSION["$ses_nm"] = $val;
}

function getSession($ses_nm)
{
	return $_SESSION[$ses_nm];
}

/**
* 생일당일 문자메세지 발송
*/
function autoSms()
{
	global $db, $swshop;

	if(date("Y-m-d", strtotime($swshop['auto_sms'])) != date("Y-m-d"))
	{
		$sms = $db->_fetch("select * from ".SW_SMS." where gubun='U' and mode='birthday'");

		if(!strcmp($sms['buse'], "Y"))
		{
			$pos = "birthday";
			include_once(dirname(__FILE__)."/./lib.sms.php");
		}

		$db->_execute("update ".SW_CONFIG." set auto_sms=now()");
	}
}

/**
* 사이트 드래그 및 우클릭 방지
*/
function setMouseOff()
{
	global $cfg;

	if(!strcmp($cfg['mouseEvent'], "N"))
	{
		echo <<< SCRIPT
			<script type="text/javascript">
			$(document).ready(function(){
				$(this).bind('contextmenu', function(e){
					return false;
				});
				$(this).bind('selectstart', function(e){
					return false;
				});
				$(this).bind('dragstart', function(e){
					return false;
				});
			});
			</script>
SCRIPT;
	}
}

/**
* 상품자동 수령
*/
function setAutoStatus($mode="")
{
	global $cfg, $db;

	if($mode == "202")
	{
		$sqry = sprintf("select idx, userid from %s where status=201 and chgdt is not null and DATE_ADD(chgdt, INTERVAL +7 DAY) <= NOW()", SW_ORDER);
		if($db->isRecodeExists($sqry))
			$db->_execute("update sw_order set status=202 where status=201 and chgdt is not null and DATE_ADD(chgdt, INTERVAL +7 DAY) <= NOW()");
	}
	else
	{
		$sqry = sprintf("select idx, userid, ordcode from %s where status=202 and chgdt is not null and DATE_ADD(chgdt, INTERVAL +7 DAY) <= NOW()", SW_ORDER);
		if($db->isRecodeExists($sqry))
		{
			$qry = $db->_execute($sqry);

			while($row=mysql_fetch_array($qry))
			{
				if($row['userid'])
				{
					$apoint = array();
					$agname = array();
					$sqry2 = sprintf("select gname, emoney, ea from %s where ordcode='%s' order by idx asc", SW_ORDER_ITEM, $row['ordcode']);
					$qry2 = $db->_execute($sqry2);

					while($row2 = mysql_fetch_array($qry2))
					{
						$agname[] = $row2['gname'];

						if($row2['emoney'] > 0)
							$apoint[] = $row2['emoney'] * $row2['ea'];
					}

					if(count($agname) > 1)
						$ordgname = sprintf("%s 외 %d건", $agname[0], count($agname)-1);
					else
						$ordgname =  $agname[0];

					$totpoint = array_sum($apoint);
					if($totpoint > 0 && $row['userid'])
					{
						$mb = getMember($row['userid']);
						$reason = $ordgname." 상품구매 포인트 적립";
						setCash($mb['idx'], $totpoint, 2, "+", $reason);
					}
				}

				$db->_execute("update sw_order set status='900' where idx='%d'", SW_ORDER, $row['idx']);
			}
		}
	}
}

// ================================
// desc		: Pretty print some JSON
// name		: json_format
// param	: $
// return	: $
// ================================
function json_format($json) {
	$tab = "	";
	$new_json = "";
	$indent_level = 0;
	$in_string = false;

	$json_obj = json_decode($json);

	if($json_obj === false)
		return false;

	$json = json_encode($json_obj);
	$len = strlen($json);

	for($c = 0; $c < $len; $c++) {
		$char = $json[$c];
		switch($char) {
			case '{':
			case '[':
				if(!$in_string) {
					$new_json .= $char . "\n" . str_repeat($tab, $indent_level+1);
					$indent_level++;
				} else {
					$new_json .= $char;
				}
				break;
			case '}':
			case ']':
				if(!$in_string) {
					$indent_level--;
					$new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
				} else {
					$new_json .= $char;
				}
				break;
			case ',':
				if(!$in_string) {
					$new_json .= ",\n" . str_repeat($tab, $indent_level);
				} else {
					$new_json .= $char;
				}
				break;
			case ':':
				if(!$in_string) {
					$new_json .= ": ";
				} else {
					$new_json .= $char;
				}
				break;
			case '"':
				if($c > 0 && $json[$c-1] != '\\') {
					$in_string = !$in_string;
				}
			default:
				$new_json .= $char;
				break;
		}
	}

	return $new_json;
}

/**
 * Indents a flat JSON string to make it more human-readable.
 *
 * @param string $json The original JSON string to process.
 *
 * @return string Indented version of the original JSON string.
 */
function indent($json) {

	$result	  = '';
	$pos		 = 0;
	$strLen	  = strlen($json);
	$indentStr   = '  ';
	$newLine	 = "\n";
	$prevChar	= '';
	$outOfQuotes = true;

	for ($i=0; $i<=$strLen; $i++) {

		// Grab the next character in the string.
		$char = substr($json, $i, 1);

		// Are we inside a quoted string?
		if ($char == '"' && $prevChar != '\\') {
			$outOfQuotes = !$outOfQuotes;

			// If this character is the end of an element,
			// output a new line and indent the next line.
		} else if(($char == '}' || $char == ']') && $outOfQuotes) {
			$result .= $newLine;
			$pos --;
			for ($j=0; $j<$pos; $j++) {
				$result .= $indentStr;
			}
		}

		// Add the character to the result string.
		$result .= $char;

		// If the last character was the beginning of an element,
		// output a new line and indent the next line.
		if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
			$result .= $newLine;
			if ($char == '{' || $char == '[') {
				$pos ++;
			}

			for ($j = 0; $j < $pos; $j++) {
				$result .= $indentStr;
			}
		}

		$prevChar = $char;
	}

	return $result;
}

/**
 * 파라메터 값을 얻는다.
 * $format : N(수갑), S(문자열)
 */
function getParamValue($format, $param) {
	if (isset($_REQUEST[$param])) {
		if (!empty($_REQUEST[$param]) && trim($_REQUEST[$param]) != "") {
			return $_REQUEST[$param];
		}
	}

	if ($format == 'N') {
		return 0;
	} else {
		return "";
	}
}

/*************************************************************************
**
**  푸쉬 전송 모듈
**
*************************************************************************/
function getPushToken($user_no) {
	// 회원 번호를 얻는다.
	$q = "SELECT `f_push_token` from `t_device`";
	$q.= " WHERE `f_user_no`='".$user_no."'";
	$result = mysql_query($q);
	if (!$result) {
		return "-1";
	}

	if (mysql_num_rows($result) < 1) {
		return "-2";
	}

	$row = mysql_fetch_object($result);
	return $row->f_push_token;
}

/**
 * 푸시메시지 보내는 함수
 */
function sendPushMessage($platform, $registrationIDs, $message) {

	$msgfield = array("msg" => $message);

	if ($platform == 'android') {
		$result = sendAndroidPushWithValues($registrationIDs, $msgfield);
	} else {
		$result = sendIosPushWithValues($registrationIDs, $message, '');
	}

	return $result;
}

/**
 * 안드로이드 푸시메시지 -> 메시지에 필드값들이 들어가 있다.
 */
function sendAndroidPushWithValues($registrationIDs, $msgfield) {

	// 	$registrationIDs = array();
	// 	$registrationIDs['0'] = $dtoken;
	$url = 'https://android.googleapis.com/gcm/send';
	// thecosy.master@gmail.com/TheCOSY
	$apiKey = "AIzaSyB7sS-z3cdYNK2gk-ELeJQ3cHaM3dUQO2c";
	$headers = array('Authorization: key='.$apiKey, 'Content-Type: application/json');
	$fields = array('registration_ids' => $registrationIDs, 'data' => $msgfield);

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields ));

	$result = curl_exec($ch);
	// 	if ($result == true) {
	// 		echo ' GCM Success!';
	// 	} else {
	// 		echo 'GCM Fail!'.$result;
	// 	}
	curl_close($ch);

	// 	sleep(59);

	return $result;
}

/**
 * Ios 푸시메시지 -> 메시지에 필드값들이 들어가 있다.
 */
function sendIosPushWithValues($registrationIDs, $msgfield, $customData) {

	$result = '';
	//$registrationIDs = array();

	// 개발용
	// $apnsHost = 'gateway.sandbox.push.apple.com';
	// $apnsCert = 'apns-dev.pem';

	// 실서비스용
	$apnsHost = 'gateway.push.apple.com';
	$apnsCert = dirname(__FILE__).'/../resource/apns-pro.pem';

	//$registrationIDs[0] = "cc700671cd01c668443563462887b4353e89a3ca771923a7ec0f6ed096fcb145";
	// $deviceToken[0] = "267caecd4b97adb7abc66069326629219019c5d2a8fd722a9ed1cd4edbab0c03";

	$apnsPort = 2195;
	$streamContext = stream_context_create();
	stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

	$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
	if ($apns)
	{
		for($i = 0; $i<count($registrationIDs); $i++) {
			$payload = json_encode(array('aps' => array('alert' => $msgfield, 'badge' => 0, 'sound' => 'default', 'custom_data' => $customData)));
			$msg = chr(0) . pack('n', 32) . pack('H*', $registrationIDs[$i]) . pack('n', strlen($payload)) . $payload;
			$result = fwrite($apns, $msg, strlen($msg));
			if (!$result)
				$result = 'Message not delivered' . PHP_EOL;
			else
				$result = 'Message successfully delivered' . PHP_EOL;

			// 			echo $result . PHP_EOL;
			// ob_flush();
			flush();
		}
	}
	else
	{
		$result = 'Message not delivered'.$errorString;
	}
	fclose($apns);

	return $result;
}

?>
