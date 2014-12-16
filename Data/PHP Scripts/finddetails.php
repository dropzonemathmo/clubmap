<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<?php
    $urlofaddress = urlencode("clubsnpubslocations.json");
    $resp_json = file_get_contents($urlofaddress);
    $resp = json_decode($resp_json,true);
            
    $length = count($resp['results']);
    $result = array();
                
    for ($x = 0; $x < $length; $x++) {
                
        $placeid = $resp['results'][$x]['place_id'];
        
        // google place details
        
        $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key=AIzaSyDs6RzjlMJZMcca24BUKGnqb9SHX7z9OO4";
      
        // get the json response
        $json = file_get_contents($url);
        
        // decode the json
        $json_array = json_decode($json, true);
	
	//getting the opening times
	$dailyOpening = array();

	$numOpeningResults =
	count($json_array["result"]["opening_hours"]["weekday_text"]);

	for($y = 0; $y < $numOpeningResults; $y++){
	       array_push($dailyOpening,$json_array["result"]["opening_hours"]["weekday_text"][$y]);
	}

	//getting the individual reviews

	$indReviews = array();

	$noIndReviews = count($json_array["result"]["reviews"]);

	for($y = 0; $y < $noIndReviews; $y++){
	       $indReviews[$y] = array(
	       		       "rating" =>
	       $json_array["result"]["reviews"][$y]["rating"],
			       "author_name" =>
	       $json_array["result"]["reviews"][$y]["author_name"],
			       "text" => $json_array["result"]["reviews"][$y]["text"]

	       );
	}
        
        $result[$x] = array(
            "name" => $json_array["result"]["name"],
            "address" => $json_array["result"]["formatted_address"],
            "rating" => $json_array["result"]["rating"],
            "user_ratings_total" =>
            $json_array["result"]["user_ratings_total"],
	    "indReviews" => $indReviews,
	    "weekday_text" => $dailyOpening,
            "lat" => $json_array["result"]["geometry"]["location"]["lat"],
            "lng" =>
            $json_array["result"]["geometry"]["location"]["lng"],
	    "price_level" => $json_array["result"]["price_level"]
            );
            

        }
                
    $json = json_encode($result);
    echo $json;
?>
