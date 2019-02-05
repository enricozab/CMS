<?php
  session_start();
  require_once('../mysql_connect.php');

  $cheatType = 'NULL';
  if($_POST['cheatingType'] != null){
    $cheatType = $_POST['cheatingType'];
  }

  $incidentReport = 'NULL';
  if($_POST['incidentreportID'] != null){
    $incidentReport = $_POST['incidentreportID'];
  }

  //Insert in cases
  $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,LOCATION,DETAILS,HANDLED_BY_ID)
            VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}')";

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }

  //
?>
