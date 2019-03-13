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

  $typeq="SELECT * FROM REF_OFFENSES WHERE offense_id = {$_POST['offenseID']}";
  $typeres=mysqli_query($dbc,$typeq);
  if(!$typeres){
    echo mysqli_error($dbc);
  }
  else {
    $typerow=mysqli_fetch_array($typeres,MYSQLI_ASSOC);
  }

  if($typerow['type'] == "Major") {
    $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,DATE_INCIDENT,LOCATION,DETAILS,HANDLED_BY_ID)
              VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['dateIncident']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}')";
  }
  else {
    $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,CHEATING_TYPE_ID,COMPLAINANT_ID,DATE_INCIDENT,LOCATION,DETAILS,HANDLED_BY_ID,REMARKS_ID)
              VALUES ($incidentReport,'{$_POST['studentID']}','{$_POST['offenseID']}',$cheatType,'{$_POST['complainantID']}','{$_POST['dateIncident']}','{$_POST['location']}','{$_POST['details']}','{$_POST['assignIDO']}',3)";
  }

  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }

  //
?>
