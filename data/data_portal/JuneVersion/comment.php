<?php
// Create connection
$con=mysqli_connect("mysql.2freehosting.com","u714891374_admin","Peanut69","u714891374_crowd");



// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



echo "<font face='verdana' size='5'>
<div style='position:relative; top:50px; left:170px'>
<iframe width='560' height='315' src='http://www.youtube.com/embed/_17Liv5R8mw' frameborder='0' allowfullscreen></iframe>
</div>

<div style='position:relative; top:100px; left:100px'>
<form action='addcomment.php' method='post'>		
<table border='0' bgcolor='grey'>
	<tr>
		<td colspan='2'>Your Story:</td> 
	</tr>
	<tr>	
		<td colspan='2'><textarea rows='7' cols='100' name='story'>write your story here</textarea></td>
	</tr>
	<tr>	
				<td>Your Username:<input type='textbox' name='username'></td>
				<td>Your E-mail:<input type='textbox' name='email'></td>
				
	</tr>
	<tr>
		<td colspan='2'><input type='submit' value='add story'></td>
	</tr>
	
</table>
</form>
</div>";
$result = mysqli_query($con,"SELECT * FROM Stories2 ORDER BY Score DESC");
echo "<div style='position:relative; top:120px; left:100px'>
<form method='post' action='score.php'>
<table border='1' width='800' bgcolor='grey'>
<tr>
<th>username</th>
<th width='300'>Stories</th>
<th width='100'>button</th>
<th>score</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  $upname = "up" . $row['PID'];
  $downname = "down" . $row['PID'];
  echo "<tr>";
  echo "<td>" . $row['Username'] . "</td>";
  echo "<td>" . $row['Story'] . "</td><td><input type='radio' name='" . $upname;
  echo "' value='1'>up<input type='radio' name='" . $downname;
  echo "' value='1'>down</td>";
  echo "<td><center>" . $row['Score'] . "</center></td>";
  echo "</tr>";
}
echo "<tr><td colspan='4'><center><input type='submit' value='add score'></center></td></tr>";
echo "</table></form></div></font>";

mysqli_close($con);
?>


