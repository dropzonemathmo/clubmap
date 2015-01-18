<?php
// Create connection
$con=mysqli_connect("mysql.2freehosting.com","u714891374_admin","Peanut69","u714891374_crowd");

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else {
  echo "Connected Successfully";
}
mysqli_close($con);
?>