$(document).ready(function(){

/*스와이퍼*/
  var swiper = new Swiper('.swiper-container', {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    }
  });
});


/*스크롤탑버튼*/
  $(function(){
    $('.top_button').click(function(){
      $('html,body').animate({
          scrollTop: 0
      },200);
      return false;
  });
  });


/*회원가입팝업*/
  $(function() {
    $(".signin").click(function(){ // 회원가입버튼을 누르면
        $(".signin_wrap").show(); // 팝업창이 나타난다.
       $("html").addClass("popup_on"); //스크롤이사라진다.
    });

    $(".bt_close").click(function(){ // 닫기버튼을 누르면
        $(".signin_wrap").fadeOut(); // 팝업창이 사라진다.
        $(".signin_wrap").css("display","none");
        $("html").removeClass("popup_on"); // 스크롤이 나타난다.
    });


   $("#step2_close").click(function(){
     $(".signin_wrap").hide(); // 팝업창이 사라진다.
     $(".signin_wrap2").hide(); // 팝업창이 사라진다.
     $("html").removeClass("popup_on"); // 스크롤이 나타난다.
   });


   $("#signup").click(function(){ // 회원가입버튼을 누르면
       $(".signup_wrap").show(); // 팝업창이 나타난다.
      $("html").addClass("popup_on"); //스크롤이사라진다.
   });

   $("#login_close").click(function(){
     $(".signup_wrap").fadeOut(); // 팝업창이 사라진다.
     $(".signup_wrap").css("display","none");

     $("html").removeClass("popup_on"); // 스크롤이 나타난다.
   });

});
