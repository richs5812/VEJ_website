<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Gallery</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>12th Earth Day</h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>

<section>
<?php
include 'db_connect.php';

$query = "select * from VEJ_pics WHERE gallery = ?";
$stmt = $con->prepare( $query );

$gallery = '12th Earth Day';

//bind the id of the image you want to select
$stmt->bindParam(1, $gallery);
$stmt->execute();

//to verify if a record is found
$num = $stmt->rowCount();
//echo $num;

if( $num ){
	//if found
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	
	echo '
	<div class="img">
		<a target="_blank" href="uploads/'.$row["fileName"].'">
		<img src="uploads/'.$row["fileName"].'" width="300" />
		</a>
		<div class="desc">'.$row["caption"].'</div>
	</div>
	';
	
	}
}else{
	//if no image found with the given id,
	//load/query your default image here
}

//echo "<img src='source.php?id=1' width='400' />";

?>
</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>