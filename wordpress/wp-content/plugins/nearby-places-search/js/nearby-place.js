/**
 * @file
 * Near By Place Search JavaScript file. Includes click events triggers, initialize Gmap etc.
 */

(function ($) {  
   'use strict';
      $('input.radio_btn').on('change', function () {
        if (infowindow) {
          infowindow.close();
        }
        search_types(map.getCenter());
      });

      $('#cust_btn').click(function () {
        showMap();
      });

      $('#nearby-places-search-search-form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
          e.preventDefault();
          return false;
        }
      });

      var default_latitude = object_name.latitude;
      var default_longitude = object_name.longitude;
      var default_radius = object_name.radius;
      var map;
      var markersArray = [];
      var search_lat = $('#latitude').val();
      var search_long = $('#longitude').val();
      var pyrmont = new google.maps.LatLng(default_latitude, default_longitude);
      if (search_lat !== '' && search_long !== '') {
        pyrmont = new google.maps.LatLng(search_lat, search_long);
      }

      function fileExists(fileLocation) {
        var response = $.ajax({
          url: fileLocation,
          type: 'HEAD',
          async: false
        }).status;
        return response;
      }

      var marker;
      var geocoder = new google.maps.Geocoder();
      var infowindow = new google.maps.InfoWindow();
      function initialize() {
		 
        map = new google.maps.Map(document.getElementById('map-container'), {
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          center: pyrmont,
          zoom: 14
        });
        infowindow = new google.maps.InfoWindow();
        showMap();
      }

      function createMarker(place, icon) {
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location,
          icon: icon,
          visible: true
        });

        markersArray.push(marker);
        google.maps.event.addListener(marker, 'click', function () {
          infowindow.setContent('<b>'+object_name.name+':&nbsp;</b>' + place.name + '<br><b>'+object_name.address+':&nbsp;</b>' + place.vicinity);
          infowindow.open(map, this);
        });
      }

      function search_types(latLng) {
        clearOverlays();
        if (!latLng) {
          latLng = pyrmont;
        }
        var type = $('.radio_btn:checked').val();
        var imgPath = object_name.urllink;
        var icon = imgPath + '/' + type + '.png';

        if (typeof type !== 'undefined') {
          var file_exists_chk = fileExists(imgPath + '/' + type + '.png');
          if (file_exists_chk === 404) {
            icon = imgPath + '/default.png';
          }
        }

        var request = {
          location: latLng,
          radius: default_radius,
          types: [type]
        };

        var service = new google.maps.places.PlacesService(map);
        service.search(request, function (results, status) {
          map.setZoom(14);
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
              results[i].html_attributions = '';
              createMarker(results[i], icon);
            }
          }
          else if (status === google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
            alert(object_name.no_record_text);
            return false;
          }
        });
      }

      // Deletes all markers in the array by removing references to them.
      function clearOverlays() {
        var i = 0;
        for (i in markersArray) {
          if (markersArray.hasOwnProperty(i)) {
            markersArray[i].setVisible(false);
          }
        }
      }
      google.maps.event.addDomListener(window, 'load', initialize);

      function showDragMarker(results, lat, lng) {
        if (results) {
          $('#edit-address').val(results.formatted_address);
          $('#latitude').val(lat);
          $('#longitude').val(lng);
        }
      }

      function showMap() {
        var input_addr = $('#edit-address').val();
		
        geocoder.geocode({address: input_addr}, function (results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            var latlng = new google.maps.LatLng(latitude, longitude);
            if (results[0]) {
              map.setZoom(14);
              map.setCenter(latlng);
              marker = new google.maps.Marker({
                position: latlng,
                map: map,
                draggable: true
              });
              $('#edit-address').val(results[0].formatted_address);
              $('#latitude').val(marker.getPosition().lat());
              $('#longitude').val(marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
              search_types(marker.getPosition());
              google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, marker);
              });

              google.maps.event.addListener(marker, 'dragend', function () {
                var obj = {latLng: marker.getPosition()};
                geocoder.geocode(obj, function (results, status) {
                  if (status === google.maps.GeocoderStatus.OK) {
                    showDragMarker(results[0], marker.getPosition().lat(), marker.getPosition().lng());
                    infowindow.setContent(results[0].formatted_address);
                    var centralLatLng = marker.getPosition();
                    search_types(centralLatLng);
                    infowindow.open(map, marker);
                  }
                });
              });
            }
            else {
              alert(object_name.sorry_text);
            }
          }
          else {
            alert(object_name.failed_text +': '+status);
          }
        });
      }
    
 
})(jQuery);
