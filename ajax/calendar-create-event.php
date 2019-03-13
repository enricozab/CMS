<?php
session_start();
header('Content-type: application/json');

require_once('../calendar/google-calendar-api.php');
require_once('../mysql_connect.php');

try {
	// Get event details
	$event = $_POST['event_details'];

	$capi = new GoogleCalendarApi();

	// Get user calendar timezone
	$user_timezone = $capi->GetUserCalendarTimezone($event['access_token']);

	// Create event on primary calendar
	$event_id = $capi->CreateCalendarEvent('primary', $event['title'], $event['attendees'], $event['all_day'], $event['event_time'], $user_timezone, $event['access_token']);

	echo json_encode([ 'event_id' => $event_id ]);

	if(isset($_SESSION["caseID"])) {
		if($_SESSION['user_type_id'] == 7) {
			$hdate = null;
			if($event['event_time']['event_date'] != null) {
				$hdate = $event['event_time']['event_date'];
			}
			else {
				$hdate = $event['event_time']['start_time'];
			}
			$query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=9, HEARING_DATE='{$hdate}' WHERE CASE_ID = {$_SESSION['caseID']}";
		}
		else if($_SESSION['user_type_id'] == 4) {
			$query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=3 WHERE CASE_ID = {$_SESSION['caseID']}";
		}
	  $result=mysqli_query($dbc,$query);
	  if(!$result){
	    echo mysqli_error($dbc);
	  }
		unset($_SESSION['caseID']);
	}
}
catch(Exception $e) {
	header('Bad Request', true, 400);
    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
}
//unset($_SESSION['access_token_calendar']);
//header('Location: google-login.php');

?>