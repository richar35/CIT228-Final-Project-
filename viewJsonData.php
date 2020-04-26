<?php

$raceList = file_get_contents("raceList.json");

$display="<div id='race_name'><h1>Race Information</h1>";

    $display="<div id='race'><h1>Race List</h1>";
	$raceObject = json_decode($raceList);
	foreach ($raceObject->raceList as $race){
	  $id = $race->id;
	  $raceName = $race->raceName;
	  $location = $race->city;
	  $addDate = $race->dateAdded;
	  $modDate = $race->dateModified;	  	  
	  $display.= "<hr><h2>ID:" . $id . "</h2>" . "<hr><p>Race Name: " . $raceName . "</p>" .
				 "<p>Race Location: " . $location . "</p>" .
                 "<p>Date Added: " . $addDate . "</p>" .
                 "<p>Date Modified: " . $modDate . "</p>";
	 }
	 $display .= "</div>";
	 include 'BeginNav.php';
	 echo $display;
	 include 'EndNav.php';
?>
