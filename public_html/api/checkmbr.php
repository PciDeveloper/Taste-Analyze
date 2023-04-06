<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';
// require_once(dirname(__FILE__)."/public_html/lib/func.util.php");
/*
APP으로부터 요청받은 데이터 처리( 사용자 로그인 )
Return  - 회원정보
        - status : 1:성공, 2:회원정보존재하지않음, 3:필수정보 누락, 4:비밀번호 일치하지않음
Parameter
userid
pass
push_token
osvs os 버전
appvs 앱 버전
md   모델명

*/
// error_log("push_token ----- ".var_export($_REQUEST, true)."\n", 3, "/home/zorder/log/custom.log");

//|| $push_token == "" || $osvs == "" || $appvs == ""
if($userid == "" || $pwd == "" || $push_token == "" || $os == "" || $osver == "" || $appver == "" || $model == ""){
  $data_json['status'] = (int)"3";
  $data_json['msg'] = "필수정보 누락";
  $json =  json_encode($data_json);
  echo $json;
  exit;
}

$strUserid = urldecode($userid);
$strPwd = urldecode($pwd);

if($userid) {
  $sqry = sprintf("select * from sw_member where userid=TRIM('%s')", $strUserid);

  $row = $db->_fetch($sqry, 1);
  if($row['pwd'])
  {
    if($db->_password($strPwd) == $row['pwd'])
    {
      $db->_execute("update sw_member set push_token = '".$push_token."' , os = '".$os."' , osver = '".$osvs."' , appver = '".$appvs."' , model = '".$md."',  vcnt=vcnt+1, logdt=now() where idx='".$row['idx']."'");

      $data_json['status']          = (int)"1";
      $data_json['msg']             = "성공";
      $data_json['useridx']		    	=	(int)$row['idx'];
      $data_json['birthday']		    =	($row['birthday'] ? $row['birthday'] : "");
      $data_json['userid']		    	=	$row['userid'];
      $data_json['userlv']		      =	($row['userlv'] ? (int)$row['userlv'] : 10);
      $data_json['tel']		     	    =	($row['tel'] ? $row['tel'] : "");
      $json =  json_encode($data_json);
      echo $json;
      exit;
    }else{
      $data_json['status'] = (int)"4";
      $data_json['msg'] = "비밀번호가 일치하지 않습니다.";
      $json =  json_encode($data_json);
      echo $json;
      exit;
    }
  }else{
    $data_json['status'] = (int)"2";
    $data_json['msg'] = "회원정보가 존재하지 않습니다.";
    $json =  json_encode($data_json);
    echo $json;
    exit;
  }

}else{
  $data_json['status'] = (int)"3";
  $data_json['msg'] = "필수정보 누락";
  $json =  json_encode($data_json);
  echo $json;
  exit;
}



?>
