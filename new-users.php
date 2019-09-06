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


require('include/header.php');
require('include/menu.php');

if(isset($_POST['nrID'])){
    $acceptedUsers = $_POST['nrID'];
    appendUsers($con, $acceptedUsers);
}



?>


    <!-- container -->

    <div class="container">
        <div class="new-users">
            <h1 class="h1-responsive font-weight-light">Lista nowych użytkowników</h1>
            <hr>
            <p class="font-weight-light"> W celu przyjęcia nowych użytkowników zaznacz, a następnie wniśnij przycisk "AKCEPUTJ".</p>
            <form action="new-users.php" method="post">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Imię i nazwisko</th>
                        <th scope="col">ID</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Data rejestracji</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            getNewUsers($con);
                        ?>
                    </tbody>
                </table>
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary btn-lg float-right">Akceptuj</button>
                </div>
            </form>
        </div>

    </div>

    <!-- /container -->
<?php require('include/footer.php');?>