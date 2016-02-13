<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Upload Result</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Upload result</h1>
</header>

<nav>
<?php include_once("dynamic_nav.php"); ?>
</nav>

<section>
<?php
include 'db_connect.php';
$target_dir = "uploads/";
/*
if(count($_FILES['filesToUpload']['name'])) {
	foreach ($_FILES['filesToUpload']['name'] as $file) {
	    
		//do your upload stuff here
		echo $file;
		
	}
}*/

for($i=0; $i<count($_FILES['filesToUpload']['name']); $i++) {

$target_file = $target_dir . basename($_FILES["filesToUpload"]["name"][$i]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["filesToUpload"]["tmp_name"][$i]);
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
if ($_FILES["filesToUpload"]["size"][$i] > 6000000) {
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
    if (move_uploaded_file($_FILES["filesToUpload"]["tmp_name"][$i], $target_file)) {
        echo "The file ". basename( $_FILES["filesToUpload"]["name"][$i]). " has been uploaded. <br />";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

	//$image = fopen($_FILES['filesToUpload']['tmp_name'], 'rb');    
    $file_name = basename( $_FILES["filesToUpload"]["name"][$i]);
    
    $query = "INSERT INTO VEJ_pics (fileName, caption, gallery) VALUES (?, ?, ?)";
	$stmt = $con->prepare( $query );

	//$gallery = '12th_earth_day';

	//bind the id of the image you want to select
	$stmt->bindParam(1, $file_name);
	$stmt->bindParam(2, $_POST["caption"]);
	$stmt->bindParam(3, $_POST["gallery"]);


	$con->beginTransaction();
	$stmt->execute();
	$con->commit();

}
}

?> 

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
