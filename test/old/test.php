<?php
session_start();
include 'db.inc.php';


$sql = "UPDATE LoanAccount SET balance = '2', loanAmount = '3', 
term = '2', monthlyPayment = '2' 
WHERE loanAccountID = " . 6 ;
if(!mysqli_query($con, $sql))
{
    die ("rror".mysqli_error($con));
}

mysqli_close($con);

?>

