<?php
//if user loggin move to homepage
   session_start();
   if (isset($_SESSION['fullname'])){
       header( "Location: homepage.php");
       exit();
   }
   require('db.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>login</title>
</head>
<body id = 'sign-in-body'>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark  ">
  <a class="navbar-brand" href="#">
  <h1  >Classes Management System</h1>
  </a>
</nav>
<div id = 'reset-password-div' class="col-lg-5 col-md-7 col-sm-10 col-10">

        <div id = 'login-container' class="container" >
        <form action="reset.php" method = 'post'>
        <div class = "form-group"><h2>Reset Password</h2> </div>
        <div class="form-group justify-content-center">
            <label >Reset password for <?= $email?> </label>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password"  class="form-control" placeholder="Enter password" id="pwd" name = 'password'>
        </div>
        <div class="form-group">
            <label for="pwd">Confirm Password:</label>
            <input type="password"  class="form-control" placeholder="Enter password" id="pwd" name = 'c_password'>
        </div>
       
        <button type="submit" class="btn btn-primary form-button">Apply</button>
        </form> 
        </div> 
        <p> <?= $err?></p>

</div>

</body>
</html>
