<?php

function CheckIfPasswordIsBreached($password_input, $is_console) {
	$password_format = strtoupper(sha1($password_input));
	$password_sha1_prefix = substr($password_format, 0, 5);
	$url_for_api = "https://api.pwnedpasswords.com/range/$password_sha1_prefix";
	$password_sha1_without_prefix= substr($password_format, 5, 40);


	$return_value = "Given password: ". $password_input . "<br>";
	$return_value .= " > Password in SHA1 with uppercase: ". $password_format . "<br>";
	$return_value .= " > Prefix: ". $password_sha1_prefix . "<br>";
	$return_value .= " > Password without prefix: ". $password_sha1_without_prefix . "<br>";


	$response = file_get_contents($url_for_api);
	$resp_to_array = explode("\n", $response);


	foreach($resp_to_array as $line) {

		$api_only_hash = substr($line, 0, 35);

		if ($api_only_hash == $password_sha1_without_prefix){

			$return_value .= "<br>Password is breached :( <br>";
			$return_value .= "<a href=$url_for_api>" . $url_for_api . "</a><br>";
			$return_value .= "=> " . $line . "<br><br>";

			if ($is_console) {
				$return_value = str_replace("<br>", "\n", "$return_value");
				echo $return_value;
				die();
			}


			return $return_value;
		}
	}
	$return_value .="<br>The given password is not breached! :) <br><br>";

	if ($is_console) {
		$return_value = str_replace("<br>", "\n", "$return_value");
		echo $return_value;
		die();
	}

	return $return_value;
}

?>
