<?php
session_start();
include 'db.inc.php';
/*
 * Grab the specified columns from the row where customerID equals the value posted over from the form
 * on OpenDeposit.html.php and copy the values over into session variables.
 * If no such customer ID exists then the number of rows affected will be 0 and the error message session variable
 * $_SESSION['errorVarCust'] will be initialised. The value assigned to the variable isn' relevant, it's just there
 * for readability. It is used in the func.php file.
 *
 */
if(isset($_POST['searchCustomer']))
{
    $_SESSION['customerID'] = $_POST['customerID'];


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
        $_SESSION['errorVarCust'] = "No such Customer found";
    }

} //search if

/*
 * Query the database to find the latest/highest/most recent accountID from the CustomerAccounts table
 * and then add one to it to create the next available accountID.
 */
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
    $_SESSION['customerID'] = $_POST['customerIDHide'];
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['surname'] = $_POST['surname'];
    $_SESSION['addressLine1'] = $_POST['addressLine1'];
    $_SESSION['addressLine2'] = $_POST['addressLine2'];
    $_SESSION['addTown'] = $_POST['addTown'];
    $_SESSION['addCounty'] = $_POST['addCounty'];
    $_SESSION['dateOfBirth'] = $_POST['dateOfBirth'];


}

/*
 *
 * Insert into the deposit account the next accountID, the opening deposit and the date of the transaction (today)
 * Insert into CustomerAccounts the customerID of the customer and the accountID of the account to be created
 * Find the next available transactionID in preperation for inserting into the transaction table
 * Insert into the transaction table the relevant details (next available ID, the accountID, the transaction type
 * , the amount and the date.
 * clear the session to prevent any potential errors from the user clicking add deposit again or anything of that
 * nature
 */
else if(isset($_POST['addDeposit'])) {
    $date = date("Y-m-d");
    $sql = "insert into DepositAccount (depositAccountID, balance, dateOpened) values ($_SESSION[nextaccountID],$_POST[deposit],
    NOW()) ";
    if (!mysqli_query($con, $sql)) {
        die("error connecting to depositaccount table " . mysqli_error($con));
    }
    $sql = "Insert into CustomerAccounts (customerID, accountID) values ($_SESSION[customerID],$_SESSION[nextaccountID] )";
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
    \"Lodgement\",$_POST[deposit], NOW())";

    if (!$result = mysqli_query($con, $sql)) {
        die("error connecting to Transactions table " . mysqli_error($con));
    }

    session_unset();
}
//reset everything on the page
else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: OpenDeposit.html.php");


?>