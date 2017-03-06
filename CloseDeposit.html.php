<?php session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        form{
            margin: 1em;
            max-width: 500px;
        }
        label{
            display: inline-block;
            width: 9em;
            margin-right: 1em;
            margin-top : 1em;
            text-align: right;
        }
    </style>
    <script>
        function  populate()
        {
            var sel = document.getElementById("listbox");
            var result;
            result = sel.options[sel.selectedIndex].value;
            var personDetails = result.split(',');
            document.getElementById("customerID").value = personDetails[0];
            document.getElementById("firstname").value = personDetails[1];
            document.getElementById("surname").value = personDetails[2];
            document.getElementById("addressLine1").value = personDetails[4];
            document.getElementById("addressLine2").value = personDetails[5];
            document.getElementById("addTown").value = personDetails[6];
            document.getElementById("addCounty").value = personDetails[7];
            document.getElementById("dateOfBirth").value = personDetails[3];

            return false;
        }


    </script>


</head>
<body onload="unset();">

<h1> Close Deposit Account</h1>
<h4> Please select a person from the list or search by Customer Number </h4>

<?php include 'closecustnamesearch.php'; ?>
<p id = "display"> </p>

<form  action="CloseDeposit.php"   method="post">

    <label for "amendid">Customer Number </label>
    <input type = "text" name = "customerID" id = "customerID"
           value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?> ">
    <label for "amendfirstname">First Name </label>
    <input readonly type = "text" name = "firstname" id = "firstname"
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?>  ">
    <label for "amendlastname">Surname </label>
    <input readonly type = "text" name = "surname" id = "surname"
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?> ">
    <label for "amendDOB">Date of Birth </label>
    <input readonly type = "text" name = "dateOfBirth" id = "dateOfBirth" title = "format is dd-mm-yyyy"
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?> ">
    <label for "addressLine1">Address Line 1</label>
    <input readonly type = "text" name = "addressLine1" id = "addressLine1"
           value="<?php if(ISSET($_SESSION['addressLine1'])) echo $_SESSION['addressLine1'] ?> ">
    <label for "addressLine2">Address Line 2 </label>
    <input readonly type = "text" name = "addressLine2" id = "addressLine2"
           value="<?php if(ISSET($_SESSION['addressLine2'])) echo $_SESSION['addressLine2'] ?> ">
    <label for "addTown">Town </label>
    <input readonly type = "text" name = "addTown" id = addTown
           value="<?php if(ISSET($_SESSION['addTown'])) echo $_SESSION['addTown'] ?> ">
    <label for "addCounty">County </label>
    <input readonly type = "text" name = "addCounty" id = "addCounty"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?> ">
    <br><br>
    <input type = "submit" name="search" id="search" value = "Search Customers" >
    <input type="submit"  name="confirm" id="confirm" value="Confirm Customer ">
    <input type="submit"  name="reset" id="reset"  value="reset">


<br><br><br>
    <label for "close1">close1 </label>
    <input readonly type = "text" name = "close1" id = "close1"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?> ">
    <label for "close2">close2 </label>
    <input readonly type = "text" name = "close2" id = "close2"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?> ">
</form>
<?php if(ISSET($_SESSION['results']))
{
    $tempARR = $_SESSION['results'];
    echo "<table>
		<tr> <th> Close Account </th><th> Account ID</th><th>Balance</th><th> Date Opened </th> </tr>";



    {
        foreach($tempARR as $row)
        {

           ?>

            <td> <form name="formstuff" action="CloseDeposit.php" method="post">
                    <input type="hidden" id="personid" name="personid" value="<?php echo $row[0]; ?>">
                    <input type="submit" value="Close" id="closeAcc" name="closeAcc" title="Click here to close the Account">
                </form></td>
    <?php

            foreach($row as $rowItem)
            {
                echo
                    "<td>".$rowItem."</td>";

            }
            echo "</tr>";
        }
        echo "</table>";





 }
}
else{
    echo "";
}
?>
</body>
</html>
