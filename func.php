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

?>

