<?php

session_start();

/* By Qassim Hassan, http://wp-time.com/send-email-via-gmail-api-using-php/ */

if( !isset($_GET['code']) or isset($_SESSION["access_token"]) ){
	if ($_SESSION['user_type_id']==2){
		header("location: ../faculty/faculty-report-student.php");
	}
	if ($_SESSION['user_type_id']==3){
		header("location: ../hdo/hdo-incident-reports.php");
	}

	exit();
}


include 'Qassim_HTTP.php';
include 'config.php';


$header = array( "Content-Type: application/x-www-form-urlencoded" );

$data = http_build_query(
			array(
				'code' => str_replace("#", null, $_GET['code']),
				'client_id' => $client_id,
				'client_secret' => $client_secret,
				'redirect_uri' => $redirect_uri,
				'grant_type' => 'authorization_code'
			)
		);

$url = "https://www.googleapis.com/oauth2/v4/token";

$result = Qassim_HTTP(1, $url, $header, $data);
$access_token = $result['access_token']; // Get access token


$info = Qassim_HTTP(0, "https://www.googleapis.com/gmail/v1/users/me/profile", array("Authorization: Bearer $access_token"), 0); // Get email address
$_SESSION["emailAddress"] = $info['emailAddress'];


if( !empty($result['error']) ){ // if have some problems, will be logout
	header("location: logout.php");
}
else{ // if get access token, will be redirect to index.php
	$_SESSION["access_token"] = $access_token;
	if ($_SESSION['user_type_id']==2){
		header("location: ../faculty/faculty-report-student.php");
	}
	if ($_SESSION['user_type_id']==3){
		header("location: ../hdo/hdo-incident-reports.php");
	}
}

?>
