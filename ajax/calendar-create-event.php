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
		$pdate = null;
		if($event['event_time']['event_date'] != null) {
			$pdate = $event['event_time']['event_date'];
		}
		else {
			$pdate = $event['event_time']['start_time'];
		}
		if($_SESSION['user_type_id'] == 7) {
			$query="UPDATE 	CASES SET IF_NEW=1, STATUS_ID=2, PROCEEDING_DATE='{$pdate}', 
						REMARKS_ID=CASE
										WHEN (SELECT PROCEEDINGS FROM CASE_REFERRAL_FORMS WHERE CASE_ID = {$_SESSION['caseID']})=3 THEN 9
										WHEN (SELECT PROCEEDINGS FROM CASE_REFERRAL_FORMS WHERE CASE_ID = {$_SESSION['caseID']})=2 THEN 15
										ELSE 16
									END
						WHERE 	CASE_ID = {$_SESSION['caseID']}";
		}
		else if($_SESSION['user_type_id'] == 4) {
			$query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=3 WHERE CASE_ID = {$_SESSION['caseID']}";
		}
		$result=mysqli_query($dbc,$query);
		if(!$result){
			echo mysqli_error($dbc);
		}
		if($_SESSION['user_type_id'] == 4) {
			$query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID,DATE)
              			VALUES ({$_SESSION['caseID']},4,'{$_SESSION['user_id']}','{$pdate}')";
			$result2=mysqli_query($dbc,$query2);
			if(!$result2){
				echo mysqli_error($dbc);
			}
		}
		else if ($_SESSION['user_type_id'] == 7) {
			$query="SELECT CRF.PROCEEDINGS AS 'PROCEEDINGS'
						FROM 		CASES C
						LEFT JOIN	CASE_REFERRAL_FORMS CRF ON C.CASE_ID = CRF.CASE_ID
						WHERE		C.CASE_ID =".$_SESSION['caseID'];
			$result=mysqli_query($dbc,$query);
			if(!$result){
			  echo mysqli_error($dbc);
			}
			else{
			  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			}
			$action = 14;
			if ($row['PROCEEDINGS'] == 2) {
				$action = 13;
			}
			else if ($row['PROCEEDINGS'] == 3) {
				$action = 12;
			}
			if ($action == 14) {
				$query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID)
							VALUES ({$_SESSION['caseID']},20,'{$_SESSION['user_id']}')";
				$result2=mysqli_query($dbc,$query2);
				if(!$result2){
					echo mysqli_error($dbc);
				}
			}
			else {
				$query2="INSERT INTO CASE_AUDIT (CASE_ID,ACTION_DONE_ID,ACTION_DONE_BY_ID,DATE)
							VALUES ({$_SESSION['caseID']},{$action},'{$_SESSION['user_id']}','{$pdate}')";
				$result2=mysqli_query($dbc,$query2);
				if(!$result2){
					echo mysqli_error($dbc);
				}
			}
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
