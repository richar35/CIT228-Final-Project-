<?php
function doDB() {
	global $mysqli;

	//connect to server and select database; you may need it
	$mysqli = mysqli_connect("localhost", "root", "", "races");
	//$mysqli = mysqli_connect("localhost", "lisabalbach_richar35", "CIT19020018", "lisabalbach_richar35 ");

	//if connection fails, stop script execution
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
}
?>