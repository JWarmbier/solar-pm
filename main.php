<?php
require('include/header.php');
require('inc/config.php');
require('inc/functions.php');



if (isset($_SESSION['UserData'])) {
    exit(header("location:/solar-pm/"));
}

?>

<div class="container text-center">
    <img id="put-logo" src="img/logo.svg" alt="PUT Solar Dynamics">
<h1>PUT Solary Dynamics</h1>
</div> <!-- /container -->


<!-- Login Form -->
<div class="container">
<!-- HTML Form -->
      <form action="submit.php" method="post" name="login_form" id="login_form" >
       <!-- <h2 class="form-signin-heading">Logowanie</h2> -->
        <div class="form-group">
            <label for="Email" class="sr-only">E-mail</label>
            <input type="email" name="Email" id="Email" class="form-control" placeholder="E-mail" required autofocus>
        </div>
        <div class="form-group">
            <label for="Password" class="sr-only">Hasło</label>
            <input type="password" name="Password" id="Password" class="form-control" placeholder="Hasło" required pattern=".{6,12}" title="Od 6 do 12 znaków">
        </div>
        <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->

        <button type="submit" class="btn btn-lg btn-primary btn-block">Zaloguj się</button>
        <button type="button" class="btn btn-lg btn-info btn-block" data-toggle="modal" data-target="#registration_modal">Stwórz konto</button>
      </form>
<!-- /HTML Form -->

<!-- Registration Form -->
  <div class="modal fade" role="dialog" id="registration_modal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- HTML Form -->
        <form action="submit.php" method="post" name="registration_form" id="registration_form" >
        <div class="modal-header">
            <h4 class="modal-title">Formularz rejestracyjny</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <!-- Modal Body -->
        <div class="modal-body">
            <div class="form-group">
                <label for="Name">Imię i nazwisko</label>
                <input type="text" name="Name" id="Name" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki" autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="Email" id="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Password">Hasło</label>
                <input type="password" name="Password" id="Password" class="form-control" required pattern=".{6,12}" title="Od 6 do 12 znaków">
            </div>
            <div class="form-group">
                <label for="Confrim-password">Powtórz hasło</label>
                <input type="password" name="Confirm-password" id="Confirm-password" class="form-control" required pattern=".{6,12}" title="Od 6 do 12 znaków">
            </div>
            <div class="form-group">
                <label for="Course">Kierunek studiów</label>
                <input type="text" name="Course" id="Course" class="form-control" required pattern=".{2,100}" title="Minimum 2 znaki. autofocus>
            </div>
            <div class="form-group">
                <label for="Year">Rok</label>
                <select class="form-control custom-select" name="Year" id="Year" value="1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="StudentID">Numer albumu</label>
                <input type="text" name="StudentID" id="StudentID" class="form-control" required pattern=".{6,6}" title="6 cyfr" autofocus>
            </div>
            <div class="form-group">
                <label for="Department">Funkcja w zespole</label>
                <select class="form-control custom-select" name="Role" id="Role">
                    <?php
                        getRoles($con);
                    ?>
                </select>
            </div>
            <div class="form-group text-center">
                <div class="g-recaptcha" data-sitekey="6Lcw-7AUAAAAANrOgdPiASA4EvNrWVWYF9MHcMTj"></div>
            </div>
                <div id="display_error" class="alert alert-danger alert-dismissible fade show"></div><!-- Display Error Container -->
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
        <input type="submit" class="btn btn-lg btn-success" value="Stwórz" id="submit">
          <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Anuluj</button>
        </div>
        </form>

      </div>
    </div>
  </div>

<?php require('include/footer.php');?>