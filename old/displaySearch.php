<?php
session_start();
include 'db.inc.php';

$sql = "Select firstname, surname, dateOfBirth from Customer where customerID = ". $_POST['customerID'];

if(!$result = mysqli_query($con, $sql))
{
	die("Error in querying database ". mysqli_error($con));
}

$rowcount = mysqli_affected_rows($con);

$_SESSION['customerID']=$_POST['customerID'];
if($rowcount == 1)
{
	$row = mysqli_fetch_array($result);

	$_SESSION['customerID'] = $row['customerID'];
	$_SESSION['firstname'] = $row['firstname'];
	$_SESSION['surname'] = $row['surname'];
	$_SESSION['dob'] = $row['dateOfBirth'];

}

else if ($rowcount == 0)
{
	echo "no matching records ";
	unset ($_SESSION['firstname']);
	unset ($_SESSION['lastname']);
	unset ($_SESSION['dob']);

}

mysqli_close($con);

//go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: OpenDeposit.html.php");
//or alternately use the following
// echo "<script> window.location.href = 'view.html.php </script> ";
?>
