<?php
  session_start();
  require_once('../mysql_connect.php');

  $feedbackq="UPDATE FORM_UPLOADING SET FEEDBACK_UPLOADED=1 WHERE CASE_ID = ".$_POST['caseID'];
  $feedbackres=mysqli_query($dbc,$feedbackq);
  if(!$feedbackres){
    echo mysqli_error($dbc);
  }
?>
