<?php
include 'connect.php';
doDB();
if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select a Race to View:</h1>";

	//get parts of records
	$get_list_sql = "SELECT id, race_name AS display_race
                FROM master_racename ORDER BY race_name";
	$get_list_res = mysqli_query($mysqli, $get_list_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_list_res) < 1) {
		//no records
		$display_block .= "<p><em>Sorry, no records to select!</em></p>";

	} else {
		//has records, so get results and print in a form
		$display_block .= "
		<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
		<p><label for=\"sel_id\">Select a Record:</label><br/>
		<select id=\"sel_id\" name=\"sel_id\" required=\"required\">
		<option value=\"\">-- Select One --</option>";

		while ($recs = mysqli_fetch_array($get_list_res)) {
			$id = $recs['id'];
			$display_race = stripslashes($recs['display_race']);
			$display_block .= "<option value=\"".$id."\">".$display_race."</option>";
		}

		$display_block .= "
		</select></p>
		<button class='btn-success'='submit' name='submit' value='view'>View Selected Entry</button>
		</form>";
	}
	//free result
	mysqli_free_result($get_list_res);

} else if ($_POST) {
	//check for required fields
	if ($_POST['sel_id'] == "")  {
		header("Location: selectEntry.php");
		exit;
	}

	//create safe version of ID
	$safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);

	//get master_info
	$get_master_sql = "SELECT id, race_name AS display_race
	                   FROM master_racename WHERE id = '".$safe_id."'";
	$get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));

	while ($name_info = mysqli_fetch_array($get_master_res)) {
		$display_race = stripslashes($name_info['display_race']);
	}

	$display_block = "<h1>Showing Record for ".$display_race."</h1>";

	//free result
	mysqli_free_result($get_master_res);

	//get all addresses
	$get_racelocation_sql = "SELECT city, state, zipcode, type
	                      FROM racelocation WHERE master_id = '".$safe_id."'";
	$get_racelocation_res = mysqli_query($mysqli, $get_racelocation_sql) or die(mysqli_error($mysqli));

 	if (mysqli_num_rows($get_racelocation_res) > 0) {

		$display_block .= "<p><strong>Race Location and Distance:</strong><br/>
		<ul>";

		while ($add_info = mysqli_fetch_array($get_racelocation_res)) {
			$city = stripslashes($add_info['city']);
			$state = stripslashes($add_info['state']);
			$zipcode = stripslashes($add_info['zipcode']);
			$type = stripslashes($add_info['type']);
            

			$display_block .= "<li> $city $state $zipcode </li><br>
			<li>$type</li>";

			


		}

		$display_block .= "</ul>";
	}

	//free result
    mysqli_free_result($get_racelocation_res);
    
    //get all addresses
	$get_date_sql = "SELECT month, day, year
    FROM date WHERE master_id = '".$safe_id."'";
$get_date_res = mysqli_query($mysqli, $get_date_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_date_res) > 0) {

$display_block .= "<p><strong>Race Date:</strong><br/>
<ul>";

while ($add_info = mysqli_fetch_array($get_date_res)) {
$month = stripslashes($add_info['month']);
$day = stripslashes($add_info['day']);
$year = stripslashes($add_info['year']);


$display_block .= "<li> $month $day $year </li>";
}

$display_block .= "</ul>";
}

//free result
mysqli_free_result($get_date_res);

	//get all tel
	$get_tel_sql = "SELECT tel_number FROM telephone
	                WHERE master_id = '".$safe_id."'";
	$get_tel_res = mysqli_query($mysqli, $get_tel_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_tel_res) > 0) {

		$display_block .= "<p><strong>Telephone:</strong><br/>
		<ul>";

		while ($tel_info = mysqli_fetch_array($get_tel_res)) {
			$tel_number = stripslashes($tel_info['tel_number']);

			$display_block .= "<li>$tel_number</li>";
		}

		$display_block .= "</ul>";
	}

	//free result
	mysqli_free_result($get_tel_res);


	//get all email
	$get_email_sql = "SELECT email FROM email
	                  WHERE master_id = '".$safe_id."'";
	$get_email_res = mysqli_query($mysqli, $get_email_sql) or die(mysqli_error($mysqli));

	 if (mysqli_num_rows($get_email_res) > 0) {

		$display_block .= "<p><strong>Email:</strong><br/>
		<ul>";

		while ($email_info = mysqli_fetch_array($get_email_res)) {
			$email = stripslashes($email_info['email']);
			

			$display_block .= "<li>$email</li>";
		}

		$display_block .= "</ul>";
	}

	//free result
	mysqli_free_result($get_email_res);

	//get personal note
	$get_notes_sql = "SELECT note FROM race_notes
	                  WHERE master_id = '".$safe_id."'";
	$get_notes_res = mysqli_query($mysqli, $get_notes_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_notes_res) == 1) {
		while ($note_info = mysqli_fetch_array($get_notes_res)) {
			$note = nl2br(stripslashes($note_info['note']));
			$display_block .= "<p><strong>Race Notes:</strong><br/>$note</p>";
		}

		
	}

	//free result
	mysqli_free_result($get_notes_res);

}
//close connection to MySQL
mysqli_close($mysqli);
?>
<?php include 'BeginNav.php'; ?>
<?php echo $display_block; ?>
<?php include 'EndNav.php'; ?>