<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="styles.css">
<title>Voices for Earth Justice - Create/Edit page</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<header>
<img src="images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Create/Edit page</h1>
</header>

<nav>
<?php include_once("nav.html"); ?>
</nav>

<section>

<!--start drop down menu-->
<br />
<form id="dropDownMenu" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
<select class="dropDown" name="page_id" onchange="change()">
<option value="">New Page</option>

<?php 
include 'db_connect.php';

$query = "SELECT page_id, Title FROM Pages ORDER BY Title ASC;";
$stmt = $con->prepare( $query );

$con->beginTransaction();
$stmt->execute();
$con->commit();

$num = $stmt->rowCount();

if( $num ){
	//if found
	while ($dropDownRow = $stmt->fetch(PDO::FETCH_ASSOC)){
		if ($dropDownRow['page_id']==$_POST['page_id']){
    		$selected = "selected";
    	}else{
    		$selected = "";
    		}
        echo '<option value="'. $dropDownRow['page_id'] .'" '.$selected.' >'. $dropDownRow['Title'] .'</option>';

	}
	
}else{
	echo 'no results';
}

?>
</select>

<script>
function change(){
    document.getElementById("dropDownMenu").submit();
}
</script>

</form>
<!--end drop down menu-->

<form action="update_page.php" method="post">

<br />
<?php

include 'db_connect.php';

$pageQuery = "select * from Pages WHERE page_id = ?";
$pageStmt = $con->prepare( $pageQuery );

$pageStmt->bindParam(1, $_POST["page_id"]);

$con->beginTransaction();
$pageStmt->execute();
$con->commit();

$pageRow = $pageStmt->fetch(PDO::FETCH_ASSOC);


echo '<input type="hidden" name="page_id" value="' .$pageRow["page_id"]. '" />

<label for="pageTitle">Page Title: </label><input type="text" name="pageTitle" id="pageTitle" value="'.$pageRow["Title"].'" /><br /><br />

<label for="OtherNotes">Page Content: </label><textarea id="pageContent" name="pageContent" rows="40" cols="120" >'.$pageRow["Content"].'</textarea>

<br /><br />';

if ($_POST["page_id"] == ""){
	echo '<input type="submit" value="Create Page"/>';
} else {
	echo '<input type="submit" value="Update Page"/>';
}
echo '</form>';
?>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
