<?php
session_start();
if(isset($_SESSION['passChanged']))
{
    echo "<script> alert(\"Password Changed\") </script>";
    unset($_SESSION['passChanged']);
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

    <script type="text/JavaScript" src="../cillianscript.js">


    </script>

</head>
<body>
<h2 align="center"> Welcome to HCCC Banking System</h2>
<form class="form1" name="logoutform" action="login.php" method="post"></form>

<!--
allow user to change password or to log out -->
<div style="width:400px; margin-right:auto; margin-left:auto; padding-top: 150px">
    <input type="submit" form="logoutform" name="changepass" value="Change Password">
</div>
    <div style="width:400px; margin-right:auto; margin-left:auto; padding-top: 150px">

    <input type="submit" form="logoutform" name="logout" value="logout">

</div>
</body>
</html>
