<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Upload</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Upload Image(s)</h1>
</header>

<nav>
<?php include_once("dynamic_nav.php"); ?>
</nav>

<section>

<form action="path_upload.php" method="post" enctype="multipart/form-data"><br />
    Select image to upload:
   <!-- <input type="file" name="fileToUpload" id="fileToUpload" multiple><br /><br />-->
   <input name="filesToUpload[]" id="filesToUpload" type="file" multiple="" /><br /><br />
	Create New Gallery: <input type="text" name="newGalleryName" id="gallery" value="" size="50"><br /><br />
<?php   	//display gallery choices in drop down menu
	echo 'or add to existing gallery: <select id="existingGalleryName" name="existingGalleryName"">
		<option value=""></option>';
	$galleryNameSql = 'SELECT DISTINCT gallery FROM Pics';
    foreach ($con->query($galleryNameSql) as $galleryNameRow) {
    	if ($pageRow["GalleryName"]==$galleryNameRow['gallery']){
    		$selected = 'selected';
    	} else {
    		$selected = NULL;
    	}
        echo '<option value="'.$galleryNameRow['gallery'].'" '.$selected.'>'.$galleryNameRow['gallery'].'</option>';
    }
    echo '</select><br><br>';
	//end gallery choice drop down menu
?>
    Caption: <input type="text" name="caption" id="caption">
    <input type="submit" value="Upload Image(s)" name="submit">
<!--<script>
function galleryNameChoice() {
    if (document.getElementById("existingGalleryName").value != ""){
        document.getElementById("newName").style.display = 'none';
    }     
    else{
        document.getElementById("newName").style.display = 'block';
    }        
}
</script>-->
</form>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>