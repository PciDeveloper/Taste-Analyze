<?php
include_once(dirname(__FILE__)."/../inc/_header.php");
function generate_state() {
    $mt = microtime();
    $rand = mt_rand();
    return md5($mt . $rand);
}
$state = generate_state();
//naver_login.php
$client_id = "7mYQGw5I_rGkwLDuKKaa"; // 위에서 발급받은 Client ID 입력
$redirectURI = urlencode("http://cpgjaspt.cafe24.com/member/naver_login_callback.php"); //자신의 Callback URL 입력
$state = $state;
$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;


$kakaoURL = "https://kauth.kakao.com/oauth/authorize?client_id=940beea2b2ff7cebaad4f317b8852175&redirect_uri=http://".$_SERVER['HTTP_HOST']."/member/kakao_login_callback.php&response_type=code";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>체험넷</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/sign.css">
    <link rel="stylesheet" href="/css/subpage_2.css">
	  <link rel="stylesheet" href="/css/product_detail.css">
    <link rel="stylesheet" href="/css/booking.css">
    <link rel="stylesheet" href="/css/booking_status.css">
    <link rel="stylesheet" href="/css/mypage.css">
    <link rel="stylesheet" href="/css/notice.css">
    <link rel="stylesheet" href="/css/notice_list.css">
    <link rel="stylesheet" href="/css/notice_view.css">
    <link rel="stylesheet" href="/css/password.css">
    <link rel="stylesheet" href="/css/term.css">
    <link rel="stylesheet" href="/css/ui.css">
    <link rel="stylesheet" href="/css/account_setting.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script type="text/javascript" src="/sadm/assets/js/jquery-ui-1.8.5.custom.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="/sadm/assets/css/jquery-ui-1.8.6.custom.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="/js/index.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="/js/class.common.js"></script>

    <script type="text/javascript" src="/sadm/assets/js/jquery.ui.datepicker-ko.js" charset="utf-8"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script>
    jQuery(function($) {
    	$('.date-picker').datepicker({
    		  dateFormat: 'yy-mm-dd'
    	});
    });

    function naverlogin()
    {
    	url = "<?php echo $apiURL ?>";
    	// Common.winPopup(url, 500, 500);
      location.href = url;
    }

    $(document).ready(function(){
          var currentPosition = parseInt($("#nav_wrap").css("top"));
          $(window).scroll(function() {
              var position = $(window).scrollTop(); // 현재 스크롤바의 위치값을 반환합니다.
              $("#nav_wrap").stop().animate({"top":position+currentPosition+"px"},1000);
          });
      });

      function kakaologin(){
        url = "<?php echo $kakaoURL?>";
        // Common.winPopup(url, 500, 500);
        location.href = url;
      }
      $(document).ready(function() {
       /* quick menu */
        $(window).scroll(function(){
        $("#nav_wrap").stop();
        $("#nav_wrap").animate( { "top": $(document).scrollTop() + 80 + "px" }, 1000 );
       });
      });
    </script>
</head>
<body>
<iframe name="ifrm" style="display:none;height:100px;width:100%;"></iframe>
<div id="msgwrap"></div>
<div id="msgbox"></div>
    <!--헤더-->
    <header>
        <div id="header_wrap">
            <div class="header">
                <h1 class="logo">
                    <a href="/"><img src="/img/icon/logo.png" alt="로고"></a>
                </h1>
                <div class="log_wrap">
                    <ul class="log_profile">
                        <? if(isLogin()){ ?>
                        <?php if ($_SESSION['SES_USERLV'] == "100"){?><li class="signup"><a href="http://cpgjaspt.cafe24.com/sadm" target="_blank">[관리자모드]</a></li><?php }?>
                        <?php
                          $mbinfo = getUser($_SESSION['SES_USERIDX']);
                          if($mbinfo['photo']){
                            if ($mbinfo['user_type'] == 0){
                        ?>
                        <li class="signup"><a href='/mypage/index.php'><img src='/upload/member/thum/thum_<?=$mbinfo['photo']?>'></a></li>
                        <?php
                            }else{
                        ?>
                        <li class="signup"><a href='/mypage/index.php'><img src='<?=$mbinfo['photo']?>'></a></li>
                        <?
                            }
                          }else{
                        ?>
                        <li class="signup"><a href="/mypage/index.php"><img src="/img/icon/user_2.png"></a></li>
                        <?php
                          }
                        ?>
                        <li class="signup"><a href="/mypage/index.php"><?=$mbinfo['nick']?></a></li>
                        <li class="signup"><a href="/member/login.act.php?act=logout">로그아웃</a></li>
                        <li class=""><a href="/mypage/index.php">마이페이지</a></li>
                      <?php }else{?>
                        <li class="signup" id="signup"><a href="/member/login.php">로그인</a></li>
                        <li class="signin"><a href="/member/join.php">회원가입</a></li>
                      <?php }?>
                        <li class="kakao_info"><a href="/common/contract.php">카카오톡문의</a></li>
                        <li class="booking_info"><a href="/common/booking.php">예약방법안내</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--네비게이션바-->
    <div id="nav_wrap" style="position:absolute;right:10px;">
        <div class="align">
            <div class="call_wrap">
                <img src="/img/icon/call.png" alt="문의전화">
                <span>1599-5757</span>
            </div>
            <div class="bank_wrap">
                <img src="/img/icon/bank.png" alt="계좌안내">
                <span class="bank_name"><?=$siteinfo['AccountBank']?></span>
                <p><?=$siteinfo['AccountNum']?></p>
                <span class="bank_user">예금주 : <?=$siteinfo['AccountName']?></span>
            </div>
            <div class="customer_wrap">
                <img src="/img/icon/customer.png" alt="고객상담">
                <p>고객센터</p>
                <ul>
                    <li><a href="/community/notice.php">알려드려요</a></li>
                    <li><a href="/community/faq.php">자주묻는질문</a></li>
                    <li><a href="/community/qna.php">1:1문의</a></li>
                    <li><a href="/community/event.php">이벤트</a></li>
                </ul>
            </div>
        </div>
    </div>
