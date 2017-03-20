<?php
session_start();
include 'db.inc.php';
/*
 * Grab the specified columns from the row where customerID equals the value posted over from the form
 * on ViewDeposit.html.php and copy the values over into session variables.
 * If no such customer ID exists then the number of rows affected will be 0 and the error message session variable
 * $_SESSION['errorVarCust'] will be initialised. The value assigned to the variable isn' relevant, it's just there
 * for readability. It is used in the func.php file.
 * $_SESSION['accID'] is assigned a blank value here to avoid a situation where the user would use the
 * customerID search and the session variable for accountID from a previous query would still be output to the
 * accountID input field.
 */
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
        $_SESSION['accID'] = "";
    }
    else if ($rowcount ==0)
    {

        $_SESSION['errorVarCust'] = "No such Customer found";

    }

} //Customer Id search if
/*
 * similar to the above query except that as well as getting the deposit account details using the posted accountID,
 * the relevant customer details are fetched too. This allows the input fields on ViewDeposit.html.php to be filled
 * with the correct information without any extra steps needed from the user.
 * The deposit account details are stored in an array because the following section deals with providing
 * details of every deposit account associated with a customer ID. The ViewDeposit.html.php page was set up to
 * deal with an array of information and even though there is only one account being dealt with here (because I
 * am searching by a specific account ID) storing the details in an array of the same name and basic shape as the one
 * below was the best solution.
 * The value assigned to the $_SESSION['errorVarAcc'] variable is again not relevant, it's just there for readability.
 */
else if(isset($_POST['searchAccount']))
{

    session_unset();
    $_SESSION['accID'] = $_POST['accID'];

    $sql = "select Customer.customerID, Customer.firstname, Customer.surname, Customer.dateOfBirth, Customer.addressLine1, Customer.addressLine2
 ,Customer.addTown, Customer.addCounty, DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened,
  DepositAccount.closed from Customer Inner join CustomerAccounts on Customer.customerID = CustomerAccounts.customerID Inner join 
   DepositAccount on CustomerAccounts.accountID = DepositAccount.depositAccountID where depositAccountID = ". $_POST['accID'];

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

        $_SESSION['results'][0] =  array("depositAccountID" => $row['depositAccountID'], "balance" => $row['balance'],
            "date" => $row['dateOpened']);


    }
    else if ($rowcount ==0)
    {

        $_SESSION['errorVarAcc'] = "No such Account found";
    }
} //Account Id search if

/*
 * This section deals with fetching the details of all deposit accounts (that are not closed) associated with
 * a particular customerID. The rows gathered as a result of the query are stored in an associative array stored
 * in a session variable.  If no deposit accounts are associated with a customerID there is code on
 * ViewDeposit.html.php to deal with that.
 */

else if(Isset($_POST['confirm']))
{
    session_unset();


    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened
  FROM DepositAccount INNER JOIN CustomerAccounts
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

}
/*
 * if the user tries to generate a report without selecting a radio button, a function in
 * func.php will send an alert informing the user when this session variable is created.
 */

else if(isset($_POST['ViewDetails']) && !isset($_POST['radio']))
{
    $_SESSION['radioVar'] = "please select a row";
}
/*
 *
 * The value of the radio button that was selected on ViewDeposit.html.php is posted over and is used to
 * query the transactions associated with that account and store them in an array inside a session variable
 * ['trans'].
 *
 */
else if(isset($_POST['ViewDetails']) && isset($_POST['radio']))
{

    $_SESSION['radio'] = $_POST['radio'];

    $sql= "SELECT Transactions.transactionID, Transactions.amount, Transactions.type, Transactions.date from Transactions 
    where accountID = ". $_POST['radio'];

    if(!$result = mysqli_query($con,$sql))
    {
        die("Error in querying database ".mysqli_error($con));
    }
    $_SESSION['trans'] = mysqli_fetch_all($result,MYSQLI_ASSOC);
}
// reset everything on the page

else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables, if a record was found
header("Location: ViewDeposit.html.php");

?>

