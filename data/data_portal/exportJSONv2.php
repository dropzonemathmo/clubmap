<?php include 'db_connect.php';?>

<?php

 

function exportJSON($type){

   $mysqli = connectToDatabase();
    $myArray = array();
    if ($result = $mysqli->query("SELECT name, rating, total_rating, address, geocoord_lat, geocoord_long, classification, mon_closing_time, tues_closing_time, wed_closing_time, thurs_closing_time, fri_closing_time, sat_closing_time, sun_closing_time FROM placeInfo WHERE classification LIKE '$type' AND mon_closing_time<>''")) {
        $tempArray = array();
	echo "the result is<br>"; 

        while($row = $result->fetch_object()) {
                $tempArray = $row;
                array_push($myArray, $tempArray);
            }
        
	echo json_encode($myArray);
	file_put_contents("$type.txt", json_encode($myArray));

    }

    $result->close();


	unset($myArray);

   disconnectFromDatabase($mysqli);

}

	exportJSON("Pub");
	exportJSON("NightClub");
	exportJSON("Bar");
  
?>
