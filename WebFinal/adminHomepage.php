<?php
// check is that user logined
require('database.php');
session_start();
   if (!isset($_SESSION['admin'])){
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
    <title>Adminstration</title>
</head>
<body class = 'purple-body' onload="get_user()" >




<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">
  <h2 >Classes Management</h1>
  
  </a>
    
  <button class="navbar-toggler btn btn-dark" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
      </li>
      <li class="nav-item">
       <!-- empty-->
      </li>
      <li class="nav-item">
        <!-- empty-->
      </li>
       <!-- Dropdown -->
    <li class="nav-item dropdown">
    <button class="btn btn-warning  dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
    Admin
</button>
    <div class="dropdown-menu">
       <button type ='submit' name = 'sign-out' form = 'sign-out-form' class="dropdown-item btn" href="#" id = 'sign-out-button'>Sign Out</a>
        
    </div>
    </li>    
    </ul>
  </div>  
</nav>


<div class = 'container admin'>
    <div class ='row' id= "admin-page" >
            
    </div>
</div>

<div id ='role-modal'></div>

<form action = 'logout.php' method = 'post' id = 'sign-out-form'></form>
</body>
</html>