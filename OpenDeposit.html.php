<?php session_start();
/*
 * if a a createVAR session variable exists  and the referrer
 * is any page other than this one, unset the session. Before this the session variables would populate the form
 * fields on every page regardless of which page they were created as a result of. It didn't look good.
 * func.php is a file with some php functions stored in it.
 *
 */
if(isset($_SESSION['createVAR']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/proj/OpenDeposit.html.php')
{
    session_unset();
}
include 'func.php';


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
            text-align: left;
        }
    </style>


    <script type="text/JavaScript" src="cillianscript.js">

    </script>
</head>
<body>
        <div id="top">
        <h1> Open Deposit Account</h1>
        <h4> Please select a person from the list or search by Customer Number </h4>

        </div>  <!-- top -->

    <div id="mid">
        <div id="left">
            <br>
            <!-- checkEmpty() function is located in cillian.js. it ensures that a value must be entered
            into an appropriate field before the form can be submitted -->
            <form  class="form1" action="OpenDeposit.php"  onsubmit="return checkEmpty(this.submited);" method="post">
            <table>
                <tr> <td>
                      <font size="5">  Select Name From List </font> </td> </tr>
                <tr>
            <td> <?php include 'opencustnamesearch.php'; ?> Or
            </td> </tr>
                <tr> <td>  <label for "customerID" > Search By Customer ID </label>
                    </td> </tr>

                <tr> <td>    <input class="textfield" pattern="[0-9]+" title="numeric only" type = "text" name = "customerID" id = "customerID"
                                    value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
                    </td></tr>
                <tr> <td>      <button type="submit" class="formitem" onclick="this.form.submited=this.name;" name="searchCustomer" id="search" class="formitem"> Search by Customer Number</button>
                    </td></tr>
                <tr> <td> </td></tr>

            </table>
            </form>
        </div> <!-- left -->

        <div id="midleft">
            <!--   if the session variables associated with the information related to these fields exist, output the values
              stored to the field. Fields are readonly so this is purely for user information. -->
                <form class="form1" action="OpenDeposit.php" onsubmit="return formCheck(this.submited);"  method="post">
                    <div id="formRow">
                        <input type = "hidden" name = "customerIDHide" id = "customerIDHide"
                           value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
                    </div>
              <div id="formRow">
                  <label for "firstname" >First Name </label>
                  <input  class="textfield" readonly type = "text" name = "firstname" id = "firstname"
                       value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?>">
              </div>
                    <div id="formRow">
                    <label for "amendlastname">Surname </label>
                <input class="textfield" readonly type = "text" name = "surname" id = "surname"
                       value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?>">
                    </div>   <div id="formRow">
                <label for "amendDOB">Date of Birth </label>
                <input class="textfield" readonly type = "text" name = "dateOfBirth" id = "dateOfBirth" title = "format is dd-mm-yyyy"
                       value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
                           $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?>">
                        </div>    <div id="formRow">
                <label for "addressLine1">Address Line 1</label>
                <input class="textfield" readonly type = "text" name = "addressLine1" id = "addressLine1"
                       value="<?php if(ISSET($_SESSION['addressLine1'])) echo $_SESSION['addressLine1'] ?>">
                            </div>      <div id="formRow">
                <label for "addressLine2">Address Line 2 </label>
                <input class="textfield" readonly type = "text" name = "addressLine2" id = "addressLine2"
                       value="<?php if(ISSET($_SESSION['addressLine2'])) echo $_SESSION['addressLine2'] ?>">
                                </div>      <div id="formRow">
                <label for "addTown">Town </label>
                <input class="textfield" readonly type = "text" name = "addTown" id = addTown
                       value="<?php if(ISSET($_SESSION['addTown'])) echo $_SESSION['addTown'] ?>">
                                    </div>  <div id="formRow">
                <label for "addCounty">County </label>
                <input class="textfield" readonly type = "text" name = "addCounty" id = "addCounty"
                       value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?>">
                                        </div>
                    <table>
                    <tr> <td>  <input class="formitem" onclick="this.form.submited=this.value;" type="submit"
                                      name="confirm" id="confirm" value="Confirm Customer"> </td></tr>
                    <tr> <td>  <input class="formitem" onclick="this.form.submited=this.value;" type="submit"
                                      name="reset" id="reset"  value="reset">  </td></tr>
                    </table>
                 </form>

        </div> <!-- midcen -->
        <div id="right" >

            <form  class="form1" action="OpenDeposit.php"   onsubmit="return createCheck();" method="post">
                <label for "account"> Account ID </label>

                <input class="textfield" readonly type="text" name="accountID" id="accountID"
                       value="<?php if(isset($_SESSION['nextaccountID'])) echo $_SESSION['nextaccountID'] ?>">

                <input type="button"  class="formitem" <?php if(isset($_SESSION['nextaccountID']))
                { ?> onclick="document.getElementById('deposit').disabled=false;" <?php }?> value="Unlock Deposit" name="unlock" id="unlock">
                <input readonly type="hidden" name="custIDagain" id="custIdagain"
                       value="<?php if(isset($_SESSION['customerID'])) echo $_SESSION['customerID'] ?>">
                <br>
                <label for "deposit"> Opening Deposit </label>
                <input class="textfield" disabled type="text" name="deposit" id="deposit" pattern="\d{1,}\.\d{2}" title="Currency format (xxx.xx) No Symbols">
                <!-- deposit can not be empty -->
                <input type="submit" class="formitem" onclick="this.form.submited=this.name;"  value="Create Account" name="addDeposit" id="addDeposit">
            </form>
        </div>   <!-- midright -->

        <?php
        /*
         * If the account was created the createVar session variable will exist and this message will alert.
         * once the alert is issued, unset the session variable so that any page reloads won't trigger the message.
         */
        if(isset($_SESSION['createVAR']))
        {
                echo "<script>alert(\"Account Created\")</script>";
                unset($_SESSION['createVAR']);
        }
        ?>
    </div>

</body>
</html>
