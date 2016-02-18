<?php
  header("Content-Type: application/xml; charset=ISO-8859-1");
  include("classes/photo.class.php");
  $rss = new RSS();
  echo $rss->GetFeed();
?>