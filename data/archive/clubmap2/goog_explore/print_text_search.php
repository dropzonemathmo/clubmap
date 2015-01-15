
<?php include 'db_connect.php';?>
<?php include 'place_info.php';?>

<?php

	
function printtextsearch($textSearch,$GoogAPIKey){

//required for SSL
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  


$text_encode = urlencode($textSearch);

$urlofaddress = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$text_encode}&key={$GoogAPIKey}";

	//connect to database
	$conn = connectToDatabase();

	//PHP string
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	$resp = json_decode($resp_json,true);


	$count = count($resp["results"]);

	for($y = 0; $y < $count; $y++){
		echo "<tr><td>";
		echo $resp["results"][$y]["place_id"];
		echo "</td>";//	
		$placeid = $resp["results"][$y]["place_id"];	
	
		//prints out place data separated by <td> tags using google place id API
		printOutPlaceInfo($placeid,$conn,$urlofaddress,$GoogAPIKey);
		echo "</tr>";	
	}
	disconnectFromDatabase($conn);
}
