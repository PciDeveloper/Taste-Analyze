// SLIDINGmobmenu.JS
//--------------------------------------------------------------------------------------------------------------------------------
//JS for operating the sliding mobmenu*/
// -------------------------------------------------------------------------------------------------------------------------------
// Author: Designova.
// Website: http://www.designova.net 
// Copyright: (C) 2013 
// -------------------------------------------------------------------------------------------------------------------------------

/*global $:false */
/*global window: false */

(function(){
  "use strict";

$(function ($) {

// mobmenu Action
$('#sm-trigger, .mobmenu-close,.mtc').on('click', function(){
    $('#sm-trigger').toggleClass('active');
    $('#mastwrap').toggleClass('sliding-toright');
    $('#sm').toggleClass('mobmenu-open');
    $('#mastwrap').addClass('nav-opened');
});
$('#mastwrap').on('click', function(){
    $('#mastwrap').removeClass('sliding-toright');
    $('#sm').removeClass('mobmenu-open');
});

});
// $(function ($)  : ends

})();
//  JSHint wrapper $(function ($)  : ends

