<?php
/*
 * if when searching using a customerID or an accountID no such ID exists, one of these messages is alerted
 */
if(isset($_SESSION['errorVarCust']))
{
echo "<script> alert(\"Customer ID " . $_SESSION['customerID']  . " does not exist\" ); </script> ";
session_unset();
}

if(isset($_SESSION['errorVarAcc'])) {
echo "<script> alert(\"Account ID " . $_SESSION['accID'] .
    " does not exist or is not a Deposit Account\"); </script> ";
session_unset();
}


/*
checks if a session variable was created to store a message about an attempt made to close an account
and sends it to an alert if one exists
see CloseDeposit.php for more details

*/
if(isset($_SESSION['closeVar'])) {
    echo "  <script> alert( \"$_SESSION[closeVar]\" );
                                 
                </script>
                 ";
    unset($_SESSION['closeVar']);
}

/*
 * on DepositReport.html.php if the user tries to generate a report without selecting a radio button
 * this alert will appear.
 */
if(isset($_SESSION['radioVar']))
{
    echo "<script> alert(\"Please select a row\") </script>";
    unset($_SESSION['radioVar']);
}
?>


