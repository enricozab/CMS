<?php
  session_start();
  require_once('../mysql_connect.php');

  $acads = 0;
  $decision;
  if(is_array($_POST['decision'])) {
    if(array_key_exists("Render Academic Service",$_POST['decision'])) {
      $acads = 1;
    }
    $decision = implode(", ", $_POST['decision']);
  }
  else {
    if(strpos($_POST['decision'],"Render Academic Service") !== false) {
      $acads = 1;
      echo $acads;
    }
    $decision = $_POST['decision'];
  }

  if(isset($_POST['verdict'])) {
    if($_POST['verdict'] == "Guilty") {
      $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='$decision', VERDICT='{$_POST['verdict']}', NEED_ACAD_SERVICE=$acads WHERE CASE_ID = {$_POST['caseID']}";
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
  }
  else {
    if(isset($_POST['pd'])) {
      $query="UPDATE CASES SET IF_NEW=1, REMARKS_ID=14, PROCEEDING_DECISION='{$_POST['decision']}' WHERE CASE_ID = {$_POST['caseID']}";
      $result=mysqli_query($dbc,$query);
      if(!$result){
        echo mysqli_error($dbc);
      }
    }
    else {
      $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='{$_POST['decision']}' WHERE CASE_ID = {$_POST['caseID']}";
      $result=mysqli_query($dbc,$query);
      if(!$result){
        echo mysqli_error($dbc);
      }
    }
  }

?>
