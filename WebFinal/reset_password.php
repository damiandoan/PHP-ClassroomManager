<?php
//if user loggin move to homepage
//    session_start();
   include('database.php');
   $err = '';
   if (isset($_POST['email'])){
       //reset password
       $email = $_POST['email'];
       if(is_email_existed($email)!=true){
          $err = 'Sorry! we not found your account by this email.';
       }
       else{
           //check there is already token
           $token = md5($email. '+' .random_int(1,100000000));
           $sql = 'UPDATE  password_token set token = ? where email = ?';
           $connection = create_connection();
           $stmt = $connection->prepare($sql);
           
           $stmt -> bind_param('ss', $token, $email);
           
           if(!$stmt->execute()){
               $err = 'Sorry! something went wrong';
           }
           else{
                if($stmt->affected_rows==0){
                    $expired_time =  3600*12+ time();
                    $sql = 'insert into password_token values(?,?,?)';
                    $stmt = $connection -> prepare($sql);
                    $stmt->bind_param('ssi', $email, $token, $expired_time); 
                    if(!($stmt->execute())){
                        $err = 'Sorry! something went wrong';
                    }
                }
                send_reset_password_email($email, $token);
                echo 'An email has been sent to '.''.$email;
            }
       }
       
   }
   else{

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
<body >


<nav class="navbar navbar-expand-sm bg-dark navbar-dark  ">
  <a class="navbar-brand" href="#">
  <h1  >Classroom Management System</h1>
  </a>
</nav>

<div id = 'login-div' class="col-lg-5 col-md-7 col-sm-10 col-10">

        <div id = 'login-container' class="container" >
        <form action="reset_password.php" method = 'post'>
        <div class = "form-group"><h2>Send email to reset password</h2> </div>
        <div class="form-group justify-content-center">
            <label for="email">Email address:</label>
            <input type="email" name = 'email' class="form-control" placeholder="Enter email" id="email">
        </div>
        <button type="submit" class="btn btn-primary form-button">Send email</button>
        <p class ='error-alert'> <?= $err?></p>

</div>

</body>
</html>
