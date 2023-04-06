<?php
/**
* sms Library
*
* @Author		: seob
* @Update		:	2018-09-28
* @Description	:	ALIGO(알리고) sms function
*/

// sms 설정정보 가져오기 //
function _get_sms_cfg($mode, $gubun='U')
{
	global $db;

	if($mode)
	{
		$sqry = sprintf("select buse, msg from %s where mode='%s' and gubun='%s'", SW_SMS, $mode, $gubun);
		return $db->_fetch($sqry, 1);
	}
}


if(!strcmp($cfg['bsms'], 'Y'))
{
	$sms_url = "https://apis.aligo.in/send/";		// 전송요청 URL
	$sms['user_id'] = $cfg['sms_id'];				// SMS 아이디
	$sms['key'] = $cfg['sms_key'];					// 인증키

	$sender	= str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $cfg['sender']))))));
	$sms['sender'] = $sender;						// 발신번호
	$sms['rdate'] = "";								// 예약일자 - 20161004 : 2016-10-04일기준
	$sms['rtime'] = "";								// 예약시간 - 1930 : 오후 7시30분
	$sms['testmode_yn'] = "";						// Y 인경우 실제문자 전송X , 자동취소(환불) 처리

	switch($sms_gb)
	{
		// 회원가입시 //
		case "join" :
			// 회원가입시 회원발송 //
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], 'Y') && $mobile)
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[성명]", $name, str_replace("[아이디]", $userid, str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $mobile))))));
				$destination = sprintf("%s|%s", $receiver, $name);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 회원가입완료", $cfg['shopnm']);

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
										part	= 2,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $userid, $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}

			// 회원가입시 관리자발송 //
			$smscfg = _get_sms_cfg($sms_gb, 'A');
			if(!strcmp($smscfg['buse'], 'Y') && $cfg['receive'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[성명]", $name, str_replace("[아이디]", $userid, str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $cfg['receive']))))));
				$destination = sprintf("%s|%s", $receiver, $cfg['shopnm']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 회원가입완료", $cfg['shopnm']);

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
										part	= 9,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $userid, $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 주문시 //
		case "order" :
			// 주문시 --- 회원발송 //
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], 'Y') && $ord->vars['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $ord->vars['ordcode'], str_replace("[주문상품]", $ord->vars['goods_name'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $ord->vars['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $ord->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 상품주문완료", $cfg['shopnm']);

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
										part		= 4,
										s_id		= '',
										r_id		= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt		= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}

			// 주문시 --- 관리자발송 //
			$smscfg = _get_sms_cfg($sms_gb, 'A');
			if(!strcmp($smscfg['buse'], 'Y') && $cfg['receive'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $ord->vars['ordcode'], str_replace("[주문상품]", $ord->vars['goods_name'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $cfg['receive']))))));
				$destination = sprintf("%s|%s", $receiver, $ord->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 상품주문완료", $cfg['shopnm']);

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
										part	= 10,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 무통장 결제시 결제정보 안내 --- 회원발송 //
		case "payment" :
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], 'Y') && $ord->vars['mobile'])
			{
				$exbank = explode("|", $_POST['sbank']);
				$msg = $smscfg['msg'];
				$msg = str_replace("[은행명]", $exbank[0], str_replace("[계좌]", $exbank[1], str_replace("[예금주]", $exbank[2], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg)))));
				$msg = str_replace("[결제금액]", number_format($ord->amount)."원", str_replace("[입금자명]", $buyer, $msg));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $ord->vars['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $ord->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 입금계좌정보", $cfg['shopnm']);

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
										part	= 5,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 구매상품 발송 --- 회원발송 //
		case "delivery" :
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], "Y") && $sale->vars['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $sale->vars['ordcode'], str_replace("[주문상품]", $gname, str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$msg = str_replace("[배송업체]", $delivery[$dycompany]['name'], str_replace("[운송장]", $dynumber, $msg));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $sale->vars['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $sale->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 상품발송", $cfg['shopnm']);

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
										part	= 6,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 주문취소 완료 --- 회원발송 //
		case "cancel" :
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], "Y") && $sale->vars['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $sale->vars['ordcode'], str_replace("[주문상품]", $gname, str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $sale->vars['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $sale->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 주문취소완료", $cfg['shopnm']);

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
										part	= 7,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 일괄주문취소 완료 --- 회원발송 : 관리자 취소접수 페이지의 일괄처리시 //
		case "cancel_bundle" :
			$smscfg = _get_sms_cfg('cancel', 'U');
			if(!strcmp($smscfg['buse'], "Y") && $smsinf['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $smsinf['ordcode'], str_replace("[주문상품]", $smsinf['gname'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $smsinf['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $smsinf['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 주문취소완료", $cfg['shopnm']);

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
										part	= 7,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $smsinf['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 주문취소 요청 --- 관리자 발송 //
		case "app_cancel" :
			$smscfg = _get_sms_cfg($sms_gb, 'A');
			if(!strcmp($smscfg['buse'], "Y") && $cfg['receive'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $ord['ordcode'], str_replace("[주문상품]", $ord['name'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $cfg['receive']))))));
				$destination = sprintf("%s|%s", $receiver, $cfg['shopnm']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 주문취소요청", $cfg['shopnm']);

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
										part	= 11,
										s_id	= '',
										r_id	= '',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 반품완료 --- 회원발송 //
		case "back" :
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], "Y") && $sale->vars['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $sale->vars['ordcode'], str_replace("[주문상품]", $gname, str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $sale->vars['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $sale->vars['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 반품(환불)완료", $cfg['shopnm']);

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
										part	= 8,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $ord->vars['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 일괄환불(반품) 완료 --- 회원발송 : 관리자 환불접수 페이지의 일괄처리시 //
		case "back_bundle" :
			$smscfg = _get_sms_cfg($sms_gb, 'U');
			if(!strcmp($smscfg['buse'], "Y") && $smsinf['mobile'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $smsinf['ordcode'], str_replace("[주문상품]", $smsinf['gname'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $smsinf['mobile']))))));
				$destination = sprintf("%s|%s", $receiver, $smsinf['name']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 반품(환불)완료", $cfg['shopnm']);

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
										part	= 8,
										s_id	= '',
										r_id	= '%s',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $smsinf['userid'], $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
		// 반품신청 --- 관리자발송 //
		case "app_back" :
			$smscfg = _get_sms_cfg($sms_gb, 'A');
			if(!strcmp($smscfg['buse'], "Y") && $cfg['receive'])
			{
				$msg = $smscfg['msg'];
				$msg = str_replace("[주문번호]", $ord['ordcode'], str_replace("[주문상품]", $ord['name'], str_replace("[쇼핑몰명]", $cfg['shopnm'], str_replace("[URL]", $cfg['shopurl'], $msg))));
				$receiver = str_replace(" ", "", str_replace("/", "", str_replace("(", "", str_replace(")", "", str_replace(".", "", str_replace("-", "", $cfg['receive']))))));
				$destination = sprintf("%s|%s", $receiver, $cfg['shopnm']);

				$sms['msg'] = stripslashes($msg);
				$sms['receiver'] = $receiver;
				$sms['destination'] = $destination;
				$sms['title'] = sprintf("%s 반품(환불)요청", $cfg['shopnm']);

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
										part	= 12,
										s_id	= '',
										r_id	= '',
										s_mobile	= '%s',
										r_mobile	= '%s',
										message		= '%s',
										rescd		= '%s',
										resmsg		= '%s',
										msg_id		= '%s',
										msg_type	= '%s',
										regdt	= now()", SW_SMS_LOG, $sms['sender'], $receiver, $sms['msg'], $retArr->result_code, $retArr->message, $retArr->msg_id, $retArr->msg_type);

					$db->_execute($isqry);
				}
			}
		break;
	}
}
?>
