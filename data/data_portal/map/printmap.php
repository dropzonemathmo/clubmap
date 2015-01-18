    <?php


function printmap($jsonAddress){  


echo "
<!DOCTYPE html>
<html>
  <head>
    <meta name='viewport' content='initial-scale=1.0, user-scalable=no'>
    <meta charset='utf-8'>
    <title>Simple markers</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 20px;
        padding: 20px
      }
    </style>
    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>";

    	$urlofaddress = $jsonAddress;
        $resp_add_json = file_get_contents($urlofaddress);    
        $resp_add =  json_decode($resp_add_json, true);
        $length = count($resp_add["results"]);
	echo " There are $length entries in $jsonAddress";


  	
echo "

    <script>
function initialize() {
  var myLatlng = new google.maps.LatLng(51.52338,-0.07522);
  
var mapOptions = {
    zoom: 14,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);";



for($y = 1; $y <$length; $y++){


$lat = $resp_add["results"][$y]["geocoord_lat"];
$long = $resp_add["results"][$y]["geocoord_long"];
$name = $resp_add["results"][$y]["name"];
$rating = $resp_add["results"][$y]["rating"];
$total_rating = $resp_add["results"][$y]["total_rating"];

$score = $rating  + log($total_rating + 1);

if($score > 7.5){
	$radius = 200;
}

if($score < 7.5 && $score > 6.5){
	$radius = 50;
}


if($score < 6.5){
	$radius = 25;
}

echo "

  var newLatlng$y = new google.maps.LatLng($lat,$long)

  var marker$y = new google.maps.Marker({
      position: newLatlng$y,
      map: map})

     var iw$y = new google.maps.InfoWindow({
       content: '$name'
     });
     google.maps.event.addListener(marker$y, 'click', function (e) { iw$y.open(map, this); });


    var populationOptions$y = {
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: newLatlng$y,
      radius: $radius
    };
    // Add the circle for this city to the map.
    cityCircle$y = new google.maps.Circle(populationOptions$y);";




}


echo "
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id='map-canvas'></div>

<table><tr><td>number</td><td>name</td><td>rating</td><td>num of ratings</td><td>address</td><td>score</td><td>radius</td></tr>";



for($y = 0; $y <$length; $y++){


$name = $resp_add["results"][$y]["name"];
$rating = $resp_add["results"][$y]["rating"];
$address = $resp_add["results"][$y]["address"];
$total_rating = $resp_add["results"][$y]["total_rating"];
$score = $rating  + log($total_rating + 1);

if($score > 7.5){
	$radius = 200;
}

if($score < 7.5 && $score > 6.5){
	$radius = 50;
}


if($score < 6.5){
	$radius = 25;
}

echo "<tr><td>$y</td><td>$name</td><td>$rating</td><td>$total_rating</td><td>$address</td><td>$score</td><td>$radius</td></tr>";




}


echo "</table></body></html> ";
}
?>

