<?php
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




// sql to create table
$sql = "CREATE TABLE barsAndClubs (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
place_id VARCHAR(100) NOT NULL,
url VARCHAR(100),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table barsAndClubs created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?> 
