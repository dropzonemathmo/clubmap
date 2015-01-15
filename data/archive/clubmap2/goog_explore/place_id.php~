<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<?php


	//required for SSL
	$arrContextOptions=array(
    		"ssl"=>array(
        	"verify_peer"=>false,
        	"verify_peer_name"=>false,
    		),
	);  
            
	$placeid = $_POST["placeid"];
	$GoogAPIKey = $_POST["GoogAPIKey"];

        // google place details
        
        $urlofaddress = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key={$GoogAPIKey}";

function printTable($placeid,$GoogAPIKey) {
    echo "Hello world!";
}        
	// get the json response    
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	
	$resp = json_decode($resp_json,true);
	
//	echo $resp_json;	
	
	echo "<table border=1><tr>";
	echo "<td>";
	echo $resp["result"]["name"];	
	echo "</td>";	
		
	$types_count = count($resp["result"]["types"]);
	for ($y =0; $y < $types_count; $y++){
		echo "<td>";
		echo $resp["result"]["types"][$y];
		echo "</td>";
	}	
	echo "</tr></table>";
?>
