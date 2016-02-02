<ul class="nav">
<?php 
include 'db_connect.php';

$navQuery = "SELECT * FROM Pages ORDER BY Title ASC;";
$navStmt = $con->prepare( $navQuery );

$con->beginTransaction();
$navStmt->execute();
$con->commit();

$navNum = $navStmt->rowCount();

if( $navNum ){
	//if found
	while ($navRow = $navStmt->fetch(PDO::FETCH_ASSOC)){
	
	echo '<li class="nav"><a href="page_display?page_id='.$navRow['page_id'].'">'.$navRow['Title'].'</a></li>';
	

	}
	
}else{
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
