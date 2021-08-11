<?php
include('database.php');
if(isset($_GET['email']) && isset($_GET['token'])){

    $email = $_GET['email'];
    $token = $_GET['token'];
    
    //test is token and email legal
    $sql = 'SELECT * from password_token where email = ? and token = ? and expired_time>?';
    $connection = create_connection();
    $stmt = $connection->prepare($sql);
    
    $curr_time = time();
    $stmt -> bind_param('ssi', $email, $token, $curr_time);
    if(!$stmt->execute()){
        $err = 'Sorry! something went wrong';
    }
    else{
        $stmt->store_result();
        
        if ($stmt->num_rows == 0){
            echo "password reset request is invalid request or expired "; 
        }
        else{
            if(isset($_POST['password']) && isset($_POST['c_password'])){
                $password = $_POST['password'];
                $c_password = $_POST['c_password'];
                if ($password != $c_password){
                    $err = 'confirm password is invalid';
                }
                else{
                    $sql = 'UPDATE user set user_password = ? where email = ?';
                    $connection = create_connection();
                    $stmt = $connection->prepare($sql);
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $stmt -> bind_param('ss', $password, $email);
    
                    if(!$stmt->execute()){
                        $err = 'Sorry! something went wrong';
                    }
                    else{
                        if ($stmt->affected_rows == 1){
                        $alert = 'Change password successfully!';
                        }
                        else{
                            $err = 'something when wrong';
                        }
                    }
                }
            }
        }
    }
}else{
    header('location: reset_password.php');
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
<div id = 'login-div' class="col-lg-5 col-md-7 col-sm-10 col-10">

        <div id = 'login-container' class="container" >
        <form action="change_password.php?email=<?=$email?>&token=<?=$token?>" method = 'post'>
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
        <p> <?= $alert?></p>

</div>

</body>
</html>
