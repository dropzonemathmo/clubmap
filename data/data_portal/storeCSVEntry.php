<?php include 'db_connect.php';?>
<?php include 'place_info.php';?>

<?php

	
function storeCSVEntry($name,$address,$tag,$ordering,$GoogAPIKey){
	echo "storing entry $name <br>";
	//required for SSL
	$arrContextOptions=array(
    		"ssl"=>array(
        	"verify_peer"=>false,
        	"verify_peer_name"=>false,
  	  	),
	);  


	$text_encode = urlencode($name.$address);

	$urlofaddress = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$text_encode}&key={$GoogAPIKey}";

	//connect to database
	$conn = connectToDatabase();

	//PHP string
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	$resp = json_decode($resp_json,true);
	
	//echo $resp_json;
	$count = count($resp["results"]);

// only do it for one value not total count
	for($y = 0; $y < 1; $y++){
		//if no place id store as such
		echo "<h1> place id coming up</h1><br>";
		echo $resp["results"][$y]["place_id"];
		if (empty($resp["results"][$y]["place_id"])) {
    			echo "no place_id found for $name <br>";
			$placeid = "NO PLACE ID FOUND";
		}		
		else {
			$placeid = $resp["results"][$y]["place_id"]; //store that with tag and ordering in queryTable
			echo "place id found $placeid $name <br>"; 
		}
	
		//if Place Id not in table store in table

		echo "Now Check to see if already stored in database <br><br>";
		$checkidsql = "SELECT * FROM placeInfo WHERE place_id='$placeid' LIMIT 5";
		$place_id_exist = mysqli_query($conn,$checkidsql);
		
		var_dump($place_id_exist);	
		if ($place_id_exist->num_rows == 0) {
  			// do something
			echo "new place found with placeid $placeid";
			storePlaceInfo($placeid,$conn,$GoogAPIKey);
		}
		else {
			echo "place_id already exists";
		}
	


	// Insert data into database
		$sql = "INSERT INTO queryStore (name, address, tag ,ordering, place_id)
		VALUES ('$name', '$address', '$tag','$ordering', '$placeid') ";

		if (mysqli_query($conn, $sql)) {
			echo "New record created successfully";
		}	
		 else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

	}
	disconnectFromDatabase($conn);
}
