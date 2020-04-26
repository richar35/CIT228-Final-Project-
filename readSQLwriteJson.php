<?php 
include 'connect.php';
doDB();
 
$query="SELECT master_racename.id,race_name, master_racename.date_added, 
master_racename.date_modified, racelocation.city FROM master_racename JOIN racelocation ON 
master_racename.id = racelocation.master_id"; 
$result=$mysqli->query($query)
	or die ($mysqli->error);

//store the entire response
$response = array();

//the array that will hold the titles and links
$posts = array();

while($row=$result->fetch_assoc()) //mysql_fetch_array($sql)
{ 
$id=$row['id']; 
$raceName=$row['race_name']; 
$location=$row['city'];
$dateAdded=$row['date_added']; 
$dateModified=$row['date_modified']; 

//each item from the rows go in their respective vars and into the posts array
$posts[] = array('id'=> $id, 'raceName'=> $raceName, 'city'=> $location, 'dateAdded'=>$dateAdded, 'dateModified'=>$dateModified); 

} 

//the posts array goes into the response
$response['raceList'] = $posts;

//creates the file
$fp = fopen('raceList.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
include 'BeginNav.php';
$display_block="<p>The Race list has been written to json</p>";
$display_block.="<p><a href='viewJsondata.php'>View Race info</a></p>";
echo $display_block;
include 'EndNav.php';
?> 
