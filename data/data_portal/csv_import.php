<?php include 'storeCSVEntry.php';?>
<?php
$GoogAPIKey = $_POST["GoogAPIKey"];
$tag = $_POST["Tag"];


echo "
<html><head>
<script src='//code.jquery.com/jquery.min.js'></script>
	<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
	<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' rel='stylesheet'>
	<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script></head><body>";

echo "<h1> $tag </h1>";


if ($_FILES['csv']['size'] > 0) {

    //get the csv file
    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");
     echo "importing name and addresses";	
    //loop through the csv file and insert into database
	$ordering  = 1;
    do {
        if ($data[0]) {
		//data[0] is name
		echo $data[0];
		//data[1] is address
		echo " ";
		echo $data[1];
		echo "<br>";
		storeCSVEntry($data[0],$data[1],$tag,$ordering,$GoogAPIKey);
		$ordering++;          
        }
    } while ($data = fgetcsv($handle,1000,",","'"));

}

echo "</body></html>";

?>

