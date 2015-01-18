<?php
	$urlofaddress = urlencode("data.json");
    $resp_json = file_get_contents($urlofaddress);
    $resp = json_decode($resp_json,true);
	
    $l = count($resp["result"]);

    $sum = 0.0;

    for($x = 0; $x < $l; $x++){
    	$sum += $resp["result"]["user_ratings_total"];
    }

    $result = $sum/$l;

    echo "{$result}";

?>