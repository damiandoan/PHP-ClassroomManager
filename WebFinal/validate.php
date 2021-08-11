<?php
    require('database.php');
    if(isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['department_name']) && isset($_POST['password']) && isset($_POST['c_password']) && isset($_POST['tel'])){
         $fullname = $_POST['fullname'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $c_password = $_POST['c_password'];
         $department_name = $_POST['department_name'];
         $tel = $_POST['tel'];
         $err = 'false';
         if(empty(trim($fullname))){
             $err = 'Please enter your full name';
         }
         else if(!preg_match("/^([a-zA-Z' ]+)$/",$fullname)){
            $err = 'sorry, full name require letters only';
         }
         else if (empty(trim($department_name))){
            $err = 'Please enter your department name';
        }
        else if (empty(trim($tel))){
            $err = 'Please enter your phone number';
        }
        else if(!preg_match("/^([0-9]*)$/", $tel)) {
            $err = 'invalid phone number';
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
        else if (!preg_match('/^([a-z0-9\+\_\-\.]+)@([a-z0-9\+\_\-\.]{2,})(\.[a-z]{2,4})$/i', $email)){
            $err = 'invalid email';
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) || (strpos($email,'@student.tdtu.edu.vn') < 1 && strpos($email,'@tdtu.edu.vn') < 1)){
            $err = 'wrong domain, email must belong to @student.tdtu.edu.vn or @tdtu.edu.vn';
 
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
                    

                    if($err == 'false'){
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
                                //  header("location: login.php");
                                $err = 'success';
                             } else{
                                $err = "Oops! Registrate unsuccessfully";
                             }
                            $connection->close();
                        //
                         }
                    }
                    
                    
            
        } 

        print_r(json_encode($err));
    }
    

    if(isset($_POST['s_email']) && isset($_POST['s_password'])){

       
        $email = $_POST['s_email'];
        $password = $_POST['s_password'];
        $alert = 'wrong';
        if (empty($email)){
            $alert = 'Please enter email';
        }
        else if (empty($password)){
         $alert = 'Please enter password';
        }
        
        else {
             
             $respone = login($email, $password);
             // echo $respone[0], $respone[1];
             $alert = $respone[0];
            
 
             if(strcmp($respone[0],'admin')==0){
                 //logout all existed tab
                 session_destroy();
                 session_start();
                 $_SESSION['admin'] = true;
                 $alert = 'success';
                //  header('Location: adminHomepage.php');
             }
             else if(strcmp($respone[0],'user')==0){
                 //logout all existed tab
                 session_destroy();
                 session_start();
                 $_SESSION['fullname'] = $respone[1]['fullname'];
                 $_SESSION['email'] = $respone[1]['email'];
                 
                 $alert = 'success';
                //  exit();
             }
             
        }

        print_r(json_encode($alert));
        
    }
  
?>