<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css">
<title>Voices for Earth Justice - Edit gallery</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
<script>
function change(){
    document.getElementById("galleryDropDownMenu").submit();
}
</script>
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

<br />
<form id="galleryDropDownMenu" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<?php
include '../db_connect.php';

	//start gallery choice dropdown menu
	echo 'Select gallery name: <select name="GalleryName" onchange="change()">
		<option value=""></option>';
	$galleryNameSql = 'SELECT DISTINCT gallery FROM Pics';
    foreach ($con->query($galleryNameSql) as $galleryNameRow) {
    	if ($_POST["GalleryName"]==$galleryNameRow['gallery']){
    		$selected = 'selected';
    	} else {
    		$selected = NULL;
    	}
        echo '<option value="'.$galleryNameRow['gallery'].'" '.$selected.'>'.$galleryNameRow['gallery'].'</option>';
    }
    echo '</select><br><br>';
	//end gallery choice drop down menu

?>
</form>

<?php
		$galleryQuery = "select PicID, fileName, gallery, caption, picSlug from Pics WHERE gallery = ?";
		$galleryStmt = $con->prepare( $galleryQuery );

		//bind the id of the image you want to select
		$galleryStmt->bindParam(1, $_POST["GalleryName"]);
		$galleryStmt->execute();

		while ($galleryRow = $galleryStmt->fetch(PDO::FETCH_ASSOC)){
			
			echo '<div class="img"><form action="update_photo" method="post">';
				//<a target="_blank" href="uploads/'.$row["fileName"].'">
				echo '<img src="../thumbnailPics/'.$galleryRow["picSlug"].'/'.$galleryRow["fileName"].'" />
				</a>';
	
			//if ($galleryRow["caption"]!=NULL)
				echo '<div class="desc">';
				//echo'<label for="fileName">Edit File Name: </label><input type="text" id="fileName" name="fileName" value="'.$galleryRow["fileName"].'" />';
				echo '<input type="hidden" name="PicID" value="'.$galleryRow["PicID"].'" />
				<input type="hidden" name="picSlug" value="'.$galleryRow["picSlug"].'" />
				<input type="hidden" name="fileName" value="'.$galleryRow["fileName"].'" />
				<input type="hidden" name="gallery" value="'.$galleryRow["gallery"].'" />';
				echo '<label for="caption">Edit Caption: </label><input type="text" id="caption" name="caption" value="'.$galleryRow["caption"].'" />
				<input type="submit" name="updatePhoto" value="Update Photo" />
				<input type="submit" name="deletePhoto" value="Delete Photo" onClick="return confirm(\'Are you sure you want to delete this photo?\');" />
				</div>';

			echo'</form></div>';
	
			}
?>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>