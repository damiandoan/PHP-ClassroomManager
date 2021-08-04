<?php
require('database.php');



if (isset($_GET['keyword'])&&isset($_GET['email'])){
$data = get_classroom($_GET['email']);
$q = $_GET['keyword'];
$result = array();
foreach($data as $row){
        $name = strtolower($row['classroom_name']);
        if(strpos($name, $q ) >-1){
            $result[] = $row['classroom_name'];
        } 
}
// // print($result);
print_r(json_encode($result));
}
?>