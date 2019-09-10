
<!doctype html>
<html>
<!-- Include reCAPTCHA v2 -->
<script src='https://www.google.com/recaptcha/api.js'  ></script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PUT Solar Dynamics</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<?php
if(isset($_SESSION['timestamp'])){
    if(time() - $_SESSION['timestamp'] > 900) { //subtract new timestamp from the old one
        unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
        session_destroy();
        header("Location: ./", true, 301);
        exit;
    } else {
        echo time() - $_SESSION['timestamp'];
        $_SESSION['timestamp'] = time(); //set new timestamp
    }
}

