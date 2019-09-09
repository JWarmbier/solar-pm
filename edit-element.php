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
if(isset($_POST['element_id'])) {
    $result= getSpecificElement($con,$_POST['element_id']);
    if($result) {
        ?>
        <!-- container -->
        <div class="container">
            <form action="submit.php" method="post" name="edit-element-form" id="edit-element-form">
                <div class="modal-header">
                    <h4 class="modal-title">Aktualizujacja danych</h4>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="el_name">Nazwa elementu:</label>
                        <input type="text" name="el_name" id="el_name" class="form-control" required pattern=".{2,100}"
                               title="Minimum 2 znaki" autofocus value="<?php echo $result['el_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="category">Wybierz kategorię:</label>
                        <select class="form-control custom-select" name="category" id="category">
                            <?php
                            getCategories($con,$result['el_category_id']);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="el_parameter">Parametr:</label>
                        <input type="text" name="el_parameter" id="el_parameter" class="form-control" required
                               pattern=".{2,100}" title="Minimum 2 znaki" value="<?php echo $result['el_parameter'];?>" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="el_amount">Ilośc [szt.]:</label>
                        <input type="text" name="el_amount" id="amount" class="form-control" title="Minimum 2 znaki"
                               value="<?php echo $result['el_amount'];?>" autofocus>
                        <div id="amount_error" class="alert alert-danger alert-dismissible fade show">To nie jest liczba
                            całkowita.
                        </div><!-- Display Error Container -->
                    </div>
                    <div class="form-group">
                        <label for="datasheet">Link do dokumentacji:</label>
                        <input type="text" name="datasheet" id="datasheet" class="form-control" required
                               pattern=".{2,100}"
                               title="Minimum 2 znaki" value="<?php echo $result['datasheet'];?>" autofocus>
                    </div>

                    <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div>
                    <!-- Display Error Container -->
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <input type="hidden" name="element_id" value="<?php echo $_POST['element_id'];?>">
                    <input type="submit" class="btn btn-lg btn-success" value="Aktualizuj" id="submit">
                </div>
            </form>
        </div>


        <!-- /container -->
        <?php

    }else{
        echo 'Nie ma takiego elementu.';
    }
    }else{
    ?>
    <div class="container">
        <p>Błąd, nie znaleziono elementu.</p>
    </div>
<?php
}
    require('include/footer.php');?>