<?php
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
 at
 else if(isset($_POST['closeAcc']))

*/
if(isset($_SESSION['closeVar'])) {
    echo "  <script> alert( \"$_SESSION[closeVar]\" );
                                 
                </script>
                 ";
    unset($_SESSION['closeVar']);
}

?>

