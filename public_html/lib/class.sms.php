<?
####################################################################
##
##	파 일 이 름 : class.sms.php
##	작   성   일 : 2005-01-30 오후 17:30:19
##	최종수정일 : 2005-05-10 오전 09:29:12
##	작   성   자 : 이용창(Yi YongChang)
##	메         일 : yyc2851@i-heart.co.kr
##	소         속 : http://www.i-heart.co.kr
##	소   유   권 : i-heart.co.kr
##	파 일 설 명 : SMS Socket 발송 Class 페이지
##
####################################################################

//////////////////////////////////////////////////////////////////////////////////////////////////
function spacing($text,$size) {
	for ($i=0; $i<$size; $i++) $text.=" ";
	$text = substr($text,0,$size);
	return $text;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function cut_char($word, $cut) {
	$word=substr($word,0,$cut);						// 필요한 길이만큼 취함.
	for ($k=$cut-1; $k>1; $k--) {	 
		if (ord(substr($word,$k,1))<128) break;		// 한글값은 160 이상.
	}
	$word=substr($word,0,$cut-($cut-$k+1)%2);
	return $word;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function CheckCommonType($dest, $rsvTime) {
	$dest=eregi_replace("[^0-9]","",$dest);
	if (strlen($dest)<10 || strlen($dest)>11) return "휴대폰 번호가 틀렸습니다";
	$CID=substr($dest,0,3);
	if ( eregi("[^0-9]",$CID) || ($CID!='010' && $CID!='011' && $CID!='016' && $CID!='017' && $CID!='018' && $CID!='019') ) return "휴대폰 앞자리 번호가 잘못되었습니다";
	$rsvTime=eregi_replace("[^0-9]","",$rsvTime);
	if ($rsvTime) {
		if (!checkdate(substr($rsvTime,4,2),substr($rsvTime,6,2),substr($rsvTime,0,4))) return "예약날짜가 잘못되었습니다";
		if (substr($rsvTime,8,2)>23 || substr($rsvTime,10,2)>59) return "예약시간이 잘못되었습니다";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function Check_Date($resYear, $c_resYear, $resMonth, $c_resMonth, $resDay, $c_resDay, $resHour, $c_resHour) {
	if ($resYear < $c_resYear || $resMonth < $c_resMonth || $resDay < $c_resDay || $resHour < $c_resHour) {
		echo "
			<script language='javascript'>
			<!--//
				alert('예약시간이 현재 시간 이전입니다. 예약시간을 다시 설정해주세요');
				history.go(-1);
			//-->
			</script>
		";
		exit();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// SMS 클래스
class SMS {
	var $ID;
	var $PWD;
	var $SMS_Server;
	var $port;
	var $SMS_Port;
	var $Data = array();
	var $Result = array();
	var $fp;

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// 초기 설정 값
	function SMS() {
		global $cfg;

		$this->ID=$cfg['sms_id'];
		$this->PWD=$cfg['sms_pw'];

		//$this->ID="sinbiweb";			// *****계약 후 지정 사용자가 입력*****
		//$this->PWD="bong5584";			// *****계약 후 지정 사용자가 입력*****
		//$this->SMS_Server="211.239.159.217";
		//$this->SMS_Port="7296";
		$this->SMS_Server="211.239.159.200";
		$this->SMS_Port="7296";
		$this->ID = spacing($this->ID,10);
		$this->PWD = spacing($this->PWD,10);
		$this->fp="";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// 결과값 지우기
	function Init() {
		$this->Data = "";
		$this->Result = "";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// 번호별 메세지 입력
	function Add($dest, $callBack, $Caller, $msg, $rsvTime) {
		// 내용 검사 1
		$Error = CheckCommonType($dest, $rsvTime);
		if ($Error) return $Error;
		// 내용 검사 2
		if ( eregi("[^0-9]",$callBack) ) return "회신 전화번호가 잘못되었습니다";
		$msg=cut_char($msg,80); // 80자 제한
		// 보낼 내용을 배열에 집어넣기
		$dest = spacing($dest,11);
		$callBack = spacing($callBack,11);
		$Caller = spacing($Caller,10);
		$rsvTime = spacing($rsvTime,12);
		$msg = spacing($msg,80);
		$this->Data[] = '01144 '.$this->ID.$this->PWD.$dest.$callBack.$Caller.$rsvTime.$msg;
		return "";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// socket 열기
	function Open() {
		$this->fp=fsockopen($this->SMS_Server,$this->SMS_Port);
		if (!$this->fp) { return false; }
		return true;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// socket 닫기
	function Close() {
		fclose($this->fp);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////
	// SMS 보내기
	function Send () {
		set_time_limit(300);
		foreach($this->Data as $key => $puts) {
			$gets = "";
			$dest = substr($puts,26,11);
			fputs($this->fp,$puts);
			while(!$gets) { $gets=fread($this->fp,29); }
			if (substr($gets,0,8)=="0223  00") $this->Result[]=$dest.":".substr($gets,19,10);
			else $this->Result[$dest]=$dest.":Error";
			$gets="";
		}
		$this->Data="";
		return true;
	}
}
?>