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
geocoord_lat VARCHAR(20),
geocoord_long VARCHAR(20),
address VARCHAR(100),
closing_time VARCHAR(100),
reg_date TIMESTAMP,
rating VARCHAR(10),
type1 VARCHAR(20),
type2 VARCHAR(20),
type3 VARCHAR(20),
type4 VARCHAR(20),
type5 VARCHAR(20),
type6 VARCHAR(20),
type7 VARCHAR(20),
type8 VARCHAR(20)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table barsAndClubs created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?> 
