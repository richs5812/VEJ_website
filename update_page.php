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

if ($_POST['page_id']==""){
	require_once ('insert_page.php');
	} else {
    
//allow null ParentPage value
if ($_POST["ParentPage"] == "")
{
	$parentPage = NULL;
} else {
	$parentPage = $_POST["ParentPage"];
}

$query = "UPDATE Pages SET Title=?, Content=?, ParentPage=?, Slug=? WHERE page_id=?";
$stmt = $con->prepare( $query );

$stmt->bindParam(1, $_POST["pageTitle"]);
$stmt->bindParam(2, $_POST["pageContent"]);
$stmt->bindParam(3, $parentPage);
$stmt->bindParam(4, $_POST["pageSlug"]);
$stmt->bindParam(5, $_POST["page_id"]);


$con->beginTransaction();
if ($stmt->execute() == TRUE) {
  echo 'Page updated successfully.';
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
