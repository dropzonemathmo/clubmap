<!DOCTYPE html>
<html>
  <head>
    <title>Hawt</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
     
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    
    <?php
    	$urlofaddress = urlencode("data.json");
        $resp_add_json = file_get_contents($urlofaddress);    
        $resp_add =  json_decode($resp_add_json, true);
        $length = count($resp_add["result"]);
    ?>
    
    <?php
        function latlgn($index,&$resp_add) {
            
            $lati = $resp_add['result'][$index]['lat'];
            $longi = $resp_add['result'][$index]['lng'];
            echo "{$lati},{$longi},";  
        } 
        
        function rating($index,&$resp_add) {
            $length = count($resp_add["result"]);
            $rating = $resp_add['result'][$index]['rating'];
            echo "{$rating},";              
        } 
        
        function names($index,&$resp_add) {
            $length = count($resp_add["result"]);
            
            $nameofpub = $resp_add['result'][$index]['name'];  
            echo "\"{$nameofpub}\",";  
        } 

        function noratings($index,&$resp_add) {
            $noratings = $resp_add['result'][$x]['user_ratings_total'];  
            echo "\"{$noratings}\",";  
        } 
		
		function openingTimes($index,&$resp_add){
            $openingTimes = $resp_add['result'][$x][''];
		
		}
		
    ?>

    <script>
        // In the following example, markers appear when the user clicks on the map.
        // The markers are stored in an array.
        // The user can then click an option to hide, show or delete the markers.
        var map;
        var markers = [];
        var MY_MAPTYPE_ID = 'custom_style';

        function initialize() {
            
            var styleArray = [
              {
                featureType: "all",
                stylers: [
                  { saturation: -80 }
                ]
              },{
                featureType: "road.arterial",
                elementType: "geometry",
                stylers: [
                  { hue: "#00ffee" },
                  { saturation: 50 }
                ]
              },{
                featureType: "poi.business",
                elementType: "labels",
                stylers: [
                  { visibility: "off" }
                ]
              }
            ];
        
        
            var london = new google.maps.LatLng(51.5101,-0.1340);
            var mapOptions = {
                zoom: 14,
                center: london,
                mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
                },
                mapTypeId: MY_MAPTYPE_ID
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

            var styledMapOptions = {
                name: 'Custom Style'
            };
            
            var customMapType = new google.maps.StyledMapType(styleArray, styledMapOptions);

            map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
            
            var remove_poi = [
                {
                  "featureType": "poi",
                  "elementType": "labels",
                  "stylers": [
                    { "visibility": "off" }
                  ]
                }
              ];

            map.setOptions({styles: remove_poi});

            var latlgn = [<?php
                latlgn();
            ?>];
            
            var names = [<?php
                names();
            ?>];
            
            var ratings = [<?php
                rating();
            ?>];

            var noratings = [<?php
                noratings();
            ?>];
           
            for(var i = 0; i < names.length; i++){
                var pubLocation = new google.maps.LatLng(parseFloat(latlgn[2*i]),parseFloat(latlgn[2*i+1]));
                addMarker(pubLocation,names[i]);
                var colour = getRandomColor();
                var populationOptions = {  
      				strokeColor: colour,
      				strokeOpacity: 0.8,
      				strokeWeight: 2,
      				fillColor: colour,
      				fillOpacity: 0.35,
      				map: map,
      				center: pubLocation,
      				radius: Math.pow(2,parseFloat(ratings[i]))*Math.log(noratings[i])
    			};
                cityCircle = new google.maps.Circle(populationOptions);
                
            }
            
        }
        
        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        
        // Add a marker to the map and push to the array.
        function addMarker(location,pubName,) {
        
          var infowindow = new google.maps.InfoWindow({
              content: pubName
          });

          var marker = new google.maps.Marker({
             icon: {
                  path: google.maps.SymbolPath.CIRCLE,
                  scale: 2
                },
            position: location,
            map: map
          });
          
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });
          
            markers.push(marker);
          
        }

        // Sets the map on all markers in the array.
        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setAllMap(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setAllMap(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }
        
       

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    
    <div id="map-canvas"></div>
  </body>
</html>
