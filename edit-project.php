<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/

use PhpRbac\Rbac;

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

if(isset($_POST['project_id'])) {
    if($project = getProject($con, $_POST['project_id'])) {
        $coworkers = getProjectCoworkers($con, $_POST['project_id']);
        ?>


        <!-- container -->
        <div class="container">
            <div class="new-project">
                <?php
                if (isset($_GET['action'])) {
                    if ($_GET['action'] == 'success') {
                        ?>
                        <div class="alert alert-success" role="alert">
                            Udało się poprwnie edytować projekt.
                        </div>
                        <?php
                    }
                }
                ?>
                <form action="submit.php" method="post" name="update-project-form" id="update-project-form">
                    <div class="form-group">
                        <h2 class="h2-responsive font-weight-light">Akutalizacja danych aktulanego projektu</h2>
                        <hr>
                    </div>

                    <div class="form-group">
                        <label for="title">Nazwa projektu:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $project['name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Opis projektu:</label>
                        <textarea class="form-control" id="description" name="description" rows="4"> <?php echo $project['description'];?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="department">Dział w którym projekt będzie realizowany:</label>
                        <select class="form-control custom-select float-right" name="department">
                            <?php
                            getDepartments($con, $project['DepartmentID']);
                            ?>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <label for="project-team">Osoby odpowiedzialne za projekt:</label>
                        <ul class="list-group list-group-flush" id="team-project-list">
                            <li class="list-group-item"><?php echo $tmp['name']; ?> - autor<input type="hidden" name="author" value="<?php echo $tmp['user_id']; ?>">
                                    <?php
                                        for($i = 0; $i < count($coworkers); $i++){
                                            echo '<li class="list-group-item" id="li-coworker-id-'.$coworkers[$i]['user_id'].'">';
                                            echo '<p class="float-left" id="p-coworker-id-';
                                            echo  $coworkers[$i]['user_id'].'">'.$coworkers[$i]['name'];
                                            echo '</p><input type="hidden" name="coworker[]" value="';
                                            echo $coworkers[$i]['user_id'];
                                            echo '">';
                                            ?>
                                            <button type="button" class="btn btn-primary btn-sm float-right btn-remove-person" value="<?php echo $coworkers[$i]['user_id'];?>">Usuń
                                            </button>
                                            </li>
                                            <?php
                                        }
                                    ?>
                        </ul>
                        <button type="button" class="btn btn-primary btn float-right" data-toggle="modal"
                                data-target="#new-person">Dodaj osobę
                        </button>
                    </div>
                    <div class="form-group clearfix">
                        <label for="projects-elements">Lista części:</label>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Parametr</th>
                                <th scope="col">Dostępność [szt.]</th>
                                <th scope="col">Kategoria</th>
                                <th scope="col">Dokumentacja</th>
                                <th scope="col">Zapotrzebowanie</th>
                            </tr>
                            </thead>
                            <tbody id="table-list-of-elements">
                            <?php
                                $elemetns = getProjectElements($con, $_POST['project_id']);
                                if($elemetns->num_rows > 0 );
                            {
                                while($element = $elemetns->fetch_assoc()){
                                    ?>
                                    <tr>
                                        <td><?php echo $element['el_name'];?></td>
                                        <td><?php echo $element['el_parameter'];?></td>
                                        <td><?php echo $element['el_amount'];?></td>
                                        <td><?php echo $element['category_name'];?></td>
                                        <td> <a href="<?php echo $element['datasheet'];?>" class="btn btn-primary btn-sm">Dokumentacja</a></td>
                                        <td><input type="hidden" name="elements[]" value="<?php echo $element['element_id'];?>">
                                            <input type="number" pattern="^[0-9]" name="amountOfElements[]" value="<?php echo $element['amount']?>">
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                        </table>

                        <button type="button" class="btn btn-primary btn float-right" data-toggle="modal"
                                data-target="#new-element">Dodaj część
                        </button>
                    </div>
                    <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div>
                    <div class="form-group clearfix">
                        <input type="hidden" name="project_id" value="<?php echo $project['ID']; ?>">
                        <input type="submit" class="btn btn-lg btn-success btn-block float-right"
                               value="Aktualizuj">
                    </div>
                </form>
            </div>
            <!-- Add users responsible for project -->
            <div class="modal fade" role="dialog" id="new-person">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- HTML Form -->
                        <form action="submit.php" method="post" name="password_form" id="password_form"
                              autocomplete="off">
                            <div class="modal-header">
                                <h4 class="modal-title">Dodawanie nowej osoby</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <label for="person">Wybierz osobę:</label>
                                <select class="form-control custom-select float-right" name="person" id="select-person">
                                    <?php
                                    showAllUsers($con, $_SESSION['UserData']['user_id'], $coworkers);
                                    ?>
                                </select>
                                <br>
                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <input type="button" class="btn btn-lg btn-success" value="Dodaj" id="btn-add-person">
                                <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Add users responsible for project -->
            <!-- Add elements to projects -->
            <div class="modal fade" role="dialog" id="new-element">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- HTML Form -->
                        <form action="submit.php" method="post" name="password_form" id="password_form"
                              autocomplete="off">
                            <div class="modal-header">
                                <h4 class="modal-title">Dodawanie części</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <div class="form-group clearfix">
                                    <label for="person">Wybierz część:</label>
                                    <select class="form-control custom-select float-right" name="person" id="select-element">
                                        <?php
                                            listOfElements($con, $_POST['project_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <?php descriptionOfElements($con);?>
                                </div>

                            </div>
                            <!-- Modal Footer -->
                            <div class="modal-footer">
                                <input type="button" class="btn btn-lg btn-success" value="Dodaj" id="btn-add-element">
                                <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Elements to project -->
        </div>
        <?php
    } else{
        echo "Nie istnieje projekt o ID: ".$_POST['project_id'];
    }
    } else {
        echo 'Błąd, nie można edytować projektu.';
    }
    ?>

    <!-- /container -->
<?php require('include/footer.php');?>