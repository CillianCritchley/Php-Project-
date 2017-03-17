<?php session_start();
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
    <form  action="ViewDeposit.php"  onsubmit="return checkEmpty(this.submited);"  method="post">
        <table>
            <tr> <td>
                    <font size="5">  Select Name From List </font> </td> </tr>
            <tr>
                <td> <?php include 'viewcustnamesearch.php'; ?> Or
                </td> </tr>
            <tr> <td>  <label for "customerID" > Search By Customer ID </label>
                </td> </tr>

            <tr> <td>    <input class="InputAddOn-field"  type = "text" pattern="[0-9]{1,}" name = "customerID" id = "customerID"
                                value="<?php if(ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID'])?>">
                </td></tr>
            <tr> <td>      <button type="submit" onclick="this.form.submited=this.name;" name="searchCustomer" id="searchCustomer" class="InputAddOn-item"> Search by Customer Number</button>
                </td></tr>
            <tr> <td> <?php if(isset($_SESSION['errorVarCust'])) echo $_SESSION['errorVarCust']?></td></tr>
            <tr> <td>  <label for "customerID" > Search By Account ID </label>
                </td> </tr>
            <tr>  </tr>
            <tr> <td>    <input class="InputAddOn-field" pattern="[0-9]{1,}" title="numeric only" type = "text" name = "accID" id = "accID"
                                value="<?php if(ISSET($_SESSION['accID'])) echo htmlspecialchars($_SESSION['accID'])?>">
                </td></tr>

            <tr> <td>      <button type="submit" onclick="this.form.submited=this.name;" name="searchAccount" id="searchAccount" class="InputAddOn-item"> Search by Account Number</button>
                </td></tr>
            <tr> <td> </td></tr>
            <tr> <td> </td></tr>


        </table>
    </form>
</div>
<div id="midleft">
<p id = "display"> </p>

<form  action="ViewDeposit.php"  onsubmit="return formCheck(this.submited);" method="post">

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
    <input type="submit"  onclick="this.form.submited=this.value;" name="confirm" id="confirm" value="Confirm Customer">
    <input type="submit"  onclick="this.form.submited=this.value;" name="reset" id="reset"  value="reset">

</form>
</div>
    <div id="rightReport">
        <div id="righttop">
<?php if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) > 0 )
{
$tempARR = $_SESSION['results'];
?>
            <form action='ViewDeposit.php' id="viewdepositform" method='post'>
                <input type="hidden" name="customerIDHide2" id="customerIDHide2"
                       value="<?php if (ISSET($_SESSION['customerID'])) echo htmlspecialchars($_SESSION['customerID']) ?>">
                <table>
                    <tr>
                        <th> Select</th>
                        <th></th>
                        <th> Account ID</th>
                        <th>Balance</th>
                        <th> Date Opened</th>
                    </tr>
                    <?php


                    foreach ($tempARR as $row)
                    {

                    ?>
                    <!-- table row for each row in the $tempARR array -->

                    <tr>
                        <!-- give each radio button the value of the account ID associated with this row -->
                        <?php echo "<td> <input type=\"radio\" name='radio' value=".$row['depositAccountID'].">  </td>";



                        foreach ($row as $rowItem) {

                            // fill each column of the row
                            echo
                                "<td>" . $rowItem . "</td>";

                        }   //inner loop

                        // end of table row
                        echo "</tr>";


                        }    // outer loop
                        echo "</table>

                         </form> " ;

        }
        else if(ISSET($_SESSION['results']) && (count($_SESSION['results'])) == 0 )
        {
            echo "Customer has no Deposit Accounts";
        }
        ?>

        </div>
        <div id="righttopleft">
            <input type = 'submit' form="viewdepositform" name='ViewDetails' value="View Account Details">

        </div>
        <div id="rightbottom">
            <div id="reportHeaderDiv">
                <table>
                    <?php
                    if(isset($_SESSION['tran'])) {
                    ?>
                        <TABLE>
                            <TR>
                                <TD> First Half of Text</TD>
                            </TR>
                            <tr>
                                <TD> Image</TD>
                                <TD> Second Half of Text</TD>
                            </TR>
                        </TABLE>
                        <?php
                    }
                    ?>
            </div>
            <div id="reportContentDiv">
                <?php
                if (isset($_SESSION['tran'])) {
                ?>
                <table>
                    <tr>
                        <th> Transaction ID</th>
                        <th> Amount</th>
                        <th> Date</th>
                        <th> Type</th>
                    </tr>
                    <?php


                    foreach ($_SESSION['tran'] as $transrow) {
                        echo "<tr> ";
                        foreach ($transrow as $transactionindex) {
                            {
                                echo "   <td> " . $transactionindex . "</td> ";
                            }

                        }

                    }

                        echo "</tr></table> </td> </tr>";


                }

        ?>
    </div> <!-- rightBottom div -->
</div>  <!-- right div -->

</div>  <!-- mid div -->
</div>

</body>
</html>
