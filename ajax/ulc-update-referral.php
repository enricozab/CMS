<?php
  session_start();
  require_once('../mysql_connect.php');

  $referralq='UPDATE CASE_REFERRAL_FORMS SET IF_UPLOADED=1 WHERE CASE_ID='.$_POST['caseID'];
  $referralres=mysqli_query($dbc,$referralq);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
