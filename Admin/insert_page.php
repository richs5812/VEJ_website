<!--<!DOCTYPE html>
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

<section>-->
<?php
//include 'db_connect.php';
/*
//allow null ParentPage value
if ($_POST["ParentPage"] == "")
{
	$parentPage = NULL;
} else {
	$parentPage = $_POST["ParentPage"];
}*/
    
$query = "INSERT INTO Pages (Title, Content, ParentPage, Slug, Template, Content2, GalleryName, pubDate, IncludeInNav, SqlDate, MenuOrder, pageType) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_POST["pageTitle"]);
$stmt->bindParam(2, $_POST["pageContent"]);
$stmt->bindParam(3, $_POST["ParentPage"]);
$stmt->bindParam(4, $slug);
$stmt->bindParam(5, $_POST["Template"]);
$stmt->bindParam(6, $_POST["pageContentDos"]);
$stmt->bindParam(7, $galleryName);
$stmt->bindParam(8, $rssDate);
$stmt->bindParam(9, $_POST["includeInNav"]);
$stmt->bindParam(10, $sqlFormattedPageDate);
$stmt->bindParam(11, $_POST["menuOrder"]);
$stmt->bindParam(12, $_POST["pageType"]);


$con->beginTransaction();
if ($stmt->execute() == TRUE) {
  echo 'Page created successfully.';
} else {
	print_r($stmt->errorInfo());
}$con->commit();

?> 
<!--
</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
-->
