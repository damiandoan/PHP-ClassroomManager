<?php
// Initialize the session

if (isset($_POST['sign-out'])){
session_start();
$_SESSION = array();
session_destroy();
}
header('location: login.php');
exit();
?>