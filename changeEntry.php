<?php
session_start();
include 'connect.php';
doDB();

if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select a Race to Update</h1>";

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
		<p><label for=\"change_id\">Select a Record to Update:</label><br/>
		<select id=\"change_id\" name=\"change_id\" required=\"required\">
		<option value=\"\">-- Select One --</option>";

		while ($recs = mysqli_fetch_array($get_list_res)) {
			$id = $recs['id'];
			$display_race = stripslashes($recs['display_race']);
			$display_block .= "<option value=\"".$id."\">".$display_race."</option>";
		}

		$display_block .= "
		</select></p>
		<button class='btn-success' type='submit' name='submit' value='change'>Change Selected Entry</button>
		</form>";
	}
	//free result
	mysqli_free_result($get_list_res);

} else if ($_POST) {
	//check for required fields
	if ($_POST['change_id'] == "")  {
		header("Location: changeEntry.php");
		exit;
	}

	//create safe version of ID
	$safe_id = mysqli_real_escape_string($mysqli, $_POST['change_id']);
	$_SESSION["id"]=$safe_id;
	$_SESSION["racelocation"]="true";
	$_SESSION["date"]="true";
	$_SESSION["telephone"]="true";
	$_SESSION["email"]="true";
	$_SESSION["race_notes"]="true";
	//get master_info
	$get_master_sql = "SELECT race_name FROM master_racename WHERE id = '".$safe_id."'";
	$get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));

	while ($race_name = mysqli_fetch_array($get_master_res)) {
		   $display_race = stripslashes($race_name['race_name']);
	}

	$display_block = "<h1>Record Update</h1>";
	$display_block.="<form method='post' action='change.php'>";
	$display_block.="<fieldset><label>Race Name:</label><br/>";
	$display_block.="<input type='text' name='race_name' size='20' maxlength='75' required='required' value='" . $display_race ."'/></fieldset>";
	//free result
	mysqli_free_result($get_master_res);
	//get all addresses
	$get_racelocation_sql = "SELECT city, state, zipcode, type
	                      FROM racelocation WHERE master_id = '".$safe_id."'";
	$get_racelocation_res = mysqli_query($mysqli, $get_racelocation_sql) or die(mysqli_error($mysqli));

 	if (mysqli_num_rows($get_racelocation_res) > 0) {


		while ($add_info = mysqli_fetch_array($get_racelocation_res)) {
			$city = stripslashes($add_info['city']);
			$state = stripslashes($add_info['state']);
			$zipcode = stripslashes($add_info['zipcode']);
			$type = $add_info['type'];

			$display_block .="<fieldset><label>City/State/Zip:</label><br/>";
			$display_block .="<input type='text' name='city' size='30' maxlength='50' value='" . $city . "'/>";
			$display_block .="<input type='text' name='state' size='5' maxlength='2' value='".$state."'/>";
			$display_block .="<input type='text' name='zipcode' size='10' maxlength='10' value='".$zipcode."'/></fieldset>";
			$display_block .="<fieldset><label>Distance:</label><br>";
			
			if ($type=="Marathon"){
				$display_block .="<input type='radio' id='marathon' name='distance' value='Marathon' checked='checked' /><label for='marathon'>Marathon</label>";
				$display_block .="<input type='radio' id='half' name='distance' value='Half Marathon' /><label for='half'>Half Marathon</label>";
				$display_block .="<input type='radio' id='tenK' name='distance' value='10K' /><label for='10K'>10K</label>";
				$display_block .="<input type='radio' id='fiveK' name='distance' value='5K' /><label for='5K'>5K</label>";
			}
			else if ($type=="Half Marathon"){
				$display_block .="<input type='radio' id='marathon' name='distance' value='Marathon'/><label for='marathon'>Marathon</label>";
				$display_block .="<input type='radio' id='half' name='distance' value='Half Marathon' checked='checked'/><label for='half'>Half Marathon</label>";
				$display_block .="<input type='radio' id='10K' name='distance' value='10K' /><label for='10K'>10K</label>";
				$display_block .="<input type='radio' id='fiveK' name='distance' value='5K' /><label for='5K'>5K</label>";
			}

			else if ($type=="10K"){
				$display_block .="<input type='radio' id='marathon' name='distance' value='Marathon'/><label for='marathon'>Marathon</label>";
				$display_block .="<input type='radio' id='half' name='distance' value='Half Marathon' /><label for='half'>Half Marathon</label>";
				$display_block .="<input type='radio' id='tenK' name='distance' value='10K' checked='checked' /><label for='10K'>10K</label>";
				$display_block .="<input type='radio' id='fiveK' name='distance' value='5K' /><label for='5K'>5K</label>";
			}
			else{
				$display_block .="<input type='radio' id='marathon' name='distance' value='Marathon'/><label for='marathon'>Marathon</label>";
				$display_block .="<input type='radio' id='half' name='distance' value='Half Marathon' /><label for='half'>Half Marathon</label>";
				$display_block .="<input type='radio' id='tenK' name='distance' value='10K'  /><label for='10K'>10K</label>";
				$display_block .="<input type='radio' id='fiveK' name='distance' value='5K' checked='checked' /><label for='5K'>5K</label>";
			}	
		}
	$display_block .="</fieldset>";
	}
	else{
	$_SESSION["racelocation"]='false';
	$display_block .= <<<END_OF_BLOCK

	<fieldset>
	<label>City/State/Zip:</label><br/>
	<input type="text" name="city" size="30" maxlength="50" />
	<input type="text" name="state" size="5" maxlength="2" />
	<input type="text" name="zipcode" size="10" maxlength="10" />
	</fieldset>
	
	<fieldset>
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
END_OF_BLOCK;
	}

	//free result
	mysqli_free_result($get_racelocation_res);

	//get all race dates
	$get_date_sql = "SELECT month, day, year
	                      FROM date WHERE master_id = '".$safe_id."'";
	$get_date_res = mysqli_query($mysqli, $get_date_sql) or die(mysqli_error($mysqli));

 	if (mysqli_num_rows($get_date_res) > 0) {

		$display_block .= "<p><strong>Race Dates:</strong></p>";

		while ($add_info = mysqli_fetch_array($get_date_res)) {
			$month = stripslashes($add_info['month']);
			$day = stripslashes($add_info['day']);
			$year = stripslashes($add_info['year']);

			$display_block .="<fieldset><label>Month/Day/Year:</label><br/>";
			$display_block .="<input type='text' name='month' size='30' maxlength='50' value='" . $month . "'/>";
			$display_block .="<input type='text' name='day' size='5' maxlength='2' value='".$day."'/>";
			$display_block .="<input type='text' name='year' size='10' maxlength='10' value='".$year."'/></fieldset>";
			
	
		}
	$display_block .="</fieldset>";
	}
	else{
	$_SESSION["date"]='false';
	$display_block .= <<<END_OF_BLOCK

	<fieldset>
	<label>Month/Day/Year:</label><br/>
	<input type="text" name="month" size="30" maxlength="50" />
	<input type="text" name="day" size="5" maxlength="2" />
	<input type="text" name="year" size="10" maxlength="10" />
	</fieldset>
	
END_OF_BLOCK;
	}

	//free result
	mysqli_free_result($get_date_res);


	//get all tel
	$get_tel_sql = "SELECT tel_number FROM telephone
	                WHERE master_id = '".$safe_id."'";
	$get_tel_res = mysqli_query($mysqli, $get_tel_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_tel_res) > 0) {

		while ($tel_info = mysqli_fetch_array($get_tel_res)) {
			$tel_number = stripslashes($tel_info['tel_number']);
			$display_block .= "<fieldset><label>Phone Number:</label><br/>";
			$display_block .= "<input type='text' name='tel_number' size='30' maxlength='150' value='".$tel_number."' />";
		}
			
		
	$display_block .="</fieldset>";
	}
	else{
	$_SESSION["telephone"]='false';	
	$display_block .= <<<END_OF_BLOCK

	<fieldset>
	<label>Telephone Number:</label><br/>
	<input type="text" name="tel_number" size="30" maxlength="25" />
	</fieldset>
END_OF_BLOCK;
	}
	//free result
	mysqli_free_result($get_tel_res);
	

	//get email
	$get_email_sql = "SELECT email FROM email
	                  WHERE master_id = '".$safe_id."'";
	$get_email_res = mysqli_query($mysqli, $get_email_sql) or die(mysqli_error($mysqli));
	 if (mysqli_num_rows($get_email_res) > 0) {

		while ($email_info = mysqli_fetch_array($get_email_res)) {
			$email = stripslashes($email_info['email']);
			$display_block .= "<fieldset><label>Email Address:</label><br/>";
			$display_block .= "<input type='email' name='email' size='30' maxlength='150' value='".$email."' />";
		}

		$display_block .= "</fieldset>";
	}

	else{
		$_SESSION["email"]='false';
		$display_block .= '<fieldset><label>Email Address:</label><br/><input type="email" name="email" size="30" maxlength="150"/>';

	}
	
	
	//free result
	mysqli_free_result($get_email_res);

	//get race note
	$get_notes_sql = "SELECT note FROM race_notes
	                  WHERE master_id = '".$safe_id."'";
	$get_notes_res = mysqli_query($mysqli, $get_notes_sql) or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_notes_res) == 1) {
		while ($note_info = mysqli_fetch_array($get_notes_res)) {
			$note = nl2br(stripslashes($note_info['note']));
		}
		$display_block .= "<p><label for='note'>Race Note:</label><br/>";
		$display_block .= "<textarea id='note' name='race_notes' cols='35' rows='3'>".$note."</textarea></p>";
	}
	else{
		$_SESSION["notes"]='false';
		$display_block .= '<p><label for="note">Race Note:</label><br/><textarea id="note" name="race_notes" cols="35" rows="3"></textarea></p>';
		}

	
	//free result
	mysqli_free_result($get_notes_res);

	$display_block .= "<p style='text-align: left;'><button class='btn-success' type='submit' name='submitChange' id='submitChange' value='submitChange'>Change Entry</button>";
	
}
//close connection to MySQL
mysqli_close($mysqli);
	


?>
<?php include 'BeginNav.php'; ?>
<?php echo $display_block; ?>
<?php include 'EndNav.php'; ?>