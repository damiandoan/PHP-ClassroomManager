
<?php
function adu($filename){
$target_dir = "database/classroom_images/";
$target_file = $target_dir . basename($_FILES["classroom_image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$file = $_FILES["classroom_image"];
// Check if image file is a actual image or fake image

if(isset($_POST["submit"])) {
  $check = getimagesize($file["tmp_name"]);
  if($check !== false) {
    //echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    //echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  //echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($file["size"] > 500000) {
  //echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  $extension  = pathinfo( $file["name"], PATHINFO_EXTENSION );
  $filename = $filename.'.'.$extension;
  if (move_uploaded_file($file["tmp_name"], $target_dir.$filename)) {
    //echo "The file ". htmlspecialchars( basename( $_FILES["classroom_image"]["name"])). " has been uploaded.";
  } else {
    //echo "Sorry, there was an error uploading your file.";
  }
}
}

if(isset($_POST["submit"])) {
    adu('alow');
  }


?>


<!DOCTYPE html>
<html>
<body>

<form action="test.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="classroom_image" id="classroom_image" accept="image/*"> 
  <input type="submit" value="Upload Image" name="submit" >
</form>

</body>
</html>
