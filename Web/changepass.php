<?php
session_start();
include ('db.inc.php');
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

