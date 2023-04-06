<?php
include_once(dirname(__FILE__)."/../inc/_header.php");
//header('Content-Type: application/json; charset=utf-8');

  $returnCode = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다.
  $restAPIKey = "940beea2b2ff7cebaad4f317b8852175"; // 본인의 REST API KEY를 입력해주세요
  $callbacURI = urlencode("http://".$_SERVER['HTTP_HOST']."/member/kakao_login_callback.php"); // 본인의 Call Back URL을 입력해주세요
  // API 요청 URL
  $returnUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&code=".$returnCode;

  $isPost = true;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $returnUrl);
  curl_setopt($ch, CURLOPT_POST, $isPost);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $headers = array();
  $loginResponse = curl_exec ($ch);
  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close ($ch);

  $accessToken= json_decode($loginResponse)->access_token; //Access Token만 따로 뺌

if (!$accessToken) {
    ReloadParent("OP","아이디 정보가 없습니다. 재시도 해주세요.", "/index.php");
    exit();
}else{
  $api_url = 'https://kapi.kakao.com/v2/user/me';
 $access_token = $accessToken;

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $api_url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_POST, true);
 //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token , 'Accept: application/json', 'Content-Type: application/json'));

 $response = curl_exec($ch);

 $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 curl_close($ch);

 if (!$response) {
   ReloadParent("OP","아이디 정보가 없습니다. 재시도 해주세요.", "/index.php");
   exit;
 }
 //print_r($response);
 //$test= json_decode($response)->id;
 $user_info_json = json_decode($response, true);
 $_SESSION['$user_info_json'] = $user_info_json;

  $row = $db->_fetch("select * from sw_member where user_type = 1 and kakaoid ='".$user_info_json['id']."' and status = 1");

  if ($row['idx'] > 0 ){
    $_SESSION['SES_FACEBOOK'] = false;
    $_SESSION['SES_USERID'] = $row['userid'];
    $_SESSION['SES_USERIDX'] = $row['idx'];
    $_SESSION['SES_USEREM'] = $row['email'];
    $_SESSION['SES_USERNM'] = $row['name'];
    $_SESSION['SES_USERLV'] = $row['userlv'];


    $db->_execute("update ".SW_MEMBER." set logdt=now(), vcnt=vcnt+1 where idx='".$row['idx']."'");
    $rurl = ($referer) ? $referer : "/index.php";
    unset($_SESSION['SES_GUEST']);
    goUrl($rurl);
  }else{
    $chk_id = sprintf("select * from sw_member where kakaoid=TRIM('%s') and user_type = 1 and status = 1", $user_info_json['id']);
    if($db->isRecodeExists($chk_id))
      msg("이미등록된 아이디 입니다.",-1,true);

    $mailing = ($info_agree) ? $info_agree : "Y";
    $bsms = ($info_agree) ? $info_agree : "Y";

    $isqry = "insert into ".SW_MEMBER." set
          name = '".$user_info_json['properties']['nickname']."',
          nick = '".$user_info_json['properties']['nickname']."',
          userid = '$userid',
          kakaoid = '".$user_info_json['id']."',
          photo = '".$user_info_json['properties']['profile_image']."',
          user_type = '1',
          userlv = '20',
          email = '".$user_info_json['kakao_account']['email']."',
          hp = '$hp',
          ip = '".$_SERVER['REMOTE_ADDR']."',
          vcnt = 0,
          status = 1,
          mailing='".$mailing."',
          bsms='".$bsms."',
          regdt = now()
        ";
    if($db->_execute($isqry))
    {
      $bidx = $db->getLastID();
      $row = $db->_fetch("select * from sw_member where idx='".$bidx."'");
      $_SESSION['SES_KAKAO'] = true;
      $_SESSION['SES_USERID'] = $row['kakaoid'];
      $_SESSION['SES_USERIDX'] = $row['idx'];
      $_SESSION['SES_USEREM'] = $row['email'];
      $_SESSION['SES_USERNM'] = $row['nick'];
      $_SESSION['SES_USERLV'] =  20;
      ParentReload('O');
      msgGoUrl("회원가입을 축하드립니다.", "/index.php");
    }

  }

}

?>
