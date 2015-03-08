<html>
<head>
	<title></title>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
</head>
<body>
<h1> Nearby Data </h1><br>
<?php include '../db_connect.php';?>
<?php include 'place_info.php';?>
<?php
	
//required for SSL
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$coordinates = $_POST["coordinates"];//"51.5072,-0.1275";
$radius = $_POST["radius"];//"5000";
$types = $_POST["types"];//"bar";
$GoogAPIKey = $_POST["GoogAPIKey"];//AIzaSyBE30hkgGbIO2nkcigR7c1sU0PBI5nVEAk
	
$urlofaddress = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$coordinates}&radius={$radius}&types={$types}&key={$GoogAPIKey}";

echo $urlofaddress;
	//connect to database
	$conn = connectToDatabase();

	//PHP string
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	$resp = json_decode($resp_json,true);

	$count = count($resp["results"]);
	echo "<table border=1><tr><td><b>place_id</b></td><td><b>name</b></td>";

	for($y = 0; $y < $count; $y++){
		echo "<tr><td>";
		echo $resp["results"][$y]["place_id"];
		echo "</td>";//
	
		$placeid = $resp["results"][$y]["place_id"];	
	
		//prints out place data separated by <td> tags using google place id API
		printOutPlaceInfo($placeid,$conn,$urlofaddress,$GoogAPIKey);
		echo "</tr>";	
	}
	echo "</table>";
	disconnectFromDatabase($conn);
?>
</body>
</html>
