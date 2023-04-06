// BGVIDEO-INIT.JS
//--------------------------------------------------------------------------------------------------------------------------------
//This is  JS file that activates element animation effects used in this template*/
// -------------------------------------------------------------------------------------------------------------------------------
// Template Name: hymaze.
// Author: Pixelglimse.
// Website: http://www.pixelglimpse.com
// Copyright: (C) 2014
// -------------------------------------------------------------------------------------------------------------------------------

/*global $:false */
/*global window: false */

(function(){
  "use strict";


$(function ($) {

   		if( !device.tablet() && !device.mobile() ) {

			/* plays the BG video if non-mobile device is detected*/ 
			$(window).load(function() {
				$(".bgplayer").mb_YTPlayer();

				$(".player").mb_YTPlayer();
			});
			
			$('.video-overlay button.play-button').click(function() {
				$(this).css('display','none');
				$('.video-overlay button.pause-button').css({
					'display':'inline-block',
					'text-align':'center'
				});
				$('.video-overlay-text span').css('opacity',0);
				$('.video-overlay').css('background-color','rgba(0,0,0,0)');
			});
			$('.video-overlay button.pause-button').click(function() {
				$(this).css('display','none');
				$('.video-overlay button.play-button').css({
					'display':'inline-block',
					'text-align':'center'
				});
				$('.video-overlay-text span').css('opacity',1);
				$('.video-overlay').css('background-color','rgba(255,255,255,0.8)');
			});
						
		} else {
			
			/* displays a poster image if mobile device is detected*/ 
			$('.player,.bgplayer').addClass('hide');
			$('.video-section, .video-home-section').addClass('video-poster-image');
			
		}

   
});
// $(function ($)  : ends

})();
//  JSHint wrapper $(function ($)  : ends







	

