<?php
//if user loggin move to homepage
   session_start();
   if (isset($_SESSION['fullname'])){
       header( "Location: homepage.php");
       exit();
   }
   require('database.php');
   $error = '';
   $email = '';
   $password = '';
   $email_error = '';
   $password_error = '';

   if(isset($_POST['email']) && isset($_POST['password'])){
       $email = $_POST['email'];
       $password = $_POST['password'];

       if (empty($email)){
           $email_error = 'Please enter email';
       }
       else if (empty($password)){
        $password_error = 'Please enter password';
       }
       else {
            $data = login($email, $password);
           
           if ($data){
               print_r($email);
               $_SESSION['fullname'] = $data['fullname'];
               header('Location: homepage.php');
               exit();
               //more data
           }
           else{
               $error = 'Invalid email or password';
           }

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
    <script src = 'main.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>login</title>
</head>
<body id = 'sign-in-body'>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark  ">
  <a class="navbar-brand" href="#">
  <h1  >Classroom Management System</h1>
  </a>
</nav>
<div id ='login-div' class="col-lg-5 col-md-7 col-sm-10 col-10 ">

        <div id = 'login-container' class="container" >
        <form action="login.php" method = 'post'>
        <div class = "form-group"><h2>Login</h2> </div>
        <div class="form-group justify-content-center">
            <label for="email">Email address:</label>
            <input type="email" name = 'email' class="form-control" placeholder="Enter email" id="email">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password"  class="form-control" placeholder="Enter password" id="pwd" name = 'password'>
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
            <input class="form-check-input" type="checkbox"> Remember me
            </label>
        </div>
       
        <button type="submit" class="btn btn-primary form-button">Login</button>
        <div class="form-link" > <a onclick = 'reset_password_popup() ; return false;' href="">Forgot password?</a> </div>
        
        <div class="form-link" > <a href="register.php">Don't have  an account? Create one.</a> </div>
        </form> 
        </div> 
        <p class ='error-alert'> <?= $err?></p>

</div>




</body>
</html>
