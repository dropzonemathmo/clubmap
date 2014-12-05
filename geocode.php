<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Location Accumulator</title>
       
 
</head>
<body>
 


<?php
if($_POST){
 
    // get latitude, longitude and formatted address
    $data_arr = geocode($_POST['address']);
 
    // if able to geocode the address
    if($data_arr){
         
        $latitude = $data_arr[0];
        $longitude = $data_arr[1];
        $formatted_address = $data_arr[2];
                     
    ?>
 
    <!-- JavaScript to show google map -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>    
    
 
    <?php
 
    // if unable to geocode the address
    }else{
        echo "No map found.";
    }
}
?>
 
 
<!-- enter any address -->
<form action="" method="post">
    <input type='text' name='address' placeholder='Enter any address here' />
    <input type='submit' value='Geocode!' />
</form>
 
<?php
 
// function to geocode address, it will return false if unable to geocode address
function geocode($address){
 



$urlofaddress = urlencode("shoreditch.json");
$resp_add_json = file_get_contents($urlofaddress);
$resp_add = json_decode($resp_add_json,true);

echo "<table border=1><tr><td><b>name</b></td><td><b>address</b></td><td><b>coords</b></td></tr>";

if($resp_add['status']='OK'){
for ($x = 0; $x <= 10; $x++) {



   $addofpub = $resp_add['data'][$x]['address'][0];
$nameofpub = $resp_add['data'][$x]['name'][0];    
 
    
// url encode the address
$theadd = $addofpub;
    $addofpub = urlencode($addofpub);
     
    // google map geocode api url
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address={$addofpub}";

    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);


 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']='OK'){
 
        // get the important data
        $lati = $resp['results'][0]['geometry']['location']['lat'];
        $longi = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];
    
      echo "<tr><td>  $nameofpub </td> <td> $theadd </td><td> ($lati , $longi) </td> </tr>";   
    }
} 
    echo "</table>";
}


    else{
        return false;
    }
}
?>
 
</body>
</html>
