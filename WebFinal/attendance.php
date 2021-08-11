<?php
include('database.php');
//check attandance
if(isset($_POST['student_ID']) && isset($_POST['lesson_ID'])){
  $lesson_ID = $_POST['lesson_ID'];
  $student_ID = $_POST['student_ID'];
  check_attendance($lesson_ID, $student_ID);
  print_r('success');
}

//uncheck attandance
if(isset($_POST['un_student_ID']) && isset($_POST['lesson_ID'])){
  $lesson_ID = $_POST['lesson_ID'];
  $student_ID = $_POST['un_student_ID'];
  uncheck_attendance($lesson_ID, $student_ID);
  print_r('uncheck success');
}

if(isset($_GET['attendance_view'])){
  $lesson_ID = $_GET['attendance_view'];
  $sql = 'select student_ID from attendance where lesson_ID = ?';
  $connection = create_connection();
  $stmt = $connection->prepare($sql);
  
  
  $stmt->bind_param('s', $lesson_ID);
    if(!$stmt->execute()){
      echo " Sorry! cannot load classroom";
    }
    else{
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        // output data of each row
        
            while($row = $result->fetch_assoc()) {
              
            $data[]= $row['student_ID'];
            
            }
            print_r(json_encode($data));
       }
       else{
         print_r(json_encode(array()));
       }
       
    }
    $connection->close();
    
}


if(isset($_GET['review20name'])&&isset($_GET['review20email'])){
  $classroom_name = $_GET['review20name'];
  $teacher_email = $_GET['review20email'];
  $result = get_student_miss_over_20($classroom_name, $teacher_email);
  print_r(json_encode($result));
}

?>