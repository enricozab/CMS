<?php
  session_start();
  require_once('../mysql_connect.php');

  $other = 'NULL';
  if($_POST['other'] != null){
    $other = "'".$_POST['other']."'";
  }

  $query="UPDATE CASE_REFERRAL_FORMS SET ULC_OTHER_REMARKS={$other}, IF_SIGNED=1 WHERE CASE_ID={$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
