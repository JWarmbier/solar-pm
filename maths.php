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


?>
    <!-- container -->

    <div class="container">
        <br>
        <h2 class="h2-responsive font-weight-light">Transformacja Fouriera - definicja</h2>

        $$ {
            {\hat {f}}(\xi )=\int \limits _{\mathbb {R} ^{n}}f(x)\ e^{-2\pi i(x,\xi )}\,dx
        } $$
        <h2 class="h2-responsive font-weight-light">Odwrotna transformata</h2>

        $$ {
        f(t)={\frac {1}{\sqrt {2\pi }}}\int \limits _{-\infty }^{\infty }{\hat {f}}(\omega )e^{i\omega t}d\omega
        } $$
    </div>

<?php require('include/footer.php');?>