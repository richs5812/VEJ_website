<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css">
<title>Voices for Earth Justice - Upload Result</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="../images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Upload result</h1>
</header>

<nav>
<?php include_once("admin_nav.php"); ?>
</nav>

<section>
<?php
include '../db_connect.php';

if ($_POST["existingGalleryName"]==""){
	$galleryName = $_POST["newGalleryName"];
} else {
	$galleryName = $_POST["existingGalleryName"];
}
echo 'Pic will be entered into gallery: '.$galleryName.'<br>';

for($i=0; $i<count($_FILES['filesToUpload']['name']); $i++) {

$slugNoHyphens = str_replace(" - "," ",$galleryName);
$strippedSlug = preg_replace("/[^a-zA-Z0-9 ]/", "", $slugNoHyphens);
$slug = str_replace(" ","-",$strippedSlug);

$target_dir = '/Library/WebServer/Documents/Sites/VEJ/fullSizePics/'.$slug.'/';

if (!file_exists($target_dir) && !is_dir($target_dir)) {
    mkdir($target_dir, 0755);         
} 

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
    $fileName = basename( $_FILES["filesToUpload"]["name"][$i]);
    //$slideshowFileName = 'slideshow'.$fullSizeFileName;
  //  $thumbnailFileName = 'thumbnail'.$fullSizeFileName;
    
    $query = "INSERT INTO Pics (fileName, caption, gallery, picSlug) VALUES (?, ?, ?, ?)";
	$stmt = $con->prepare( $query );

	//bind the id of the image you want to select
	$stmt->bindParam(1, $fileName);
	$stmt->bindParam(2, $_POST["caption"]);
	$stmt->bindParam(3, $galleryName);
	$stmt->bindParam(4, $slug);


	$con->beginTransaction();
	$stmt->execute();
	$con->commit();
	
	//process image for slideshow and insert info into database
	try
	{
	// Open the original image
	$image = new Imagick();
	$image->readImage($target_file);

	$origSize = $image->getImageGeometry();
	$origWidth = $origSize['width'];
	$origHeight = $origSize['height'];

	if ($origWidth >= $origHeight){
		if ($origWidth > 1200){
		 $image->resizeImage(1200, 0, Imagick::FILTER_UNDEFINED, 1);
		 }
	} else {
		if ($origHeight > 1200){
		 $image->resizeImage(0, 1200, Imagick::FILTER_UNDEFINED, 1);
		 }
	}

	$resizedSize = $image->getImageGeometry();
	$resizedWidth = $resizedSize['width'];
	$resizedHeight = $resizedSize['height'];

	// Open the watermark
	$watermark = new Imagick();
	$watermark->readImage('images/watermark_opacity60.png');
	//$watermark->setImageOpacity(0.7);
	// Overlay the watermark on the original image
	//$image->compositeImage($watermark, imagick::COMPOSITE_OVER, 1011, 784);
	$image->compositeImage($watermark, imagick::COMPOSITE_OVER, $resizedWidth-189, $resizedHeight-116);

	/* Create a drawing object and set the font size */
    $draw = new ImagickDraw();

    /*** set the font ***/
    $draw->setFont( "/Library/Fonts/Tahoma.ttf" );

    /*** set the font size ***/
    $draw->setFontSize( 24 );

    /*** add some transparency ***/


    /*** set gravity to the center ***/
    $draw->setGravity( Imagick::GRAVITY_SOUTHEAST );
    $draw->setFillOpacity( 0.6 );
	$image->annotateImage( $draw, 22, 24, 0, "voices4earth.org" );
    /*** overlay the text on the image ***/
    $draw->setFillColor('white');
       $draw->setFillOpacity( 0.6 );
    $image->annotateImage( $draw, 23, 23, 0, "voices4earth.org" );
    
    $image->setImageCompressionQuality(50);

	$target_slideshow_dir = '/Library/WebServer/Documents/Sites/VEJ/slideshowPics/'.$slug;

	if (!file_exists($target_slideshow_dir) && !is_dir($target_slideshow_dir)) {
  	  mkdir($target_slideshow_dir, 0755);         
	} 

    /*** write image to disk ***/
    $image->writeImage( $target_slideshow_dir.'/'.$fileName );

    echo 'Slideshow Image Created <br>';
   /* 
    $slideshowQuery = "INSERT INTO SlideshowPics (fileName, caption, gallery) VALUES (?, ?, ?)";
	$slideshowStmt = $con->prepare( $slideshowQuery );

	//bind the id of the image you want to select
	$slideshowStmt->bindParam(1, $fileName);
	$slideshowStmt->bindParam(2, $_POST["caption"]);
	$slideshowStmt->bindParam(3, $_POST["gallery"]);


	$con->beginTransaction();
	$slideshowStmt->execute();
	$con->commit();
	*/
}
catch(Exception $e)
{
        echo $e->getMessage();
}


	//process image for slideshow and insert info into database
	try
	{
	// Open the original image
	$thumbImage = new Imagick();
	$thumbImage->readImage($target_file);
	
	$thumbSize = $thumbImage->getImageGeometry();
	$thumbWidth = $origSize['width'];
	$thumbHeight = $origSize['height'];

	if ($thumbWidth >= $thumbHeight){
		 $thumbImage->thumbnailImage( 300, null );
	} else {
		 $thumbImage->thumbnailImage( null, 300 );
	}

	$target_thumbnail_dir = '/Library/WebServer/Documents/Sites/VEJ/thumbnailPics/'.$slug;

	if (!file_exists($target_thumbnail_dir) && !is_dir($target_thumbnail_dir)) {
  	  mkdir($target_thumbnail_dir, 0755);         
	} 

    /*** write image to disk ***/
    $thumbImage->writeImage( $target_thumbnail_dir.'/'.$fileName );

    echo 'Thumbnail Image Created';
/*    
    $thumbnailQuery = "INSERT INTO ThumbnailPics (fileName, caption, gallery) VALUES (?, ?, ?)";
	$thumbnailStmt = $con->prepare( $thumbnailQuery );

	//bind the id of the image you want to select
	$thumbnailStmt->bindParam(1, $fileName);
	$thumbnailStmt->bindParam(2, $_POST["caption"]);
	$thumbnailStmt->bindParam(3, $_POST["gallery"]);


	$con->beginTransaction();
	$thumbnailStmt->execute();
	$con->commit();
	*/
}
catch(Exception $e)
{
        echo $e->getMessage();
}

}
}

?> 

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
