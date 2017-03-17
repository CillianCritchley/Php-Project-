<?php session_start();
if((isset($_SESSION['errorVarAcc']) || isset($_SESSION['errorVarCust']) || isset($_SESSION['customerID']))  && $_SERVER['HTTP_REFERER'] != 'http://localhost/proj/CloseDeposit.html.php')
{
    $_SESSION = array();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="Cillian.css" type="text/css">

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
            document.getElementById("customerIDHide").value = personDetails[0];

            document.getElementById("firstname").value = personDetails[1];
            document.getElementById("surname").value = personDetails[2];
            document.getElementById("addressLine1").value = personDetails[4];
            document.getElementById("addressLine2").value = personDetails[5];
            document.getElementById("addTown").value = personDetails[6];
            document.getElementById("addCounty").value = personDetails[7];
            document.getElementById("dateOfBirth").value = personDetails[3];

            return false;
        }

        function checkEmpty(button)
        {
            var cus = document.getElementById("customerID").value;
            var acc = document.getElementById("accID").value;

           if(button == "searchCustomer" && cus == "")
           {
               alert("cannot submit empty field");
               return false
           }
           else if(button == "searchAccount" && acc == "")
            {
                alert("cannot submit empty field");
                return false;
            }
           else{
               return true;
           }
        }
        window.onload = function(){

            document.getElementById('listbox').selectedIndex = -1;
            <?php if(isset($_SESSION['errorVarCust'])) { ?> alert("Customer ID " + <?php echo $_SESSION['customerID'] ?> +
                    " does not exist");  <?php session_unset();}?>
            <?php if(isset($_SESSION['errorVarAcc'])) { ?> alert("Account ID " + <?php echo $_SESSION['accID'] ?> +
                    " does not exist or is not a Deposit Account");  <?php session_unset();}?>
        }

    </script>


</head>
<body >
<div id="top">
<h1> Close Deposit Account</h1>

    <h4> Please select a person from the list or search by Customer Number </h4>
</div>
<div id="mid">

        <div id="left" > <form  action="CloseDeposit.php"   onsubmit="return checkEmpty(this.submited);" method="post">
            <table>
                <tr> <td>
                        <font size="5">  Select Name From List </font> </td> </tr>
                <tr>
                    <td> <?php include 'closecustnamesearch.php'; ?> Or
                    </td> </tr>
                <tr> <td>  <label for "customerID" > Search By Customer ID </label>
                    </td> </tr>

                <tr> <td>    <input class="InputAddOn-field"  pattern="[0-9]{1,}" title="numeric only" type = "text" name = "customerID" id = "customerID"
                                    value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
                    </td></tr>
                <tr> <td>      <button type="submit" onclick="this.form.submited=this.name;" name="searchCustomer" id="searchCustomer" class="InputAddOn-item"> Search by Customer Number</button>
                    </td></tr>
                <tr> <td>     <tr> <td>  <label for "accountID" > Search By Account ID </label>
                    </td> </tr></td></tr>
                <tr> <td>    <input class="InputAddOn-field"  pattern="[0-9]{1,}" title="numeric only" type = "text" name = "accID" id = "accID"
                                    value="<?php if(ISSET($_SESSION['accID'])) echo htmlspecialchars($_SESSION['accID'])?>">
                    </td></tr>

                <tr> <td>      <button type="submit" onclick="this.form.submited=this.name;" name="searchAccount" id="searchAccount" class="InputAddOn-item"> Search by Account Number</button>
                    </td></tr>
                <tr> <td> <?php if(isset($_SESSION['errorVarAcc'])) echo $_SESSION['errorVarAcc']?> </td></tr>
            </table>
        </form> </div>

<div id="midleft">

<form  action="CloseDeposit.php"   id="ConfirmReset" method="post">

    <input type = "hidden" name = "customerIDHide" id = "customerIDHide"
           value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
    <label for "amendfirstname">First Name </label>
    <input readonly type = "text" name = "firstname" id = "firstname"
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?>">
    <label for "amendlastname">Surname </label>
    <input readonly type = "text" name = "surname" id = "surname"
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?>">
    <label for "amendDOB">Date of Birth </label>
    <input readonly type = "text" name = "dateOfBirth" id = "dateOfBirth" title = "format is dd-mm-yyyy"
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?>">
    <label for "addressLine1">Address Line 1</label>
    <input readonly type = "text" name = "addressLine1" id = "addressLine1"
           value="<?php if(ISSET($_SESSION['addressLine1'])) echo $_SESSION['addressLine1'] ?>">
    <label for "addressLine2">Address Line 2 </label>
    <input readonly type = "text" name = "addressLine2" id = "addressLine2"
           value="<?php if(ISSET($_SESSION['addressLine2'])) echo $_SESSION['addressLine2'] ?>">
    <label for "addTown">Town </label>
    <input readonly type = "text" name = "addTown" id = addTown
           value="<?php if(ISSET($_SESSION['addTown'])) echo $_SESSION['addTown'] ?>">
    <label for "addCounty">County </label>
    <input readonly type = "text" name = "addCounty" id = "addCounty"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?>">
    <br><br>
    <input type="submit"  name="confirm" id="confirm" value="Confirm Customer ">

        <input type="submit"  name="reset" id="reset"  value="reset">

<br><br><br>

</form>
</div>
<div id="right">
<div id="rightleft">
<?php

 if(isset($_SESSION['closeVar'])) {
    echo "  <script> alert( \"$_SESSION[closeVar]\" );
                                 
                </script>
                 ";
    unset($_SESSION['closeVar']);
}


if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) > 0 )
{
    $tempARR = $_SESSION['results'];
    echo "<table>
		<tr> <th> Close Account </th><th> Account ID</th><th>Balance</th><th> Date Opened </th> </tr>";



    {
        $index=0;
        foreach($tempARR as $row)
        {

           ?>

         <tr>  <td> <form name="CloseDepositForm" id="CloseDepositForm" action="CloseDeposit.php" method="post">

                    <input type="hidden" id="depAccID" name="depAccID" value="<?php echo $row['depositAccountID']; ?>">
                    <input type="hidden" id="balance" name="balance" value="<?php echo $row['balance']; ?>">
                    <input type="hidden" id="index" name="index" value="<?php echo $index; ?>">
                    <input type="submit" value="Close" id="closeAcc" name="closeAcc" title="Click here to close the Account">
                </form></td>
    <?php

            foreach($row as $rowItem)
            {
                echo
                    "<td>".$rowItem."</td>";

            }
            echo "</tr>";
            ?>
            <tr> <td>


            </td></tr>

    <?php
            $index++;
        }
        echo "</table>";





 }
}
else if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) == 0 )
{
    echo "Customer has no Deposit Accounts";
}
else{
    echo "";
}
?>
</div>  <!-- div id ="rightleft"> -->
</div> <!--  <div id="right"> -->

    </div>  <!-- <div id="mid"> -->

</body>
</html>
