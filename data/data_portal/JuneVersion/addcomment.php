<?php
// Create connection
$con=mysqli_connect("mysql.2freehosting.com","u714891374_admin","Peanut69","u714891374_crowd");



// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// escape variables for security
$storyfirst = $_POST['story'];

$story = nl2br($storyfirst);
echo $story;
$username = mysqli_real_escape_string($con, $_POST['username']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$score = 0;
$sql="INSERT INTO Stories2 (Story, Username, Email, Score) VALUES ('$story', '$username', '$email','$score')";
mysqli_query($con,$sql);


mysqli_close($con);
?>


<a href="comment.php">thanks for adding your story - click here to go back</a>