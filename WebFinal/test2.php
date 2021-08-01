<?php
require('database.php');
if(isset($_POST["submit"])) {
    adu('alow2w');
  }
?>

<!DOCTYPE html>
<html>
<body>

<form action="test2.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="classroom_image" id="classroom_image" accept="image/*"> 
  <input type="submit" value="Upload Image" name="submit" >
</form>

</body>
</html>