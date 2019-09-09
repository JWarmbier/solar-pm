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

$removed = false;
if(isset($_POST['action']) && isset($_POST['element_id'])){
    if($_POST['action'] == 'remove-element'){
        removeElement($con, $_POST['element_id']);
        $removed = true;
    }
}

?>


    <!-- container -->
    <div class="container">


        <div class="div-list-of-elements">
            <?php

                if ($removed) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        Usuwanie element zakończyło się pomyślnie.
                    </div>
                    <?php
                }
            ?>

            <div class="clearfix">
                <h2 class="h2-responsive font-weight-light float-left">Spis części</h2>
                <button type="button" class="btn btn-primary btn float-right" data-toggle="modal" data-target="#new-element-modal">Dodaj element</button

            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Parametr</th>
                    <th scope="col">Dostępność [szt.]</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Dokumentacja</th>
                    <th scope="col">Akcje</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    getAllElements($con);
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /container -->
    <!-- Adding Element Form -->
    <div class="modal fade" role="dialog" id="new-element-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- HTML Form -->
                <form action="submit.php" method="post" name="new-element-form" id="new-element-form" >
                    <div class="modal-header">
                        <h4 class="modal-title">Dodaj nowy element</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="el_name">Nazwa elementu:</label>
                            <input type="text" name="el_name" id="el_name" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="category">Wybierz kategorię:</label>
                            <select class="form-control custom-select" name="category" id="category">
                                <?php
                                getCategories($con);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="el_parameter">Parametr:</label>
                            <input type="text" name="el_parameter" id="el_parameter" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="el_amount">Ilośc [szt.]:</label>
                            <input type="text" name="el_amount" id="amount" class="form-control" title="Minimum 2 znaki" autofocus>
                            <div id="amount_error" class="alert alert-danger alert-dismissible fade show">To nie jest liczba całkowita.</div><!-- Display Error Container -->
                        </div>
                        <div class="form-group">
                            <label for="datasheet">Link do dokumentacji:</label>
                            <input type="text" name="datasheet" id="datasheet" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>

                        <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-lg btn-success" value="Dodaj" id="submit">
                        <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /Adding Element Form -->

    <!-- Editing Element Form -->
    <div class="modal fade" role="dialog" id="editing-element-modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- HTML Form -->
                <form action="submit.php" method="post" name="new-element-form" id="new-element-form" >
                    <div class="modal-header">
                        <h4 class="modal-title">Dodaj nowy element</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="el_name">Nazwa elementu:</label>
                            <input type="text" name="el_name" id="el_name" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="category">Wybierz kategorię:</label>
                            <select class="form-control custom-select" name="category" id="category">
                                <?php
                                getCategories($con);
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="el_parameter">Parametr:</label>
                            <input type="text" name="el_parameter" id="el_parameter" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>
                        <div class="form-group">
                            <label for="el_amount">Ilośc [szt.]:</label>
                            <input type="text" name="el_amount" id="amount" class="form-control" title="Minimum 2 znaki" autofocus>
                            <div id="amount_error" class="alert alert-danger alert-dismissible fade show">To nie jest liczba całkowita.</div><!-- Display Error Container -->
                        </div>
                        <div class="form-group">
                            <label for="datasheet">Link do dokumentacji:</label>
                            <input type="text" name="datasheet" id="datasheet" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
                        </div>

                        <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-lg btn-success" value="Dodaj" id="submit">
                        <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /Editing Element Form -->
<?php require('include/footer.php');?>