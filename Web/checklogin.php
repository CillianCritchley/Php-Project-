<?php
session_start();
include 'db.inc.php';

/*
 * grab the password from the database for the user 'user'
 */

$sql = "select password from Password where user = user";

if(!$result = mysqli_query($con,$sql))
{
    die("Error connecting to database to check password . ".mysqli_error($con));
}

$row = mysqli_fetch_array($result);


/*
 * if the count variable value is under two, check the posted password to the value retrieved from the database
 * if equal, assign value of 4 to count and set session ['userloggedin']
 */
if ($_SESSION['count'] <2)
{
    if($_POST['pass'] == $row[0])
    {

        $_SESSION['userloggedin'] = "ddddd";
       // DO I NEED TO ASSIGN THIS TO COUNT?
        $_SESSION['count']=4;
        header('location: index.html.php');
    }

        $_SESSION['count']++;
       header('location: login.php');

}
/*
 *  code for the third and final login attempt. increment count if it's value is 2.
 */
else{
    $_SESSION['count']++;
    header('location: login.php');
}


?>