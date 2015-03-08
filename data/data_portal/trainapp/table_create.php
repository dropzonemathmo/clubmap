<?php
$servername = "localhost";
$username = "nim";
$password = "bogaboga123";
$db = "trainmap";

// Create connection
$conn = new mysqli($servername, $username, $password,$db);


$sqlQueryStore = "CREATE TABLE trainFareStore (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
destination VARCHAR(100) NOT NULL,
departure VARCHAR(100) NOT NULL,
arival_time VARCHAR(100) NOT NULL,
departure_time VARCHAR(100) NOT NULL
)";



if ($conn->query($sqlQueryStore) === TRUE) {
    echo "Table queryStore created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();

?> 
