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
<?php include_once("dynamic_nav.php"); ?>
</nav>

<section>
<?php

//echo $_GET["filename"];
//echo '<br />';
//echo $_GET["gallery"];

include 'db_connect.php';

$query = "select * from VEJ_pics WHERE gallery = ?";
$stmt = $con->prepare( $query );

$gallery = $_GET["gallery"];

//bind the id of the image you want to select
$stmt->bindParam(1, $gallery);
$stmt->execute();

//to verify if a record is found
$num = $stmt->rowCount();
//echo $num;

$imageArray = array();
$i=0;
if( $num ){
	//if found
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
	
	$imageArray[$i]=$row["fileName"];
	$i++;
	
	}
	
	$key=array_search($_GET["filename"],$imageArray);
	$count=count($imageArray);
	//echo $count;
	//echo $key;
	
	//echo '
	//<div class="img">';
		//<a target="_blank" href="uploads/'.$row["fileName"].'">
	
	if ($key==0){
	//echo '<a href="slideshow.php?filename='.$imageArray[$key-1].'&gallery='.$gallery.'">Click for previous photo</a>';
	echo'	<img src="uploads/'.$_GET["filename"].'"/>
		</a>';
	echo '<a href="slideshow.php?filename='.$imageArray[$key+1].'&gallery='.$gallery.'">Click for next photo</a>';
	} elseif ($key==($count-1)){
	echo '<a href="slideshow.php?filename='.$imageArray[$key-1].'&gallery='.$gallery.'">Click for previous photo</a>';
	echo'	<img src="uploads/'.$_GET["filename"].'"/>
		</a>';
	//echo '<a href="slideshow.php?filename='.$imageArray[$key+1].'&gallery='.$gallery.'">Click for next photo</a>';
	} else {	
	echo '<a href="slideshow.php?filename='.$imageArray[$key-1].'&gallery='.$gallery.'">Click for previous photo</a>';
	echo'	<img src="uploads/'.$_GET["filename"].'"/>
		</a>';
	echo '<a href="slideshow.php?filename='.$imageArray[$key+1].'&gallery='.$gallery.'">Click for next photo</a>';
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
