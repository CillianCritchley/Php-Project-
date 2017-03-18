<?php
session_start();
include 'db.inc.php';
if(isset($_POST['logout']))
{
    session_unset();
    header('location: thankyou.html');
}
else if(isset($_POST['changepass']))
{
    session_unset();
    header('location: changepass.php');
}
else if($_SESSION['count'] > 2 && !isset($_SESSION['userloggedin']))
{
    echo "<script> alert(\"login failed\")</script>";
}
else if($_SESSION['count'] <= 2)
{
?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="../Cillian.css" type="text/css">

        <style>

            form{
                margin: 23em;
                padding: 20px 0 35px 0 ;
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
        <center>
<form action="checklogin.php" method="post">
     <label for="pass"> Enter Password for User Login</label>
    <input type="text" name="pass" id="pass" required pattern="[a-zA-z0-9]{1,}">
    <input type="submit" name="sendpass" id="sendpass" value="submit">

</form>
    </center>
<?php
}
else if(isset($_SESSION['userloggedin']))
{
header('location: index.html.php');
}
?>
    </body>
</html>

