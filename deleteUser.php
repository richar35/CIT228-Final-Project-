<?php
include 'connect.php';
doDB();

if (!$_POST)  {
	//haven't seen the selection form, so show it
	$display_block = "<h1>Select a User to delete</h1>";

	//get parts of records
	$get_list_sql = "SELECT id, f_name, l_name AS display_name
				FROM auth_users ORDER BY l_name";
				
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
			$display_user = stripslashes($recs['display_name']);
			$display_block .= "<option value=\"".$id."\">".$display_user."</option>";
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
		header("Location: deleteUser.php");
 		exit;
 	}

    //create safe version of ID
    $safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);

	//issue queries


	$del_auth_users_sql = "DELETE FROM racelocation WHERE id = '".$safe_id."'";
	$del_auth_users_sql_res = mysqli_query($mysqli, $del_auth_users_sql) or die(mysqli_error($mysqli));


	mysqli_close($mysqli);

	$display_block = "<h1>Your acount has been removed.</h1>";
}
?>
<?php include 'userNav.php'; ?>
<?php echo $display_block; ?>
<?php include 'userEndNav.php'; ?>
