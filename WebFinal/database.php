<?php

use JetBrains\PhpStorm\ArrayShape;
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
session_start();


if(isset($_POST['delete-student']) & isset($_POST['from-classroom'])){
  $student_ID = $_POST['delete-student'];
  $classroom_name = $_POST['from-classroom'];
   if(delete_student_from_class($classroom_name, $_SESSION['email'], $student_ID)==true){
    print_r(json_encode('success'));
   }
   else{
    print_r(json_encode('fail'));
   }
}
if(isset($_GET['stload_email']) &&isset($_GET['stload_classroom_name']) ){
  $email = $_GET['stload_email'];
  $classroom_name= $_GET['stload_classroom_name'];
  // echo $email, $classroom_name;
  $result = get_students_from_classroom($classroom_name, $email);
  print_r(json_encode($result));
}

if(isset($_GET['view_SID']) &&isset($_GET['view_classroom_name']) ){
  $student_ID = $_GET['view_SID'];
  $classroom_name= $_GET['view_classroom_name'];
  // echo $email, $classroom_name;
  $result = get_miss_lessons_from_student($classroom_name, $_SESSION['email'], $student_ID);
  print_r(json_encode($result));
}

if(isset($_POST['d_teacher_email']) &&isset($_POST['d_classroom_name']) ){
  $email = $_POST['d_teacher_email'];
  $classroom_name= $_POST['d_classroom_name'];
  // echo $email, $classroom_name;
  if(delete_classroom($classroom_name, $email)){
    print_r(json_encode(Array('status'=>'success')));
  }
}



if( isset($_POST['classroom_name'] ) && isset($_POST['subject'] ) && isset($_POST['course_length'] ) && isset($_POST['room_ID'] ) &&isset($_POST['create_classroom']) ){
  if($_POST['create_classroom'] == true){
    $classroom_name = $_POST['classroom_name'];
    $subject = $_POST['subject'];
    $course_length = ($_POST['course_length']);
    $course_length = intval($course_length);
    $room_ID= $_POST['room_ID'] ;
    $email = $_SESSION['email'];

    $alert= add_classroom($classroom_name, $subject, $room_ID, $course_length, $email);
    
    print_r(json_encode(array('status'=>$alert)));

  }
}  


if( isset($_POST['classroom_name'] ) && isset($_POST['subject'] ) && isset($_POST['course_length'] ) && isset($_POST['room_ID'] ) &&isset($_POST['edit']) ){
  if($_POST['edit'] == true){
  // echo'good';
  $classroom_name = $_POST['classroom_name'];
  $new_classroom_name = $_POST['new_classroom_name'];
  $subject = $_POST['subject'];
  $course_length = ($_POST['course_length']);
  $course_length = intval($course_length);
  $room_ID= $_POST['room_ID'] ;
  $email = $_SESSION['email'];
  
  $connection = create_connection();
  if(is_uploaded_file($_FILES['classroom_image']['tmp_name'])){
     
     $image = "database/classroom_images/".upload_classroom_photo($email.$classroom_name);
    //  echo json_encode($image);
     $sql = 'update classroom set classroom_name=?,`subject`=?,room_ID=?,image = ?,course_length=?  where classroom_name=? and teacher_email =? ';
     $stmt = $connection->prepare($sql);
    
    $stmt->bind_param('ssssiss', $new_classroom_name, $subject, $room_ID, $image,$course_length,$classroom_name, $email);
    if($stmt->execute()){
      print_r(json_encode(Array('status'=>'success')));
    }
    
  }
  else{
    $sql = 'update classroom set classroom_name=?,`subject`=?,room_ID=?,course_length=?  where classroom_name=? and teacher_email =? ';

    $stmt = $connection->prepare($sql);
    $stmt->bind_param('sssiss', $new_classroom_name, $subject, $room_ID,$course_length,$classroom_name, $email); 
    $stmt->bind_param('ssssiss', $new_classroom_name, $subject, $room_ID, $image,$course_length,$classroom_name, $email);
    // echo 'good';
     if($stmt->execute()){
      
          // echo 'good';
          print_r(json_encode(Array('status'=>'success')));
  
     }

  }  

    //  $alert = add_classroom($classroom_name, $subject, $room_ID, $course_length, $email);
  }   

}

if(isset($_GET['login_status'])){
  if(!isset($_SESSION['email']) && !isset($_SESSION['admin'])){
    print_r(json_encode('false'));
  }
}

if(isset($_GET['adminview'])){
  if(!isset($_SESSION['admin'])){
    header("location: login");
  }
   $sql = 'select fullname, email, department_name, tel from user';
   $connection = create_connection();
   $stmt = $connection->prepare($sql);
    
   if($stmt->execute()){
    
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          // output data of each row
          
          while($row = $result->fetch_assoc()) {
            $row['role'] = get_role($row['email']);
            $data[]= $row;
            
          }

        }
        print_r(json_encode($data));

} 
}

if(isset($_POST['email_role'])){
  $connection = create_connection();
  $email = $_POST['email_role'];
  $role = get_role($email);
  // echo 'role'. $role;
  if($role == 'teacher'){
      

            $sql = 'insert into admin(email) values(?)';
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $email);
            if($stmt->execute()){
              print_r('switch to admin success');
            } 
  }
  else{
    $sql = 'delete from admin  where email = ?';
      
      $stmt = $connection->prepare($sql);
      $stmt->bind_param("s", $email);
      if($stmt->execute()){
        print_r('switch to teacher success');
      }  
  }
}


if(isset($_GET['inspect'])){
  if(!isset($_SESSION['admin'])){
    print_r('fail');
  }
    $_SESSION['email'] = $_GET['inspect'];
    $_SESSION['fullname'] = 'Administrator';
    print_r('success');
}

if(isset($_GET['classrooms_load'])){
  $teacher_email = $_GET['classrooms_load'];
  $result = get_classroom($teacher_email);
  print_r(json_encode($result));
}

function get_role($email){
  $sql = "SELECT email FROM admin WHERE email= ?";
    $connection = create_connection();
            $stmt = $connection->prepare($sql);
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $email);
            
            // Set parameters
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    return 'administrator';
                }
                else{
            
                  $sql = "SELECT email FROM user WHERE email= ?";
                  $connection = create_connection();
                  $stmt = $connection->prepare($sql);
                  // Bind variables to the prepared statement as parameters
                  $stmt->bind_param("s", $email);
                  
                  // Set parameters
                  if($stmt->execute()){
                      // store result
                      $stmt->store_result();
                      
                      if($stmt->num_rows == 1){
                        return 'teacher';
                      }
                      }
                    }    
                      
                      
            } 
            $stmt->close();
            return 'unknown';

}

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
  //check is this admin
  $role = 'user';
  $connection = create_connection();
  $sql = 'select * from admin where email = ?';
  $stm = $connection->prepare($sql);
    $stm->bind_param('s',  $email);
    
    if (!$stm->execute()){
      return Array('error', null);
    }
    
    $result = $stm->get_result();
        if ($result->num_rows == 1){
          $role = 'admin';
    }
    
  // check login
      $sql = 'select * from user where email = ?';
    
      $stm = $connection->prepare($sql);
      $stm->bind_param('s',  $email);
      if (!$stm->execute()){
        return Array('wrong', null);
      }
      $result = $stm->get_result();
      if ($result->num_rows == 0){
          
          return Array('account doesnt exists', null);
      }
      $data = $result->fetch_assoc();
      $hashed_password = $data['user_password'];
      $connection->close();
      if (!password_verify($password, $hashed_password)){
        return Array('wrong password', null);
          
      }
      else {
        //login success
        return Array($role, $data);
        
    }
     


   return Array('wrong', null);
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
        $mail->Username   = '519h0323@student.tdtu.edu.vn';                     //SMTP username
        $mail->Password   = 'WCRVd69sXCxHwrw';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('519h0323@student.tdtu.edu.vn');
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
        $mail->Body    = "<h1>RESET PASSWORD FOR $email </h1><h1><a href='http://localhost:8888/change_password.php?email=$email&token=$token'> Click here to change password.</a></h1> ";
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function add_classroom($classroom_name, $subject, $room_ID, $course_length, $email){
  //prevent leak another account information
  if($_SESSION['email'] != $email){
    return null;
  }
    $sql = 'INSERT INTO classroom ( classroom_name, `subject`, room_ID, `image`, course_length, teacher_email) VALUES ( ?, ?, ?, ?, ?, ?)';
    $connection = create_connection();
    // echo $classroom_name, $subject, $room_ID, $course_length, $email;
    $stmt = $connection->prepare($sql);
         
        $image ="database/classroom_images/".upload_classroom_photo($email.$classroom_name);
    $stmt->bind_param('ssssis', $classroom_name, $subject, $room_ID, $image,$course_length, $email);
    
    if(!$stmt->execute()){
      $alert = 'check your classroom name, its duplicate by others';
  }
  else{
      $alert = 'success';
  }
  $connection->close();
  return $alert;
    
}


function upload_classroom_photo($filename){
    $target_dir = "database/classroom_images/";
    $target_file = $target_dir . basename($_FILES["classroom_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file = $_FILES["classroom_image"];
    
    
      $check = getimagesize($file["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        $uploadOk = 0;
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
     
    $extension  = $imageFileType;
    $filename = $filename.'.'.$extension;
    if(file_exists($target_dir.$filename)) {
      unlink($target_dir.$filename);
   }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      return null;
    } else {
      if (move_uploaded_file($file["tmp_name"], $target_dir.$filename)) {
        //echo "The file ". htmlspecialchars( basename( ["name"])). " has been uploaded.";
        return $filename;
      } else {
        //echo "Sorry, there was an error uploading your file.";
      }
    }
    return null;
    }
    

function delete_classroom($classroom_name, $email){
   //prevent leak another account information
   if($_SESSION['email'] != $email){
    return null;
  }
  
              $sql = 'delete from classroom where classroom_name = ? and teacher_email = ?';
              $connection = create_connection();
              $stmt = $connection->prepare($sql);
              $stmt->bind_param('ss', $classroom_name, $email);
              if(!$stmt->execute()){
                $alert = 'error! cannot delete classroom';
              }
              else{
                return true;
                
              }
        
       

    $connection->close();
    return false;
}

function add_student($classroom_name, $teacher_email, $student_ID, $first_name, $last_name, $student_email){
  //prevent leak another account information
  if($_SESSION['email'] != $teacher_email){
    return null;
  }
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
            
  //prevent leak another account information
  if($_SESSION['email'] != $teacher_email){
    return false;
  }

            $sql = 'DELETE FROM take_course where classroom_name = ? and teacher_email = ? and student_ID =?';
            $connection = create_connection();
            $stmt = $connection->prepare($sql);
            $stmt->bind_param('sss', $classroom_name, $teacher_email,$student_ID);
            if(!$stmt->execute()){
              $success = false;
            }
            else{
              $success = true;
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
  //prevent leak another account information
  if($_SESSION['email'] != $teacher_email){
    return null;
  }
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
  //prevent leak another account information
  if($_SESSION['email'] != $teacher_email){
    return null;
  }
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
  //prevent leak another account information
  if($_SESSION['email'] != $teacher_email){
    return null;
  }
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
    //if attendance don't exist
    $sql = 'select * from attendance where lesson_ID =? and student_ID =?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    $stmt->bind_param('ss', $lesson_ID, $student_ID);
      if($stmt->execute()){

        $result = $stmt->get_result();
        if($result->num_rows == 0){
          echo 'check ok';

          $sql = 'INSERT INTO ATTENDANCE(lesson_ID, student_ID) values(?,?)';
        
          $stmt = $connection->prepare($sql);
          
          $stmt->bind_param('ss', $lesson_ID, $student_ID);
            if(!$stmt->execute()){
              echo " Sorry! cannot check $student_ID attend";
            }
        }    

    } 
      $connection->close();
  }

  function uncheck_attendance($lesson_ID, $student_ID){
    //if attendance exist
    $sql = 'select * from attendance where lesson_ID =? and student_ID =?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    $stmt->bind_param('ss', $lesson_ID, $student_ID);
      if($stmt->execute()){

        $result = $stmt->get_result();
        if($result->num_rows == 1){

              $sql = 'delete from ATTENDANCE where lesson_ID =? and student_ID =?';
              $connection = create_connection();
              $stmt = $connection->prepare($sql);


              $stmt->bind_param('ss', $lesson_ID, $student_ID);
              
                if(!$stmt->execute()){
                  echo " Sorry! cannot uncheck $student_ID";
                }
        }    

    } 
    
      $connection->close();
  }

  function get_lesson($classroom_name, $teacher_email){
    //prevent leak another account information
    if($_SESSION['email'] != $teacher_email){
      return null;
    }
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
    //prevent leak another account information
    if($_SESSION['email'] != $teacher_email){
      return null;
    }
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
    //prevent leak another account information
    if($_SESSION['email'] != $teacher_email){
      return null;
    }
    
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
    //prevent leak another account information
    if($_SESSION['email'] != $teacher_email){
      return null;
    }
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