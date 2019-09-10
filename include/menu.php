
<?php
require_once 'PhpRbac/src/PhpRbac/Rbac.php';
$rbac = new PhpRbac\Rbac();
$tmp = getUserData($con, $_SESSION['UserData']['user_id']);

?>

<nav class="mb-1 navbar navbar-expand-lg navbar-dark blue">
    <a class="navbar-brand" href="/solar-pm/">PUT Solar Dynamics</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
        <ul class="navbar-nav mr-auto">
            <?php
            $visible = $rbac->check('admin-panel', $_SESSION['UserData']['user_id']);
            if($visible)
                echo '<li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" id="coordinator-panel" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">Panel administratora
                           </a>
                                <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">';
            if($rbac->check('append-user', $_SESSION['UserData']['user_id']))
                echo '<a class="dropdown-item" href="new-users.php">Nowi użytkownicy</a>';
            if($rbac->check('all-users', $_SESSION['UserData']['user_id']))
                echo '<a class="dropdown-item" href="all-users.php">Członkowie zespołu</a>';
            if($visible)
                echo '</div></li>';
            ?>

            <?php
            $visible = $rbac->check('leader-panel', $_SESSION['UserData']['user_id']);
            if($visible && 'Koordynator' != $tmp['Title']) {
                echo '<li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle" id="leader-panel" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">Panel lidera
                           </a>
                                <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">';
                if ($rbac->check('department-new-users', $_SESSION['UserData']['user_id']))
                    echo '<a class="dropdown-item" href="new-users.php">Nowi członkowie działu</a>';
                if ($rbac->check('department-users', $_SESSION['UserData']['user_id']))
                    echo '<a class="dropdown-item" href="all-users.php">Członkowie działu</a>';
                if ($visible)
                    echo '</div></li>';
            }
            if(isAppended($con, $_SESSION['UserData']['user_id']) == 1) {
                ?>

                <li class="nav-item">
                    <a class="nav-link" id="new-user-menu" href="new-project.php">Stwórz projekt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="my-projects" href="my-projects.php">Moje projekty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="list-of-elements" href="list-of-elements.php">Spis części</a>
                </li>
                <?php
            }
            ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="final-panel" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">Zaliczenie
                </a>
                <div class="dropdown-menu dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
                    <a class="dropdown-item" href="maths.php">MathJax</a>
                    <a class="dropdown-item" href="media.php">Media</a>
                    <a class="dropdown-item" href="drag-and-drop.php">Drag&Drop</a>
                    <a class="dropdown-item" href="canvas.php">Canvas</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i> <?php echo $_SESSION['UserData']['name'] ?> </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                    <a class="dropdown-item" href="my-account.php">Moje konto</a>
                    <a class="dropdown-item" href="logout.php">Wyloguj się</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
