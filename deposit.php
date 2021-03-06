<?php
session_start();
include 'db.inc.php';

if(isset($_POST['search']))
{


    $sql = "select firstname, surname, dateOfBirth, addressLine1, addressLine2
 ,addTown, addCounty from Customer where customerID = " . $_POST['customerID'];

if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ". mysqli_error($con));
    }

    $rowcount = mysqli_affected_rows($con);

if($rowcount ==1)
    {
        $row = mysqli_fetch_array($result);
        $_SESSION['customerID'] = $_POST['customerID'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['surname'] = $row['surname'];
        $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
        $_SESSION['addressLine1'] = $row['addressLine1'];
        $_SESSION['addressLine2'] = $row['addressLine2'];
        $_SESSION['addTown']  = $row['addTown'];
        $_SESSION['addCounty'] = $row['addCounty'];


    }
    else if ($rowcount ==0)
    {
        echo "No Matching records";
    }

} //search if

else if(Isset($_POST['confirm']))
{
    $sql = "select MAX(CustomerAccounts.accountID) from CustomerAccounts";

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }

    $row = mysqli_fetch_array($result);
    $max = $row[0];
    $_SESSION['nextaccountID'] = $max + 1;
    $_SESSION['customerID'] = $_POST['customerID'];
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['surname'] = $_POST['surname'];
    $_SESSION['addressLine1'] = $_POST['addressLine1'];
    $_SESSION['addressLine2'] = $_POST['addressLine2'];
    $_SESSION['addTown'] = $_POST['addTown'];
    $_SESSION['addCounty'] = $_POST['addCounty'];
    $_SESSION['dateOfBirth'] = $_POST['dateOfBirth'];


}
else if(isset($_POST['addDeposit'])) {
    $date = date("Y-m-d");
    $sql = "insert into DepositAccount (depositAccountID, balance, dateOpened) values ($_SESSION[nextaccountID],$_POST[deposit],
    NOW()) ";
    if (!mysqli_query($con, $sql)) {
        die("error connecting to depositaccount table " . mysqli_error($con));
    }
    $sql = "Insert into CustomerAccounts (customerID, accountID) values ($_SESSION[customerID],$_SESSION[nextaccountID])";
    if (!mysqli_query($con, $sql)) {
        die("error connecting to CustomerAccounts table " . mysqli_error($con));
    }
    $sql = "select max(transactionID + 1) from Transactions ";
    if (!$result = mysqli_query($con, $sql)) {
        die("error Generating account number " . mysqli_error($con));
    }
    $row = mysqli_fetch_array($result);
    $max = $row[0];

    $sql = " Insert into Transactions (transactionID, accountID, type, amount, date) values ($max,$_SESSION[nextaccountID],
    \"withdrawal\",$_POST[deposit], NOW())";

    if (!$result = mysqli_query($con, $sql)) {
        die("error connecting to Transactions table " . mysqli_error($con));
    }

    $_SESSION = array();
}

else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: OpenDeposit.html.php");
//or alternately use the following
// echo "<script> window.location.href = 'view.html.php </script> ";


?>