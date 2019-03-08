<?php

session_start();

/* By Qassim Hassan, http://wp-time.com/send-email-via-gmail-api-using-php/ */

if( isset($_SESSION["access_token"]) or isset($_SESSION["emailAddress"]) ){
	unset($_SESSION["access_token"]);
	unset($_SESSION["emailAddress"]);
	if ($_SESSION['user_type_id']==2){
		header("location: localhost/cms/faculty/faculty-report-student.php");
	}
	if ($_SESSION['user_type_id']==3){
		header("location: localhost/cms/hdo/hdo-incident-reports.php");
	}
}
else{
	if ($_SESSION['user_type_id']==2){
		header("location: localhost/cms/faculty/faculty-report-student.php");
	}
	if ($_SESSION['user_type_id']==3){
		header("location: localhost/cms/hdo/hdo-incident-reports.php");
	}
}

?>
