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
function is_email_existed($email){
    //check if the email is already registed
    $sql = "SELECT email FROM user WHERE email= ?";
    $connection = create_connection();

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
                
                $stmt->close();
                return false;
            } 
}
function login($email, $password){
    $sql = 'select * from user where email = ?';
    $connection = create_connection();
    $stm = $connection->prepare($sql);
    $stm->bind_param('s',  $email);
    if (!$stm->execute()){
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
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();
        $mail ->CharSet = 'UTF-8';                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'email cua minh';                     //SMTP username
        $mail->Password   = 'mat khau';                               //SMTP password
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
        $mail->Body    = "<a href='http://localhost:8888/change_password.php?email=$email&token=$token'> Click here to change password.</a> ";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function add_classroom($classroom_name, $subject, $room_ID, $course_length, $email){
    $sql = 'INSERT INTO classroom ( classroom_name, `subject`, room_ID, `image`, course_length, teacher_email) VALUES ( ?, ?, ?, ?, ?, ?)';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    if( !empty($_FILES)){
         
        $image = upload_classroom_photo($email.$classroom_name);
    }
    else{
        $image = NULL;
    }
    $stmt->bind_param('ssssis', $classroom_name, $subject, $room_ID, $image,$course_length, $email);
    
    if(!$stmt->execute()){
        $err = 'sorry!';
    }
    else{
        $alert = 'Create classroom successfully!';
    }
    return array($err, $alert);
    
}


function upload_classroom_photo($filename){
    $target_dir = "database/classroom_images/";
    $target_file = $target_dir . basename($_FILES["classroom_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file = $_FILES["classroom_image"];
    
    if(isset($_POST["submit"])) {
      $check = getimagesize($file["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
      //echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($file["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      //echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      $extension  = pathinfo( $file["name"], PATHINFO_EXTENSION );
      $filename = $filename.'.'.$extension;
      if (move_uploaded_file($file["tmp_name"], $target_dir.$filename)) {
        //echo "The file ". htmlspecialchars( basename( ["name"])). " has been uploaded.";
      } else {
        //echo "Sorry, there was an error uploading your file.";
      }
    }
    return $filename;
    }
    
   
?>