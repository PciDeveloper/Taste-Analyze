<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';

/*
	APP으로부터 요청받은 데이터 처리(회원 가입)
	status  1:성공 , 2:실패, 3:이미등록된회원, 4:비밀번호가일치하지않음 5:필수정보누락
	Return  - 회원정보
	Parameter
	userid		회원아이디 urlencoding
	pwd  비밀번호
  tel		전화번호 (ex : 010-1111-2222)
	birth			생년월일 (ex : 1995-01-01)
*/

if($userid == "" || $pwd == "" || $tel == "" || $birthday == ""){
	$data_json['status'] = (int)"5";
	$data_json['msg'] = "필수정보 누락.";
	$json =  json_encode($data_json);
	echo $json;
	exit;
}

 $strUserid = urldecode($userid);
 $strPass = urldecode($pwd);

// $chkmb = $db->_fetch("select * from sw_member where userid=TRIM('%s')", $strUserid);
$chkmb = $db->_fetch("select * from sw_member where userid='".trim($userid)."'");

if($chkmb['idx'])
{
	$data_json['status'] = (int)"3";
	$data_json['msg'] = "이미 등록된 회원입니다.";
	$json =  json_encode($data_json);
	echo $json;
	exit;
}
else
{
  $isqry = "insert into sw_member set
								birthday    = '".$birthday."',
								userid   = '".$strUserid."',
                userlv    = '10',
  							pwd	  	 = '".$db->_password($strPass)."',
  							tel	  	 = '".$tel."',
  							regdt		 = now()";
	if($db->_execute($isqry))
	{
		$data_json['status'] = (int)"1";
		$data_json['msg'] = "성공";
    $json =  json_encode($data_json);
    echo $json;
    exit;
	}
	else
	{
		$data_json['status'] = (int)"2";
		$data_json['msg'] = "실패";
    $json =  json_encode($data_json);
    echo $json;
    exit;
	}

}

?>
