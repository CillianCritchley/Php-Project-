<?php session_start();

if(isset($_SESSION['customerID']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/proj/OpenDeposit.html.php')
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
            document.getElementById("firstname").value = personDetails[1];
            document.getElementById("surname").value = personDetails[2];
            document.getElementById("addressLine1").value = personDetails[4];
            document.getElementById("addressLine2").value = personDetails[5];
            document.getElementById("addTown").value = personDetails[6];
            document.getElementById("addCounty").value = personDetails[7];
            document.getElementById("dateOfBirth").value = personDetails[3];

            return false;
        }

        window.onload = function(){



            document.getElementById('listbox').selectedIndex = -1;
        }

    </script>


</head>
<body>
<div id="contain">
<div id="top">
<h1> Open Deposit Account</h1>
<h4> Please select a person from the list or search by Customer Number </h4>
</div>


<div id="mid">
<div id="midleft">
    <br>

    <table>
        <tr> <td>
                Select Name From List</td> </tr>
        <tr>
    <td> <?php include 'opencustnamesearch.php'; ?>
    </td> </tr>


        <tr> <td><form  action="OpenDeposit.php"   method="post">
                    <button type="submit" name="search" id="search" class="InputAddOn-item"> Search by Customer Number</button>
            </td></tr>
        <tr> <td>    <input class="InputAddOn-field" type = "text" name = "customerID" id = "customerID"
                            value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?> ">
            </td></tr>
    </table>
</div>
<div id="midcen">



    <label for "firstname" >First Name </label>
    <input  class="InputAddOn-field" readonly type = "text" name = "firstname" id = "firstname"
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?>  ">
        <label for "amendlastname">Surname </label>
    <input class="InputAddOn-field" readonly type = "text" name = "surname" id = "surname"
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?> ">
    <label for "amendDOB">Date of Birth </label>
    <input class="InputAddOn-field" readonly type = "text" name = "dateOfBirth" id = "dateOfBirth" title = "format is dd-mm-yyyy"
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?> ">
    <label for "addressLine1">Address Line 1</label>
    <input class="InputAddOn-field" readonly type = "text" name = "addressLine1" id = "addressLine1"
           value="<?php if(ISSET($_SESSION['addressLine1'])) echo $_SESSION['addressLine1'] ?> ">
    <label for "addressLine2">Address Line 2 </label>
    <input class="InputAddOn-field" readonly type = "text" name = "addressLine2" id = "addressLine2"
           value="<?php if(ISSET($_SESSION['addressLine2'])) echo $_SESSION['addressLine2'] ?> ">
    <label for "addTown">Town </label>
    <input class="InputAddOn-field" readonly type = "text" name = "addTown" id = addTown
           value="<?php if(ISSET($_SESSION['addTown'])) echo $_SESSION['addTown'] ?> ">
    <label for "addCounty">County </label>
    <input class="InputAddOn-field" readonly type = "text" name = "addCounty" id = "addCounty"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?> ">

    <br><br>
    <input class="InputAddOn-field" type="submit"  name="confirm" id="confirm" value="Confirm Customer ">
    <input class="InputAddOn-field" type="submit"  name="reset" id="reset"  value="reset">
</form>
</div>
    <div id="midright" >

        <form  action="OpenDeposit.php"   method="post">
            <input readonly type="text" name="accountID" id="accountID"
                   value="<?php if(isset($_SESSION['nextaccountID'])) echo $_SESSION['nextaccountID'] ?>">
            <br>

            <label for "deposit"> Opening Deposit </label> <input type="text" name="deposit" id="deposit" >
            <!-- deposit can not be empty -->
            <input type="submit" value="addDeposit" name="addDeposit" id="addDeposit">
        </form>
    </div>
</div>



</div> <!-- contain div -->
</body>
</html>
