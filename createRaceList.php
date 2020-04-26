<?php
	//connect to server and select database; you may need it
	//include 'connect.php';
	include 'connect.php';
	doDB();
	$get_master_name = "SELECT * FROM master_racename";
	$get_master_res = mysqli_query($mysqli, $get_master_name) or die(mysqli_error($mysqli));

	$xml = "<raceList>";
	while($r = mysqli_fetch_array($get_master_res)){
	 $xml .= "<id>".$r['id']."</id>";
	 $xml .= "<name>".$r['race_name']."</first>";  
 	 $xml .= "<addDt>".$r['date_added']."</addDt>";  
  	 $xml .= "<modDt>".$r['date_modified']."</modDt>";    
     $xml .= "</address>";  
	}
$xml .= "</raceList>";
$sxe = new SimpleXMLElement($xml);
$sxe->asXML("race.xml");
include 'BeginNav.php';
echo "<h2>contacts.xml has been created</h2>";
echo "<p><a href='viewRaces.php'>[View Contact List]</a>";
include 'EndNav.php';
?>