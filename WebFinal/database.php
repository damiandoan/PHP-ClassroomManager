<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHP_MAILER/Exception.php';
require 'PHP_MAILER/PHPMailer.php';
require 'PHP_MAILER/SMTP.php';


define('DB_SERVER', 'localhost:8889');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'account');
function  create_connection(){
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
    $connection->close();
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
        $mail->Username   = '';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
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
    // echo $classroom_name, $subject, $room_ID, $course_length, $email;
    $stmt = $connection->prepare($sql);
         
        $image = upload_classroom_photo($email.$classroom_name);
    $stmt->bind_param('ssssis', $classroom_name, $subject, $room_ID, $image,$course_length, $email);
    
    if(!$stmt->execute()){
        $err = 'sorry!';
    }
    else{
        $alert = 'Create classroom successfully!';
    }
    $connection->close();
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
    
   
    if ($file["size"] > 500000000) {
      // echo "Sorry, your file is too large.";
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
      return null;
    } else {
      $extension  = $imageFileType;
      $filename = $filename.'.'.$extension;
      if (move_uploaded_file($file["tmp_name"], $target_dir.$filename)) {
        //echo "The file ". htmlspecialchars( basename( ["name"])). " has been uploaded.";
      } else {
        //echo "Sorry, there was an error uploading your file.";
      }
    }
    return $filename;
    }
    

function delete_classroom($classroom_name, $email){
  
              $sql = 'delete from classroom where classroom_name = ? and teacher_email = ?';
              $connection = create_connection();
              $stmt = $connection->prepare($sql);
              $stmt->bind_param('ss', $classroom_name, $email);
              if(!$stmt->execute()){
                $alert = 'error! cannot delete classroom';
              }
              else{
                $alert = 'delete '.$classroom_name.' successfully';
                echo 'good';
              }
        
       

    $connection->close();
    return $alert;
}

function add_student($classroom_name, $teacher_email, $student_ID, $first_name, $last_name, $student_email){
    $sql = 'SELECT * FROM student where student_ID =?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $student_ID);
    
   if(!$stmt->execute()){
      $alert = 'error! cannot check student is exist';
    }else{
      $result = $stmt->get_result();
      if ($result->num_rows == 0) {
          //
          $sql = 'INSERT INTO student (student_ID, first_name, last_name, email) VALUES (?, ?, ?, ?)';
          $stmt = $connection->prepare($sql);
          $stmt->bind_param('ssss', $student_ID,$first_name, $last_name, $student_email);
          if(!$stmt->execute()){
            $alert = 'error! cannot add the student to classroom';
          }
          //
      }

    }

      $sql = 'INSERT INTO take_course (student_ID, classroom_name, teacher_email) VALUES (?, ?, ?)';
      $stmt = $connection->prepare($sql);
      $stmt->bind_param('sss', $student_ID,$classroom_name, $teacher_email);
      if(!$stmt->execute()){
        $alert = 'error! cannot add the student';
      }
      else{
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
          $alert = $first_name.' '.$last_name.' '.$student_ID.' '.'already in classroom';
        }  
      $alert = 'Add '.$first_name.' '.$last_name.' to '.$classroom_name.' successfully !';
      }
    $connection->close();
    return $alert;
}

function delete_student_from_class($classroom_name, $teacher_email, $student_ID){

            $sql = 'DELETE FROM take_course where classroom_name = ? and teacher_email = ? and student_ID =?';
            $connection = create_connection();
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('sss', $classroom_name, $teacher_email,$student_ID);
            if(!$stmt->execute()){
              $success = true;
            }
            else{
              $success = false;
              }        
  
      
      $connection->close();
      return $success;

}
function get_student_from_ID($student_ID){
  $sql = 'SELECT student_ID, first_name, last_name from student where student_ID = ?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    
    $stmt->bind_param('s', $student_ID);
      if(!$stmt->execute()){
        // echo "<p class ='error-alert'> Sorry! cannot find student</p>";
      }
      else{
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
          // output data of each row
              // echo 'founded';
              $data = $result->fetch_assoc();
                
         }
         return $data;
      }
      $connection->close();
      return null;
   
}


function import_students_from_csv($classroom_name, $teacher_email){
  $file = $_FILES['student-list-file'];
  if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          add_student($classroom_name, $teacher_email, $data[0], $data[1], $data[2], $data[3]);
      }
      fclose($handle);
  }
  else{
    echo 'something wrong!';
  }
  }


function get_students_from_classroom($classroom_name, $teacher_email){
  $sql = 'SELECT student.student_ID, student.first_name, student.last_name, student.email FROM student, take_course WHERE take_course.teacher_email like ? and take_course.classroom_name like ? and student.student_Id = take_course.student_ID';
  $connection = create_connection();
  $stmt = $connection->prepare($sql);
  
  $stmt->bind_param('ss', $teacher_email,$classroom_name);
    if($stmt->execute()){
    
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        // output data of each row
        
        while($row = $result->fetch_assoc()) {
          
          $data[]= $row;
          
        }

      }

  } 
  $connection->close();
  return $data;
}

  

function create_lesson($classroom_name, $teacher_email, $date, $shift){
  $sql = 'INSERT INTO lesson(classroom_name, teacher_email,date, shift) values(?,?,?,?)';
  $connection = create_connection();
  $stmt = $connection->prepare($sql);
  $stmt->bind_param('ssss', $classroom_name,$teacher_email, $date, $shift);
    if($stmt->execute()){
      $sql = 'SELECT lesson_ID from lesson where classroom_name like ? and teacher_email like ? and date like ? and shift like ?';
      $stmt = $connection->prepare($sql);
      
      
      $stmt->bind_param('ssss', $classroom_name,$teacher_email, $date, $shift);
      
      if($stmt->execute()){
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();  
            $lesson_ID = $data['lesson_ID'];
            return $lesson_ID;   
      }
    }
}
           
  
  function check_attendance($lesson_ID, $student_ID){
    $sql = 'INSERT INTO ATTENDANCE(lesson_ID, student_ID) values(?,?)';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    
    $stmt->bind_param('ss', $lesson_ID, $student_ID);
      if(!$stmt->execute()){
        echo "<p class ='error-alert'> Sorry! cannot check <?=$student_ID?> attend </p>";
      }
      $connection->close();
  }

  function get_lesson($classroom_name, $teacher_email){
    $sql = 'SELECT date,shift, lesson_ID FROM lesson where classroom_name = ? and teacher_email = ?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    
    $stmt->bind_param('ss', $classroom_name, $teacher_email);
      if(!$stmt->execute()){
        echo "<p class ='error-alert'> Sorry! cannot load lesson</p>";
      }
      else{
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          // output data of each row
          
              while($row = $result->fetch_assoc()) {
                
              $data[]= $row;
              
              }
         }
         return $data;
      }
      $connection->close();
      return null;
  }
  



  function get_miss_lessons_from_student($classroom_name, $teacher_email, $student_ID){
     $sql = 'SELECT lesson_ID, date, shift from lesson where classroom_name = ? and teacher_email = ? and lesson_ID not IN (SELECT lesson_ID from  attendance where student_ID = ?)';
     $connection = create_connection();
     $stmt = $connection->prepare($sql);
     
     $stmt->bind_param('sss', $classroom_name,$teacher_email, $student_ID);
     
     if($stmt->execute()){
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        // output data of each row
        
            while($row = $result->fetch_assoc()) {
              
            $data[]= $row;
            
            }
       }
       return $data; 
     }
     $connection->close();
  }

  function get_student_miss_over_20($classroom_name, $teacher_email){
    $total_lesson = count(get_lesson($classroom_name, $teacher_email));
    $student_list = get_students_from_classroom($classroom_name, $teacher_email);
    
    foreach($student_list as $student){
         $miss_day = count(get_miss_lessons_from_student($classroom_name,$teacher_email,$student['student_ID']));
         if($miss_day/$total_lesson > 1/5) //over 20% of lesson miss
         $result[] = $student;
    }
    return $result;
  }


  function get_classroom($teacher_email){
    
    $sql = 'select * from classroom where teacher_email = ?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    
    $stmt->bind_param('s', $teacher_email);
      if(!$stmt->execute()){
        echo "<p class ='error-alert'> Sorry! cannot load classroom</p>";
      }
      else{
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          // output data of each row
          
              while($row = $result->fetch_assoc()) {
                
              $data[]= $row;
              
              }
         }
         return $data;
      }
      $connection->close();
      return null;
  }
?>