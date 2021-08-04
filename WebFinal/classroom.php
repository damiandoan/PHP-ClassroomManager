<?php
 require('database.php');
 session_start();
    if (!isset($_SESSION['fullname'])){
        header( "Location: login.php");
        exit();
    }

if(!isset($_SESSION['classroom_name'])){
        header('location: homepage.php');
}
$classroom_name = $_SESSION['classroom_name'];
$teacher_email = $_SESSION['teacher_email'];

if(isset($_POST['submit-add-student-form'])){
  $alert =add_student($classroom_name, $teacher_email, $_POST['student_ID'], $_POST['first_name'], $_POST['last_name'], $_POST['student_email']);
  header('Location: '.$_SERVER["PHP_SELF"], true, 303);
}
if(isset($_POST['submit-import-students-form'])){
  import_students_from_csv($classroom_name, $teacher_email);
  header('Location: '.$_SERVER["PHP_SELF"], true, 303);
}

if(isset($_POST['delete-student'])){
  $student_ID = $_POST['delete-student'];
   if(delete_student_from_class($classroom_name, $teacher_email, $student_ID)==true){
    header('Location: '.$_SERVER["PHP_SELF"], true, 303);
   }
}

if(isset($_POST['date']) && isset($_POST['shift'])){
  
  $date = $_POST['date'];
  $shift = $_POST['shift'];
  $lesson_ID = create_lesson($classroom_name,$teacher_email,$date, $shift);
  header('Location: '.$_SERVER["PHP_SELF"], true, 303);
}

if(isset($_POST['student_attended'])){
  $student_attended = $_POST['student_attended'];
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src = 'main.js'> </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title><?=$classroom_name?> </title>
</head>
<body>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">
  <h1  ><?=$classroom_name?></h1>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <button class="btn btn-primary"  type = 'submit' data-toggle="modal" data-target="#add-student-modal-box" data-whatever="@mdo" >Add student</a>
      </li>
      <li class="nav-item">
      <button class="btn text-dark bg-light" type = 'submit' data-toggle="modal" data-target="#import-students-modal" data-whatever="@mdo" >Import students</a>
      </li>
      <li class="nav-item">
      <button class="btn text-white bg-success" type = 'submit' data-toggle="modal" data-target="#create-shift-modal" data-whatever="@mdo" >Create lesson</a>

      </li>
      
      <li class="nav-item">
      <button class="btn text-white btn-secondary" type = 'submit' data-toggle="modal" data-target="#review-miss-modal" data-whatever="@mdo" >Review student miss 20% lesson</a>

      </li>
    
    </ul>
  </div>  
</nav>

<!-- LESSONS VIEW ZONE -->
<div class = 'container top'>
   <p><h3>schedule</h3></p>
    <div class = 'row'>
          <div >
          <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Date</th>
              <th scope="col">Shift</th>
              <th scope="col"></th>

            </tr>
          </thead>
          <tbody>
          <?php 
                      $data =get_lesson($classroom_name, $teacher_email);
                      $i = 0;
                      foreach($data as $row){
                        ?>
                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><?=$row['date']?></td>
                          <td><?=$row['shift']?></td>
                          <td>
                            <button type="submit" class="btn btn-outline-secondary"  onclick = "" data-toggle="modal" data-target="#check-attendance" data-whatever="@mdo">check attendance</button>
                            <button type="button" class="btn btn-danger"  onclick = "send_delete_student_request('<?=$row['lesson_ID']?>')"> Delete </button>
                          </td>
                        </tr>
                        <?php
                        $i++;
                      }
  
          ?>
            </tbody>
            </table>
          </div>


    </div>
   <!-- LESSONS VIEW ZONE --> 



  
</div>
<div class = 'container'>
   <p><h3>Student list</h3></p>
<table class="table table-hower table-striped ">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Student ID</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
  <tbody>
  <?php 
   $data =get_students_from_classroom($classroom_name, $teacher_email);
   $i = 0;
   foreach($data as $row){
    ?>
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$row['first_name']?></td>
      <td><?=$row['last_name']?></td>
      <td><?=$row['student_ID']?></td>
      <td ><p class = 'td-email'><?=$row['email']?></p></td>
      <td><button type="submit"  class="btn btn-danger"  onclick = "send_delete_student_request('<?=$row['student_ID']?>','<?=$row['first_name']?>','<?=$row['last_name']?>')" data-toggle="modal" data-target="#confirm-delete-student" data-whatever="@mdo">Delete</button></td>
    </tr>
    <?php
    $i++;
   }
  
  ?>
   </tbody>
</table>
</div>


<div class="modal " id="add-student-modal-box" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add student to <?=$classroom_name?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="classroom.php" method="post" class="form-horizontal" role="form" id = 'add-student-form' enctype="multipart/form-data">


              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">First name</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="first_name">
                  </div>
              </div> <!-- form-group // -->

              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Last name</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="last_name" >
                  </div>
              </div> <!-- form-group // -->
              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Student ID</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="student_ID" >
                  </div>
              </div> <!-- form-group // -->

              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="student_email" >
                  </div>
              </div> <!-- form-group // -->

              

            
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name = 'submit-add-student-form' form = 'add-student-form' class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>



<div class="modal" id="import-students-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-light">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Import student from csv to <?=$classroom_name?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="classroom.php" method="post" class="form-horizontal" role="form" id = 'import-students-form' enctype="multipart/form-data">
      <label for="formFileMultiple" class="form-label"> use csv file with studentID, first name, last name, email in each line format! :</label>
      <input class="form-control btn-light" type="file"  name="student-list-file"  accept=".csv" >
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name = 'submit-import-students-form' form = 'import-students-form' class="btn btn-primary">Import</button>
      </div>
    </div>
  </div>
</div>


<!-- model box for delete student alert! -->
<div class="modal" tabindex="-1" role="dialog" id="confirm-delete-student">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p> Do you really want to delete <strong id ='student-delete-name'></strong></p>
        <form action="classroom.php" method="post">
        <button type = 'submit' id = 'delete-button' name ='delete-student' class="btn btn-primary">Delete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- model box for delete student alert! -->



 <!-- model box for create shift! -->
 <div class="modal modal-xl" tabindex="-1" role="dialog" id="create-shift-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create a shift</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Create a lesson for <?=$classroom_name?></p>
        <form method ='post' action = 'classroom.php' role = 'form' id ='create-shift-form'>
        <div class = 'form-group'>
              <label>Date:</label>
              <input type ='date' name = 'date'>
        </div>
        
        <div class = 'form-group'>

              <label>Shift:</label>  
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-secondary active">
                      <input type="radio" name="shift" id="option1" value="1" autocomplete="off" checked> Shift 1
                    </label>
                    <label class="btn btn-outline-secondary">
                      <input type="radio" name="shift" id="option2" value="2" autocomplete="off">Shift 2
                    </label>
                    <label class="btn btn-outline-secondary">
                      <input type="radio" name="shift" id="option3" value="3" autocomplete="off"> Shift 3
                    </label>
                    <label class="btn btn-outline-secondary">
                      <input type="radio" name="shift" id="option3" value ='4' autocomplete="off"> Shift 4
                    </label>
            </div>
        </div>
        

  </form>
      </div>
      <div class="modal-footer">
        <button type = 'submit'  form ='create-shift-form' class="btn btn-outline-primary">Add record</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- model box for create shift  -->


<!-- model box for review 20% miss student! -->
<div class="modal modal-xl" tabindex="-1" role="dialog" id="review-miss-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Students miss over 20% lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
                            <div class = 'vertical-scroll'>
                    <table class="table table-hower table-dark ">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">First Name</th>
                          <th scope="col">Last Name</th>
                          <th scope="col">Student ID</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $data =get_student_miss_over_20($classroom_name, $teacher_email);
                      $i = 0;
                      foreach($data as $row){
                        ?>
                        <tr>
                          <th scope="row"><?=$i?></th>
                          <td><?=$row['first_name']?></td>
                          <td><?=$row['last_name']?></td>
                          <td><?=$row['student_ID']?></td>                        </tr>
                        <?php
                        $i++;
                      }
                      
                      ?>
                      </tbody>
                    </table>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- model box for review 20% miss student!  -->



<!-- model box for check attendance! -->
<div class="modal modal-xl" tabindex="-1" role="dialog" id="check-attendance">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Students miss over 20% lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
    
      <div class = 'container'>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Student ID</th>
      <!-- <th scope="col">Email</th> -->
      <th scope="col">Attend</th>
    </tr>
  </thead>
  <tbody>
  <?php 
   $data =get_students_from_classroom($classroom_name, $teacher_email);
   $i = 0;
   foreach($data as $row){
    ?>
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$row['first_name']?></td>
      <td><?=$row['last_name']?></td>
      <td><?=$row['student_ID']?></td>
      <!-- <td><?=$row['email']?></td> -->
      <td class = 'align-middle'><input class="form-check-input" type="checkbox" name = 'student_attended[]' value="<?=$row['student_ID']?>"></td>
    </tr>
    <?php
    $i++;
   }
  
  ?>
   </tbody>
</table>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- model box for check attendance!  -->


<form action = 'classroom.php' method="POST" id = 'delete-selected-student'></form>
<p><?=$alert?></p>
</body>
</html>