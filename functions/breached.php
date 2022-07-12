<?php

function CheckIfPasswordIsBreached($password_input, $is_console) {
	date_default_timezone_set("Europe/Budapest");
	$password_format = strtoupper(sha1($password_input));
	$password_sha1_prefix = substr($password_format, 0, 5);
	$url_for_api = "https://api.pwnedpasswords.com/range/$password_sha1_prefix";
	$password_sha1_without_prefix= substr($password_format, 5, 40);


	$return_value = date("H:i:s") . " [INFO]: Given password: ". $password_input . "<br>";
	$return_value .= date("H:i:s") . " [INFO]: > Password in SHA1 with uppercase: ". $password_format . "<br>";
	$return_value .= date("H:i:s") . " [INFO]: > Prefix: ". $password_sha1_prefix . "<br>";
	$return_value .= date("H:i:s") . " [INFO]: > Password without prefix: ". $password_sha1_without_prefix . "<br>";

	$options = stream_context_create(array('http'=>
	    array(
		    'timeout' => 10 // 10 seconds
		 )
	));
	$response = file_get_contents($url_for_api, false, $options);
	if (empty($response)) {
		die (date("H:i:s") . ' [ERROR]: Cannot reach ' . $url_for_api . ' -> Connection Timed Out.');
	}
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
