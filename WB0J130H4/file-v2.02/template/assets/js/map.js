var $ = jQuery.noConflict();

//
// map config
// --------------------------------------------------
//

var _map_api_key =                                'abcde12345abcde12345'; // google map api key, more info - https://developers.google.com/maps/faq

var _map_latitude_longitude =                     [40.6700, -73.9400]; // google map location

//
// map script
// --------------------------------------------------
//

function initMap() {
  var $map = $('.map');

  $map.each(function() {
    var $this = $(this);

    if ($this.is(':visible')) {
      var mapCanvas = document.getElementById($this.attr('id'));
      var myLatlng = new google.maps.LatLng(_map_latitude_longitude[0], _map_latitude_longitude[1]); // map location
      var mapOptions = {
        center: myLatlng,
        disableDefaultUI: true,
        scrollwheel: false,
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        streetViewControl: false,
        zoomControl: true,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.SMALL,
          position: google.maps.ControlPosition.RIGHT_TOP
        },
        // style start
        styles: [
          {"featureType":"all","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#aadd55"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#0099dd"}]}
        ]
        // style end
      };

      var map = new google.maps.Map(mapCanvas, mapOptions);

      var image = 'assets/img/map-marker.png';
      var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: image
      });

      google.maps.event.addDomListener(window, 'resize', function() {
        var center = map.getCenter();

        google.maps.event.trigger(map, 'resize');
        map.setCenter(center);
      });
    }
  });
}

function loadScript() {
  if ($('.map').is(':visible')) {
    var script = document.createElement('script');

    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + _map_api_key + '&callback=initMap';
    document.body.appendChild(script);
  }
}

$(window).on('load', function() {
  loadScript();  
});
