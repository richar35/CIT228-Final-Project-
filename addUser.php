<?php

include 'connect.php';

if (!$_POST) {
	//haven't seen the form, so show it
	$display_block = <<<END_OF_BLOCK
	<form method="post" action="$_SERVER[PHP_SELF]" class="form">
	<h3>Create your Username and Password Below:</h3>
	<fieldset>
	<label>First/Last Names:</label><br/>
	<input type="text" name="f_name" size="20" maxlength="75" required="required" />
	<input type="text" name="l_name" size="30" maxlength="75" required="required" />
	</fieldset>
<br>
<fieldset>
<label>User Email</label><br/>
<input type="text" name="email" size="30" maxlength="50" required="required" />
</fieldset>
<br>
	<fieldset>
	<label>Create Username</label><br/>
	<input type="text" name="username" size="30" maxlength="50" required="required" />
	</fieldset>
<br>
	<fieldset>
	<label>Create Password</label><br/>
	<input type="text" name="password" size="30" maxlength="50" required="required" />
    </fieldset>

	<button type="submit" name="submit" value="send" class="bg-success">Create User</button>
	</form>
END_OF_BLOCK;

} else if ($_POST) {
	//time to add to tables, so check for required fields
    if (($_POST['f_name'] == "") || ($_POST['l_name'] == "") || ($_POST['email'] == "") || ($_POST['username'] == "") || ($_POST['password'] == "")) {
		header("Location: addUser.php");
		exit;
	}

	//connect to database
	doDB();

	//create clean versions of input strings
	$safe_f_name = mysqli_real_escape_string($mysqli, $_POST['f_name']);
	$safe_l_name = mysqli_real_escape_string($mysqli, $_POST['l_name']);
	$safe_userEmail = mysqli_real_escape_string($mysqli, $_POST['email']);
	$safe_username = mysqli_real_escape_string($mysqli, $_POST['username']);
	$safe_password = mysqli_real_escape_string($mysqli, $_POST['password']);
	$id = mysqli_insert_id($mysqli);
	
	

	

	 if (($_POST['f_name']) || ($_POST['l_name']) || ($_POST['email']) || ($_POST['username']) || ($_POST['password'])) {
		$add_auth_users_sql = "INSERT INTO auth_users (f_name, l_name,
	 	                    email, username, password)  VALUES (
		                    '".$safe_f_name."',
	 	                    '".$safe_l_name."' , '".$safe_userEmail."', '".$safe_username."', '".$safe_password."')";
	 	$add_auth_users_res = mysqli_query($mysqli, $add_auth_users_sql) or die(mysqli_error($mysqli));
	 }


	mysqli_close($mysqli);
	$display_block = "<p>Thank you for signing up! You can now begin adding races.
	<br>
	<a href='menu2.html'>Click Here to Go to the Main Menu</a>
	</p>";
	
}
?>
<?php include 'userNav.php'; ?>

<?php echo $display_block; ?>
<?php include 'userEndNav.php'; ?>