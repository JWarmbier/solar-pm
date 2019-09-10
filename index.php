<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/
require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:main.php"));
} else
{
    exit(header("location: my-account.php"));
}



?>
