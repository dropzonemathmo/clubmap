<?php

function storePlaceInfo($placeid,$conn,$APIKey){
		
	echo "<h3>storing place info</h3><br>";
		//required for SSL
		$arrContextOptions=array(
		    "ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		    ),
		); 

	//place id search
	$urlofplace = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key={$APIKey}";

        // get the json response    
	$resp_json = file_get_contents($urlofplace,false, stream_context_create($arrContextOptions));
		
		
	$resp = json_decode($resp_json,true);
	

	$types_count = count($resp["result"]["types"]);
	
	$name = $resp["result"]["name"];
	$geo_coord_lat = $resp["result"]["geometry"]["location"]["lat"];
	$geo_coord_long = $resp["result"]["geometry"]["location"]["lng"];
	$address = $resp["result"]["formatted_address"];
	$mon_closing_time = $resp["result"]["opening_hours"]["weekday_text"][0];
	$tues_closing_time = $resp["result"]["opening_hours"]["weekday_text"][1];
	$wed_closing_time = $resp["result"]["opening_hours"]["weekday_text"][2];
	$thurs_closing_time = $resp["result"]["opening_hours"]["weekday_text"][3];
	$fri_closing_time = $resp["result"]["opening_hours"]["weekday_text"][4];
	$sat_closing_time = $resp["result"]["opening_hours"]["weekday_text"][5];
	$sun_closing_time = $resp["result"]["opening_hours"]["weekday_text"][6];
	$rating = $resp["result"]["rating"];
	$total_rating = $resp["result"]["user_ratings_total"];
	
	$name = str_replace("'", "", $name);
	$address = str_replace("'", "", $address);
	
	//var_dump($total_rating);

	file_put_contents("{$placeid}.txt", $resp_json);

	echo $name;
	echo $geo_coord_lat;
	echo $geo_coord_long;
	echo $address;
	echo $mon_closing_time;
	echo $rating;
	echo $total_rating;
	echo "<br>";

		// Insert data into database
		$sql = "INSERT INTO placeInfo (name, place_id, geocoord_lat, geocoord_long, address, mon_closing_time, tues_closing_time, wed_closing_time, thurs_closing_time, fri_closing_time, sat_closing_time, sun_closing_time, rating, total_rating)
		VALUES ('$name', '$placeid', '$geo_coord_lat','$geo_coord_long','$address','$mon_closing_time','$tues_closing_time','$wed_closing_time','$thurs_closing_time','$fri_closing_time','$sat_closing_time','$sun_closing_time','$rating', '$total_rating') ";

		if (mysqli_query($conn, $sql)) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		//end insert into database
	echo "</td>";
}

?>
