<?php

require_once('google-calendar-api.php');
require_once('settings.php');

// Google passes a parameter 'code' in the Redirect Url
if(isset($_GET['code'])) {
	try {
		$capi = new GoogleCalendarApi();

		// Get the access token
		$data = $capi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);

		// Save the access token as a session variable
		$_SESSION['access_token_calendar'] = $data['access_token'];
		exit();
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}

?>
