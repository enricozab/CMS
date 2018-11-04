<?php
  session_start();
  require_once('../php/mysql_connect.php');

  $query4="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,OTHER_OFFENSE,CHEATING_TYPE,
            COMPLAINANT_ID,DETAILS,COMMENTS,APPREHENDED_BY_ID)
            VALUES ('{$_POST['incidentreportID']}','{$_POST['studentID']}','{$_SESSION['offenseID']}','{$_POST['otherOffense']}',
                  '{$_POST['cheatingType']}','{$_POST['complainantID']}','{$_POST['details']}','{$_POST['comments']}',
                  '{$_POST['apprehendedbyID']}')";
  $result4=mysqli_query($dbc,$query4);
  if(!$result4){
    echo 'mysqli_error($dbc)';
  }
?>
