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

	private function getDetails()
	{

		include "db_connect.php";
		$query = "SELECT path, gallery_name, caption, pub_date FROM Document";
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

		$query = "SELECT path, gallery_name, caption, pub_date FROM Document";
		$stmt = $con->prepare( $query );
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$items .= '<item>
				<title>'. $row["gallery_name"] .'</title>
				<link>http://localhost:8000/</link>
				<description><![CDATA[<figure><img src="http://localhost:8000/slideshow/'.$row["path"].'" /><figcaption>'.$row["caption"].'</figcaption></figure>]]></description>
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
