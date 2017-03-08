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
    $_SESSION = array();


    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened,
  DepositAccount.closed FROM DepositAccount INNER JOIN CustomerAccounts
    ON DepositAccount.depositAccountID = CustomerAccounts.accountID
    INNER JOIN Customer ON CustomerAccounts.customerID=Customer.customerID WHERE Customer.customerID = " . $_POST['customerID'] . " AND closed = 0" ;

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }


    $_SESSION['customerID'] = $_POST['customerID'];
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
        $sql = "Select * from Transactions where accountID = " . $_SESSION['results'][$index]['depositAccountID'];

        if(!$transactions = mysqli_query($con,$sql))
        {
            die("Error in querying database ".mysqli_error($con));
        }
        $transactions = mysqli_fetch_all($transactions,MYSQLI_ASSOC);
        $_SESSION['tran'][$index] = $transactions;
        foreach($_SESSION['tran'][$index] as $complication) {
            echo $complication['transactionID'] . " ";
        }
        echo "<br>";
        $index++;

     /*   $transactions = mysqli_fetch_array($transactions);
        $_SESSION['tran'][$index] = array('transactionID' => $transactions[0], 'accountID' => $transactions[1],
            'amount' => $transactions[2], 'type' => $transactions[3], 'date' => $transactions[4]);
        echo $_SESSION['tran'][$index]['transactionID']."<br>";
        $index++;
     */
    }
   // echo $_SESSION['tran'][$index]['transactionID'];

// need  rows from transactions table relating to accountID

}
else if(isset($_POST['closeAcc'])) {

    $sql = "update DepositAccount set closed=1 WHERE depositAccountID = " . $_POST['depAccID'];
   if(! mysqli_query($con,$sql)){
       die("Error closing Deposit Account".mysqli_error($con));
   }
    $_SESSION = array();
}

else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: ViewDeposit.html.php");
//or alternately use the following
// echo "<script> window.location.href = 'view.html.php </script> ";

/*
$index = 0;
while($row = mysqli_fetch_array($result))
{
//    echo $row['depositAccountID'] ." " . $row['balance'] . " " ;
//  echo "<br>";
$_SESSION['results'][$index] = array('accountID' => $row[0], 'balance' => $row[1], 'dateOpened' => $row[2]);
$_SESSION['transactions'][$index] = array('tran1') =
$index++;

} */

?>

