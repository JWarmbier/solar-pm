<?php

/*Function to get users data*/
function getUserData($con, $user_id){
$result = $con->query("SELECT U.*, P.name, P.name, P.course, P.student_id, P.year, R.Title, S.RoleID FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_ID=P.user_id LEFT JOIN solar_userroles S ON S.UserID=U.user_ID   LEFT JOIN solar_roles R ON R.ID=S.RoleID WHERE U.user_id='$user_id' LIMIT 1");
    if($result->num_rows==1){
        return $result->fetch_assoc();
    }else{
    	return FALSE;
    }
}

function showAllUsers($con, $user_id){
    $result = $con->query("SELECT U.*, P.name, P.name, P.course, P.student_id, P.year, R.Title, S.RoleID FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_ID=P.user_id LEFT JOIN solar_userroles S ON S.UserID=U.user_ID   LEFT JOIN solar_roles R ON R.ID=S.RoleID");
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if($user_id != $row['user_id'])
            echo '<option value="'.$row['user_id'].'">'.$row['name'].'</option>';
        }
    }
}

function safeInput($con, $data) {
  return htmlspecialchars(mysqli_real_escape_string($con, trim($data)));
}

/*Function to set JSON output*/
function output($Return=array()){
    /*Set response header*/
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    /*Final JSON response*/
    exit(json_encode($Return));
}
/*Function to get list of roles*/
function getDepartments($con){
    $result = $con->query("SELECT * FROM departments");
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['DepartmentID'].'">'.$row['DepartmentName'].'</option>';
        }
    }
}
function getRoles($con){
    $res = $con->query("SELECT * FROM solar_roles");
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            if(substr_count($row['Title'], 'Członek') == 1)
            echo '<option value="'.$row['ID'].'">'.$row['Title'].'</option>';
        }
    }else {
        echo '<option> Brak elementów w tabeli "roles" </option>';
    }
}
function getAllRoles($con, $myRole){
    $res = $con->query("SELECT * FROM solar_roles");
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            if($row['Title'] != 'root')
                if($row['Title'] == $myRole)
                    echo '<option value="'.$row['ID'].'" selected>'.$row['Title'].'</option>';
                else
                    echo '<option value="'.$row['ID'].'">'.$row['Title'].'</option>';
        }
    }else {
        echo '<option> Brak elementów w tabeli "roles" </option>';
    }
}

/*Function to check if the department exists */
function isDepartmentID($con, $departmentID){
    $result = $con->query("SELECT * FROM departments WHERE DepartmentID=".$departmentID);
    if($result->num_rows == 1)
        return true;
    else
        return false;
}

/* Function displays rows in table with users which are not appended.*/
function getNewUsers($con){
    $rbac = new PhpRbac\Rbac();
    $result = null;
    $tmp = getUserData($con, $_SESSION['UserData']['user_id']);
    $children = $rbac->Roles->children($tmp['RoleID']);
    if(count($children)!= 0 && $tmp['Title'] != 'Koordynator' ){
        $result = $con->query("SELECT U.*, P.name, P.name, P.course, P.student_id, P.year, R.Title, S.RoleID FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_ID=P.user_id LEFT JOIN solar_userroles S ON S.UserID=U.user_ID   LEFT JOIN solar_roles R ON R.ID=S.RoleID  WHERE U.status='0' AND S.RoleID=".$children[0]['ID']);
    } else{
        $result = $con->query("SELECT U.user_id, U.email, U.entry_date, P.name FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_id=P.user_id WHERE U.status = '0'");
    }

    $counter = 1;
    if($result->num_rows > 0){
        while($user = $result->fetch_assoc()){
            echo '<tr>';
            echo '<th scope="row"><div class="custom-control custom-checkbox"><input class="form-check-input" type="checkbox" value="'.$user['user_id'].'" name="nrID[]"><label class="form-check-label" for="defaultCheck1">'.$counter.'</label></div></th>';
            echo '<td> '.$user['name'].'</td>';
            echo '<td> '.$user['user_id'].'</td>';
            echo '<td> '.$user['email'].'</td>';
            echo '<td> '.$user['entry_date'].'</td>';
            echo '</tr>';
            $counter++;
        }
    }
}

/* Function to append users */

function appendUsers($con, $users){
    for( $i = 0; $i < count($users); $i++){
        $result = $con->query("UPDATE tbl_users SET status='1' WHERE user_id=".$users[$i]);
    }
}

function getAllCurrentUsers($con){
    $result = $con->query("SELECT U.*, P.name, P.name, P.course, P.student_id, P.year, R.Title, S.RoleID FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_ID=P.user_id LEFT JOIN solar_userroles S ON S.UserID=U.user_ID   LEFT JOIN solar_roles R ON R.ID=S.RoleID WHERE U.status='1'");
    return $result;
}
function getAllKindOfUsers($con, $roleID){
    $result = $con->query("SELECT U.*, P.name, P.name, P.course, P.student_id, P.year, R.Title, S.RoleID FROM tbl_users U LEFT JOIN tbl_user_profile P ON U.user_ID=P.user_id LEFT JOIN solar_userroles S ON S.UserID=U.user_ID   LEFT JOIN solar_roles R ON R.ID=S.RoleID  WHERE U.status='1' AND S.RoleID=".$roleID);
    return $result;
}

function showListOfNames($users){
    $i = 0;
    while($user = $users->fetch_assoc()) {
        echo '<a class="list-group-item list-group-item-action ';
        if($i == 0) echo ' active';
        echo '" id="list-ID-'.$user['user_id'].'-list" data-toggle="list" href="#list-ID-'.$user['user_id'].'" role="tab" aria-controls="ID-'.$user['user_id'].'">'.$user['name'].'</a>';
        $i++;
    }
}
function removeAccount($con, $user_id){
    $con->query("DELETE FROM tbl_user_profile WHERE user_id=".$user_id);
    $con->query("DELETE FROM tbl_users WHERE user_id=".$user_id);

}

function showDescriptionOfUsers($con, $users){
    $i = 0;
    $tmp = getUserData($con, $_SESSION['UserData']['user_id']);
    while($user = $users->fetch_assoc()){
        ?>

        <div class="tab-pane fade
        <?php
        if($i == 0) echo 'show active';
        echo '" id="list-ID-'.$user['user_id'].'" role="tabpanel" aria-labelledby="list-ID-'.$user['user_id'].'-list">';
        ?>
         <form calss="profile-form" id="profile-<?php echo $user['user_id']; ?>" action="all-users.php" method="post">
            <h3 class="h3-responsive font-weight-light" id="name"><?php echo $user['name'];?></h3>
            <hr>

            <p class="font-weight-medium email" ><b>Adres email: </b> <?php echo $user['email'];?></p>
            <p class="font-weight-medium year" ><b>Rok studiów: </b><?php echo $user['year'];?></p>
            <p class="font-weight-medium course"><b>Kierunek studiów: </b><?php echo $user['course'];?></p>
            <p class="font-weight-medium student_id"><b>Nr albumu: </b><?php echo $user['student_id'];?></p>
        <?php
        if(substr_count($tmp['Title'], 'Lider') == 0) {
            ?>
            <label for="Department">Funkcja w zespole:</label>
            <select class=" custom-select" name="role" id="role_id">
                <?php
                getAllRoles($con, $user['Title']);
                ?>
            </select>
            <?php
        } else {
            ?>
            <p class="font-weight-medium student_id"><b>Funkcja w zespole: </b><?php echo $user['Title'];?></p>
            <?php
        }
            ?>
            <br>
            <input type="hidden" name="user_id" value="<?php echo $user['user_id'];?>">
            <div class="clearfix">
                <button type="submit" class="btn btn-primary btn float-right" name="action" value="remove-account">Usuń użytkownika</button>
                <?php


                    if(substr_count($tmp['Title'], 'Lider') == 0)
                    {
                ?>
                        <button type="submit" class="btn btn-primary btn float-right" name="action" value="change-role" >Zmień funckję</button>
                <?php
                    }
                ?>
            </div>
        </form>
        </div>

        <?php
        $i++;
    }
}