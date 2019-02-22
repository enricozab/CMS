<?php

/* By Qassim Hassan, http://wp-time.com/send-email-via-gmail-api-using-php/ */

$scope = "https://mail.google.com/"; // Do not change it!

$redirect_uri = "http://localhost/CMS/gmail/sign-in.php"; // Enter your redirect_uri WHERE THE CODE GOES AFTER LOGGING IN

$client_id = "847418612593-r3mdvmf7mes078aghrojkkb7gnkvlrqp.apps.googleusercontent.com"; // Enter your client_id

$client_secret = "ovl2IR1GS5fnLzIZsFwgTbiC"; // Enter your client_secret

$login_url = "https://accounts.google.com/o/oauth2/v2/auth?scope=$scope&response_type=code&redirect_uri=$redirect_uri&client_id=$client_id"; // Do not change it!

?>
