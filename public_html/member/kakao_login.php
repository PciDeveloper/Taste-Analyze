<?php
$restAPIKey = "940beea2b2ff7cebaad4f317b8852175"; //본인의 REST API KEY를 입력해주세요
 $callbacURI = urlencode("http://cpgjaspt.cafe24.com/member/kakao_login_callback.php"); //본인의 Call Back URL을 입력해주세요
 $kakaoLoginUrl = "https://kauth.kakao.com/oauth/authorize?client_id=".$restAPIKey."&redirect_uri=".$callbacURI."&response_type=code";
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8"/>
 </head>
<script>
Kakao.Link.createDefaultButton({
  container: '#CONTAINER_ID',
  objectType: 'feed',
  content: {
    title: '디저트 사진',
    description: '아메리카노, 빵, 케익',
    imageUrl:
      'http://mud-kage.kakao.co.kr/dn/NTmhS/btqfEUdFAUf/FjKzkZsnoeE4o19klTOVI1/openlink_640x640s.jpg',
    link: {
      mobileWebUrl: 'https://developers.kakao.com',
      androidExecParams: 'test',
    },
  },
  social: {
    likeCount: 10,
    commentCount: 20,
    sharedCount: 30,
  },
  buttons: [
    {
      title: '웹으로 이동',
      link: {
        mobileWebUrl: 'https://developers.kakao.com',
      },
    },
    {
      title: '앱으로 이동',
      link: {
        mobileWebUrl: 'https://developers.kakao.com',
      },
    },
  ],
  success: function(response) {
    console.log(response);
  },
  fail: function(error) {
    console.log(error);
  }
});
</script>
 <body>
   <div class="add1">
    <script src="//developers.kakao.com/sdk/js/kakao.min.js">
    </script>
     <a id="kakao-link-btn" href="javascript:;">
     <img src="https://happist.com/files/sns/Kakao.png" width="32" height="32" border="0"/></a>
    <script type='text/javascript'>
            Kakao.init('940beea2b2ff7cebaad4f317b8852175');
            Kakao.Link.createScrapButton({
            container: '#kakao-link-btn',
            requestUrl: document.URL
            });
    </script>
</div>
  <a href="<?= $kakaoLoginUrl ?>">
   카카오톡으로 로그인
  </a>
 </body>
</html>
<!-- <html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>:: 카카오톡 공유하기 ::</title>
<script type="text/JavaScript" src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript">
    function shareKakaotalk() {
        Kakao.init("XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");      // 사용할 앱의 JavaScript 키를 설정
        Kakao.Link.sendDefault({
              objectType:"feed"
            , content : {
                  title:"WARCRAFT3 THE REIGN OF CHAOS"   // 콘텐츠의 타이틀
                , description:"너흰아직 준비가 안되었다!"   // 콘텐츠 상세설명
                , imageUrl:"illidan_stormrage.jpg"   // 썸네일 이미지
                , link : {
                      mobileWebUrl:"http://magic.wickedmiso.com/"   // 모바일 카카오톡에서 사용하는 웹 링크 URL
                    , webUrl:"http://magic.wickedmiso.com/" // PC버전 카카오톡에서 사용하는 웹 링크 URL
                }
            }
            , social : {
                  likeCount:0       // LIKE 개수
                , commentCount:0    // 댓글 개수
                , sharedCount:0     // 공유 회수
            }
            , buttons : [
                {
                      title:"게시글 확인"    // 버튼 제목
                    , link : {
                        mobileWebUrl:"http://magic.wickedmiso.com/"   // 모바일 카카오톡에서 사용하는 웹 링크 URL
                      , webUrl:"http://magic.wickedmiso.com/" // PC버전 카카오톡에서 사용하는 웹 링크 URL
                    }
                }
            ]
        });
    }
</script>
</head>
<body>
    <h1>카카오톡 공유하기</h1>
    <input type="button" onClick="shareKakaotalk();" value="KAKOA Talk으로 공유하기"/>
</body>
</html> -->
