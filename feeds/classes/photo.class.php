<?php
  class RSS
  {
	public function RSS()
	{
		include "db_connect.php";
	}
	public function GetFeed()
	{
		return $this->getDetails() . $this->getItems();
	}
	/*private function dbConnect()
	{
		DEFINE ('LINK', mysql_connect (DB_HOST, DB_USER, DB_PASSWORD));
	}*/
	private function getDetails()
	{
		//$detailsTable = "Pages";
		//$this->dbConnect($detailsTable);
		include "db_connect.php";
		$query = "SELECT fileName, gallery, caption, picSlug, pubDate FROM Pics";
		$stmt = $con->prepare( $query );
		$stmt->execute();
		while ($picRow = $stmt->fetch(PDO::FETCH_ASSOC)){
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title>Voices for Earth Justice: Latest Photos</title>
      <link>http://www.voices4earth.org</link>
      <description>Latest photos by Voices for Earth Justice.</description>';
		}
		return $details;
		$con = NULL;
	}
	private function getItems()
	{
		include "db_connect.php";
		$items = '';
		/*$itemsTable = "social_media_feed";
		$this->dbConnect($itemsTable);
		$query = "SELECT * FROM ". $itemsTable;
		$result = mysql_db_query (DB_NAME, $query, LINK);
		while($row = mysql_fetch_array($result))
		{*/
		$query = "SELECT fileName, gallery, caption, picSlug, pubDate FROM Pics";
		$stmt = $con->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$items .= '<item>
				<title>'. $row["gallery"] .'</title>
				<link>http://localhost/Sites/VEJ/</link>
				<description><![CDATA[<figure><img src="http://localhost/Sites/VEJ/slideshowPics/'.$row["picSlug"].'/'.$row["fileName"].'" /><figcaption>'.$row["caption"].'</figcaption></figure>]]></description>
				<pubDate>'. $row["pubDate"] .'</pubDate>
			</item>';
		}
		$items .= '</channel>
				</rss>';
		return $items;
		$con = NULL;
	}
}
/*<image>
					<url>http://localhost/Sites/VEJ/thumbnailPics/'.$row["picSlug"].'/'.$row["fileName"].'</url>
					<title>'.$row["fileName"].'</title>
					<link>http://www.voices4earth.org</link>*/
?>