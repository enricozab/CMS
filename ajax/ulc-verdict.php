<?php
  session_start();
  require_once('../mysql_connect.php');

  if($_POST['verdict'] == "Guilty") {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='{$_POST['decision']}', VERDICT='{$_POST['verdict']}' WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
  else {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='Incident/Violation is recorded but without any offense', VERDICT='{$_POST['verdict']}' WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
?>
