<?php
include $_SERVER["DOCUMENT_ROOT"].'/api/inc/_header.php';
/*
	2022-11-09
	APP으로부터 요청받은 데이터 처리( 비밀번호 변경 )
	Return  - 회원정보
          - status : 1 성공 , 2: 실패 , 3:필수정보 누락 , 4: 비밀번호 일치하지않음
	Parameter

  parameter
    useridx 회원번호
  	nowpw 현재 비밀번호 urlencoding
  	pwd   변경할 비밀번호 urlencoding


*/
// error_log("push_token ----- ".var_export($_REQUEST, true)."\n", 3, "/home/zorder/log/custom.log");

if($useridx == "" || $tel == "" || $birthday == ""){
  $data_json['status'] = (int)"4";
  $data_json['msg'] = "필수정보 누락";
  $json =  json_encode($data_json);
  echo $json;
  exit;
}


$mb = $db->_fetch("select * from sw_member where idx = '".$useridx."'");
$requestPwd = $db->_fetch("select password('".$pwd."')");

if($mb['idx']){

  if($nowpw != "" && $pwd != ""){
    $strNowpwd = urldecode($nowpw);
    $strPwd = urldecode($pwd);
    if($db->_password($strNowpwd) == $mb['pwd']){
      $usqry = "update sw_member set
               birthday	 = '".$birthday."',
               pwd  	   = '".$requestPwd[0]."',
               tel  		 = '".$tel."',
               updt 		 = now()
               where idx = '".$useridx."'";
      if($db->_execute($usqry)){
        $data_json['status']          = (int)"1";
        $data_json['msg']             = "비밀번호가 변경되었습니다.";
        $json =  json_encode($data_json);
        echo $json;
        exit;
      }else{
        $data_json['status'] = (int)"2";
        $data_json['msg'] = "비밀번호 변경에 실패하였습니다.";
        $json =  json_encode($data_json);
        echo $json;
        exit;
      }
    }else{
      $data_json['status'] = (int)"3";
      $data_json['msg'] = "이전 비밀번호가 일치하지 않습니다.";
      $json =  json_encode($data_json);
      echo $json;
      exit;
    }
  }else{
    $usqry = "update sw_member set
             birthday	 = '".$birthday."',
             tel  		 = '".$tel."',
             updt 		 = now()
             where idx = '".$useridx."'";
    if($db->_execute($usqry)){
      $data_json['status']          = (int)"1";
      $data_json['msg']             = "회원정보가 변경되었습니다.";
      $json =  json_encode($data_json);
      echo $json;
      exit;
    }else{
      $data_json['status'] = (int)"2";
      $data_json['msg'] = "회원정보 변경에 실패하였습니다.";
      $json =  json_encode($data_json);
      echo $json;
      exit;
    }
  }
}else{
  $data_json['status'] = (int)"3";
  $data_json['msg'] = "존재하지 않은 회원정보 입니다.";
  $json =  json_encode($data_json);
  echo $json;
  exit;
}
?>
