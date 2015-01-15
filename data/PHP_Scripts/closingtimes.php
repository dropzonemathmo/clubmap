<html>
<head>
	<title>Data shit</title>
</head>
<body>

<?php
    $urlofaddress = urlencode("data.json");
    $resp_json = file_get_contents($urlofaddress);
    $resp = json_decode($resp_json,true);
            
    $length = count($resp['result']);
    $result = array();

    echo "
    	 <table border =1><TR>
	 <td><b> Name</b></td>
	 <td><b> Address</b></td>
	 <td><b> Rating</b></td>
	 <td><b> Noratings</b></td>
	 <td><b> Monday</b></td>
	 <td><b> Tuesday</b></td>
	 <td><b> Wednesday</b></td>
	 <td><b> Thursday</b></td>
	 <td><b> Friday</b></td>
	 <td><b> Saturday</b></td>
	 <td><b> Sunday</b></td>
	 <td><b> Price </b></td>
</TR> ";
        
	$y = -9;        
    for ($x = 0; $x < $length; $x++) {

    	echo "
        <tr>";

	$name = $resp["result"][$x]["name"];

	$address = $resp["result"][$x]["address"];

	$rating = $resp["result"][$x]["rating"];

	$noratings = $resp["result"][$x]["user_ratings_total"];


	$time0 = $resp["result"][$x]["weekday_text"][0];
	
    $time0s = substr($time0,$y);
    
	$time1 = $resp["result"][$x]["weekday_text"][1];
          
    $time1s = substr($time1,$y);
    
	$time2 = $resp["result"][$x]["weekday_text"][2];
       
       
    $time2s = substr($time2,$y);
    
       
	$time3 = $resp["result"][$x]["weekday_text"][3];
       
       
    $time3s = substr($time3,$y);
    
       
	$time4 = $resp["result"][$x]["weekday_text"][4];
       
       
    $time4s = substr($time4,$y);
    
       
	$time5 = $resp["result"][$x]["weekday_text"][5];
       
       
       
    $time5s = substr($time5,$y);
    
       
	$time6 = $resp["result"][$x]["weekday_text"][6];
    
       
    $time6s = substr($time6,$y);
    
	$price = $resp["result"][$x]["price_level"];	

	echo "<td>$name</td>
	<td>$address</td>
	<td>$rating</td>
	<td>$noratings</td>
	
	<td width=100>$time0s</td>
	
	<td width=100>$time1s</td>
	
	<td width=100>$time2s</td>
	
	<td width=100>$time3s</td>
	
	<td  width=100>$time4s</td>
	
	<td width=100>$time5s</td>
	
	<td width=100>$time6s</td>
	
	<td  width=100>$price</td>
	</tr>
	";
}
	echo " </table>";
?>

</body>
</html>
