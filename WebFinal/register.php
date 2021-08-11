
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
    <title>Register</title>
</head>
<body id = 'sign-in-body'>





<nav class="navbar navbar-expand-sm bg-dark navbar-dark  ">
  <a class="navbar-brand" href="#">
  <h1  >Classroom Management System</h1>
  </a>
</nav>
<div id = 'login-div' class="col-lg-5 col-md-7 col-sm-10 col-10">

        <div id = 'login-container' class="container">
        <form  method="post"  id = 'sign-up-form'>
        <div class = "form-group"><h2>Register your account</h2> </div>
        <div class="form-group justify-content-center">
        <p class ='text-danger' id ='sign-up-alert'> <?= $err?></p>
            <label for="input-group-text">Full name:</label>
            <input type="input-group-text" name = 'fullname' class="form-control" placeholder="your full name" id="full name" required>
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Department:</label>
            <input type="input-group-text" name = 'department_name' class="form-control" placeholder="your department" id="department" required>
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Phone number:</label>
            <input type="tel" name = 'tel' class="form-control" placeholder="your phone number" id="phone number " required>
        </div>
        <div class="form-group justify-content-center">
            <label for="email">Email address:</label>
            <input type="email" name = 'email' class="form-control" placeholder="Enter email" id="email" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" name = 'password' class="form-control" placeholder="Enter password" id="pwd" required>
        </div>
        <div class="form-group">
            <label for="pwd">Comfirm password:</label>
            <input type="password" name = 'c_password' class="form-control" placeholder="Enter passwowrd again" id="c_pwd">
        </div>
        
        </form> 
        <div>
        <button id = 'sign-up-button'  onclick = 'sign_up()' class="btn btn-primary form-button">Create</button>
        </div>
        
        
</div>



<div class="modal" id = 'go-login' tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create account success!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <a href="login.php"> <h2>click here to Login your new account now</h2></a>
      </div>
    </div>  
  </div>
</div>     


</body>
</html>
