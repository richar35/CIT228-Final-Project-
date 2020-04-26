<?php
include 'connect.php';
doDB();

if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select a Race to Remove:</h1>";

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
		<button type=\"submit\" name=\"submit\" value=\"del\">Delete Selected Entry</button>
		</form>";
	}
	//free result
	mysqli_free_result($get_list_res);
} else if ($_POST) {
	//check for required fields
	if ($_POST['sel_id'] == "")  {
		header("Location: deleteEntry.php");
		exit;
	}

    //create safe version of ID
    $safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);

	//issue queries
	$del_master_sql = "DELETE FROM master_racename WHERE id = '".$safe_id."'";
	$del_master_res = mysqli_query($mysqli, $del_master_sql) or die(mysqli_error($mysqli));

	$del_racelocation_sql = "DELETE FROM racelocation WHERE master_id = '".$safe_id."'";
	$del_racelocation_sql_res = mysqli_query($mysqli, $del_racelocation_sql) or die(mysqli_error($mysqli));

	$del_date_sql = "DELETE FROM date WHERE master_id = '".$safe_id."'";
	$del_date_res = mysqli_query($mysqli, $del_date_sql) or die(mysqli_error($mysqli));

	$del_tel_sql = "DELETE FROM telephone WHERE master_id = '".$safe_id."'";
	$del_tel_res = mysqli_query($mysqli, $del_tel_sql) or die(mysqli_error($mysqli));

	$del_email_sql = "DELETE FROM email WHERE master_id = '".$safe_id."'";
	$del_email_res = mysqli_query($mysqli, $del_email_sql) or die(mysqli_error($mysqli));

	$del_notes_sql = "DELETE FROM race_notes WHERE master_id = '".$safe_id."'";
	$del_notes_res = mysqli_query($mysqli, $del_notes_sql) or die(mysqli_error($mysqli));

	mysqli_close($mysqli);

	$display_block = "<h1>Race has been Deleted.</h1><p>Would you like to
	<a href=\"".$_SERVER['PHP_SELF']."\">delete another</a>?...Return to the <a href='menu2.html'>main menu</a>?</p>";
}
?>
<?php include 'BeginNav.php'; ?>
<?php echo $display_block; ?>
<?php include 'EndNav.php'; ?>
