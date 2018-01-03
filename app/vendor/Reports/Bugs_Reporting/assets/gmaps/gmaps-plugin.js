/**
* Theme: Velonic Admin Template
* Author: Coderthemes
* Google Maps
*/

!function($) {
    "use strict";

    var GoogleMap = function() {};

    //creates basic map
    GoogleMap.prototype.createBasic = function($container) {
        return new GMaps({
          div: $container,
          lat: -12.043333,
          lng: -77.028333
        });
    },
    //creates map with markers
    GoogleMap.prototype.createMarkers = function($container) {
        var map = new GMaps({
          div: $container,
          lat: -12.043333,
          lng: -77.028333
        });

        //sample markers, but you can pass actual marker data as function parameter
        map.addMarker({
          lat: -12.043333,
          lng: -77.03,
          title: 'Lima',
          details: {
            database_id: 42,
            author: 'HPNeo'
          },
          click: function(e){
            if(console.log)
              console.log(e);
            alert('You clicked in this marker');
          }
        });
        map.addMarker({
          lat: -12.042,
          lng: -77.028333,
          title: 'Marker with InfoWindow',
          infoWindow: {
            content: '<p>HTML Content</p>'
          }
        });

        return map;
    },
    //creates map with polygone
    GoogleMap.prototype.createWithPolygon = function ($container, $path) {
      var map = new GMaps({
        div: $container,
        lat: -12.043333,
        lng: -77.028333
      });

      var polygon = map.drawPolygon({
        paths: $path,
        strokeColor: '#BBD8E9',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#BBD8E9',
        fillOpacity: 0.6
      });

      return map;
    },

    //creates map with overlay
    GoogleMap.prototype.createWithOverlay = function ($container) {
      var map = new GMaps({
        div: $container,
        lat: -12.043333,
        lng: -77.028333
      });
      map.drawOverlay({
        lat: map.getCenter().lat(),
        lng: map.getCenter().lng(),
        content: '<div class="gmaps-overlay">Our Office!<div class="gmaps-overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center'
      });

      return map;
    },

    //creates map with street view
    GoogleMap.prototype.createWithStreetview = function ($container, $lat, $lng) {
      return GMaps.createPanorama({
        el: $container,
        lat : $lat,
        lng : $lng
      });
    },
    //Routes
    GoogleMap.prototype.createWithRoutes = function ($container, $lat, $lng) {
      var map = new GMaps({
        div: $container,
        lat: $lat,
        lng: $lng
      });
      $('#start_travel').click(function(e){
        e.preventDefault();
        map.travelRoute({
          origin: [-12.044012922866312, -77.02470665341184],
          destination: [-12.090814532191756, -77.02271108990476],
          travelMode: 'driving',
          step: function(e){
            $('#instructions').append('<li>'+e.instructions+'</li>');
            $('#instructions li:eq('+e.step_number+')').delay(450*e.step_number).fadeIn(200, function(){
              map.setCenter(e.end_location.lat(), e.end_location.lng());
              map.drawPolyline({
                path: e.path,
                strokeColor: '#131540',
                strokeOpacity: 0.6,
                strokeWeight: 6
              });
            });
          }
        });
      });
      return map;
    },
    //Type
    GoogleMap.prototype.createMapByType = function ($container, $lat, $lng) {
      var map = new GMaps({
        div: $container,
        lat: $lat,
        lng: $lng,
        mapTypeControlOptions: {
          mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm", "cloudmade"]
        }
      });
      map.addMapType("osm", {
        getTileUrl: function(coord, zoom) {
          return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
        },
        tileSize: new google.maps.Size(256, 256),
        name: "OpenStreetMap",
        maxZoom: 18
      });
      map.addMapType("cloudmade", {
        getTileUrl: function(coord, zoom) {
          return "http://b.tile.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/1/256/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
        },
        tileSize: new google.maps.Size(256, 256),
        name: "CloudMade",
        maxZoom: 18
      });
      map.setMapTypeId("osm");
      return map;
    },
    GoogleMap.prototype.createWithMenu = function ($container, $lat, $lng) {
      var map = new GMaps({
        div: $container,
        lat: $lat,
        lng: $lng
      });
      map.setContextMenu({
        control: 'map',
        options: [{
          title: 'Add marker',
          name: 'add_marker',
          action: function(e){
            this.addMarker({
              lat: e.latLng.lat(),
              lng: e.latLng.lng(),
              title: 'New marker'
            });
            this.hideContextMenu();
          }
        }, {
          title: 'Center here',
          name: 'center_here',
          action: function(e){
            this.setCenter(e.latLng.lat(), e.latLng.lng());
          }
        }]
      });
    },
    //init
    GoogleMap.prototype.init = function() {
      var $this = this;
      $(document).ready(function(){
        //creating basic map
        $this.createBasic('#gmaps-basic'),
        //with sample markers
        $this.createMarkers('#gmaps-markers');

        //polygon
        var path = [[-12.040397656836609,-77.03373871559225],
                  [-12.040248585302038,-77.03993927003302],
                  [-12.050047116528843,-77.02448169303511],
                  [-12.044804866577001,-77.02154422636042]];
        $this.createWithPolygon('#gmaps-polygons', path);

        //overlay
        $this.createWithOverlay('#gmaps-overlay');

        //street view
        $this.createWithStreetview('#panorama',  42.3455, -71.0983);

        //routes
        $this.createWithRoutes('#gmaps-route',-12.043333, -77.028333);

        //types
        $this.createMapByType('#gmaps-types', -12.043333, -77.028333);

        //statu
        $this.createWithMenu('#gmaps-menu', -12.043333, -77.028333);
      });
    },
    //init
    $.GoogleMap = new GoogleMap, $.GoogleMap.Constructor = GoogleMap
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.GoogleMap.init()
}(window.jQuery);