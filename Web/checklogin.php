<?php
session_start();
include 'db.inc.php';



$sql = "select password from Password where user = user";

if(!$result = mysqli_query($con,$sql))
{
    die("Error connecting to database to check password . ".mysqli_error($con));
}

$row = mysqli_fetch_array($result);



if ($_SESSION['count'] <2)
{
    if($_POST['pass'] == $row[0])
    {

        $_SESSION['userloggedin'] = "ddddd";
        $_SESSION['count']=4;
        header('location: index.html.php');
    }

        $_SESSION['count']++;
       header('location: login.php');

}
else{
    $_SESSION['count']++;
    header('location: login.php');
}


?>