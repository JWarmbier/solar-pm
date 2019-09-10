<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/

use PhpRbac\Rbac;

require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:main.php"));
}
require_once 'PhpRbac/src/PhpRbac/Rbac.php';
$rbac = new PhpRbac\Rbac();
?>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>PHP Login Script (PHP, MySQL, Bootstrap, jQuery, Ajax and JSON)</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Prosty wykres"
                },
                axisY:{
                    includeZero: false
                },
                data: [{
                    type: "line",
                    dataPoints: [
                        { y: 450 },
                        { y: 414},
                        { y: 530, indexLabel: "szczyt",markerColor: "red", markerType: "circle" },
                        { y: 460 },
                        { y: 450 },
                        { y: 500 },
                        { y: 480 },
                        { y: 480 },
                        { y: 405 , indexLabel: "depresja",markerColor: "red", markerType: "circle" },
                        { y: 500 },
                        { y: 480 },
                        { y: 510 }
                    ]
                }]
            });
            chart.render();

        }
    </script>

<?php
require('include/menu.php');


?>
    <!-- container -->

    <div class="container">
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    </div>

<?php require('include/footer.php');?>