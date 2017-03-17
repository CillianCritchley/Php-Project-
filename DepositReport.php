<?php
session_start();
include 'db.inc.php';

if(isset($_POST['search']))
{

    session_unset();

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
        $_SESSION['errorVarCustReport'] = "No such Customer found";    }
    $_SESSION['customerID'] = $_POST['customerID'];

} //search if

else if(Isset($_POST['confirm']))
{
    session_unset();


    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened,
  DepositAccount.closed FROM DepositAccount INNER JOIN CustomerAccounts
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
else if(isset($_POST['genReport']))
{
    if($_POST['searchFrom'] == ""  || $_POST['searchTo'] == "")
    {


    session_unset();
    $sql = "select * from Customer where CustomerID = ".$_POST['customerIDHide2'];

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database").mysqli_error($con);
    }

    $row = mysqli_fetch_array($result);
    $_SESSION['customerID'] = $_POST['customerIDHide2'];
    $_SESSION['firstname'] = $row['firstName'];
    $_SESSION['surname'] = $row['surname'];
    $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
    $_SESSION['addressLine1'] = $row['addressLine1'];
    $_SESSION['addressLine2'] = $row['addressLine2'];
    $_SESSION['addTown']  = $row['addTown'];
    $_SESSION['addCounty'] = $row['addCounty'];

    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened,
  DepositAccount.closed FROM DepositAccount INNER JOIN CustomerAccounts
    ON DepositAccount.depositAccountID = CustomerAccounts.accountID
    INNER JOIN Customer ON CustomerAccounts.customerID=Customer.customerID WHERE Customer.customerID = "
        . $_POST['customerIDHide2'] . " AND closed = 0" ;

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }



    $_SESSION['resultsReport'] =  mysqli_fetch_all($result,MYSQLI_ASSOC);



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


    } // else if
}
else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: DepositReport.html.php");


?>

