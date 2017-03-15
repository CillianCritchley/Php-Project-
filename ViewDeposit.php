<?php
session_start();
include 'db.inc.php';

if(isset($_POST['searchCustomer']))
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
        $_SESSION['accID'] = "";
    }
    else if ($rowcount ==0)
    {
        $_SESSION['errorVarCust'] = "No such Customer found";

    }

} //Customer Id search if

else if(isset($_POST['searchAccount']))
{

    session_unset();
    $_SESSION['accID'] = $_POST['accID'];

    $sql = "select Customer.customerID, Customer.firstname, Customer.surname, Customer.dateOfBirth, Customer.addressLine1, Customer.addressLine2
 ,Customer.addTown, Customer.addCounty, DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened,
  DepositAccount.closed, Transactions.transactionID, Transactions.amount,  Transactions.type, Transactions.date from Customer Inner join CustomerAccounts on Customer.customerID = CustomerAccounts.customerID Inner join 
   DepositAccount on CustomerAccounts.accountID = DepositAccount.depositAccountID 
   Inner join Transactions on CustomerAccounts.accountID = Transactions.accountID where depositAccountID = ". $_POST['accID'];

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ". mysqli_error($con));
    }

    $rowcount = mysqli_affected_rows($con);

    if($rowcount ==1)
    {
        $row = mysqli_fetch_array($result);
        $_SESSION['customerID'] = $row['customerID'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['surname'] = $row['surname'];
        $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
        $_SESSION['addressLine1'] = $row['addressLine1'];
        $_SESSION['addressLine2'] = $row['addressLine2'];
        $_SESSION['addTown']  = $row['addTown'];
        $_SESSION['addCounty'] = $row['addCounty'];

        $_SESSION['results'][0] =  array("accountID" => $row['depositAccountID'], "balance" => $row['balance'],
            "date" => $row['dateOpened']);
        $_SESSION['tran'][0][0] = array("transactionID" => $row['transactionID'], "amount" => $row['amount'],
            "type"  => $row['type'], "date" => $row['date']);

    }
    else if ($rowcount ==0)
    {
        $_SESSION['errorVarAcc'] = "No such Account found";
    }

} //Account Id search if
else if(Isset($_POST['confirm']))
{
    session_unset();


    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened FROM DepositAccount INNER JOIN CustomerAccounts
    ON DepositAccount.depositAccountID = CustomerAccounts.accountID
    INNER JOIN Customer ON CustomerAccounts.customerID=Customer.customerID
     WHERE Customer.customerID = " . $_POST['customerIDHide'] . " AND closed = 0" ;

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

   $_SESSION['results'] =  mysqli_fetch_all($result,MYSQLI_ASSOC);
   $index=0;

    foreach($_SESSION['results'] as $arrRow)
    {
        $sql = "Select * from Transactions where accountID = " . $_SESSION['results'][$index]['depositAccountID'] . "
         order by transactionID desc limit 4";

        if(!$transactions = mysqli_query($con,$sql))
        {
            die("Error in querying database ".mysqli_error($con));
        }
        $transactions = mysqli_fetch_all($transactions,MYSQLI_ASSOC);
        $_SESSION['tran'][$index] = $transactions;

        $index++;


    }


}


else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: ViewDeposit.html.php");

?>

