<?php
session_start();
//connect to database
include 'connect.php';

//time to update tables, so check for required fields
    if ($_POST['race_name'] == ""){
        header("Location: changeEntry.php");
        exit;
    }
	//connect to database
	doDB();
	//create clean versions of input strings
	$master_id=$_SESSION["id"];
	$safe_race_name = mysqli_real_escape_string($mysqli, $_POST['race_name']);
	$safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
	$safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
	$safe_zipcode = mysqli_real_escape_string($mysqli, $_POST['zipcode']);
	$safe_tel_number = mysqli_real_escape_string($mysqli, $_POST['tel_number']);
	$safe_month = mysqli_real_escape_string($mysqli, $_POST['month']);
	$safe_day = mysqli_real_escape_string($mysqli, $_POST['day']);
	$safe_year = mysqli_real_escape_string($mysqli, $_POST['year']);
	$safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$safe_note = mysqli_real_escape_string($mysqli, $_POST['race_notes']);;
	
	//update master_name table
	$add_master_sql = "UPDATE master_racename SET date_added=now(),date_modified=now(),race_name='". $safe_race_name."'".
	                   "WHERE id=".$master_id;
	$add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));

	if ($_SESSION["racelocation"]=="true"){
		//update racelocation table
		$add_racelocation_sql = "UPDATE racelocation SET master_id=".$master_id.",date_added=now(),date_modified=now()".
							",city='". $safe_city ."', state='". $safe_state .
							"', zipcode='". $safe_zipcode ."', type='".$_POST['distance']."'".
							 "WHERE master_id=".$master_id;
		$add_racelocation_res = mysqli_query($mysqli, $add_racelocation_sql) or die(mysqli_error($mysqli));
		}
	 else if (($_POST['city']) || ($_POST['state']) || ($_POST['zipcode'])) {
		//add new record to table
		$add_racelocation_sql = "INSERT INTO racelocation (master_id, date_added, date_modified, city, state, zipcode, type)  VALUES ('".
							$master_id."',now(), now(),'".$safe_city.
							"','".$safe_state."' , '".$safe_zipcode."' , '".$_POST['add_type']."')";
		$add_racelocation_res = mysqli_query($mysqli, $add_racelocation_sql) or die(mysqli_error($mysqli));
    }
    
    if ($_SESSION["date"]=="true"){
		//update date table
		$add_date_sql = "UPDATE date SET master_id=".$master_id.",date_added=now(),date_modified=now()".
							",month='". $safe_month ."', day='". $safe_day .
							"', year='". $safe_year ."'".
							 "WHERE master_id=".$master_id;
		$add_date_res = mysqli_query($mysqli, $add_date_sql) or die(mysqli_error($mysqli));
		}
	 else if (($_POST['month']) || ($_POST['day']) || ($_POST['year'])) {
		//add new record to table
		$add_date_sql = "INSERT INTO date (master_id, date_added, date_modified, month, day, year)  VALUES ('".
							$master_id."',now(), now(),'".$safe_month.
							"','".$safe_day."' , '".$safe_year."')";
		$add_date_res = mysqli_query($mysqli, $add_date_sql) or die(mysqli_error($mysqli));
    }

	if ($_SESSION["telephone"]=="true"){
		//update telephone table
		$add_tel_sql = "UPDATE telephone SET master_id=".$master_id.", date_added=now(),date_modified=now()".
		                ",tel_number='".$safe_tel_number."'".
		                 "WHERE master_id=".$master_id;
		$add_tel_res = mysqli_query($mysqli, $add_tel_sql) or die(mysqli_error($mysqli));
	   } else if ($_POST['tel_number']){

	   // add new record to telephone table
		$add_tel_sql = "INSERT INTO telephone (master_id, date_added, date_modified,
		                tel_number)  VALUES ('".$master_id."', now(), now(),
		                '".$safe_tel_number."')";
		$add_tel_res = mysqli_query($mysqli, $add_tel_sql) or die(mysqli_error($mysqli));
	   }

	if ($_SESSION["email"]=="true"){
		//update email table
		$add_email_sql = "UPDATE  email  SET master_id=".$master_id.", date_added=now(),date_modified=now()".
		                ",email='".$safe_email."'".
		                 "WHERE master_id=".$master_id;
		$add_email_res = mysqli_query($mysqli, $add_email_sql) or die(mysqli_error($mysqli));
	}else if ($_POST['email']) {
	// add new record to email table
		$add_email_sql = "INSERT INTO email (master_id, date_added, date_modified,
		                  email, type)  VALUES ('".$master_id."', now(), now(),
		                  '".$safe_email."', '".$_POST['email_type']."')";
		$add_email_res = mysqli_query($mysqli, $add_email_sql) or die(mysqli_error($mysqli));
	}
	

	if ($_SESSION["race_notes"]=="true"){
 		//update notes table
		$add_notes_sql = "UPDATE race_notes SET master_id=".$master_id.", date_added=now(),date_modified=now()".
		                  ",note='".$safe_note."'".
		                  "WHERE master_id=".$master_id;
		$add_notes_res = mysqli_query($mysqli, $add_notes_sql) or die(mysqli_error($mysqli));
	} else 	if ($_POST['race_notes']) {
	  // add new record to notes table
		$add_notes_sql = "INSERT INTO race_notes (master_id, date_added, date_modified,
		                  note)  VALUES ('".$master_id."', now(), now(), '".$safe_note."')";
		$add_notes_res = mysqli_query($mysqli, $add_notes_sql) or die(mysqli_error($mysqli));
	}

	mysqli_close($mysqli);
	$display_block = "<p>Your entry has been changed...</p>";

?>
<?php include 'BeginNav.php'; ?>
<?php echo $display_block; ?>
<?php include 'EndNav.php'; ?>