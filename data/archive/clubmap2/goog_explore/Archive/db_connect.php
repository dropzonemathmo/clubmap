<?php

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
