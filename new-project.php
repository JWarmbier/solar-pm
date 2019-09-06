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
        <div class="new-project">
            <?php
            if(isset($_GET['action'])) {
                if ($_GET['action'] == 'success') {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Udało się utworzyć projekt.
                    </div>
                    <?php
                }
            }
            ?>

            <form action="submit.php" method="post" name="new-project-form" id="new-project-form">
                <div class="form-group">
                    <h2 class="h2-responsive font-weight-light">Nowy projekt</h2>
                    <hr>
                </div>

                <div class="form-group">
                    <label for="title">Nazwa projektu:</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="description">Opis projektu:</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label for="department">Dział w którym projekt będzie realizowany:</label>
                    <select class="form-control custom-select float-right" name="department">
                        <?php
                        getDepartments($con);
                        ?>
                    </select>
                </div>
                <div class="form-group clearfix">
                    <label for="project-team">Osoby odpowiedzialne za projekt:</label>
                    <ul class="list-group list-group-flush" id="team-project-list">
                        <li class="list-group-item"><?php echo $tmp['name'];?> <input type="hidden" name="author" value="<?php echo $tmp['user_id'];?>"> </li>
                    </ul>
                    <button type="button" class="btn btn-primary btn float-right" data-toggle="modal" data-target="#new-person">Dodaj osobę</button>
                </div>
                <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div>
                <div class="form-group clearfix">
                    <input type="submit" class="btn btn-lg btn-success btn-block float-right" value="Utwórz projekt">
                </div>
            </form>
        </div>
        <!-- Add users responsible for project -->
        <div class="modal fade" role="dialog" id="new-person">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- HTML Form -->
                    <form action="submit.php" method="post" name="password_form" id="password_form" autocomplete="off">
                        <div class="modal-header">
                            <h4 class="modal-title">Dodawanie nowej osoby</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <label for="person">Wybierz osobę:</label>
                            <select class="form-control custom-select float-right" name="person" id="select-person">
                                <?php
                                showAllUsers($con, $_SESSION['UserData']['user_id']);
                                ?>
                            </select>
                            <br>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <input type="button" class="btn btn-lg btn-success" value="Dodaj" id="btn-add-person">
                            <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /Add users responsible for project -->
    </div>


    <!-- /container -->
<?php require('include/footer.php');?>