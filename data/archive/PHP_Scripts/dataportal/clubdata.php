

<html>
<head>
	<title></title>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

</head>
<body>

Club Data

<?php
	
//required for SSL
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$coordinates = "51.5072,-0.1275";
$radius = "5000";
$types = "bar";
$GoogAPIKey = "AIzaSyBE30hkgGbIO2nkcigR7c1sU0PBI5nVEAk";
	
$urlofaddress = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location={$coordinates}&radius={$radius}&types={$types}&key={$GoogAPIKey}";

//PHP string
	$resp_json = file_get_contents($urlofaddress,false, stream_context_create($arrContextOptions));
	
	$resp = json_decode($resp_json,true);



	$count = count($resp["results"]);


echo $resp["results"][0]["name"];
echo $resp["results"][0]["place_id"];
echo $resp["results"][0]["types"];


/*

    for($x = 0; $x < $depth; $x++){
    	$page_token = $resp["next_page_token"];
        $count = count($resp["results"]);
        echo $urlofaddress;
        echo "<br>";

        echo "page {$x} token:<br>{$page_token}<br>";

        $result = "
            {
                \"results\":[
        ";
        $stry = strval($x);
        $filename = "data_hawt_".$stry.".txt";

        $file = fopen($filename, "w+"); 

    	for($y = 0; $y < $count; $y++){
    		$object = $resp["results"][$y];
    		$json_object = json_encode($object);
    		//echo $json_object;

            $result .= $json_object;

            // The new person to add to the file

            // Write the contents to the file, 
            // using the FILE_APPEND flag to append the content to the end of the file
            //file_put_contents($filename, $json_object, FILE_APPEND | LOCK_EX);
            if($y != $count - 1){
                $result .= ",";
            }
    	}
        $result .= "
                        ]
                    }
                ";

        fwrite($file, $result);
        fclose($file);


        
        $resp_json = file_get_contents($urlofaddress);
        $resp = json_decode($resp_json,true);
    }
*/
?>
</body>
</html>
