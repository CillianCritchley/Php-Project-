<?php
session_start();
error_reporting(0);

include 'db.inc.php';
if(!ISSET($_POST['submit'])) {
    $sql = "select MAX(CustomerAccounts.accountID) from CustomerAccounts ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
        $_SESSION['accountID'] = $row['MAX(CustomerAccounts.accountID)'];
        $_SESSION['accountID'] = $_SESSION['accountID'] + 1;

}
else if(isset($_POST['submit'])) {
    $sql = "select firstname, surname, dateOfBirth, addressLine1, addressLine2, addTown, addCounty
 , MAX(CustomerAccounts.accountID)from Customer JOIN CustomerAccounts where Customer.customerID = " . $_POST['customerID'];
    error_reporting(1);
    $result = mysqli_query($con, $sql);
    $rowcount = mysqli_affected_rows($con);
    if ($rowcount == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['customerID'] = $_POST['customerID'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['surname'] = $row['surname'];
        $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
        $_SESSION['addressLine1'] = $row['addressLine1'];
        $_SESSION['addressLine2'] = $row['addressLine2'];
        $_SESSION['addTown'] = $row['addTown'];
        $_SESSION['addCounty'] = $row['addCounty'];
        $_SESSION['accountID'] = $row['MAX(CustomerAccounts.accountID)'];
        $_SESSION['accountID'] = $_SESSION['accountID'] + 1;
    } else if ($rowcount == 0) {
        echo "No Matching records";
    }

session_destroy();

mysqli_close($con);
}

?>

<!DOCTYPE html>
<html>
<body>
<head>
    <script>
        function  populate()
        {
            var sel = document.getElementById("listbox");
            var result;
            result = sel.options[sel.selectedIndex].value;
            var personDetails = result.split(',');
            document.getElementById("customerID").value = personDetails[0];
            document.getElementById("custID").value = personDetails[0];
            document.getElementById("firstname").value = personDetails[1];
            document.getElementById("surname").value = personDetails[2];
            document.getElementById("dob").value = personDetails[3];
            document.getElementById("addressLine1").value = personDetails[4];
            document.getElementById("addressLine2").value = personDetails[5];
            document.getElementById("addTown").value = personDetails[6];
            document.getElementById("addCounty").value = personDetails[7];

            return false;
        }


        function unLock()
        {
            document.getElementById("deposit").disabled=false;
            document.getElementById("accountID").value="<?php if(ISSET($_SESSION['accountID'])) echo $_SESSION['accountID']  ?>";
        }

        function resetForm()
        {
            document.getElementById("customerID").value="";
            document.getElementById("firstname").value="";
            document.getElementById("surname").value="";
            document.getElementById("addressLine1").value="";
            document.getElementById("addressLine2").value="";
            document.getElementById("addTown").value="";
            document.getElementById("addCounty").value="";
            document.getElementById("dob").value="";
        }

        function createDepAc()
        {
            <?php
            include 'db.inc.php';
            if(ISSET($_POST['createButton']) ) {

                $custid = $_POST['custID'];

                $max = $_SESSION['accountID'];


                $sql = "insert into DepositAccount (depositAccountID,balance) values ($max,$custid)";
                if(!mysqli_query($con,$sql))
                {
                    die ("an error in the Deposit sql query". mysqli_error($con));
                }
                $sql = "insert into CustomerAccounts (customerID, accountID) values ($custid,$max)";

                if(!mysqli_query($con,$sql))
                {
                    die ("an error in the CustomerAccounts sql query". mysqli_error($con));
                }

                mysqli_close($con);

            } //if
            ?>
        }
    </script>

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
        }
    </style>
    <link rel="stylesheet" href="Cillian.css" type="text/css">


</head>

<div id="top">
<h1 > Deposit Account - Open</h1>
<h4 id="headertext"> Please select a person from the drop down list or search using their customer number </h4>
</div>
<div id="midleft"></div>
<div id="midcen1">
    <div id="textbox">
    <h3> Select Customer from drop down list on left or use the Customer Id field to search</h3>
    </div>

    <p> &nbsp;</p>
    <form name="myForm" action=""   method="post">
        <p class="alignleft"> <?php include 'listbox.php'; ?> </p>


<div class="alignright">    <label for "customerID">Customer Number </label>
    <input type = "text" name = "customerID" id = "customerID"
           value="<?php if(ISSET($_SESSION['customerID'])) echo $_SESSION['customerID'] ?> ">

    <br>
    <label for "firstname">First Name </label>
    <input type = "text" name = "firstname" id = "firstname" disabled
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?> ">
    <label for "surname">Surname </label>
    <input type = "text" name = "surname" id = "surname" disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?> ">
    <label for "dateOfBirth">Date of Birth </label>
    <input type = "text" name = "dob" id = "dob" title = "format is dd-mm-yyyy" disabled
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?> ">
    <label for "addressLine1">Address Line 1</label>
    <input type = "text" name = "addressLine1" id = "addressLine1" disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['addressLine1'] ?> ">
    <label for "addressLine2">Address Line 2 </label>
    <input type = "text" name = "addressLine2" id = "addressLine2" disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['addressLine2'] ?> ">
    <label for "addTown">Town </label>
    <input type = "text" name = "addTown" id = addTown disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['addTown'] ?> ">
    <label for "addCounty">County </label>
    <input type = "text" name = "addCounty" id = "addCounty" disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['addCounty'] ?> ">
</div>
    <br><br>
    <div style="clear: both;"></div>

<div class="aligncenter">

    <input type = "submit" name="submit" value = "Search Customers" >
            <br>
    <input type="button" onclick="resetForm()" value="clear form">
<br>
    <form name="unlock" action="" >
        <button type="button" onclick="unLock()" id="confirm"   name="confirm" value="Confirm Customer "> Confirm </button>
        </form>
</div>

    <br> <br>

</form>
</div>


<div id="midcen2">

    <form name="accountForm" action=""   onsubmit="createDepAc()" method="post">


<div class="alignright">    <label for "customerID">Account Number </label>
    <input type = "text" name = "accountID" id = "accountID" disabled>

    <br>
    <label for "balance">Enter Opening Deposit </label>
    <input type = "text" name = "deposit" id = "deposit" disabled>
    <input type = "hidden" name="custID" id="custID"
           value="<?php if(ISSET($_SESSION['customerID'])) echo $_SESSION['customerID'] ; ?>" >
    <br><br>
    <div style="clear: both;"></div>

<div class="aligncenter">

<input type="submit" id="createButton"  name="createButton" value="Create Account ">
</div>


</form>
</div>

<!--
<div id="midright"></div>
-->

</body>
</html>
