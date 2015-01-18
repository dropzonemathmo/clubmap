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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import a CSV File with PHP & MySQL</title>
</head>

<body>

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  Choose your file: <br />
  <input name="csv" type="file" id="csv" />
	GoogAPIKey: <input type="text" name="GoogAPIKey"><br>
  <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html> 
