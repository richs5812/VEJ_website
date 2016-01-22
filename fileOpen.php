<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>File Open</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>File Open</h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>

<section>
<form action="fileWrite.php" method="post">

<textarea rows="50" cols="100" name="edit">
<?php

$myfile = fopen("catholic_heart_2015.php", "r+") or die("Unable to open file!");
echo fread($myfile,filesize("catholic_heart_2015.php"));
fclose($myfile);

?>
</textarea>
<input type="submit" value="Save Changes"/>
</form>

</section>

</body>
</html>