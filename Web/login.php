<?php
session_start();
include 'db.inc.php';
/*
 * if the logout button is pressed (Welcome.html), unset all sessions (including ['userloggedin'] and redirect to thankyou.html
 * thankyou.html contains a window.onload script to reload the parent (index.php) which drops the user back
 * to the initial login screen as ['userloggedin'] has been unset
 */
if(isset($_POST['logout']))
{
    session_unset();
    header('location: thankyou.html');
}
/*
 * if changepass button is pressed (Welcome.html) redirec  to changepass.php
 */
else if(isset($_POST['changepass']))
{
    // CHECK IF I NEED THIS

    session_unset();
    header('location: changepass.php');
}
/*
 * if the count session variable has been incremented twice (0,1,2) and the user is still not logged in
 * alert that login has failed
 */
else if($_SESSION['count'] > 2 && !isset($_SESSION['userloggedin']))
{
    echo "<script> alert(\"login failed\")</script>";
}
/*
 * if the count session variable has a value of less than or equal to 2, show the login form
 * the above block of code is executed if count is higher than 2 and the user has failed to log in
 * checklogin.php contains the code to deal with a successful login
 */
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
<form class="form1" action="checklogin.php" method="post">
     <label for="pass"> Enter Password for User Login</label>
    <input type="password" name="pass" id="pass" required pattern="[a-zA-z0-9]{1,}" autofocus>
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

