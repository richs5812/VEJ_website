<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Insert Result</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Insert result</h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>

<section>
<?php
include 'db_connect.php';
    
$query = "INSERT INTO Pages (Title, Content) VALUES (?,?)";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_POST["pageTitle"]);
$stmt->bindParam(2, $_POST["pageContent"]);

$con->beginTransaction();
if ($stmt->execute() == TRUE) {
  echo 'Page title and content inserted successfully.';
} else {
	echo "Error: <br>". $stmt->error;
}$con->commit();

?> 

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>