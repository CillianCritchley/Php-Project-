<?php
include "db.inc.php"; //database connection

$sql = "SELECT  Customer.customerID, Customer.firstName, Customer.surname, Customer.addressLine1, Customer.addressLine2, Customer.addTown, Customer.addCounty, 
Customer.dateOfBirth, DepositAccount.depositAccountID, DepositAccount.balance, DepositAccount.closed FROM Customer INNER JOIN CustomerAccounts ON Customer.customerID=CustomerAccounts.customerID 
INNER JOIN DepositAccount ON CustomerAccounts.accountID=DepositAccount.depositAccountID  AND deleted IN ('0') GROUP BY surname";

$result = mysqli_query($con,$sql);

if(!$result = mysqli_query($con,$sql))
{
	die( ' Error in querying the datbase'.mysqli_error($con));
}

echo "<br><select name = 'listbox' id = 'listbox' onclick = 'populate()'>";

while ($row = mysqli_fetch_array($result))
{
	$id = $row['customerID'];
	$fname = $row['firstName'];
	$sname = $row['surname'];
	$dob   = date_create($row['dateOfBirth']);
	$dob   = date_format($dob,"d-m-Y");
	$address1 = $row['addressLine1'];
	$address2 = $row['addressLine2'];
	$town  = $row['addTown'];
	$county = $row['addCounty'];
	$allText = "$id,$fname,$sname,$dob,$address1,$address2,$town,$county";
	echo "<option value = '$allText'> $sname,  $fname </option>";

}
echo "</select>";
mysqli_close($con);

?>