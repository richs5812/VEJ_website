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
<h1>Events</h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>

<section>

<form action="path_upload.php" method="post" enctype="multipart/form-data"><br />
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload"><br /><br />
    Gallery: <input type="text" name="gallery" id="gallery" value="12th Earth Day"><br /><br />
    Caption: <input type="text" name="caption" id="caption">
    <input type="submit" value="Upload Image" name="submit">
</form>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>