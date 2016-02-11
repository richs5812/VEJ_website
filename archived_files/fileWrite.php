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

<?php
$myfile = fopen("catholic_heart_2015.php", "w") or die("Unable to open file!");
$txt = $_POST["edit"];
fwrite($myfile, $txt);
fclose($myfile);

echo 'file edited!';
?>

</section>

</body>
</html>