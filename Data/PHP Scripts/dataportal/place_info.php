<?php

function printOutPlaceInfo($placeid,$conn,$url){	



		//required for SSL
		$arrContextOptions=array(
		    "ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		    ),
		); 

	$urlofplace = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key=AIzaSyDs6RzjlMJZMcca24BUKGnqb9SHX7z9OO4";

        // get the json response    
	$resp_json2 = file_get_contents($urlofplace,false, stream_context_create($arrContextOptions));
	
	$resp2 = json_decode($resp_json2,true);
	$types_count = count($resp2["result"]["types"]);
	
	$name = $resp2["result"]["name"];
	echo "<td>";
	echo $name;
	echo "</td><td>";

	for ($z =0; $z < $types_count; $z++){
		echo "<td>";
		echo $resp2["result"]["types"][$z];
		echo "</td>";
	}


		// Insert data into database
		$name = 'hello';
		$placeid = 'hello2';
		$url = 'www.hello3.com';

		$sql = "INSERT INTO barsAndClubs (name, place_id, url)
		VALUES ('$name', '$placeid', '$url')";

		if (mysqli_query($conn, $sql)) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		//end insert into database



}

?>
