<?php
@session_start();

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

		// Redirect to the page where user can create event
		if ($_SESSION['user_type_id']==1){
			header('Location: ../student/student-calendar.php');
		}
		if ($_SESSION['user_type_id']==3){
			header('Location: ../hdo/hdo-calendar.php');
		}
		if ($_SESSION['user_type_id']==4){
			header('Location: ../ido/ido-calendar.php');
		}
		if ($_SESSION['user_type_id']==6){
			header('Location: ../aulc/aulc-calendar.php');
		}
		if ($_SESSION['user_type_id']==7){
			header('Location: ../ulc/ulc-calendar.php');
		}
		if ($_SESSION['user_type_id']==9){
			header('Location: ../sdfod/sdfod-calendar.php');
		}
		//header('Location: home.php');
		exit();
	}
	catch(Exception $e) {
		echo $e->getMessage();
		exit();
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<!-- Bootstrap Core CSS -->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<script src="../vendor/jquery/jquery.min.js"></script>

</head>
<body>
<?php
$login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
?>
<button class="btn btn-primary" id="login">Login with Google</button>

<script>
$('#login').click(function() {
	location.href= '<?php echo $login_url; ?>';
});
</script>
</body>
</html>
