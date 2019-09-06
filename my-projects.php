<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/
require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:main.php"));
}

require('include/header.php');
require('include/menu.php');

require_once 'PhpRbac/src/PhpRbac/Rbac.php';
$rbac = new PhpRbac\Rbac();


?>


    <!-- container -->
    <div class="container">


        <div class="div-my-projects">
        <h2 class="h2-responsive font-weight-light">Moje projekty</h2>
            <div id="accordion">
                <?php
                displayMyProjects($con, $_SESSION['UserData']['user_id']);
                ?>
            </div>
        </div>
    </div>


    <!-- /container -->
<?php require('include/footer.php');?>