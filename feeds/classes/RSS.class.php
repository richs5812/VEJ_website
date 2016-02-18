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
		$query = "SELECT Title, Content, Slug, pubDate FROM Pages WHERE pageType = 'Post'";
		$stmt = $con->prepare( $query );
		$stmt->execute();
		while ($pageRow = $stmt->fetch(PDO::FETCH_ASSOC)){
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title>Voices for Earth Justice: Latest Blog Posts</title>
      <link>http://www.voices4earth.org</link>
      <description>Latest blog posts by Voices for Earth Justice.</description>';
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
		$query = "SELECT Title, Content, Slug, pubDate FROM Pages WHERE pageType = 'Post'";
		$stmt = $con->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$items .= '<item>
				<title>'. $row["Title"] .'</title>
				<link>http://localhost/Sites/VEJ/'. $row["Slug"] .'</link>
				<description><![CDATA['. $row["Content"] .']]></description>
				<pubDate>'. $row["pubDate"] .'</pubDate>
			</item>';
		}
		$items .= '</channel>
				</rss>';
		return $items;
		$con = NULL;
	}
}
?>