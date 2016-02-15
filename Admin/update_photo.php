<!DOCTYPE html>
<html>
<head>
<title>Photo Updated</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../styles.css">
</head>
<body>

<header>
<img src="../images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Edit Photo</h1>
</header>

<nav>
<?php include_once("admin_nav.php"); ?>
</nav>

<section>
<?php

//connect to database using php script
include '../db_connect.php';

//check if family member Update button or Delete button was clicked
if (isset($_POST['updatePhoto'])) {
    //code to update record
    $query = "UPDATE Pics SET caption=? WHERE PicID=?";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_POST["caption"]);
$stmt->bindParam(2, $_POST["PicID"]);

$con->beginTransaction();
if ($stmt->execute() == TRUE) {
  echo 'Photo updated successfully.';
} else {
	print_r($stmt->errorInfo());
}$con->commit();   

} else if (isset($_POST['deletePhoto'])) {
    //delete action if Delete button was clicked
    $query = "DELETE FROM Pics WHERE PicID=?";
	$stmt = $con->prepare( $query );

	$stmt->bindParam(1, $_POST["PicID"]);

	$con->beginTransaction();
	if ($stmt->execute() == TRUE) {
		unlink('slideshowPics/'.$_POST["picSlug"].'/'.$_POST["fileName"].'');
		unlink('fullSizePics/'.$_POST["picSlug"].'/'.$_POST["fileName"].'');
		unlink('thumbnailPics/'.$_POST["picSlug"].'/'.$_POST["fileName"].'');
	  echo 'Photo deleted.';
	} else {
		print_r($stmt->errorInfo());
	}$con->commit();   

} else {
    echo "Error";
}

    echo '<form action="edit_gallery.php" method="post">
    <input type="hidden" name="GalleryName" value="' .$_POST['gallery']. '" />
    <input type="submit" value="Return to edit gallery: '.$_POST['gallery'].'" />
   </form>
    ';

$con = null;

?>
</section>
</body>
</html>