<?php

session_start();

/* By Qassim Hassan, http://wp-time.com/send-email-via-gmail-api-using-php/ */

if( isset($_SESSION["access_token"]) or isset($_SESSION["emailAddress"]) ){
	unset($_SESSION["access_token"]);
	unset($_SESSION["emailAddress"]);
	header("location: faculty-report-student.php");
}else{
	header("location: faculty-report-student.php");
}

?>
