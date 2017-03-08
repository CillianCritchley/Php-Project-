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

        function fillTable(id)
        {
           if(document.getElementById("" + id + 1).style.display=='none') {
               document.getElementById("" + id + 1).style.display = 'table-row';
           }
           else{
               document.getElementById("" + id + 1).style.display = 'none';
           }
        }

    </script>


</head>
<body onload="unset();">

<h1> View Deposit Account</h1>
<h4> Please select a person from the list or search by Customer Number </h4>

<?php include 'reportcustnamesearch.php'; ?>
<p id = "display"> </p>

<form  action="DepositReport.php"   method="post">

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

</form>
<?php if(ISSET($_SESSION['results']))
{
    $tempARR = $_SESSION['results'];
    $trans = $_SESSION['tran'];
    echo "<table>
		<tr> <th> Account ID</th><th>Balance</th><th> Date Opened </th> </tr>";



    {
        $index=1;

        foreach($tempARR as $row)
        {
           ?>
            <!-- table row for each row in the $tempARR array -->
          <!-- <tr onclick="fillTable( php echo $index ) -->
           <tr onclick="fillTable(<?php echo $index ?>)" id="<?php echo $index ?>">

    <?php
            foreach($row as $rowItem)
            {
                // fill each column of the row
                echo
                    "<td>".$rowItem."</td>";

            }   //inner loop

            // end of table row
            echo "</tr>";

            ?>

            <tr id="<?php echo $index ?>1" style="display: none;">
            <td colspan=100%>
            <table>

                <tr> <th> Transaction ID</th> <th> Amount </th> <th> Date </th> <th> Type</th> </tr>

                <!-- for each loop to fill transaction details should go here I think -->
                <?php
                foreach($trans[$index-1] as $transactionindex)
                {
                    echo "<tr> 
                            <td> ". $transactionindex['transactionID'] . "</td>
                            <td> " . $transactionindex['amount'] . "</td>
                            <td> " . $transactionindex['date'] . "</td>
                            <td> " . $transactionindex['type'] . "</td>
                          </tr>";
                }
                echo "</table> </td> </tr>";
                ?>


<?php
            $index++;

        }    // outer loop
        echo "</table>";





 }
}
else{
    echo "";
}
?>
</body>
</html>
