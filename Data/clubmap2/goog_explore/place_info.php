<?php

function printOutPlaceInfo($placeid,$conn,$url,$APIKey){	

		//required for SSL
		$arrContextOptions=array(
		    "ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		    ),
		); 

	$urlofplace = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key={$APIKey}";

        // get the json response    
	$resp_json = file_get_contents($urlofplace,false, stream_context_create($arrContextOptions));
		
		
	$resp = json_decode($resp_json,true);

	$types_count = count($resp["result"]["types"]);
	
	$name = $resp["result"]["name"];
	$geo_coord_lat = $resp["result"]["geometry"]["location"]["lat"];
	$geo_coord_long = $resp["result"]["geometry"]["location"]["lng"];
	$address = $resp["result"]["formatted_address"];
	$closing_time = $resp["result"]["opening_hours"]["weekday_text"][0].
$resp["result"]["opening_hours"]["weekday_text"][1].
$resp["result"]["opening_hours"]["weekday_text"][2].
$resp["result"]["opening_hours"]["weekday_text"][3].
$resp["result"]["opening_hours"]["weekday_text"][4].
$resp["result"]["opening_hours"]["weekday_text"][5].
$resp["result"]["opening_hours"]["weekday_text"][6];
	$rating = $resp["result"]["rating"];
	
$name = str_replace("'", "", $name);
$address = str_replace("'", "", $address);


	echo "<td>";
	echo $name;
	echo "</td><td>";

	echo $geo_coord_lat;
	echo "</td><td>";

	echo $geo_coord_long;
	echo "</td><td>";

	echo $address;
	echo "</td><td>";

	echo $closing_time;
	echo "</td><td>";

	echo $rating;
	echo "</td>";

	//types code	

	for($i = 0 ; $i < 9 ; $i++){
		$type[$i] = "...";
	}

	for ($z =0; $z < $types_count; $z++){
		$type[$z] = $resp["result"]["types"][$z];		
		echo "<td>";
		echo $type[$z];
		echo "</td>";
	}

	echo "<td>";
		// Insert data into database

		$sql = "INSERT INTO googExplore (name, place_id, url, geocoord_lat, geocoord_long, address, closing_time, rating, type1, type2,type3, type4,type5, type6,type7, type8)
		VALUES ('$name', '$placeid', '$url','$geo_coord_lat','$geo_coord_long','$address','$closing_time','$rating','$type[0]','$type[1]','$type[2]','$type[3]','$type[4]','$type[5]','$type[6]','$type[7]') ";

		if (mysqli_query($conn, $sql)) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		//end insert into database
	echo "</td>";
}

?>
