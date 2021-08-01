<?php
// check is that user logined
require('database.php');
session_start();
   if (!isset($_SESSION['fullname'])){
       header( "Location: login.php");
       exit();
   }

   //erease anything in session
  if(isset($_SESSION['logout'])){
    session_destroy();
    header( "Location: login.php");
       exit();
  }

  if( isset($_POST['classroom_name'] ) && isset($_POST['subject'] ) && isset($_POST['course_length'] ) && isset($_POST['room_ID'] ) ){
     $classroom_name = $_POST['classroom_name'];
     $subject = $_POST['subject'];
     $course_length = ($_POST['course_length']);
     $course_length = intval($course_length);
     $room_ID= $_POST['room_ID'] ;
     $email = $_SESSION['email'];
     if (isset($_POST['submit-add-classroom'])){

        $alert = add_classroom($classroom_name,$subject, $room_ID, $course_length, $email);
     }
     
     
  }
  if(isset($_POST['delete-classroom'])){
    $param = explode('<*>', $_POST['delete-classroom']);
    $email = $param[0];
    $classroom_name= $param[1];
    $sql = 'delete from classroom where classroom_name = ? and teacher_email = ?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $classroom_name, $email);
    if(!$stmt->execute()){
      $err = 'error! cannot delete classroom';
    }
    else{
      $err = 'delete '.$classroom_name.' successfully';
    }

    
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
    <title>homepage</title>
</head>
<body>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">
  <h1  >Classes Management System</h1>
  </a>
  <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Find your class" aria-label="Search">
        <button class="btn btn-primary" type="submit">Search</button>
      </form>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
      <button type ='submit' name = 'add-class'  class="btn btn-dark" href="#"  data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add classroom</button>
      </li>
      <li class="nav-item">
       <!-- empty-->
      </li>
      <li class="nav-item">
        <!-- empty-->
      </li>
       <!-- Dropdown -->
    <li class="nav-item dropdown">
    <button class="btn btn-dark  dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
      <?= htmlspecialchars($_SESSION["fullname"])?>
</button>
    <div class="dropdown-menu">
       <button type ='submit' name = 'sign-out' form = 'sign-out-form' class="dropdown-item btn" href="#" id = 'sign-out-button'>Sign Out</a>
        
    </div>
    </li>    
    </ul>
  </div>  
</nav>

<form action = 'logout.php' method = 'post' id = 'sign-out-form'></form>
<form action = 'homepage.php' method = 'post' id = 'delete-classroom'></form>





<div class="container">
      <div class="row">
        
        <?php
           $sql = 'SELECT user.fullname, classroom.classroom_name, classroom.subject, classroom.room_ID, classroom.course_length, classroom.image from classroom, user where classroom.teacher_email = ? and classroom.teacher_email = user.email';
           $connection = create_connection();
           $stmt = $connection->prepare($sql);
           
           $email = $_SESSION['email'];
           $stmt->bind_param('s', $email);
           if($stmt->execute()){
            
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
              // output data of each row
              
              while($row = $result->fetch_assoc()) {
                ?>
                <div class = 'col-md-4'>
                <div class="card" >
                  <div class="card-header">
      
                          <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                              <h4><?=$row['classroom_name']?></h4>
                            </li>
                            <li class="nav-item ml-auto">
                              <div class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                  Edit
                                </button>
                                <div class="dropdown-menu">
                                <button type="submit" form = 'delete-classroom' value = '<?=$email?><*><?=$row['classroom_name']?>' name ='delete-classroom' class="dropdown-item btn-red"> Delete</button>
                                <button type="submit" class="dropdown-item btn-light">Add student</button>
                                </div>
                              </div>
                            </li>
                          </ul>
      
                  </div>
                  
                  <div class="card-body">
                    <img class="card-img-top" src="database/classroom_images/<?= $row['image']?>" alt="Card image" >
                    <h4 class="card-title"><?=$row['subject']?></h4>
                    <p class="card-text"><?=$row['course_length'] ?> Lessons</p>
                  </div>
                </div>
                </div> 
              
<?php
              }
            } else {
              echo " 0 results";
            }
           }
           else{
             $err = "can't get data from server!";

           } 
        ?>
        
        </div>
  </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="homepage.php" method="post" class="form-horizontal" role="form" id = 'add-class-form' enctype="multipart/form-data">


              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Class name</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="classroom_name" id="name">
                  </div>
              </div> <!-- form-group // -->

              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Subject</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="subject" >
                  </div>
              </div> <!-- form-group // -->
              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Room</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="room_ID" >
                  </div>
              </div> <!-- form-group // -->

              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">Course length</label>
                  <div class="col-sm-9">
                  <input type="number" class="form-control" name="course_length" >
                  </div>
              </div> <!-- form-group // -->

              

            
              <label for="img">Upload your classroom avatar (Optional):</label>
              <input type="file"  name="classroom_image"  accept="image/*">

            
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name = 'submit-add-classroom' form = 'add-class-form' class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<p><?=$alert[1]?> <?=$alert[0]?></p>
</body>
</html>