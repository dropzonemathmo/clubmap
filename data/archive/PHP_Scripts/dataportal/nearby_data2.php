

<html>
<head>
	<title></title>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

</head>
<body>

<h1> Club Data </h1><br>

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

//PHP string
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	
	$resp = json_decode($resp_json,true);

printID_types($resp["results"]);

function printID_types($array){

$count = count($array);
echo "<table border=1><tr><td><b>name</b></td><td><b>place id</b></td>";


    for($y = 0; $y < $count; $y++){
		     
		     echo "<tr><td>";
		     echo $array[$y]["name"];
		     echo "</td><td>";
		     echo $array[$y]["place_id"];
		     echo "</td>";
		     $placeid = $array[$y]["place_id"];
		     $urlofplace = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key=AIzaSyDs6RzjlMJZMcca24BUKGnqb9SHX7z9OO4";

		     // get the json response    
		     $place_search_json = file_get_contents($urlofplace,false, stream_context_create($arrContextOptions));
		     
		     $place_search = json_decode($place_search_json,true);
		     $types_count = count($place_search["result"]["types"]);

		     for ($z =0; $z < $types_count; $z++){
				      echo "<td>";
				      echo $place_search["result"]["types"][$z];
				      echo "</td>";
		     }
		echo "</tr>";	
	}
}
echo "</table>";
?>
</body>
</html>
