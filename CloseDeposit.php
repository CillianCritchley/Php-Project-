<?php
session_start();
include 'db.inc.php';
/*
 * Grab the specified columns from the row where customerID equals the value posted over from the form
 * on CloseDeposit.html.php and copy the values over into session variables.
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
 * the relevant customer details are fetched too. This allows the input fields on CloseDeposit.html.php to be filled
 * with the correct information without any extra steps needed from the user.
 * The deposit account details are stored in an array because the following section deals with providing
 * details of every deposit account associated with a customer ID. The CloseDeposit.html.php page was set up to
 * deal with an array of information and even though there is only one account being dealt with here (because I
 * am searching by a specific account ID) storing the details in an array of the same name and basic shape as the one
 * below was the best solution.
 * The value assigned to the $_SESSION['errorVarAcc'] variable is again not relevant, it's just there for readability.
 */
else if(isset($_POST['searchAccount']))
{
    session_unset();
    $_SESSION['accID'] = $_POST['accID'];

    $sql = "select Customer.customerID, Customer.firstname, Customer.surname, Customer.dateOfBirth, 
    Customer.addressLine1, Customer.addressLine2, Customer.addTown, Customer.addCounty, DepositAccount.depositAccountID,
     DepositAccount.balance,DepositAccount.dateOpened, DepositAccount.closed from Customer 
     Inner join CustomerAccounts on Customer.customerID = CustomerAccounts.customerID Inner join 
     DepositAccount on CustomerAccounts.accountID = DepositAccount.depositAccountID 
      where depositAccountID = ". $_POST['accID'];

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
 * CloseDeposit.html.php to deal with that.
 */
else if(Isset($_POST['confirm']))
{

    session_unset();

    $sql=" SELECT  DepositAccount.depositAccountID, DepositAccount.balance,DepositAccount.dateOpened FROM DepositAccount INNER JOIN CustomerAccounts 
    ON DepositAccount.depositAccountID = CustomerAccounts.accountID
    INNER JOIN Customer ON CustomerAccounts.customerID=Customer.customerID WHERE Customer.customerID = "
        . $_POST['customerIDHide']. " AND closed = 0" ;

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
 * have to check if there exists a session variable ['results'] here because otherwise checking if the balance is
 * equal to 0 results in an error being displayed up until the code gets to the point where it creates
 * $_SESSION['results'].
 * The index position of the ['results'] array is posted over from CloseDeposit.html.php by a value stored in a
 * field in the form associated with the 'Close' button.
 * Unlike above the value assigned to $_SESSION['closeVar'] is not just for readability. The same variable
 * is being used to account for two potential messages, a successful account closing and the alternative.
 * The relevant code is in func.php.
 *
 */
else if(isset($_POST['closeAcc'])) {

    if(isset($_SESSION['results']) && $_SESSION['results'][$_POST['index']]['balance'] == 0 )
    {
        $sql = "update DepositAccount set closed=1 WHERE depositAccountID = " . $_POST['depAccID'];
       if(! mysqli_query($con,$sql)){
           die("Error closing Deposit Account ".mysqli_error($con));
       }
        $_SESSION['closeVar'] = "Account $_POST[depAccID] Closed";
       /*
        * if the account to be closed is the first one in the array, a simple array shift
        * http://php.net/manual/en/function.array-shift.php
        * will left shift all following values and reduce the size of the array by one.
        * If this account to be closed is anywhere else array_slice
        *  http://php.net/manual/en/function.array-slice.php
        * will have to be used to move all values in array $_SESSION['results] from index 0 to index $_POST['index']
        * into a temporary array $tempARR1.
        * A for loop is then used to push
        * (array_push) http://php.net/manual/en/function.array-push.php
        * each element in $_SESSION['results'] following that at index $_POST['index'] onto the end of $tempARR1.
        * The array stored in $_SESSION['results'] is then overwritten with the one stored in $tempARR1.
        * Doing this means that when header sends us back to CloseDeposit.html.php the list of deposit accounts in
        * the rightmost pane will be accurate, instead of still showing a record of the account that was just closed.
        */

       
        if($_POST['index'] == 0)
        {
        array_shift($_SESSION['results']);
        }
        else{
            $tempARR1 = array_slice($_SESSION['results'],0, $_POST['index']);
            for($index = $_POST['index'] +1;$index<count($_SESSION['results']);$index++)
            {
                array_push($tempARR1,$_SESSION['results'][$index]);
            }
            $_SESSION['results'] = $tempARR1;
        }
    }
    else{
        $_SESSION['closeVar'] = "Account $_POST[depAccID] not empty , balance is $_POST[balance]";
    }

}
/*
 * unsets every session variable.
 */
else if(isset($_POST['reset'])){

session_unset();
}
    //go back to the calling form - with the values that we need to display in sessions variables
header("Location: CloseDeposit.html.php");

?>