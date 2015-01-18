<?php
// Create connection
$con=mysqli_connect("mysql.2freehosting.com","u714891374_admin","Peanut69","u714891374_crowd");



// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$endresult = mysqli_query($con,"SELECT MAX(PID) FROM Stories2");
$endi = mysqli_fetch_array($endresult);
$i=1;
while ($i <= $endi[0]) {
$upentry = "up".$i;
$downentry = "down".$i;
$newupscore = intval($_POST[$upentry]);
$newdownscore = intval($_POST[$downentry]);
mysqli_query($con,"UPDATE Stories2 SET Score = Score + $newupscore WHERE PID = $i");
mysqli_query($con,"UPDATE Stories2 SET Score = Score - $newdownscore WHERE PID = $i");
//$sql="UPDATE Stories2 SET Email=$i WHERE PID = 49"

$i++;
}

mysqli_close($con);
?>

<a href="comment.php">thanks for scoring - click here to go back</a>
