(function(){
  "use strict";
//VIEWPORT DETECTION:


 $(document).ready(function() {

/*-----------------------------------------------------
Shuffle Grid
-------------------------------------------------------*/
			/* initialize shuffle plugin */
			var $grid = $('#grid');
			$grid.shuffle({
				itemSelector: '.shuf-item' // the selector for the items in the grid
			});

			/* reshuffle when user clicks a filter item */
			$('#filter li a').click(function (e) {
				e.preventDefault();
				// set active class
				$('#filter li a').removeClass('active');
				$(this).addClass('active');
				// get group name from clicked item
				var groupName = $(this).attr('data-group');
				// reshuffle grid
				$grid.shuffle('shuffle', groupName );
			});


/*-----------------------------------------------------
Portfolio Triggers
-------------------------------------------------------*/
 //$(".video-frame").fitVids();
 $('.ajax_area_trigger').slideUp(); 

    $(".proj_ajax").click(function(){
      $('.ajax_area_trigger').slideDown(1000);
     $.ajax({
      url: $(this).attr("href"),
      success: function(response) 
      {
          
          $('.ajax_area_trigger').addClass('ajax_area'); 
           //Dropping Content
           var result = $(response).filter('#ajax-era');
           $(".ajax_drop").html(result);   

           //$(response).filter(".video-frame").fitVids();

           /*--------------*/
           $("html, body").animate({
                scrollTop: $('.ajax_area_trigger').offset().top-24 + "px"
            },{
                duration: 500,
                easing: "swing"
            }); 
       //Triggering Slider
        $(".portslider").owlCarousel({
          autoPlay:12000, //Set AutoPlay to 5 seconds
          autoHeight : true,
          slideSpeed:400,
          singleItem:true,
          navigation: false,
          pagination: true,
        });

      }
     });
     return false;
    });

/*Closing the Ajax Grid*/

$(".ajax_close").click(function(){

     $('.ajax_area_trigger').slideUp();
     $('.ajax_area_trigger').removeClass('ajax_area'); 
     return false;
});










	});




})();