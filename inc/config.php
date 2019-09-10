<?php
session_start(); /* Session */
//$con=mysqli_connect("localhost","DbUser","admin123","pls"); /*Database Connection*/

$con = new mysqli("localhost", "DbUser", "admin123", "solar");
if (!$con){
    die($con->error);
}
$con->query("SET CHARSET utf8");
$con->query("SET NAMES `utf8` COLLATE `utf8_polish_ci`");

?>
