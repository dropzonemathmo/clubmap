<?php include 'db_connect.php';?>

<?php

    $mysqli = connectToDatabase();
    $myArray = array();
    if ($result = $mysqli->query("SELECT name, rating, total_rating, address, geocoord_lat, geocoord_long, classification, mon_closing_time, tues_closing_time, wed_closing_time, thurs_closing_time, fri_closing_time, sat_closing_time, sun_closing_time FROM placeInfo WHERE classification LIKE 'Pub' AND mon_closing_time<>''")) {
        $tempArray = array();
	echo "the result is<br>"; 

        while($row = $result->fetch_object()) {
                $tempArray = $row;
                array_push($myArray, $tempArray);
            }
        
	echo json_encode($myArray);
	file_put_contents("pubs.txt", json_encode($myArray));

    }

    $result->close();

	unset($myArray);

    $myArray = array();
    if ($result = $mysqli->query("SELECT name, rating, total_rating, address, geocoord_lat, geocoord_long, classification, mon_closing_time, tues_closing_time, wed_closing_time, thurs_closing_time, fri_closing_time, sat_closing_time, sun_closing_time FROM placeInfo WHERE classification LIKE 'NightClub' AND geocoord_lat<>'' AND sat_closing_time<>''")) {

// 
        $tempArray = array();
	echo "the result is<br>"; 

        while($row = $result->fetch_object()) {
                $tempArray = $row;
                array_push($myArray, $tempArray);
            }
        
	echo json_encode($myArray);
	file_put_contents("nightclub.txt", json_encode($myArray));

    }

    $result->close();
	unset($myArray);

    $myArray = array();
    if ($result = $mysqli->query("SELECT name, rating, total_rating, address, geocoord_lat, geocoord_long, classification, mon_closing_time, tues_closing_time, wed_closing_time, thurs_closing_time, fri_closing_time, sat_closing_time, sun_closing_time FROM placeInfo WHERE classification LIKE 'Bar' AND mon_closing_time<>''")) {
        $tempArray = array();
	echo "the result is<br>"; 

        while($row = $result->fetch_object()) {
                $tempArray = $row;
                array_push($myArray, $tempArray);
            }
        
	echo json_encode($myArray);
	file_put_contents("bar.txt", json_encode($myArray));

    }

    $result->close();


   disconnectFromDatabase($mysqli);
?>
