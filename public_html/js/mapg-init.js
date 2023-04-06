$(function(){
      
  $("#map").gMap({
controls: {
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: false,
            streetViewControl: true,
            overviewMapControl: false
        },
    scrollwheel: false,
    maptype: 'ROADMAP',
    markers: [
        {
            latitude: 37.5497397,
            longitude: 126.9187059,
            icon: {
                image: "http://www.kakaoapps.com/images/bg/map_img.png",
                iconsize: [154, 75],
                iconanchor: [154,75]
            }            
        }
    ],    
    zoom: 17
  });
});

/*
latitude: 37.487340,
longitude: 127.012960,
*/