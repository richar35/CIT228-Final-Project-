<?php

include 'connect.php';

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_BLOCK
	<form method="post" action="$_SERVER[PHP_SELF]" class="form">
	<h3>Add a New Race Below:</h3>
	<fieldset>
	<label>Race Name:</label><br/>
	<input type="text" name="race_name" size="20" maxlength="75" required="required" />
	</fieldset>
<br>
	<fieldset>
	<label>City/State/Zip:</label><br/>
	<input type="text" name="city" size="30" maxlength="50" required="required" />
	<input type="text" name="state" size="5" maxlength="2" required="required" />
	<input type="text" name="zipcode" size="10" maxlength="10" required="required" />
	</fieldset>
<br>
	<fieldset>
	<label>Month/Day/Year:</label><br/>
	<input type="text" name="month" size="30" maxlength="50" required="required" />
	<input type="text" name="day" size="5" maxlength="2" required="required" />
	<input type="text" name="year" size="10" maxlength="10" required="required" />
    </fieldset>
	<br>
	<fieldset>
	<label>Telephone Number:</label><br/>
	<input type="text" name="tel_number" size="30" maxlength="25" />
	</fieldset>
	<br>
    <fieldset>
    <br>
	<label>Race Distance:</label><br/>
    <input type="radio" id="marathon" name="distance" value="Marathon" checked />
	    <label for="marathon">Marathon</label>
	<input type="radio" id="half" name="distance" value="Half Marathon" />
	    <label for="half">Half Marathon</label>
	<input type="radio" id="tenK" name="distance" value="10K" />
        <label for="tenK">10K</label>
    <input type="radio" id="fiveK" name="distance" value="5K" />
	    <label for="fiveK">5K</label>
	</fieldset>
<br>
	<fieldset>
	<label>Race Email Address:</label><br/>
	<input type="email" name="email" size="30" maxlength="150" />
	</fieldset>
<br>
	<p><label for="note">Race Notes:</label><br/>
	<textarea id="note" name="race_notes" cols="35" rows="3"></textarea></p>

	<button type="submit" name="submit" value="send" class="bg-success">Add Entry</button>
	</form>
END_OF_BLOCK;

} else if ($_POST) {
	//time to add to tables, so check for required fields
	if ($_POST['race_name'] == ""){
		header("Location: addentry.php");
		exit;
	}

	//connect to database
	doDB();

	//create clean versions of input strings
	$safe_race_name = mysqli_real_escape_string($mysqli, $_POST['race_name']);
	$safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
	$safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
	$safe_zipcode = mysqli_real_escape_string($mysqli, $_POST['zipcode']);
	$safe_tel_number = mysqli_real_escape_string($mysqli, $_POST['tel_number']);
	$safe_month = mysqli_real_escape_string($mysqli, $_POST['month']);
	$safe_day = mysqli_real_escape_string($mysqli, $_POST['day']);
	$safe_year = mysqli_real_escape_string($mysqli, $_POST['year']);
	$safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$safe_note = mysqli_real_escape_string($mysqli, $_POST['race_notes']);

	//add to master_racename table
	$add_master_sql = "INSERT INTO master_racename (date_added, date_modified, race_name)
                       VALUES (now(), now(), '".$safe_race_name."')";
	$add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));

	//get master_id for use with other tables
	$master_id = mysqli_insert_id($mysqli);

	if (($_POST['city']) || ($_POST['state']) || ($_POST['zipcode'])) {
		//something relevant, so add to raceLocation table
		$add_racelocation_sql = "INSERT INTO racelocation (master_id, date_added, date_modified,
		                    city, state, zipcode, type)  VALUES ('".$master_id."',
		                    now(), now(), '".$safe_city."',
		                    '".$safe_state."' , '".$safe_zipcode."' , '".$_POST['distance']."')";
		$add_racelocation_res = mysqli_query($mysqli, $add_racelocation_sql) or die(mysqli_error($mysqli));
	}



	if (($_POST['month']) || ($_POST['day']) || ($_POST['year'])) {
		//something relevant, so add to fax table
		$add_date_sql = "INSERT INTO date (master_id, date_added, date_modified,
						month, day, year)  VALUES ('".$master_id."',
						now(), now(),'".$safe_month."',
						'".$safe_day."' , '".$safe_year."')";
		$add_date_res = mysqli_query($mysqli, $add_date_sql) or die(mysqli_error($mysqli));
	}

	if ($_POST['tel_number']) {
		//something relevant, so add to telephone table
		$add_tel_sql = "INSERT INTO telephone (master_id, date_added, date_modified,
		                tel_number)  VALUES ('".$master_id."', now(), now(),
		                '".$safe_tel_number."')";
		$add_tel_res = mysqli_query($mysqli, $add_tel_sql) or die(mysqli_error($mysqli));
	}


	if ($_POST['email']) {
		//something relevant, so add to email table
		$add_email_sql = "INSERT INTO email (master_id, date_added, date_modified,
		                  email)  VALUES ('".$master_id."', now(), now(),
		                  '".$safe_email."')";
		$add_email_res = mysqli_query($mysqli, $add_email_sql) or die(mysqli_error($mysqli));
	}

	if ($_POST['race_notes']) {
		//something relevant, so add to notes table
		$add_notes_sql = "INSERT INTO race_notes (master_id, date_added, date_modified,
		                  note)  VALUES ('".$master_id."', now(), now(), '".$safe_note."')";
		$add_notes_res = mysqli_query($mysqli, $add_notes_sql) or die(mysqli_error($mysqli));
	}
	mysqli_close($mysqli);
	$display_block = "<p>Your entry has been added.</p>";
}
?>
<?php include 'BeginNav.php'; ?>

<?php echo $display_block; ?>
<?php include 'EndNav.php'; ?>