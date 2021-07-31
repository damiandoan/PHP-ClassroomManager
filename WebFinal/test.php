<?php
include('db.php');
$result =send_reset_password_email('daudaihoc040501@gmail.com', 5000);
echo $result;
?>