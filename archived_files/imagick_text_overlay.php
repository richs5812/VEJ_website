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
//text code
    /*** the image file ***/
    $image = 'images/image.jpg';

    /*** a new imagick object ***/
    $im = new Imagick();
    /*** Set memory limit to 8 MB ***/
$im->setResourceLimit( Imagick::RESOURCETYPE_MEMORY, 8 );

    /*** read the image into the object ***/
    $im->readImage( $image );

    /* Create a drawing object and set the font size */
    $draw = new ImagickDraw();

    /*** set the font ***/
    $draw->setFont( "/Library/Fonts/Impact.ttf" );

    /*** set the font size ***/
    $draw->setFontSize( 36 );

    /*** add some transparency ***/


    /*** set gravity to the center ***/
    $draw->setGravity( Imagick::GRAVITY_SOUTHEAST );

    /*** overlay the text on the image ***/
    $draw->setFillColor('white');
       $draw->setFillOpacity( 0.6 );
    $im->annotateImage( $draw, 0, 0, 0, "voices4earth.org" );

    /**** set to png ***/
    $im->setImageFormat( "png" );

    /*** write image to disk ***/
    $im->writeImage( '/Library/WebServer/Documents/Sites/VEJ/temp/watermark_overlay.png' );

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
