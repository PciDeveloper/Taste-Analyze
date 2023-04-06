// ---------xfactor html5 template -----------//
// ---------created for pixelglimpse----------//
// -------author : gokul raghu aka AJ---------//
// -----------version 1.0---------------------//
// ------------created on 25-june-2014--------//

(function(){
  "use strict";


$(function ($) {
//22439234
		if( !device.tablet() && !device.mobile() ) {

			/* plays the BG Vimeo or Youtube video if non-mobile device is detected 81676731 */ 
			$.okvideo({ source: '77650327', //set your video source here
			                    volume: 0, 
			                    loop: true,
			                    hd:true, 
			                    adproof: true,
			                    annotations: false,
		                 });
						
		} else {
			
			/* displays a poster image if mobile device is detected*/ 
			$('.intro-video-bg').addClass('poster-img');
			
		}
   		
        
   
});
// $(function ($)  : ends

})();
//  JSHint wrapper $(function ($)  : ends







	

