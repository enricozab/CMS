<?php
// Reset OAuth access token
$g_Client->revokeToken();

// Destroy entire session data
session_destroy();

// Redirect to homepage
header("Location:index.php");


?>
