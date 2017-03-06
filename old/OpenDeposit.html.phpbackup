<?php
session_start();
include 'db.inc.php';
if(ISSET($_POST['submit'])) {

    $_SESSION = array();

    $sql = "select firstname, surname, dateOfBirth from Customer where customerID = " . $_POST['customerID'];
    $result = mysqli_query($con,$sql);
    $rowcount = mysqli_affected_rows($con);
    if($rowcount ==1)
    {
        $row = mysqli_fetch_array($result);
        $_SESSION['customerID'] = $_POST['customerID'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['surname'] = $row['surname'];
        $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
    }
    else if ($rowcount ==0)
    {
        echo "No Matching records";
    }
session_destroy();
mysqli_close($con);
}
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
</head>
<body>

<h1> Amend/View a person </h1>
<h4> Please select a person and then click the amend button if you wish to update </h4>

<?php include 'listbox.php'; ?>
<p id = "display"> </p>

<form name="myForm" action=""  method="post">

    <label for "amendid">Customer Number </label>
    <input type = "text" name = "customerID" id = "customerID"
           value="<?php if(ISSET($_SESSION['customerID'])) echo $_SESSION['customerID'] ?> ">
    <label for "amendfirstname">First Name </label>
    <input type = "text" name = "firstname" id = "firstname" disabled
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?> ">
    <label for "amendlastname">Surname </label>
    <input type = "text" name = "surname" id = "surname" disabled
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?> ">
    <label for "amendDOB">Date of Birth </label>
    <input type = "text" name = "dob" id = "dob" title = "format is dd-mm-yyyy" disabled
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?> ">

    <br><br>
    <input type = "submit" name="submit" value = "Search Customers" >
</form>
<button type="button" onclick="createDepAc()"> Confirm Customer </button>

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
        document.getElementById("dob").value = personDetails[3];
        return false;
    }

    function createDepAc()
    {
        <?php
        include 'db.inc.php';
        if(ISSET($_POST['submit'])) {

            $custid = $_SESSION['customerID'];
            $sql = "select  Max(accountID) from CustomerAccounts ";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($result);
            $max = $row[0];
            $max = $max + 1;

            $sql = "insert into DepositAccount (depositAccountID) values ($max)";
            if(!mysqli_query($con,$sql))
            {
                die ("an error in the Deposit sql query". mysqli_error($con));
            }
            $sql = "insert into CustomerAccounts (customerID, accountID) values ($custid,$max) ";

            if(!mysqli_query($con,$sql))
            {
                die ("an error in the CustomerAccoutns ssql query". mysqli_error($con));
            }
            mysqli_close($con);
        }

        ?>
    }
</script>



</body>
</html>
