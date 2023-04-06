
/*global $:false */
/*global window: false */

(function(){
  "use strict";
/*-----------------------------------------------------
Parallax
-------------------------------------------------------*/
$(window).bind('load', function () {

if( !device.tablet() && !device.mobile() ) {

            /* if non-mobile device is detected*/ 
              // Parallax Init
              $('.parallax').each(function() {
                    $(this).parallax('60%', 0.5, true);
                });
                        
        } else {
            
            /* if mobile device is detected*/ 
            $('.devider-section').addClass('parallax-off');
        }
});
/*-----------------------------------------------------
Skill Graph
-------------------------------------------------------*/

$('.block_skills').appear(function() {
         $(".theskill").each(function() 
          {
              var skillId  = $(this).attr('id');
              var color    = $(this).attr("data-color");
              if(skillId !='')
              {
                  $('#' + skillId).easyPieChart({
                      barColor: color ,
                      trackColor: 'rgba(255,255,255,0.0)',
                      scaleColor: false,
                      lineCap: 'butt',
                      lineWidth: 5,
                      size: 160,
                      animate: 2000,
                  });
              }

          });

}, { offset: 100 });
/*-----------------------------------------------------
animation
-------------------------------------------------------*/

$(function ($) {

    //ANIMATED ELEMENTS TRIGGERING
$('.animated').appear(function() {
 $(this).each(function(){ 
    $(this).css('visibility','visible');
    $(this).addClass($(this).data('fx'));
   });
},{accY: -200});

if(device.mobile()) 
    {
       $('.animated').each(function(){ 
          $(this).removeClass('animated');
       });
    } 
}); 
/*-----------------------------------------------------
Viewport Adjuter
-------------------------------------------------------*/
$(function ($) {

    var viewportHeight = $(window).height();
    //$('.splash-section, .autoheight').css('height',viewportHeight);
    $('.splash-section, .autoheight').css('height',viewportHeight/1.05);
    $('.autoheight-normal').css('height',viewportHeight/1);

              var parent_height = $('.splash-section').height();
              var image_height = $('.vertical-center').height();
              var top_margin = (parent_height)/4.0;
              // normal row
              var parent_height_normal = $('.autoheight-normal').height();
              var image_height_normal = $('.vertical-center-normal').height();
              var top_margin_normal = (parent_height_normal)/3.0;
             
              //center it
              $('.vertical-center').css( 'padding-top' , top_margin);
              //uncomment the following if ithe element to be centered is an image
              $('.vertical-center-img').css( 'margin-top' , top_margin);
              //center it normal
              $('.vertical-center-normal').css( 'padding-top' , top_margin_normal);
              //uncomment the following if ithe element to be centered is an image
              $('.vertical-center-img-normal').css( 'margin-top' , top_margin_normal);
});
      //$('#navigation_center').waypoint('sticky');
// ------------------------------------------------------------------*/
/*-----------------------------------------------------
/*---------------------------------------------------
pace options
-----------------------------------------------------*/

// paceOptions = {
//   ajax: false, // disabled
//   document: false, // disabled
// };

/*-----------------------------------------------------
Sticky Nav
-------------------------------------------------------*/
      // $('.main_navigation').waypoint('sticky');
     $(window).scroll(function () {
         if ($("#navigation").offset().top > 50) {
             $("#navigation").addClass("stuck");
         } else {
             $("#navigation").removeClass("stuck");
         }
     });
/*-----------------------------------------------------
Owl Carousel
------------------------------------------------------*/
$(document).ready(function() {
//Homepage Owl
        $(".owl_head").owlCarousel({
          autoPlay:14000, //Set AutoPlay to 5 seconds
          autoHeight : false,
          singleItem:true,
          navigation: false,
          pagination: false,
        });

      var owl = $(".owl_head");
         // Custom Navigation Events
         $(".next").click(function(){
         owl.trigger('owl.next');
          })
         $(".prev").click(function(){
          owl.trigger('owl.prev');
          })
    // owl team
          $(".owl_team").owlCarousel({
          autoPlay:5000, //Set AutoPlay to 5 seconds
          autoHeight : true,
          singleItem:false,
          navigation: false,
          pagination: false,
          items:4,
          itemsDesktop : [1199,4],
      itemsDesktopSmall : [979,4],
        });
//client Owl
        $(".owl_client_slider").owlCarousel({
          autoPlay:12000, //Set AutoPlay to 5 seconds
          autoHeight : true,
          singleItem:false,
          navigation: false,
          pagination: true,
          items : 4,
      itemsDesktop : [1199,4],
      itemsDesktopSmall : [979,4]
        });
//Testimonial Owl     
        $(".testimonials_owl").owlCarousel({
          autoPlay:10000, //Set AutoPlay to 5 seconds
          autoHeight : true,
          slideSpeed:400,
          singleItem:true,
          navigation: false,
          pagination: false,
          navigationText: ["",""]
        }); 
});  

/*-----------------------------------------------------
morphtext
------------------------------------------------------*/
 $("#js-rotating").Morphext({
    // The [in] animation type. Refer to Animate.css for a list of available animations.
    animation: "fadeInUp",
    // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
    separator: ",",
    // The delay between the changing of each phrase in milliseconds.
    speed: 5000
});

})();
//  JSHint wrapper $(function ($)  : ends
