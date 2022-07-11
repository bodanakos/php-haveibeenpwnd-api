<?php
	require_once "functions/breached.php";

	$password = $_POST['password'];
	if (isset ($_POST['submit']) && empty($password)) {
		echo "Empty password!";
	}
	if (isset($password) && ! empty($password)) {
		echo CheckIfPasswordIsBreached($password,0);
	}
?>
        <form method="post">
                <label>Password:</label>
                <input type="password" name="password">
		<input type="Submit" name="submit" value="Check Password">
	</form>
