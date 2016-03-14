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
		$type = 'Blog';
		$stmt = $con->prepare('SELECT title, content, slug, pub_date FROM Page WHERE page_type = :type');
		$stmt->bindParam(':type', $type, PDO::PARAM_STR);
		$stmt->execute();
		//while ($pageRow = $stmt->fetch(PDO::FETCH_ASSOC)){
			$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title>Voices for Earth Justice: Latest Blog Posts</title>
      <link>http://www.voices4earth.org</link>
      <description>Latest blog posts by Voices for Earth Justice.</description>';
		//}
		return $details;
		$con = NULL;
	}
	private function getItems()
	{
		include "db_connect.php";
		$items = '';
		
		$type = 'Blog';
		$stmt = $con->prepare('SELECT title, content, slug, pub_date FROM Page WHERE page_type = :type');
		$stmt->bindParam(':type', $type, PDO::PARAM_STR);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$items .= '<item>
				<title>'. $row["title"] .'</title>
				<link>http://localhost:8000/'. $row["slug"] .'</link>
				<description><![CDATA['. $row["content"] .']]></description>
				<pubDate>'. $row["pub_date"] .'</pubDate>
			</item>';
		}
		$items .= '</channel>
				</rss>';
		return $items;
		$con = NULL;
	}
}
?>