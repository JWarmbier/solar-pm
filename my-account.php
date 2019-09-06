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

?>
    <!-- container -->
    <div class="container">
        <?php
        $user = getUserData($con, $_SESSION['UserData']['user_id']);
        ?>
        <div class="account-view">
            <h1 class="h1-responsive font-weight-light" ><?php echo $user['name'];?></h1>
            <hr>

            <div class="alert alert-danger alert-dismissible fade show" <?php if($user['status']) echo 'style="display:none"';?> role="alert">
                Twoje konto nie jest jeszcze zakceptowane przez lidera.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <p class="font-weight-medium"><b>Adres email: </b> <?php echo $user['email'];?></p>
            <p class="font-weight-medium"><b>Rok studiów: </b><?php echo $user['year'];?></p>
            <p class="font-weight-medium"><b>Kierunek studiów: </b><?php echo $user['course'];?></p>
            <p class="font-weight-medium"><b>Nr albumu: </b><?php echo $user['student_id'];?></p>
            <p class="font-weight-medium"><b>Funkcja w zespole: </b><?php echo $user['Title'];?></p>
            <div class="clearfix">
                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#update_profile_modal">Edytuj profil</button>
                <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#password_modal">Zmień hasło</button>
            </div>
        </div>
    </div>


    <!-- Update Form -->
    <div class="modal fade" role="dialog" id="update_profile_modal">
    <div class="modal-dialog" >
        <div class="modal-content">

            <!-- HTML Form -->
            <form action="submit.php" method="post" name="update_profile_form" id="update_profile_form" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Aktualizacja danych</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Name">Imię i nazwisko</label>
                        <input type="text" name="Name" id="Name" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus value="<?php echo $user['name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="Email" id="Email" class="form-control" value="<?php echo $user['email'];?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Course">Kierunek studiów</label>
                        <input type="text" name="Course" id="Course" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki." value="<?php echo $user['course'];?>" autofocus>
            </div>
            <div class="form-group">
                        <label for="Year">Rok</label>
                        <select class="form-control custom-select" name="Year" id="Year">
                            <option value="1" <?php if($user['year'] == 1) echo 'selected';?>>1</option>
                            <option value="2" <?php if($user['year'] == 2) echo 'selected';?>>2</option>
                            <option value="3" <?php if($user['year'] == 3) echo 'selected';?>>3</option>
                            <option value="4" <?php if($user['year'] == 4) echo 'selected';?>>4</option>
                            <option value="5" <?php if($user['year'] == 5) echo 'selected';?>>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="StudentID">Numer albumu</label>
                        <input type="text" name="StudentID" id="StudentID" class="form-control" required pattern=".{6,6}" title="6 cyfr" value="<?php echo $user['student_id'];?>" autofocus>
                    </div>
                    <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <input type="submit" class="btn btn-lg btn-success" value="Akceptuj" id="submit">
                    <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
                </div>
            </form>

        </div>
    </div>
    </div>
        <!-- Update Form -->

    <!-- Password Form -->
    <div class="modal fade" role="dialog" id="password_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- HTML Form -->
                <form action="submit.php" method="post" name="password_form" id="password_form" autocomplete="off">
                    <div class="modal-header">
                        <h4 class="modal-title">Nowe hasło</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Password">Hasło</label>
                            <input type="password" name="Password" id="Password" class="form-control" required pattern=".{6,12}" title="Od 6 do 12 znaków">
                        </div>
                        <div class="form-group">
                            <label for="Confrim-password">Powtórz hasło</label>
                            <input type="password" name="Confirm-password" id="Confirm-password" class="form-control" required pattern=".{6,12}" title="Od 6 do 12 znaków">
                        </div>
                        <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-lg btn-success" value="Akceptuj" id="submit">
                        <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
        <!-- /Password Form -->
        <!-- Modal success - profile -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">Aktualizacja danych</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                            <p>Aktualizacja danych osobowych zakończyła się sukcesem.</p>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="btnOkUpdate" class="btn btn-outline-success waves-effect" data-dismiss="modal">Ok</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
        <!-- /Modal success - profile -->
        <!-- Modal success - password -->
        <div class="modal fade" id="successPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-notify modal-success" role="document">
                <!--Content-->
                <div class="modal-content">
                    <!--Header-->
                    <div class="modal-header">
                        <p class="heading lead">Nowe hasło</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white-text">&times;</span>
                        </button>
                    </div>

                    <!--Body-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                            <p>Zmiana hasła zakończyła się powowdzeniem.</p>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="modal-footer justify-content-center">
                        <a type="button" id="btnOkPassword" class="btn btn-outline-success waves-effect" data-dismiss="modal">Ok</a>
                    </div>
                </div>
                <!--/.Content-->
            </div>
        </div>
    <!-- /Modal success - password -->
    </div>
    <!-- /container -->
<?php require('include/footer.php');?>