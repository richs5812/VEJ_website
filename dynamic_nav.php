<ul class="nav">
<?php 
include 'db_connect.php';

$navQuery = "SELECT * FROM Pages";
$navStmt = $con->prepare( $navQuery );

$con->beginTransaction();
$navStmt->execute();
$con->commit();

$navNum = $navStmt->rowCount();
$pageArray = array();
$parentArray = array();
$noParentArray = array();
$i=0;
if( $navNum ){
	//if found
	while ($navRow = $navStmt->fetch(PDO::FETCH_ASSOC)){
	$pageArray['page_id'][$i] = $navRow['page_id'];
	//echo $pageArray['page_id'][$i];
	//echo '<br>';
	$pageArray['Parent_Page'][$i] = $navRow['Parent_Page'];
	//does page have parent? if not, save to array
	if ($navRow['Parent_Page']==NULL){
		$parentArray['page_id'][$i] = $navRow['page_id'];
		//$parentArray['page_id'][$i]= NULL;
		//echo $subPageArray['page_id'][$i];
		//echo 'pageID: '.$subPageArray['page_id'][$i].' <br>';
		//echo 'parent page: '.$subPageArray['Parent_Page'][$i].'<br><br>';
	}
	$i++;
	
	}
	$arrlength = count($pageArray['Parent_Page']);	
	//echo $arrlength;
	//does page have child? if so, display as dropdown. otherwise, display as list item
	foreach ($parentArray['page_id'] as $parentPageID) {
		$x=0;
		//echo 'page '.$parentPageID[$x].' might have a child <br><br>';
		//does parent page id match any 'Parent_Page' id's? if so, display as dropdown	
		//echo '<div class="dropdown">
    		//	<a href="page_display?page_id='.$parentPageID[$x].'" class="dropbtn">Link '.$x.'</a>';
    			
		//for($y = 0; $y < $arrlength; $y++) {
   			// echo $pageArray['Parent_Page'][$y];
   			// echo '<br>';
			/*if ($parentPageID[$x] == $pageArray['Parent_Page'][$y]){
				//echo 'page '.$parentPageID[$x].' has child '.$pageArray['page_id'][$y].' <br><br>';			
			
			}*/
			if (in_array($parentPageID[$x], $pageArray['Parent_Page'])){
				//echo 'page '.$parentPageID[$x].' has a child';
				echo '<div class="dropdown">
    			<a href="page_display?page_id='.$parentPageID[$x].'" class="dropbtn">Parent Link</a>
    				 <div class="dropdown-content">';
    				 for($y = 0; $y < $arrlength; $y++) {
   						if ($parentPageID[$x] == $pageArray['Parent_Page'][$y]){
							echo '<a href="page_display?page_id='.$pageArray['page_id'][$y].'">Child Link</a>';			
						}
			}
				echo '</div></div>';
			} else {
				echo '<li class="nav"><a href="page_display?page_id='.$parentPageID[$x].'">Link</a></li>';
			}
		//}
		//echo '</div>';
		$x++;
		
	}
/* <div class="dropdown">
    <a href="index.php" class="dropbtn">Home</a>
   <div class="dropdown-content">
      <a href="about.php">About</a>
      <a href="faith_statements.php">Faith Statements</a>
      <a href="board_members.php">Board Members</a>
    </div>
  </div>*/
	
	
	/*
	$x=0;
	foreach ($parentArray as $parent) {
		foreach ($subPageArray as $subPage) {
			if ($subPage['page_id'][$x] == $parent['page_id']){
				echo '<div class="dropdown">
    					<a href="index.php" class="dropbtn">'.$parent['page_id'].'</a>
   							<div class="dropdown-content">
    							<a href="about.php">About</a>
								<a href="faith_statements.php">Faith Statements</a>
								<a href="board_members.php">Board Members</a>
    						</div>
    					</div>';
				
								
			}
		}
	
	}*/
	
	
	
	
	//echo '<li class="nav"><a href="page_display?page_id='.$navRow['page_id'].'">'.$navRow['Title'].'</a></li>';
	

	}
	
else{
	echo 'no results';
}

?>
</ul><!--
<ul class="nav">
  <div class="dropdown">
    <a href="index.php" class="dropbtn">Home</a>
    <div class="dropdown-content">
      <a href="about.php">About</a>
      <a href="faith_statements.php">Faith Statements</a>
      <a href="board_members.php">Board Members</a>
    </div>
  </div>
  <li class="nav"><a href="resources.php">Resources</a></li>
  <div class="dropdown">
    <a href="events.php" class="dropbtn">Events</a>
    <div class="dropdown-content">
      <a href="2015_Events.php">2015 Events</a>
      <a href="2014_Events.php">2014 Events</a>
    </div>
  </div>
  <div class="dropdown">
    <a href="galleries.php" class="dropbtn">Galleries</a>
    <div class="dropdown-content">
      <a href="12th_earth_day_gallery.php">12th Earth Day Celebration</a>
      <a href="2014_gen_up.php">2014 Generation Waking Up</a>
      <a href="princeton_break_2015.php">Princeton Alternative Break Volunteers - January 2015</a>
      <a href="2015_gen_up.php">2015 Generation Waking Up</a>
	  <a href="weekly_film_2015.php">Hope House Weekly Film Screening - Early Spring 2015</a>
	  <a href="earth_day_2015.php">Earth Day Celebration - April 2015</a>
	  <a href="hope_house_open_house_2015.php">Hope House Open House - June 2015</a>
	  <a href="wexner_service_corps_2015.php">Wexner Service Corps Visits Hope House - June 2015</a>
	  <a href="catholic_heart_2015.php">Catholic Heart Work Campers Visit Hope House - July 2015</a>  
	  
    </div>
  </div>
    <li class="nav"><a href="image_upload.php">Upload Image</a></li>
    <li class="nav"><a href="fileOpen.php">Edit File</a></li>
    <li class="nav"><a href="page_create_edit.php">Insert page</a></li>
    
</ul>-->
