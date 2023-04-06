<?
####################################################################
##
##	�� �� �� �� : class.sms.php
##	��   ��   �� : 2005-01-30 ���� 17:30:19
##	���������� : 2005-05-10 ���� 09:29:12
##	��   ��   �� : �̿�â(Yi YongChang)
##	��         �� : yyc2851@i-heart.co.kr
##	��         �� : http://www.i-heart.co.kr
##	��   ��   �� : i-heart.co.kr
##	�� �� �� �� : SMS Socket �߼� Class ������
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
	$word=substr($word,0,$cut);						// �ʿ��� ���̸�ŭ ����.
	for ($k=$cut-1; $k>1; $k--) {	 
		if (ord(substr($word,$k,1))<128) break;		// �ѱ۰��� 160 �̻�.
	}
	$word=substr($word,0,$cut-($cut-$k+1)%2);
	return $word;
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function CheckCommonType($dest, $rsvTime) {
	$dest=eregi_replace("[^0-9]","",$dest);
	if (strlen($dest)<10 || strlen($dest)>11) return "�޴��� ��ȣ�� Ʋ�Ƚ��ϴ�";
	$CID=substr($dest,0,3);
	if ( eregi("[^0-9]",$CID) || ($CID!='010' && $CID!='011' && $CID!='016' && $CID!='017' && $CID!='018' && $CID!='019') ) return "�޴��� ���ڸ� ��ȣ�� �߸��Ǿ����ϴ�";
	$rsvTime=eregi_replace("[^0-9]","",$rsvTime);
	if ($rsvTime) {
		if (!checkdate(substr($rsvTime,4,2),substr($rsvTime,6,2),substr($rsvTime,0,4))) return "���೯¥�� �߸��Ǿ����ϴ�";
		if (substr($rsvTime,8,2)>23 || substr($rsvTime,10,2)>59) return "����ð��� �߸��Ǿ����ϴ�";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
function Check_Date($resYear, $c_resYear, $resMonth, $c_resMonth, $resDay, $c_resDay, $resHour, $c_resHour) {
	if ($resYear < $c_resYear || $resMonth < $c_resMonth || $resDay < $c_resDay || $resHour < $c_resHour) {
		echo "
			<script language='javascript'>
			<!--//
				alert('����ð��� ���� �ð� �����Դϴ�. ����ð��� �ٽ� �������ּ���');
				history.go(-1);
			//-->
			</script>
		";
		exit();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// SMS Ŭ����
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
	// �ʱ� ���� ��
	function SMS() {
		global $cfg;

		$this->ID=$cfg['sms_id'];
		$this->PWD=$cfg['sms_pw'];

		//$this->ID="sinbiweb";			// *****��� �� ���� ����ڰ� �Է�*****
		//$this->PWD="bong5584";			// *****��� �� ���� ����ڰ� �Է�*****
		//$this->SMS_Server="211.239.159.217";
		//$this->SMS_Port="7296";
		$this->SMS_Server="211.239.159.200";
		$this->SMS_Port="7296";
		$this->ID = spacing($this->ID,10);
		$this->PWD = spacing($this->PWD,10);
		$this->fp="";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// ����� �����
	function Init() {
		$this->Data = "";
		$this->Result = "";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// ��ȣ�� �޼��� �Է�
	function Add($dest, $callBack, $Caller, $msg, $rsvTime) {
		// ���� �˻� 1
		$Error = CheckCommonType($dest, $rsvTime);
		if ($Error) return $Error;
		// ���� �˻� 2
		if ( eregi("[^0-9]",$callBack) ) return "ȸ�� ��ȭ��ȣ�� �߸��Ǿ����ϴ�";
		$msg=cut_char($msg,80); // 80�� ����
		// ���� ������ �迭�� ����ֱ�
		$dest = spacing($dest,11);
		$callBack = spacing($callBack,11);
		$Caller = spacing($Caller,10);
		$rsvTime = spacing($rsvTime,12);
		$msg = spacing($msg,80);
		$this->Data[] = '01144 '.$this->ID.$this->PWD.$dest.$callBack.$Caller.$rsvTime.$msg;
		return "";
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// socket ����
	function Open() {
		$this->fp=fsockopen($this->SMS_Server,$this->SMS_Port);
		if (!$this->fp) { return false; }
		return true;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////
	// socket �ݱ�
	function Close() {
		fclose($this->fp);
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////
	// SMS ������
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