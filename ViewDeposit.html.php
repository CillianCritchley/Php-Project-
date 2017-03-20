<?php session_start();
/*
 * if a session variable exists storing a customerID(the actual value or variable isn't important, it's just
 * to account for an actual session variable existing and customerID is the most common) and the referrer
 * is any page other than this one, unset the session. Before this the session variables would populate the form
 * fields on every page regardless of which page they were created as a result of. It didn't look good.
 * func.php is a file with some php functions stored in it
 */
if(isset($_SESSION['customerID']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/proj/ViewDeposit.html.php')
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
            text-align: right;
        }
    </style>

    <script type="text/JavaScript" src="cillianscript.js">

    </script>

</head>
<body>
<div id="top">
<h1> View Deposit Account</h1>
<h4> Please select a person from the list or search by Customer Number </h4>
</div>
<div id="mid">

<div id="left">
    <!-- checkEmpty() function is located in cillian.js. it ensures that a value must be entered
             into an appropriate field before the form can be submitted -->
    <form  class="form1" action="ViewDeposit.php"  onsubmit="return checkEmpty(this.submited);"  method="post">
        <table>
            <tr> <td>
                    <font size="5">  Select Name From List </font> </td> </tr>
            <tr>
                <td> <?php include 'viewcustnamesearch.php'; ?> Or
                </td> </tr>
            <tr> <td>  <label for "customerID" > Search By Customer ID </label>
                </td> </tr>

            <tr> <td>    <input class="textfield"  type = "text" pattern="[0-9]{1,}" name = "customerID" id = "customerID"
                                value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
                </td></tr>
            <tr> <td>      <button type="submit" class="formitem" onclick="this.form.submited=this.name;" name="searchCustomer" id="searchCustomer" class="InputAddOn-item"> Search by Customer Number</button>
                </td></tr>
            <tr> <td> <?php if(isset($_SESSION['errorVarCust'])) echo $_SESSION['errorVarCust']?></td></tr>
            <tr> <td>  <label for "customerID" > Search By Account ID </label>
                </td> </tr>
            <tr>  </tr>
            <tr> <td>    <input class="textfield" pattern="[0-9]{1,}" title="numeric only" type = "text" name = "accID" id = "accID"
                                value="<?php if(ISSET($_SESSION['accID'])) echo htmlspecialchars($_SESSION['accID'])?>">
                </td></tr>

            <tr> <td>      <button type="submit" class="formitem" onclick="this.form.submited=this.name;" name="searchAccount" id="searchAccount" class="InputAddOn-item"> Search by Account Number</button>
                </td></tr>
            <tr> <td> </td></tr>
            <tr> <td> </td></tr>


        </table>
    </form>
</div>
<div id="midleft">
<p id = "display"> </p>

<form  class="form1" action="ViewDeposit.php"  onsubmit="return formCheck(this.submited);" method="post">
    <!--   if the session variables associated with the information related to these fields exist, output the values
    stored to the field. Fields are readonly so this is purely for user information. -->
    <input type = "hidden" name = "customerIDHide" id = "customerIDHide"
           value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
    <label for "amendfirstname">First Name </label>
    <input readonly class="textfield" type = "text" name = "firstname" id = "firstname"
           value="<?php if(ISSET($_SESSION['firstname'])) echo $_SESSION['firstname'] ?>">
    <label for "amendlastname">Surname </label>
    <input readonly class="textfield"  type = "text" name = "surname" id = "surname"
           value="<?php if(ISSET($_SESSION['surname'])) echo $_SESSION['surname'] ?>">
    <label for "amendDOB">Date of Birth </label>
    <input readonly class="textfield" type = "text" name = "dateOfBirth" id = "dateOfBirth" title = "format is dd-mm-yyyy"
           value="<?php if(ISSET($_SESSION['dateOfBirth']))  {
               $date= date_create($_SESSION['dateOfBirth']); $date = date_format($date,"d-m-Y"); echo $date; }?>">
    <label for "addressLine1">Address Line 1</label>
    <input readonly class="textfield" type = "text" name = "addressLine1" id = "addressLine1"
           value="<?php if(ISSET($_SESSION['addressLine1'])) echo $_SESSION['addressLine1'] ?>">
    <label for "addressLine2">Address Line 2 </label>
    <input readonly class="textfield"  type = "text" name = "addressLine2" id = "addressLine2"
           value="<?php if(ISSET($_SESSION['addressLine2'])) echo $_SESSION['addressLine2'] ?>">
    <label for "addTown">Town </label>
    <input readonly class="textfield" type = "text" name = "addTown" id = addTown
           value="<?php if(ISSET($_SESSION['addTown'])) echo $_SESSION['addTown'] ?>">
    <label for "addCounty">County </label>
    <input readonly class="textfield" type = "text" name = "addCounty" id = "addCounty"
           value="<?php if(ISSET($_SESSION['addCounty'])) echo $_SESSION['addCounty'] ?>">
    <br><br>
    <input type="submit" class="formitem" onclick="this.form.submited=this.value;" name="confirm" id="confirm" value="Confirm Customer">
    <input type="submit"  class="formitem" onclick="this.form.submited=this.value;" name="reset" id="reset"  value="reset">

</form>
</div>
    <div id="rightReport">
        <div id="righttop">
<?php if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) > 0 )
{
/*
* if $_SESSION['results'] exists and has a size greater than 0 this means a list of deposit accounts was created
* and assigned to it so it's safe to try and fill a form and table with details from it.
* The ['results'] variable holds a 2d array, so two foreach loops are used. The first ($tempARR as $row) assigns
* the value of the relevant deposit account ID to ahidden input field in the form associated with the Close button.
 * This value is posted over to ViewDeposit.php.
* The second foreach loop fills each particular row with the details of the account
*/
$tempARR = $_SESSION['results'];
?>
            <table style="width:100%">
           <tr> <form  action='ViewDeposit.php' id="viewdepositform" method='post'>
                <input type="hidden" name="customerIDHide2" id="customerIDHide2"
                       value="<?php if (ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID']) ?>"> </tr>

                    <tr>
                        <th width="20%"> Select</th>
                        <th width="20%"> Account ID</th>
                        <th width="20%"> Balance</th>
                        <th width="20%"> Date Opened</th>
                    </tr>
                    <?php


                    foreach ($tempARR as $row)
                    {

                    ?>
                    <!-- table row for each row in the $tempARR array -->

                    <tr>
                        <!-- give each radio button the value of the account ID associated with this row -->
                        <?php echo "<td class=\"centerTable\"> <input type=\"radio\" name='radio' value=".$row['depositAccountID'].">  </td>";



                        foreach ($row as $rowItem) {

                            // fill each column of the row
                            echo
                                "<td class=\"centerTable\">" . $rowItem . "</td>";

                        }   //inner loop

                        // end of table row
                        echo "</tr>";


                        }    // outer loop
                        echo "</table> </form>" ;

        }
                        /*
                 * If the user searches for a customerID and confirms the customer details but the customer has no deposit accounts
                 * this message will appear in an alert box and also on the screen where the above table would otherwise be.
                 */
        else if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) == 0 )
        {
            echo "<script> alert(\"Customer has no Deposit Accounts\") </script> 
            Customer has no Deposit Accounts";
        }
        ?>

        </div>
        <div id="righttopBottom">
            <?php
            if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) > 0 ) {
                ?>
                <input type='submit' class="formitem" form="viewdepositform" name='ViewDetails'
                       value="View Account Details">
                <?php
            }
            ?>
        </div>
        <div id="rightbottom">
            <div id="reportHeaderDiv">
                <table>
                    <?php
                    if(isset($_SESSION['trans'])) {
                        /*
 * if the session variable storing the transactions has been created, set up the  header and account
 * information div
 */
                        ?>
                        <TABLE style="width:100%">
                            <tr>
                                <td > Deposit Account History</td>
                            </tr>
                            <tr> </tr>
                            <tr>
                                <td> Account ID <?php echo ":   ".$_SESSION['radio'] ?> </td>
                                <td align="right"> Customer Name :   <?php echo $_SESSION['firstname']. " ". $_SESSION['surname'] ."       "; ?></td>
                                <td width="10%"> </td>
                            </TR>
                        </TABLE>
                        <?php
                    }
                    ?>
            </div>
            <div id="reportContentDiv">
                <?php
                if (isset($_SESSION['trans'])) {
                ?>
                <table style="width:100%">
                    <tr>
                        <th width="20%"> Transaction ID</th>
                        <th width="20%"> Amount</th>
                        <th width="20%"> Type</th>
                        <th width="20%"> Date</th>
                    </tr>
                    <?php
                    /*
                 * set up the table to display the transactions. it's a 2d array so two foreach loops.
                 * the inner one loops through each individual row and outputs the values therein while the
                 * outer just loops as many times as there are rows.
                 */

                    foreach ($_SESSION['trans'] as $transrow) {
                        echo "<tr> ";
                        foreach ($transrow as $transactionindex) {
                            {
                                echo "   <td class=\"centerTable\"> " . $transactionindex . "</td> ";
                            }

                        }

                    }

                        echo "</tr></table> ";


                }

        ?>
    </div> <!-- rightBottom div -->
</div>  <!-- right div -->

</div>  <!-- mid div -->
</div>

</body>
</html>
