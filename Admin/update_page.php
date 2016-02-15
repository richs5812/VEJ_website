<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Insert Result</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="../images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Insert result</h1>
</header>

<nav>
<?php include_once("admin_nav.php"); ?>
</nav>

<section>
<?php
include '../db_connect.php';
//format dates for MySQL from input format
date_default_timezone_set('America/Detroit');

$rssDate = ''.date("D, d M Y", strtotime($_POST['pageDate'])).' '.$_POST['pageTimeOfDayHour'].':'.$_POST['pageTimeOfDayMinute'].':00 EST';

if($_POST['pageDate']!=NULL){
	$sqlFormattedPageDate = date("Y-m-d", strtotime($_POST['pageDate']));
	} else {
	$sqlFormattedPageDate = NULL;
	}
	
$slugNoHyphens = str_replace(" - "," ",$_POST["pageTitle"]);
$strippedSlug = preg_replace("/[^a-zA-Z0-9 ]/", "", $slugNoHyphens);
$slug = str_replace(" ","-",$strippedSlug);

    
//allow null ParentPage value
if ($_POST["ParentPage"] == "")
{
	$parentPage = NULL;
} else {
	$parentPage = $_POST["ParentPage"];
}   
 
//allow null menuOrder value
if ($_POST["menuOrder"] == "")
{
	$menuOrder = NULL;
} else {
	$menuOrder = $_POST["menuOrder"];
}

//allow null GalleryName value
if ($_POST["GalleryName"] == "")
{
	$galleryName = NULL;
} else {
	$galleryName = $_POST["GalleryName"];
}
//figure out whether to insert or update
if ($_POST['page_id']==""){
	require_once ('insert_page.php');
	} else {

$query = "UPDATE Pages SET Title=?, Content=?, ParentPage=?, Slug=?, Template=?, Content2=?, GalleryName=?, pubDate=?, IncludeInNav=?, SqlDate=?, MenuOrder=? WHERE page_id=?";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_POST["pageTitle"]);
$stmt->bindParam(2, $_POST["pageContent"]);
$stmt->bindParam(3, $parentPage);
$stmt->bindParam(4, $slug);
$stmt->bindParam(5, $_POST["Template"]);
$stmt->bindParam(6, $_POST["pageContentDos"]);
$stmt->bindParam(7, $galleryName);
$stmt->bindParam(8, $rssDate);
$stmt->bindParam(9, $_POST["includeInNav"]);
$stmt->bindParam(10, $sqlFormattedPageDate);
$stmt->bindParam(11, $menuOrder);
$stmt->bindParam(12, $_POST["page_id"]);

$con->beginTransaction();
if ($stmt->execute() == TRUE) {
  echo 'Page updated successfully.';
   echo '<form action="page_create_edit.php" method="post">
    <input type="hidden" name="page_id" value="' .$_POST["page_id"]. '" />
    <input type="submit" value="Return to edit page: '.$_POST['pageTitle'].'" />
   </form>
    ';
} else {
	print_r($stmt->errorInfo());
}$con->commit();
}
?> 

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
