<?php
  session_start();
  require_once('../mysql_connect.php');

  $decision;
  if(is_array($_POST['decision'])) {
    $decision = implode(", ", $_POST['decision']);
  }
  else {
    $decision = $_POST['decision'];
  }

  $acads = 0;
  if(strpos($decision,"Render Academic Service") !== false) {
    $acads = 1;
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
      $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='$decision', NEED_ACAD_SERVICE=$acads WHERE CASE_ID = {$_POST['caseID']}";
      $result=mysqli_query($dbc,$query);
      if(!$result){
        echo mysqli_error($dbc);
      }
    }
    else {
      $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=2, REMARKS_ID=14, PROCEEDING_DECISION='$decision', NEED_ACAD_SERVICE=$acads WHERE CASE_ID = {$_POST['caseID']}";
      $result=mysqli_query($dbc,$query);
      if(!$result){
        echo mysqli_error($dbc);
      }
    }
  }

  if($_POST['remarks'] == 13) {
    $query="UPDATE CASES SET IF_NEW=1, STATUS_ID=3, REMARKS_ID=11, DATE_CLOSED = CURRENT_TIMESTAMP() WHERE CASE_ID = {$_POST['caseID']}";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }

?>
