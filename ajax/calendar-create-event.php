<?php
session_start();
header('Content-type: application/json');

require_once('../calendar/google-calendar-api.php');

try {
	// Get event details
	$event = $_POST['event_details'];

	$capi = new GoogleCalendarApi();

	// Get user calendar timezone
	$user_timezone = $capi->GetUserCalendarTimezone($event['access_token']);

	// Create event on primary calendar
	$event_id = $capi->CreateCalendarEvent('primary', $event['title'], $event['attendees'], $event['all_day'], $event['event_time'], $user_timezone, $event['access_token']);

	echo json_encode([ 'event_id' => $event_id ]);
}
catch(Exception $e) {
	header('Bad Request', true, 400);
    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
}

//unset($_SESSION['access_token_calendar']);
//header('Location: google-login.php');

?>
