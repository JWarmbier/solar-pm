<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
 // exit("Unauthorized Acces");
//}
require('inc/config.php');
require('inc/functions.php');

require_once 'PhpRbac/src/PhpRbac/Rbac.php';
$rbac = new PhpRbac\Rbac();

/* Check Login form submitted */
if(!empty($_POST) && $_POST['Action']=='login_form'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>array(), 'error'=>'');

    $email = safeInput($con, $_POST['Email']);
    $password = safeInput($con, $_POST['Password']);


    /* Server side PHP input validation */
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $Return['error'] = "Wpisz poprawny email.";
    }elseif($password===''){
        $Return['error'] = "Wpisz hasło.";
    }

    if($Return['error']!=''){
        output($Return);
    }

    /* Check Email and Password existence in DB */
    $result = $con->query("SELECT * FROM tbl_users WHERE email='$email' AND password='".md5($password)."' LIMIT 1");
    if($result->num_rows==1){
        $row = $result->fetch_assoc();
        /* Success: Set session variables and redirect to Protected page */
        $user = getUserData($con, $row['user_id']);
        $_SESSION['timestamp'] = time();
        $Return['result'] = $_SESSION['UserData'] = array('user_id'=>$row['user_id'], 'name' => $user['name']);
    } else {
        /* Unsuccessful attempt: Set error message */
        $Return['error'] = 'Niepoprawne dane.';
    }
    /*Return*/
    output($Return);
}


/* Check Registration form submitted */
if(!empty($_POST) && $_POST['Action']=='registration_form'){
    /* Define return | here result is used to return user data and error for error message */
    $Return = array('result'=>array(), 'error'=>'');

    $name = safeInput($con, $_POST['Name']);
    $email = safeInput($con, $_POST['Email']);
    $password = safeInput($con, $_POST['Password']);
    $confirm_password = safeInput($con, $_POST['Confirm-password']);
    $course = safeInput($con, $_POST['Course']);
    $year = safeInput($con, $_POST['Year']);
    $studentID = safeInput($con, $_POST['StudentID']);
    $department = safeInput($con, $_POST['Role']);

    /*reCAPTCHA validation*/
    $captcha  = $_POST['g-recaptcha-response'];
    $secretKey = "6Lcw-7AUAAAAAD7jy_xQu6Y-W2VT-Z17Uuvm_DOz";
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);


    /* Server side PHP input validation */

    if($name===''){
        $Return['error'] = "Wpisze imię i nazwisko.";
    }elseif (!preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@student.put.poznan.pl/",$email)) {
        $Return['error'] = "Wpisz uczelniany adres email.";
    }elseif( $password === ''||($password != $confirm_password) ){
        $Return['error'] = "Hasła różnią się od siebie.";
    }elseif($course ===''){
        $Return['error'] = "Wpisz kierunek studiów";
    } elseif($year === ''){
        $Return['error'] = "Wybierz rok";
    } elseif(!preg_match("/^[0-9]*$/", $studentID)){
        $Return['error'] = "Wpisz poprawny nr albumu.";
    } elseif($department === '' ){
        $Return['error'] = "Wybierz dział.";
    } elseif(!$responseKeys["success"]) {
        $Return['error'] = "";
    }

    if($Return['error']!=''){
        output($Return);
    }
    /* Check Email existence in DB */
    $result = $con->query("SELECT * FROM tbl_users WHERE email='$email' LIMIT 1");
    if($result->num_rows==1){
        /*Email already exists: Set error message */
        $Return['error'] = 'Istnieje konto o takim adresie email.';
    }else{
        /*Insert registration data to user table (user_GUID is Unique Identifier and Default status is 0 means pending)*/
        $con->query("INSERT INTO tbl_users (user_GUID, email, password, entry_date) values(MD5(UUID()), '$email', '".md5($password)."' ,NOW())");
        $user_id = mysqli_insert_id($con); /* Get the auto generated id used in the last query */
        /*Insert registration data to user profile table */
        $con->query( "INSERT INTO `tbl_user_profile` (user_id,name, course, student_id, role_id, year) VALUES('$user_id','$name','$course','$studentID','$department','$year' )");
        /* Success: Set session variables and redirect to Protected page */
        $Return['result'] = $_SESSION['UserData'] = array('user_id'=>$user_id, 'name'=>$name);
        $_SESSION['timestamp'] = time();
        $rbac->Users->assign($department, $user_id);
    }
    /*Return*/
    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='update_profile_form'){
    $Return = array('result'=>array(), 'error'=>'');

    $name = safeInput($con, $_POST['Name']);
    $email = safeInput($con, $_POST['Email']);
    $course = safeInput($con, $_POST['Course']);
    $year = safeInput($con, $_POST['Year']);
    $studentID = safeInput($con, $_POST['StudentID']);

    if($name===''){
        $Return['error'] = "Wpisze imię i nazwisko.";
    }elseif (!preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@student.put.poznan.pl/",$email)) {
        $Return['error'] = "Wpisz uczelniany adres email.";
    }elseif($course ===''){
        $Return['error'] = "Wpisz kierunek studiów";
    } elseif($year === ''){
        $Return['error'] = "Wybierz rok";
    } elseif(!preg_match("/^[0-9]*$/", $studentID)){
        $Return['error'] = "Wpisz poprawny nr albumu.";
    }
    $user = getUserData($con, $_SESSION['UserData']['user_id']);

    $result = $con->query("UPDATE tbl_users SET email='$email' WHERE user_id=".$user['user_id']);
    $result = $con->query("UPDATE tbl_user_profile SET name='$name', course='$course', year='$year', student_id='$studentID' WHERE user_id=".$user['user_id']);

    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='password_form'){
    $Return = array('result'=>array(), 'error'=>'');

    $password = safeInput($con, $_POST['Password']);
    $confirm_password = safeInput($con, $_POST['Confirm-password']);

    if( $password === ''||($password != $confirm_password) ){
        $Return['error'] = "Hasła różnią się od siebie.";
    }

    $user = getUserData($con, $_SESSION['UserData']['user_id']);

    $result = $con->query("UPDATE tbl_users SET password='".md5($password)."' WHERE user_id=".$user['user_id']);

    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='new-project-form'){
    $Return = array('result'=>array(), 'error'=>'');

    $title = safeInput($con, $_POST['title']);
    $description = safeInput($con, $_POST['description']);
    $author = safeInput($con, $_POST['author']);
    $department = safeInput($con, $_POST['department']);

    $coworkers = null;
    if(isset($_POST['coworker']))
        $coworkers =  $_POST['coworker'];

    if( $title === '' or strlen($title) < 6 ){
        $Return['error'] = "Tytuł musi mieć przynajmniej 5 znaków.";
    } elseif ($description === '' or strlen($description) < 21) {
        $Return['error'] = "Opis musi mieć przynajmniej 20 znaków.";
    }
    if($Return['error'] == ''){
        $con->query("INSERT INTO solar_projects (name, description , department_id, author_id) values ('$title','$description','$department','$author')");
        $project_id = mysqli_insert_id($con);

       if($coworkers != null){
            for($i=0; $i < count($coworkers) ; $i++){
                $con->query("INSERT INTO solar_projectsusers (project_id, user_id) VALUES ('$project_id','$coworkers[$i]')");
            }
        }
    }
    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='update-project-form'){
    $Return = array('result'=>array(), 'error'=>'');

    $id = safeInput ($con, $_POST['project_id']);
    $title = safeInput($con, $_POST['title']);
    $description = safeInput($con, $_POST['description']);
    $author = safeInput($con, $_POST['author']);
    $department = safeInput($con, $_POST['department']);

    $coworkers = null;
    if(isset($_POST['coworker']))
        $coworkers =  $_POST['coworker'];
    if( $title === '' or strlen($title) < 6 ){
        $Return['error'] = "Tytuł musi mieć przynajmniej 5 znaków.";
    } elseif ($description === '' or strlen($description) < 21) {
        $Return['error'] = "Opis musi mieć przynajmniej 20 znaków.";
    }

    if($Return['error'] == ''){
        $con->query("UPDATE solar_projects SET name ='$title', description='$description', department_id='$department' WHERE ID=".$id);
        $con->query("DELETE FROM solar_projectusers WHERE project_id=".$id);

        if($coworkers != null){
            for($i=0; $i < count($coworkers) ; $i++){
                $con->query("INSERT INTO solar_projectsusers (project_id, user_id) VALUES ('$id','$coworkers[$i]')");
            }
        }
    }
    if(isset($_POST['amountOfElements']) && isset($_POST['elements'])){
        $con->query("DELETE FROM solar_projectselements WHERE project_id=".$id);
        $amountOfElemetns = $_POST['amountOfElements'];
        $elements = $_POST['elements'];
        for($i = 0; $i < count($amountOfElemetns); $i++){
            if($amountOfElemetns[$i] != 0){
                $con->query("INSERT INTO solar_projectselements (project_id, element_id, amount) VALUES ('$id','$elements[$i]','$amountOfElemetns[$i]')");
            }
        }
    }

    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='new-element-form'){
    $Return = array('result'=>array(), 'error'=>'');

    $name = safeInput($con, $_POST['el_name']);
    $category = safeInput($con, $_POST['category']);
    $parameter = safeInput($con, $_POST['el_parameter']);
    $amount = safeInput($con, $_POST['el_amount']);
    $datasheet = safeInput($con, $_POST['datasheet']);

    if( $name === '' or strlen($name) < 3 ){
        $Return['error'] = "Tytuł musi mieć przynajmniej 2 znaków.";
    } elseif ($category === '' ) {
        $Return['error'] = "Kategoria nie została wybrana";
    } elseif($parameter === ''){
        $Return['error'] = "Nie wpisano parametru.";
    }elseif (!preg_match("/^[0-9]/",$amount) or $amount === ''){
        $Return['error'] = "Ilość musi być liczbą całkowitą";
    } elseif (strlen($datasheet) < 3){
        $Return['error'] = "Wpisz link do dokumentacji.";
    }

    if($Return['error'] == ''){
        $con->query("INSERT INTO solar_elements(el_name, el_parameter, el_amount, el_category_id, datasheet) VALUeS ('$name','$parameter','$amount','$category','$datasheet')");
    }
    output($Return);
}

if(!empty($_POST) && $_POST['Action']=='edit-element-form'){
    $Return = array('result'=>array(), 'error'=>'');


    $element_id = safeInput($con, $_POST['element_id']);
    $name = safeInput($con, $_POST['el_name']);
    $category = safeInput($con, $_POST['category']);
    $parameter = safeInput($con, $_POST['el_parameter']);
    $amount = safeInput($con, $_POST['el_amount']);
    $datasheet = safeInput($con, $_POST['datasheet']);

    $res = $con->query("SELECT * FROM solar_elements WHERE element_id=".$element_id);

    if($res->num_rows == 0){
        $Return[''] = "Nie istnieje już taki element w bazie danych";
    }
    elseif( $name === '' or strlen($name) < 3 ){
        $Return['error'] = "Tytuł musi mieć przynajmniej 2 znaków.";
    } elseif ($category === '' ) {
        $Return['error'] = "Kategoria nie została wybrana";
    } elseif($parameter === ''){
        $Return['error'] = "Nie wpisano parametru.";
    }elseif (!preg_match("/^[0-9]/",$amount) or $amount === ''){
        $Return['error'] = "Ilość musi być liczbą całkowitą";
    } elseif (strlen($datasheet) < 3){
        $Return['error'] = "Wpisz link do dokumentacji.";
    }

    if($Return['error'] == ''){
        $con->query ("UPDATE solar_elements SET el_name='$name', el_parameter='$parameter', el_category_id='$category', datasheet='$datasheet', el_amount='$amount' WHERE element_id=".$element_id);
    }
    output($Return);
}