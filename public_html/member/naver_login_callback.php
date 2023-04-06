<?php
 //naver_login_callback.php
 include_once(dirname(__FILE__)."/../inc/_header.php");

 // NAVER LOGIN
 define('NAVER_CLIENT_ID', '7mYQGw5I_rGkwLDuKKaa');
 define('NAVER_CLIENT_SECRET', 'qXPotrN0j1');
 define('NAVER_CALLBACK_URL', "http://".$_SERVER['HTTP_HOST']."/member/naver_login_callback.php");

 // if ($_SESSION['naver_state'] != $_REQUEST['state']) {
 //    // 오류가 발생하였습니다. 잘못된 경로로 접근 하신것 같습니다.
 //    msg("오류가 발생하였습니다.\\n잘못된 경로로 접근 하신것 같습니다.", "C");
 //  }
  $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&code=".$_GET['code']."&state=".$_REQUEST['state'];
  // 토큰값 가져오기
  $is_post = false;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $naver_curl);
  curl_setopt($ch, CURLOPT_POST, $is_post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec ($ch);
  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close ($ch); if($status_code == 200) {
  $responseArr = json_decode($response, true);
  $_SESSION['naver_access_token'] = $responseArr['access_token'];
  $_SESSION['naver_refresh_token'] = $responseArr['refresh_token'];
  // 토큰값으로 네이버 회원정보 가져오기
  $me_headers = array( 'Content-Type: application/json', sprintf('Authorization: Bearer %s', $responseArr['access_token']) );
  $me_is_post = false;
  $me_ch = curl_init();
  curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
  curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
  curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
  curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
  $me_response = curl_exec ($me_ch);
  $me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
  curl_close ($me_ch);
  $me_responseArr = json_decode($me_response, true);


  if ($me_responseArr['response']['id']) {
  // 회원아이디(naver_ 접두사에 네이버 아이디를 붙여줌)
  $mb_uid = 'naver_'.$me_responseArr['response']['id'];
  // 회원가입 DB에서 회원이 있으면(이미 가입되어 있다면) 토큰을 업데이트 하고 로그인함
  $row = $db->_fetch("select * from sw_member where user_type = 2 and naverid ='".$mb_uid."' and status = 1");

  if ($row['idx'] > 0 ) {
    // 멤버 DB에 토큰값 업데이트
    $usqry = "update sw_member set access_token ='".$responseArr['access_token']."' where idx='".$row['idx']."'";
    if($db->_execute($usqry)){
      $_SESSION['SES_NAVER'] = true;
      $_SESSION['SES_USERID'] = $row['naverid'];
      $_SESSION['SES_USERIDX'] = $row['idx'];
      $_SESSION['SES_USEREM'] = $row['email'];
      $_SESSION['SES_USERNM'] = $row['nick'];
      $_SESSION['SES_USERLV'] =  20;


      $db->_execute("update ".SW_MEMBER." set logdt=now(), vcnt=vcnt+1 where idx='".$row['idx']."'");
      $rurl = ($referer) ? $referer : "/index.php";
      unset($_SESSION['SES_GUEST']);
      goUrl($rurl);
    }else{
      msg("오류가 발생하였습니다.\\n확인 후 다시 로그인 해주세요.", "C");
    }
  } // 회원정보가 없다면 회원가입
  else {

  $mb_name = $me_responseArr['response']['name'];
  $mb_nickname = $me_responseArr['response']['nickname'];
  // 닉네임
  $mb_email = $me_responseArr['response']['email'];
  // 이메일
  $mb_profile_image = $me_responseArr['response']['profile_image'];
      // 프로필 이미지
      // 멤버 DB에 토큰과 회원정보를 넣고 로그인
      $chk_id = sprintf("select * from sw_member where naverid=TRIM('%s') and user_type = 2 and status = 1", $mb_uid);
      if($db->isRecodeExists($chk_id))
        msg("이미등록된 아이디 입니다.",-1,true);

      $mailing = ($info_agree) ? $info_agree : "Y";
      $bsms = ($info_agree) ? $info_agree : "Y";

      $isqry = "insert into ".SW_MEMBER." set
            name = '".$mb_name."',
            nick = '".($mb_nickname !="" ? $mb_nickname : $mb_name)."',
            userid = '$userid',
            naverid = '".$mb_uid."',
            user_type = '2',
            userlv = '20',
            email = '".$mb_email."',
            photo = '".$mb_profile_image."',
            access_token = '".$responseArr['access_token']."',
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
        $_SESSION['SES_USERID'] = $row['userid'];
        $_SESSION['SES_USERIDX'] = $row['idx'];
        $_SESSION['SES_USEREM'] = $row['email'];
        $_SESSION['SES_USERNM'] = $row['nick'];
        $_SESSION['SES_USERLV'] =  20;
        //msg("회원가입을 축하드립니다.", "C");
        goUrl("/index.php", "", "OC", true);
      }
    }
  } else {
     // 회원정보를 가져오지 못했습니다.
     msg("회원정보를 가져오지 못했습니다.\\n확인 후 다시 로그인 해주세요.", "C");
   }
  } else {
    // 토큰값을 가져오지 못했습니다.
    msg("토큰값을 가져오지 못했습니다.\\n확인 후 다시 로그인 해주세요.", "C");
}

?>
