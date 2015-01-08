<html>
<head>
	<title>Data shit</title>
</head>
<body>

<?php
    $urlofaddress = urlencode("clubsnpubsratings.json");
    $resp_json = file_get_contents($urlofaddress);
    $resp = json_decode($resp_json,true);
            
    $length = count($resp['results']);
    $result = array();

    echo "
    	 <table border =1><TR>
	 <td><b> Name</b></td>
	 <td><b> Address</b></td>
	 <td><b> Rating</b></td>
	 <td><b> Noratings</b></td>
	 <td><b> Lat</b></td>
	 <td><b> Lng</b></td>
</TR> ";
                
    for ($x = 0; $x < $length; $x++) {

    	echo "
        <tr>";

	$name = $resp["results"][$x]["name"];

	$address = $resp["results"][$x]["address"];

	$rating = $resp["results"][$x]["rating"];

	$noratings = $resp["results"][$x]["user_ratings_total"];

	$lat = $resp["results"][$x]["lat"];
       
	$lng = $resp["results"][$x]["lng"];	

	echo "<td>$name</td>
	<td>$address</td>
	<td>$rating</td>
	<td>$noratings</td>
	<td>$lat</td>
	<td>$lng</td>
	</tr>
	";
}
	echo " </table>";
?>

</body>
</html>
