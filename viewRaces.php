<?php
include 'BeginNav.php';
$xmlList = simplexml_load_file("race.xml") or die("Error: Cannot create object");
foreach($xmlList->address as $addr){
	$id=$addr->id;
	$name=$addr->name;
	$added=$addr->addDt;
	$mod=$addr->modDt;	
	echo "<div style='width:40%'><p style='color:green;border-bottom:2px green solid;font-weight:900;'>ID: " . $id . "<br>" .
	"<span style='background-color:white;color:black;'>Name: " . $ . " $name" . "<br>" .
	"Date Added: " . $added . "</span></p></div>";
}
include 'EndNav.php';
?>