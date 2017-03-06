<?php
include "db.inc.php"; //database connection

$sql = "SELECT customerID, firstname, surname, dateOfBirth, addressLine1,
 addressLine2, addTown, addCounty from Customer order by surname asc ";

$result = mysqli_query($con,$sql);

if(!$result = mysqli_query($con,$sql))
{
	die( ' Error in querying the datbase'.mysqli_error($con));
}

echo "<br><select name = 'listbox' id = 'listbox' onclick = 'populate()'>";

while ($row = mysqli_fetch_array($result))
{
	$id = $row['customerID'];
	$fname = $row['firstname'];
	$sname = $row['surname'];
	$dob   = date_create($row['dateOfBirth']);
	$dob   = date_format($dob,"d-m-Y");
	$address1 = $row['addressLine1'];
	$address2 = $row['addressLine2'];
	$town  = $row['addTown'];
	$county = $row['addCounty'];
	$allText = "$id,$fname,$sname,$dob, $address1, $address2, $town, $county";
	echo "<option value = '$allText'> $sname,  $fname </option>";

}
echo "</select>";
mysqli_close($con);

?>