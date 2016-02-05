<?php

include 'db_connect.php';

$query = "select Title, Content from Pages WHERE page_id = ?";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_GET["page_id"]);
$stmt->execute();

$num = $stmt->rowCount();

if( $num ){
	//if found
	while ($pageRow = $stmt->fetch(PDO::FETCH_ASSOC)){
	
	$content = $pageRow["Content"];
	$title = $pageRow["Title"];

	}
	
	
	
}else{
	echo 'no results';
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - <?php echo $title; ?></title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1><?php echo $title; ?></h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>
<section>
<?php echo $content;?>
</section>
<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
