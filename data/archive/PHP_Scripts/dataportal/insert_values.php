<?php include 'db_connect.php';?>

<?php

$conn = connectToDatabase();


$test1 = 'hello';
$test2 = 'hello2';
$test3 = 'www.hello3.com';

$sql = "INSERT INTO barsAndClubs (name, place_id, url)
VALUES ('$test1', '$test2', '$test3')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

disconnectFromDatabase($conn);

?> 
