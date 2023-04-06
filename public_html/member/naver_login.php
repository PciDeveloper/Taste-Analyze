<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function generate_state() {
    $mt = microtime();
    $rand = mt_rand();
    return md5($mt . $rand);
}

// 상태 토큰으로 사용할 랜덤 문자열을 생성
$state = generate_state();
//
//
// $client_id = "0RLcKwP4lByErQOh008e";
// $client_secret = "IU5iy1Ulbu";
// $code = $_GET["code"];
// $state = $state;
// $redirectURI = urlencode("http://cpgjaspt.cafe24.com/member/naver_login.php");
// $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
// $is_post = false;
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, $is_post);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $headers = array();
// $response = curl_exec ($ch);
// $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// echo "status_code:".$status_code."
// ";
// curl_close ($ch);
// if($status_code == 200) {
//    echo $response;
//  } else {
//    echo "Error 내용:".$response;
//  }

  //naver_login.php
$client_id = "7mYQGw5I_rGkwLDuKKaa"; // 위에서 발급받은 Client ID 입력
  $redirectURI = urlencode("http://cpgjaspt.cafe24.com/member/naver_login_callback.php"); //자신의 Callback URL 입력
  $state = $state;
  $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
?>
<a href="<?php echo $apiURL ?>"><img height="50" src="http://static.nid.naver.com/oauth/small_g_in.PNG"/></a>
