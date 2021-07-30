<?php
// check is that user logined
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
      <button type ='submit' name = 'sign-out' form = 'add-class' class="btn btn-dark" href="#" id = 'add-class'>Add Class</a>
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





<div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card" >
            <div class="card-header">

              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            
            <div class="card-body">
              <img class="card-img-top" src="images/avatar2.jpeg" alt="Card image" style="width:50%" >
              <h4 class="card-title">Dang Minh Thang</h4>
              <p class="card-text">49 student - 30 periods - Room C004</p>
              <a href="#" class="btn btn-primary">Class</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!-- header -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/images.jpeg" alt="Card image" style="width:50%" >
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!-- header -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/images.jpeg" alt="Card image" style="width:50%">
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <!--  -->
            <div class="card-header">
              
              <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                  <h4>Web class</h4>
                </li>
                <li class="nav-item ml-auto">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Edit
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#">Remove class</a>
                      <a class="dropdown-item" href="#">Add student</a>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
            <img class="card-img-top" src="images/images.jpeg" alt="Card image" style="width:50%">
            <div class="card-body">
              <h4 class="card-title">John Doe</h4>
              <p class="card-text">Some example text some example text. John Doe is an architect and engineer</p>
              <a href="#" class="btn btn-primary">See Profile</a>
            </div>
          </div>
        </div>
        
      </div>
  </div>

</body>
</html>