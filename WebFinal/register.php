<?php
//check is that user logined
//   session_start()
  
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
    <title>Register</title>
</head>
<body id = 'sign-in-body'>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark  ">
  <a class="navbar-brand" href="#">
  <h1  >Classes Management System</h1>
  </a>
</nav>
<div id = 'login-div' class="col-lg-5 col-md-7 col-sm-10 col-10">

        <div id = 'login-container' class="container">
        <form action="/action_page.php">
        <div class = "form-group"><h2>Register your account</h2> </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Full name:</label>
            <input type="input-group-text" class="form-control" placeholder="your full name" id="full name">
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Department:</label>
            <input type="input-group-text" class="form-control" placeholder="your department" id="department">
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Phone number:</label>
            <input type="tel" class="form-control" placeholder="your phone number" id="phone number " pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}">
        </div>
        <div class="form-group justify-content-center">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" placeholder="Enter email" id="email">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" placeholder="Enter password" id="pwd">
        </div>
        <button id = 'form-button' type="submit" class="btn btn-primary form-button">Create</button>

</div>

</body>
</html>
