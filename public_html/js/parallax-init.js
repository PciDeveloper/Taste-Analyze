// ---------iridium html5 template -----------
// ---------created for pixelglimpse----------
// -------author : gokul raghu aka AJ---------
// -----------version 1.0---------------------
// ------------created on 14-july-2014--------


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

