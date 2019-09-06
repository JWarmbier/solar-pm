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

$tmp = getUserData($con, $_SESSION['UserData']['user_id']);

if(isset($_POST['action'])){
    if($_POST['action'] == 'remove-account') {
        removeAccount($con, $_POST['user_id']);
    }
    if($_POST['action'] == 'change-role'){
        $user = getUserData($con, $_POST['user_id']);
        $rbac->Users->unassign($user['RoleID'], $_POST['user_id'] );
        $rbac->Users->assign( $_POST['role'], $_POST['user_id'] );
    }
}
?>
    <!-- container -->

    <div class="container">
        <div class="all-users">
            <h1 class="h1-responsive font-weight-light">Wszyscy członkowie <?php if('Koordynator' != $tmp['Title']) echo ' działu';?></h1>

            <p><?php
                $allUsersList = null;
                $allUsersDescription = null;


                $children = $rbac->Roles->children($tmp['RoleID']);
                if((count($children)!= 0 ) && 'Koordynator' != $tmp['Title']){

                    $allUsersList = getAllKindOfUsers($con , $children[0]['ID']);
                    $allUsersDescription = getAllKindOfUsers($con , $children[0]['ID']);
                } else{
                    $allUsersList = getAllCurrentUsers($con);
                    $allUsersDescription = getAllCurrentUsers($con);
                }

            ?>
            </p>
            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <?php showListOfNames($allUsersList);?>
                    </div>
                </div>
                <div class="col-8">
                    <div class="tab-content" id="nav-tabContent">
                        <?php showDescriptionOfUsers($con, $allUsersDescription); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require('include/footer.php');?>