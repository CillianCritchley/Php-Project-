<?php
session_start();
include 'db.inc.php';

if(isset($_POST['searchCustomer']))
{

    session_unset();
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
        $_SESSION['errorVarCust'] = "No such Customer found";    }

} //search if
/*
 * This section deals with fetching the details of all deposit accounts (that are not closed) associated with
 * a particular customerID. The rows gathered as a result of the query are stored in an associative array stored
 * in a session variable.  If no deposit accounts are associated with a customerID there is code on
 * DepositReport.html.php to deal with that.
 */
else if(Isset($_POST['confirm']))
{
    session_unset();


    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened FROM DepositAccount INNER JOIN CustomerAccounts
    ON DepositAccount.depositAccountID = CustomerAccounts.accountID
    INNER JOIN Customer ON CustomerAccounts.customerID=Customer.customerID WHERE Customer.customerID = " . $_POST['customerIDHide'] . " AND closed = 0" ;

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }


    $_SESSION['customerID'] = $_POST['customerIDHide'];
    $_SESSION['firstname'] = $_POST['firstname'];
    $_SESSION['surname'] = $_POST['surname'];
    $_SESSION['addressLine1'] = $_POST['addressLine1'];
    $_SESSION['addressLine2'] = $_POST['addressLine2'];
    $_SESSION['addTown'] = $_POST['addTown'];
    $_SESSION['addCounty'] = $_POST['addCounty'];
    $_SESSION['dateOfBirth'] = $_POST['dateOfBirth'];

   $_SESSION['resultsReport'] =  mysqli_fetch_all($result,MYSQLI_ASSOC);



}
/*
 * if the user tries to generate a report without selecting a radio button, a function in
 * func.php will send an alert informing the user when this session variable is created.
 */

else if(isset($_POST['genReport']) && !isset($_POST['radio']))
{
    $_SESSION['radioVar'] = "please select a row";
}
/*
 * If either of the two input fields that are used to search
 * for transactions between two specified dates are left blank the report generated includes all transactions
 * found in the database for that account.
 * The value of the radio button that was selected on DepositReport.html.php is posted over and is used to
 * query the transactions associated with that account and store them in an array inside a session variable
 * ['trans'].
 * If the options to search between two dates those dates are used in the query below to only receive the
 * transactions in between the beginning and end point of the dates queried.
 */
else if(isset($_POST['genReport']) && isset($_POST['radio']))
{
    $_SESSION['radio'] = $_POST['radio'];

    if($_POST['searchFrom'] == ""  || $_POST['searchTo'] == "")
    {

    $sql= "SELECT Transactions.transactionID, Transactions.amount, Transactions.type, Transactions.date from Transactions 
    where accountID = ". $_POST['radio'];

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }
    $_SESSION['trans'] = mysqli_fetch_all($result,MYSQLI_ASSOC);
    } // blank date if
    else{
        $sql= "SELECT Transactions.transactionID, Transactions.amount, Transactions.type, Transactions.date from Transactions 
    where date between '$_POST[searchFrom]' AND '$_POST[searchTo]' and accountID = ". $_POST['radio'];

        if(!$result = mysqli_query($con,$sql))
        {
            die("Error in querying database ".mysqli_error($con));
        }
        $_SESSION['trans'] = mysqli_fetch_all($result,MYSQLI_ASSOC);


    } // search between dates else
}
// reset everything on the page
else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables
header("Location: DepositReport.html.php");


?>

