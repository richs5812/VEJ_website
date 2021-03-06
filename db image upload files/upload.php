<?php
include 'db_connect.php';
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 6000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	/*
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }*/

	$image = fopen($_FILES['fileToUpload']['tmp_name'], 'rb');    
  //  $image = file_get_contents($_FILES["fileToUpload"]["tmp_name"]));
    $image_name = addslashes($_FILES["fileToUpload"]["name"]);
    
    $query = "INSERT INTO VEJ_pics (img, caption) VALUES (?, ?)";
	$stmt = $con->prepare( $query );

	//$gallery = '12th_earth_day';

	//bind the id of the image you want to select
	$stmt->bindParam(1, $image, PDO::PARAM_LOB);
	$stmt->bindParam(2, $image_name);

	$con->beginTransaction();
	$stmt->execute();
	$con->commit();
/*
	$sql = "INSERT INTO VEJ_pics (img, caption) VALUES ('{$image}', '{$image_name}')";
	if (!mysql_query($sql)) { // Error handling
    echo "Something went wrong! :(";
    } */
}
?> 