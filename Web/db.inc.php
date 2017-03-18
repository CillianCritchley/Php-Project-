<?php
$hostname = "localhost";
$username = "cillian";
$password = "password";
$dbname   = "bankDB";

$con = mysqli_connect($hostname, $username,$password,$dbname);

if(!$con)
{
    die ("Error connecting to MySql server ".mysqli_connect_error());
}

?>

