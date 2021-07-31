<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'library/Exception.php';
require 'library/PHPMailer.php';
require 'library/SMTP.php';


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
function is_existed_email($email){
    //check if the email is already registed
    $sql = "SELECT email FROM user WHERE email= ?";
    $connection = create_connection();
    echo "oke roi";

            $stmt = $connection->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $email);
            
            // Set parameters
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    return true;
                }
                return false;
            
            }
            else{
                $err = 'cannot connect to server';
                return true;
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
function send_reset_password_email($email, $token){
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
            );
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'daudaihoc040501@gmail.com';                     //SMTP username
        $mail->Password   = 'nghiadeptrai09';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('daudaihoc040501@gmail.com');
        $mail->addAddress($email, 'Customer');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        // //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password for Classroom management system account';
        $mail->Body    = "<a href='http://localhost:8888/change_password.php?email=$email&token=$token/'> Click here to change password.</a> ";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
function reset_password($email){

}
?>