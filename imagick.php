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
<h1>Imagick</h1>
</header>

<nav>
<?php include_once("dynamic_nav.php"); ?>
</nav>

<section>

<?php

try
{
// Open the original image
$image = new Imagick();
$image->readImage('images/image_full.jpg');

$origSize = $image->getImageGeometry();
$origWidth = $origSize['width'];
$origHeight = $origSize['height'];

if ($origWidth > $origHeight){
	 $image->resizeImage(1200, 0, Imagick::FILTER_UNDEFINED, 1);
} else {
	 $image->resizeImage(0, 1200, Imagick::FILTER_UNDEFINED, 1);
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

    /*** write image to disk ***/
    $image->writeImage( '/Library/WebServer/Documents/Sites/VEJ/temp/watermark_both13.jpg' );

    echo 'Image Created';

}
catch(Exception $e)
{
        echo $e->getMessage();
}
///Library/WebServer/Documents/Sites/VEJ/temp/dropshadow.png
?>


</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
