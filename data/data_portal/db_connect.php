<?php

error_reporting(0);

echo "
<script src='//code.jquery.com/jquery.min.js'></script>
	<link href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
	<link href='//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' rel='stylesheet'>
	<script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>";

function connectToDatabase(){
$servername = "localhost";
$username = "nim";
$password = "bogaboga123";
$db = "clubmap";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);

// Check connection
if ($conn->connect_error) {
	echo "nonono";
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
 return $conn;

}

function disconnectFromDatabase($conn){

	mysqli_close($conn);
}

?>
