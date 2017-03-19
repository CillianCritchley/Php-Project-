<?php
session_start();
include ('db.inc.php');
/*
 *  DO I NEED THIS?. I don't think so
 */
if($_SERVER['HTTP_REFERER'] == 'http://localhost/proj/Web/Welcome.html' )
{
    $_SESSION['passattempts'] =0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../Cillian.css" type="text/css">

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

    <script type="text/JavaScript" src="test/cillianscript.js">

    </script>

</head>
<body>
<form action="changepass.php"  method="post">
    <label for="oldpass"> Enter Old Password</label>
    <input type="text" required pattern="[a-zA-Z0-9]{1,}" name="oldpass">
    <input type="submit" name="sendoldpass" value="Change Password">

</form>

<?php
/*
 * If the user has submitted the a password from the enter current password form this is checked against the database
 * and if it is correct the value is echo'd into the hidden textield oldpass2 in the new password form.
 * the new password form will not be displayed unless the 'oldpass' field is posted.
 * when the user is using the new password form it is this echo'd oldpass2 value that is used to ensure the
 * new password form will be displayed after a page refresh on submit.
 *
 */
if(isset($_POST['oldpass']) || isset($_POST['oldpass2']))
{
    $sql = "select password from Password";
    if(!$result = mysqli_query($con,$sql))
    {
        die("error connecting to password table ".mysqli_error($con));
    }
    $row = mysqli_fetch_array($result);

    if((isset($_POST['oldpass']) &&  $_POST['oldpass'] == $row[0])
      || (isset($_POST['oldpass2']) &&  $_POST['oldpass2'] == $row[0]))
    {
        /*
         * the checkPass() function is explained in the cillian.js script file
         */
       ?>
<form action="changepass.php" name="newpassvalid" method="post" onsubmit="return checkPass();">
    <input type="hidden"  name="oldpass2" value="<?php echo $_POST['oldpass'] ?>">
    <label for="newpass"> Enter new Password</label>
    <input type="password" required name="newpass" pattern="[a-zA-Z0-9]{1,}" title="alphanumeric only" id="newpass">
    <label for="newpasscopy"> Enter Old Password</label>
    <input type="password" required name="newpasscopy" pattern="[a-zA-Z0-9]{1,}" title="alphanumeric only"  id="newpasscopy">
    <input type="submit" name="changepass"  value="Change Password">

</form>

<?php
/*
 * if the checkPass() function allows the form submissions, it means both entered pasaswords are equal so
 * one of them is chosen to replace the current password value in the database for user 'user'
 * and alert is then issued to notify the user of success
 */
    if(isset($_POST['changepass']))
        {
            $sql = "update Password set Password = '$_POST[newpass]' where user = 'user'";

            if(!$result = mysqli_query($con,$sql))
            {
                die("error updating password ".mysqli_error($con));
            }
            else{
                echo "<script> alert(\"password updated\") </script> ";
            }
        }
    }
}
?>

</body>
</html>

