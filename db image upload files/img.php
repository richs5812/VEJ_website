<?php
$servername = "localhost";
$username = "vej";
$password = "HopeHouse2015!";
$dbname = "VEJ";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully <br><br>";

$query = mysqli_query($conn, "SELECT img FROM VEJ_pics WHERE pic_id = ".$_GET['pic_id']);
$row = mysqli_fetch_assoc($query);
header("Content-type: image/jpeg");

echo $row['img'];

/*
$query = mysql_query("SELECT img FROM VEJ_pics WHERE pic_id =1");
$row = mysql_fetch_assoc($query);
header("Content-type: image/jpeg");
echo $row['img'];

$imgSql = "SELECT img FROM VEJ_pics WHERE pic_id = ".$GET[pic_id]."";
$imgResult = $conn->query($imgSql);

$imgRow = $imgResult->fetch_assoc();
header("Content-type: image/jpeg");
echo $imgRow['img'];*/
?>