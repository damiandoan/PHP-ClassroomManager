<?php 
define('DB_SERVER', 'localhost:8889');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'account');
function     create_connection(){
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
else{ 
    // echo 'success connection';
    return $mysqli;
}

}

function login($email, $password){
    $sql = 'select * from user where email = ?';
    $connection = create_connection();
    $stm = $connection->prepare($sql);
    $stm->bind_param('s',  $email);
    if (!$stm->execute()){
        //khong chay dc
        return null;
    }
    $result = $stm->get_result();
    if ($result->num_rows == 0){
        echo "khong co tai khoan"; 
        return null;
    }
    $data = $result->fetch_assoc();
    $hashed_password = $data['user_password'];
    if (!password_verify($password, $hashed_password)){
        //sai mat khau
        echo "sai mat khau";
        return null;
    }
    else {
        return $data;}

}
function reset_password($email){
    
}
?>