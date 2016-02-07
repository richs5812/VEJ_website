<ul class="nav">
<?php 
include 'db_connect.php';

$navQuery = "SELECT * FROM Pages ORDER BY MenuOrder ASC";
$navStmt = $con->prepare( $navQuery );

$con->beginTransaction();
$navStmt->execute();
$con->commit();

$navNum = $navStmt->rowCount();
$childArray = array();
$parentArray = array();
$i=0;
$j=0;

if( $navNum ){
	//if found
	while ($navRow = $navStmt->fetch(PDO::FETCH_ASSOC)){
		if ($navRow['ParentPage']!=NULL) {
			$childArray['page_id'][$i] = $navRow['page_id'];
			$childArray['ParentPage'][$i] = $navRow['ParentPage'];
			$childArray['Title'][$i] = $navRow['Title'];
			$childArray['Slug'][$i] = $navRow['Slug'];
			$i++;
		} else{
			$parentArray['page_id'][$j] = $navRow['page_id'];
			$parentArray['Title'][$j] = $navRow['Title'];
			$parentArray['Slug'][$j] = $navRow['Slug'];
			$parentArray['MenuOrder'][$j] = $navRow['MenuOrder'];
			$j++;
		}
}
	
	//number of pages with parent
	$childArrLength = count($childArray['page_id']);
	//echo $arrlength;
	$parentArrLength = count($parentArray['page_id']);
/*
	 for($x = 0; $x < $parentArrLength; $x++) {
			if (in_array($parentArray['page_id'][$x], $childArray['ParentPage'])){
				echo '<div class="dropdown">
    			<a href="page_display?page_id='.$parentArray['page_id'][$x].'" class="dropbtn">'.$parentArray['Title'][$x].'</a>
    				 <div class="dropdown-content">';
    				 for($y = 0; $y < $childArrLength; $y++) {
   						if ($parentArray['page_id'][$x] == $childArray['ParentPage'][$y]){
							echo '<a href="page_display?page_id='.$childArray['page_id'][$y].'">'.$childArray['Title'][$y].'</a>';			
						}
					}
				echo '</div></div>';
			} else {
				echo '<li class="nav"><a href="page_display?page_id='.$parentArray['page_id'][$x].'">'.$parentArray['Title'][$x].'</a></li>';
			}
		}*/
		
for($x = 0; $x < $parentArrLength; $x++) {
			if (in_array($parentArray['page_id'][$x], $childArray['ParentPage'])){
				echo '<div class="dropdown">
    			<a href="'.$parentArray['Slug'][$x].'" class="dropbtn">'.$parentArray['Title'][$x].'</a>
    				 <div class="dropdown-content">';
    				 for($y = 0; $y < $childArrLength; $y++) {
   						if ($parentArray['page_id'][$x] == $childArray['ParentPage'][$y]){
							echo '<a href="'.$childArray['Slug'][$y].'">'.$childArray['Title'][$y].'</a>';			
						}
					}
				echo '</div></div>';
			} else {
				echo '<li class="nav"><a href="'.$parentArray['Slug'][$x].'">'.$parentArray['Title'][$x].'</a></li>';
			}
		}
		
} else{
	echo 'no results';
}

?>
</ul>
