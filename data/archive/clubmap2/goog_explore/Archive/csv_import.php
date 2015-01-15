<?php include 'print_text_search.php';?>
<?php
$GoogAPIKey = $_POST["GoogAPIKey"];

if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
echo "<table border=1>";    
    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
		echo "<tr><td>";
		echo $data[0];
		echo "</td><td>";
		echo $data[1];
		echo "</td></tr>";
		printtextsearch($data[0].$data[1],$GoogAPIKey);          
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    
echo "</table>";

}

?>

