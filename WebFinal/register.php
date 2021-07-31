<?php
    require('database.php');
    if(isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['department_name']) && isset($_POST['password']) && isset($_POST['c_password']) && isset($_POST['tel'])){
         print_r($_POST);
         $fullname = $_POST['fullname'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $c_password = $_POST['c_password'];
         $department_name = $_POST['department_name'];
         $tel = $_POST['tel'];
         $err = '';
         if(empty(trim($fullname))){
             $err = 'Please enter your full name';
         }
         else if (empty(trim($department_name))){
            $err = 'Please enter your department name';
        }
        else if (empty(trim($tel))){
            $err = 'Please enter your phone number';
        }
        else if (empty(trim($email))){
            $err = 'Please enter your email';
        }
        else if (empty(trim($password))){
            $err = 'Please enter your password';
        }
        else if (empty(trim($c_password))){
            $err = 'Please cofirm your password';
        }
        else{
                    if (is_email_existed($email)==true){
                        $err = 'email already taken';
                    }
                    
                    
                    if(strlen($password)<6){
                        $err ='password too short, require more than 6 characters';
                    }
                    if($password != $c_password){
                        $err = 'confirm password is invalid';
                    }
                    

                    if($err == ''){
                        //
                         // Prepare an insert statement
                         $sql = "INSERT INTO user (email,fullname,department_name,tel, user_password) VALUES (?, ?, ?,?, ?)";
                         $connection = create_connection();
         
                         if($stmt = $connection->prepare($sql)){
                             // Bind variables to the prepared statement as parameters
                             //hashing password
                             $password = password_hash($password, PASSWORD_BCRYPT);
                             $stmt->bind_param("sssss", $email, $fullname, $department_name, $tel, $password);
                             

                             // Attempt to execute the prepared statement
                             if($stmt->execute()){
                                 // Redirect to login page
                                 header("location: login.php");
                             } else{
                                 echo "Oops! Registrate unsuccessfully";
                             }
                            $stmt->close();
                        //
                         }
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
        <form action="register.php" method="post">
        <div class = "form-group"><h2>Register your account</h2> </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Full name:</label>
            <input type="input-group-text" name = 'fullname' class="form-control" placeholder="your full name" id="full name">
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Department:</label>
            <input type="input-group-text" name = 'department_name' class="form-control" placeholder="your department" id="department">
        </div>
        <div class="form-group justify-content-center">
            <label for="input-group-text">Phone number:</label>
            <input type="tel" name = 'tel' class="form-control" placeholder="your phone number" id="phone number ">
        </div>
        <div class="form-group justify-content-center">
            <label for="email">Email address:</label>
            <input type="email" name = 'email' class="form-control" placeholder="Enter email" id="email">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" name = 'password' class="form-control" placeholder="Enter password" id="pwd">
        </div>
        <div class="form-group">
            <label for="pwd">Comfirm password:</label>
            <input type="password" name = 'c_password' class="form-control" placeholder="Enter passwowrd again" id="c_pwd">
        </div>
        <button id = 'form-button' type="submit" class="btn btn-primary form-button">Create</button>
        <p class ='error-alert'> <?= $err?></p>
</div>

</body>
</html>
