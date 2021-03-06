<!DOCTYPE html>

<html lang="en">
<head>
<base href="/Sites/VEJ/">
<link rel="stylesheet" href="styles.css">
<link href="http://localhost/Sites/VEJ/feeds/blogFeed.php" rel="alternate" type="application/rss+xml" title="Voices for Earth Justice: Latest Blog Posts" />
<link href="http://localhost/Sites/VEJ/feeds/photoFeed.php" rel="alternate" type="application/rss+xml" title="Voices for Earth Justice: Latest Photos" />
<title>Voices for Earth Justice - Blog</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Blog</h1>
</header>

<nav>
<?php include_once("dynamic_nav.php"); ?>
</nav>
<section>

<?php

//format dates for MySQL from input format
date_default_timezone_set('America/Detroit');

include 'db_connect.php';

if (!isset($_GET['Slug']))
{
	$slug = "Home";
} else {
	$slug = $_GET['Slug'];
}


$query = "select Title, Content, Content2, Template, GalleryName, Slug from Pages WHERE pageType = 'Post' ORDER BY SqlDate DESC";
$stmt = $con->prepare( $query );

//$stmt->bindParam(1, $slug);
$stmt->execute();

$num = $stmt->rowCount();

if( $num ){
	//if found
	while ($pageRow = $stmt->fetch(PDO::FETCH_ASSOC)){
	
	$content = $pageRow["Content"];
	$title = $pageRow["Title"];
	$content2 = $pageRow["Content2"];
	$template = $pageRow["Template"];
	$galleryName = $pageRow["GalleryName"];
echo '<div><a href="'.$pageRow["Slug"].'"><h1>'.$title.'</h1></a></div>';

echo '<div>'.$content.'</div>';

if ($template == 'Gallery'){
	$galleryQuery = "select * from Pics WHERE gallery = ?";
	$galleryStmt = $con->prepare( $galleryQuery );

//bind the id of the image you want to select
$galleryStmt->bindParam(1, $galleryName);
$galleryStmt->execute();

//to verify if a record is found
$galleryNum = $galleryStmt->rowCount();
//echo $num;

if( $galleryNum ){
	//if found
	while ($galleryRow = $galleryStmt->fetch(PDO::FETCH_ASSOC)){
	
	echo '
	<div class="img">';
		//<a target="_blank" href="uploads/'.$row["fileName"].'">
		echo '<a target="_blank" href="slideshow.php?filename='.$galleryRow["fileName"].'&gallery='.$galleryName.'">';
		echo '<img src="thumbnailPics/'.$galleryRow["picSlug"].'/'.$galleryRow["fileName"].'" width="300" />
		</a>';
	
	if ($galleryRow["caption"]!=NULL){
		echo '<div class="desc">'.$galleryRow["caption"].'</div>';
	}
	echo'</div>';
	
	}
}else{
	//if no image found with the given id,
	//load/query your default image here
}
	echo '<div>'.$content2.'</div>';
	echo '<hr>';

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
