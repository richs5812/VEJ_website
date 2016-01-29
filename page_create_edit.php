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

<form action="insert_page.php" method="post">

<br />
<label for="pageTitle">Page Title: </label><input type="text" name="pageTitle" id="pageTitle" /><br /><br />

<label for="OtherNotes">Page Content: </label><textarea id="pageContent" name="pageContent" ></textarea>

<br /><br /><input type="submit" value="Create Page"/>
</form>

</section>

<footer>
Copyright 2015 Voices for Earth Justice, nonprofit 501(c)(3). All Rights Reserved.
</footer>

</body>
</html>
