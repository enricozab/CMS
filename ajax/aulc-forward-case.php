<?php
  session_start();
  require_once('../mysql_connect.php');

  $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=8 WHERE CASE_ID = {$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  $aulc_remarks = 'NULL';
  if($_POST['aulc_remarks'] != null){
    $aulc_remarks = "'".$_POST['aulc_remarks']."'";
  }

  $changeoff = 'NULL';
  if($_POST['changeoff'] != null){
    $changeoff = $_POST['changeoff'];
  }

  $changevio = 'NULL';
  if($_POST['changevio'] != null){
    $changeoff = $_POST['changevio'];
  }

  $query="UPDATE CASE_REFERRAL_FORMS SET CASE_DECISION='{$_POST['decision']}', REASON='{$_POST['reason']}', AULC_REMARKS={$aulc_remarks}, CHANGE_OFFENSE={$changeoff}, NEW_OFFENSE={$changevio} WHERE CASE_ID={$_POST['caseID']}";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
?>
