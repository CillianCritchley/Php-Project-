<?php
include 'db.inc.php';
date_default_timezone_set('UTC');

$sql=" Select firstname, surname, dateOfBirth from Customer where customerID = ".$_POST['customerID'];

$result=mysqli_query($con,$sql);

$rowcount = mysqli_affected_rows($con);

if($rowcount==1)
{
	echo "<br>The details of the selected person are <br><br> ";
	$row= mysqli_fetch_array($result);

	echo "The Customer Number is : ".$_POST['customerID']."<br><br>";
	echo "First name is    : ";
	echo $row['firstname']."<br>";
	echo "Last name is     : ";
	echo $row['surname']."<br>";

	$date=date_create($row['dateOfBirth']);
	echo "Date of Birth is : ".date_format($date,"d/m/y");
}

	else if ($rowcount==0)
	{
		echo "No matching records";
	}

	mysqli_close($con);
	?>

<form action="OpenDeposit.html.php" method="post">
<br>
<input type="submit" value="Return to select page"/>

</form>


