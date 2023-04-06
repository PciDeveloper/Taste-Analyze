jQuery(document).ready(function($) {
(function(){
  "use strict";

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

})();

});
