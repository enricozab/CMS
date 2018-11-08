<?php
session_start();
date_default_timezone_set("Asia/Hong_Kong");
require_once('../mysql_connect.php');
if ($_SESSION['user_type_id']!=2)
    header("Location: http://".$_SERVER['HTTP_HOST'].  "/CMS/login.php");
?>
