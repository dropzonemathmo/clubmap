<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<?php
    $urlofaddress = urlencode("clubsnpubslocations.json");
    $resp_json = file_get_contents($urlofaddress);
    $resp = json_decode($resp_json,true);
            
    $length = count($resp['results']);
    $result = array();
                
    for ($x = 0; $x < $length; $x++) {
                
        $placeid = $resp['results'][$x]['place_id'];
        
        // google place details
        
        $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid={$placeid}&key=AIzaSyDs6RzjlMJZMcca24BUKGnqb9SHX7z9OO4";
      
        // get the json response
        $json = file_get_contents($url);
        
        // decode the json
        $json_array = json_decode($json, true);
        
        $closing_times = json_decode($json.results.opening_hours);
        
        $result[$x] = array(
            "name" => $json_array["result"]["name"],
            "address" => $json_array["result"]["formatted_address"],
            "rating" => $json_array["result"]["rating"],
            "user_ratings_total" => $json_array["results"]["user_ratings_total"],
            "opening_hours" => $closing_times,
            "lat" => $json_array["result"]["geometry"]["location"]["lat"],
            "lng" => $json_array["result"]["geometry"]["location"]["lng"],
            );
            

        }
                
    $json = json_encode($result);
    echo $json;
?>
