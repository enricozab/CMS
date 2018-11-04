<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");
if ($_SESSION['user_type_id']!=3)
    header("Location: http://".$_SERVER['HTTP_HOST'].  "/cms/php/login.php");
?>
