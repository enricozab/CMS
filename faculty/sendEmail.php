<?php
	$access_token = $_SESSION["access_token"];
	$url = "https://www.googleapis.com/gmail/v1/users/me/messages/send";
	$header = array('Content-Type: application/json', "Authorization: Bearer $access_token");

	$subject = 'Test'; //sample subject should be 'Incident Report created for [student name]'
	$to = 'aaicragsolrac@gmail.com'; //should be sent to all parties involved based on a query
	$message = 'Incident rerport'; //message changes based on report. sample: "An incident report was created"

	$line = "\n";
	$raw = "to: $to".$line;
	$raw .= "subject: $subject".$line.$line;
	$raw .= $message;

	$base64 = base64_encode($raw);
	$data = '{ "raw" : "'.$base64.'" }';
	$send = Qassim_HTTP(1, $url, $header, $data);

	if( !empty($send['id']) ){ // if message has been sent, will be redirect to index.php
		//header("faculty-report-student.php");
	}else{ // if access token is expired or has some problems, will be logout!
		if( !empty($send['error']['errors'][0]['reason']) ){
			header("location: logout.php");
		}else{
			header("location: logout.php");
		}
	}
?>
