<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../styles.css">
<title>Voices for Earth Justice - Create/Edit page</title>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">

<!-- date picker-->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">

  <script>
  $(function() {
    $( "#pageDatePicker" ).datepicker({dateFormat: "mm/dd/y"});
  });
  </script>
  <!-- end date picker-->
  
</head>
<body>

<header>
<img src="../images/voices_logo_color 300.jpg" alt="VEJ logo">
<h1>Create/Edit page</h1>
</header>

<nav>
<?php include_once("admin_nav.php"); ?>
</nav>

<section>

<!--start drop down menu-->
<br />
<form id="dropDownMenu" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<select class="dropDown" name="page_id" onchange="change()">
<option value="">New Page</option>

<?php 
include '../db_connect.php';

$query = "SELECT page_id, Title FROM Pages WHERE pageType = 'Page' ORDER BY Title ASC;";
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
//format dates for MySQL from input format
date_default_timezone_set('America/Detroit');

//$dropDownPath = 'galleryDropDown.php';

//include 'db_connect.php';

$pageQuery = "select * from Pages WHERE page_id = ?";
$pageStmt = $con->prepare( $pageQuery );

$pageStmt->bindParam(1, $_POST["page_id"]);

$con->beginTransaction();
$pageStmt->execute();
$con->commit();

$pageRow = $pageStmt->fetch(PDO::FETCH_ASSOC);

if (!isset ($pageRow["page_id"])){
	$published = 'Publish';
	$pageDate = date("m/d/y");
	$pageHour = date("G");
	$pageMinute = date("i");
} else{
	$published = 'Published';
	$pageDate = date("m/d/y", strtotime($pageRow["pubDate"]));
	$pageHour = date("G", strtotime($pageRow["pubDate"]));
	$pageMinute = date("i", strtotime($pageRow["pubDate"]));
}

echo '<input type="hidden" name="page_id" value="' .$pageRow["page_id"]. '" />
<input type="hidden" name="pageType" value="Page" />
<label for="pageTitle">Page Title: </label><input type="text" name="pageTitle" id="pageTitle" value="'.$pageRow["Title"].'" /><br /><br />';

//display parent page in drop down menu
	echo 'Parent Page: <select name="ParentPage">
			<option value="">No Parent</option>';
	$parentPageSql = 'SELECT page_id, ParentPage, Title FROM Pages';
    foreach ($con->query($parentPageSql) as $parentPageRow) {
    	if ($pageRow["ParentPage"]==$parentPageRow['page_id']){
    		$selected = 'selected';
    	} else {
    		$selected = NULL;
    	}
        echo '<option value='.$parentPageRow['page_id'].' '.$selected.'>'.$parentPageRow['Title'].'</option>';
    }
    echo '</select><br><br>';
	//end parent page drop down menu
	echo '<label for="menuOrder">Menu Order: </label><input type="text" name="menuOrder" id="menuOrder" value="'.$pageRow["MenuOrder"].'" /><br /><br />';

	//display template options in drop down menu
	echo 'Page Template: <select id="Template" onchange="leaveChange()" name="Template" >';
	$templageSql = 'SELECT TemplateName FROM Templates';
    foreach ($con->query($templageSql) as $templateRow) {
    	if ($pageRow["Template"]==$templateRow['TemplateName']){
    		$selected = 'selected';
    	} else {
    		$selected = NULL;
    	}
        echo '<option value='.$templateRow['TemplateName'].' '.$selected.'>'.$templateRow['TemplateName'].'</option>';
    }
    echo '</select><br><br>';
	//end template options drop down menu
	
    if ($pageRow['IncludeInNav']!='1'){
	echo '<label for="includeInNav">Include in Navigation Menu: </label>
			<input type="hidden" name="includeInNav" value="0" />
			<input type="checkbox" name="includeInNav" id="includeInNav" value="1" /><br><br>';
} else {
	echo '<label for="includeInNav">Include in Navigation Menu: </label>
			<input type="hidden" name="includeInNav" value="0" />
			<input type="checkbox" name="includeInNav" id="includeInNav" value="1" checked/><br><br>';
}	

	
echo '<label for="pageDatePicker">'.$published.' Date: </label><input type="text" name="pageDate" id="pageDatePicker" value="'.$pageDate.'">';

echo '<label for="pageTimeOfDayHour">Time of Day: Hour (0-24): </label><input type="text" name="pageTimeOfDayHour" id="pageTimeOfDayHour" value="'.$pageHour.'">';

echo '<label for="pageTimeOfDayMinute">Minute: </label><input type="text" name="pageTimeOfDayMinute" id="pageTimeOfDayMinute" value="'.$pageMinute.'"><br><br>';

echo '<label for="pageContent">Page Content: </label><textarea id="pageContent" name="pageContent" rows="20" cols="120" >'.$pageRow["Content"].'</textarea><br><br>';

//echo '<div id="message"></div>';

$content2 = $pageRow["Content2"];

if ($pageRow["Template"]=='Gallery'){
	echo '<div id="message">';
} else {
	echo '<div id="message" style="display: none;">';
}
	//display gallery choices in drop down menu
	echo 'Select gallery name: <select name="GalleryName">
		<option value=""></option>';
	$galleryNameSql = 'SELECT DISTINCT gallery FROM Pics';
    foreach ($con->query($galleryNameSql) as $galleryNameRow) {
    	if ($pageRow["GalleryName"]==$galleryNameRow['gallery']){
    		$selected = 'selected';
    	} else {
    		$selected = NULL;
    	}
        echo '<option value="'.$galleryNameRow['gallery'].'" '.$selected.'>'.$galleryNameRow['gallery'].'</option>';
    }
    echo '</select><br><br>';
	//end gallery choice drop down menu
	
	echo'<label for="pageContentDos">Page Content Block 2: </label><textarea id="pageContentDos" name="pageContentDos" rows="10" cols="120" >'.$content2.'</textarea><br><br></div>';
	echo '</div>';

if ($_POST["page_id"] == ""){
	echo '<br /><br /><input type="submit" value="Create Page"/>';
} else {
	echo '<label for="pageSlug">Page Slug for Link: </label><input type="text" name="pageSlug" id="pageSlug" value="'.$pageRow["Slug"].'" /><br /><br />
<input type="submit" value="Update Page"/>';
}
?>
<script>
function leaveChange() {
    if (document.getElementById("Template").value != "Gallery"){
        document.getElementById("message").style.display = 'none';
    }     
    else{
        document.getElementById("message").style.display = 'block';
    }        
}
</script>
<?php
echo '</form>';
?>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
