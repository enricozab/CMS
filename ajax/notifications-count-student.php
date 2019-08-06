<?php
  session_start();
  require_once('../mysql_connect.php');

  $snackq = "SELECT		*
              FROM 		REMINDERS R
              WHERE		R.USER_ID = ".$_SESSION['user_id']."
              AND			R.IF_NEW = 1";
  $snackres = mysqli_query($dbc,$snackq);
  if(!$snackres){
    echo mysqli_error($dbc);
  }
  else{
    echo $snackres->num_rows;
  }
?>
