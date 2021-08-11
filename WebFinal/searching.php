<?php
require('database.php');



if (isset($_GET['keyword'])&&isset($_GET['email'])){
$data = get_classroom($_GET['email']);
$q = strtolower($_GET['keyword']);
$result = array();
foreach($data as $row){
        $name = strtolower($row['classroom_name']);
        $subject = strtolower($row['subject']);
        $room_ID = strtolower($row['room_ID']);
        if(strpos($name, $q ) >-1){
            $result[] = $row['classroom_name'];
        }
        if(strpos($subject , $q) >-1){
            $result[] = $row['subject'];
        }
        if(strpos($room_ID ,$q) >-1){
            $result[] = $row['room_ID'];
        }
}
// // print($result);
print_r(json_encode($result));
}
?>