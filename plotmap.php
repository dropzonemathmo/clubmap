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
        function geocode() {
            $urlofaddress = urlencode("clubdata.json");
            $resp_add_json = file_get_contents($urlofaddress);
            $resp_add = json_decode($resp_add_json,true);

                for ($x = 0; $x <= 10; $x++) {

                    $addofpub = $resp_add['results'][$x]['address'];
                    $nameofpub = $resp_add['results'][$x]['name'];    
 
    
                    // url encode the address
                    $theadd = $addofpub;
                    $addofpub = urlencode($addofpub);
     
                    // google map geocode api url
                    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$addofpub}";
       
                     // get the json response
                    $resp_json = file_get_contents($url);
     
                    // decode the json
                    $resp = json_decode($resp_json, true);

                    // response status will be 'OK', if able to geocode given address 
                   if($resp['status']='OK'){
 
                       // get the important data
                        $lati = $resp['results'][0]['geometry']['location']['lat'];
                        $longi = $resp['results'][0]['geometry']['location']['lng'];
                        $formatted_address = $resp['results'][0]['formatted_address'];
                        
                        if(gettype($lati) != "NULL"){
                            echo "$lati,$longi,";  
                        }
                    }
                }
    
        } 
    ?>
    
    
    <?php
        function reviews() {
            $urlofaddress = urlencode("clubdata.json");
            $resp_add_json = file_get_contents($urlofaddress);
            $resp_add = json_decode($resp_add_json,true);

                for ($x = 0; $x <= 10; $x++) {

                    $addofpub = $resp_add['results'][$x]['address'];
                    $nameofpub = $resp_add['results'][$x]['name'];    
                    $noreviews = $resp_add['results'][$x]['no_reviews'];
    
                    // url encode the address
                    $theadd = $addofpub;
                    $addofpub = urlencode($addofpub);
     
                    // google map geocode api url
                    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$addofpub}";
       
                     // get the json response
                    $resp_json = file_get_contents($url);
     
                    // decode the json
                    $resp = json_decode($resp_json, true);

                    // response status will be 'OK', if able to geocode given address 
                   if($resp['status']='OK'){
 
                       // get the important data
                        $lati = $resp['results'][0]['geometry']['location']['lat'];
                        $longi = $resp['results'][0]['geometry']['location']['lng'];
                        $formatted_address = $resp['results'][0]['formatted_address'];
                        
                        //if(gettype($lati) != "NULL"){
                            echo "$noreviews,";  
                        //}
                    }
                }   
        } 
    ?>
    
    <script>
        // In the following example, markers appear when the user clicks on the map.
        // The markers are stored in an array.
        // The user can then click an option to hide, show or delete the markers.
        var map;
        var markers = [];

        function initialize() {
            var london = new google.maps.LatLng(51.5238121,-0.0744264);
            var mapOptions = {
                zoom: 20,
                center: london,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            };
            map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

            var coords = [<?php
                echo geocode(); 
            ?>];
            
            var no_reviews = [<?php
                echo reviews();
            ?>];
            
            
            /*for(var i = 0; i < coords.length/2; i++){
                document.write(coords[2*i] + " " + coords[2*i + 1] + " " + no_reviews[i] + "<br>");
            
            }*/
            
            for(var i = 0; i < coords.length/2; i++){
                var pubLocation = new google.maps.LatLng(coords[2*i],coords[2*i + 1]);
                //addMarker(pubLocation,"name");
                var colour = getRandomColor();
                var populationOptions = {  
      				strokeColor: colour,
      				strokeOpacity: 0.8,
      				strokeWeight: 2,
      				fillColor: colour,
      				fillOpacity: 0.35,
      				map: map,
      				center: pubLocation,
      				radius: Math.sqrt(parseFloat(no_reviews[i]))*25
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
        function addMarker(location,pubName) {
          var marker = new google.maps.Marker({
            position: location,
            map: map,
            content: "pub"
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
    <p>Click on the map to add markers.</p>
  </body>
</html>
