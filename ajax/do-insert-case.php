<?php
  session_start();
  require_once('../php/mysql_connect.php');

  $query="INSERT INTO CASES (INCIDENT_REPORT_ID,REPORTED_STUDENT_ID,OFFENSE_ID,OTHER_OFFENSE,CHEATING_TYPE,
            COMPLAINANT_ID,DETAILS,COMMENTS,APPREHENDED_BY_ID)
            VALUES ('{$_POST['incidentreportID']}','{$_POST['studentID']}','{$_POST['offenseID']}','{$_POST['otherOffense']}',
                  '{$_POST['cheatingType']}','{$_POST['complainantID']}','{$_POST['details']}','{$_POST['comments']}',
                  '{$_SESSION['user_id']}')";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }

  if($_POST['incidentreportID']>0){
    $query="UPDATE INCIDENT_REPORTS SET STATUS='For review by Head of DO' WHERE INCIDENT_REPORT_ID = '{$_POST['incidentreportID']}'";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo 'mysqli_error($dbc)';
    }
  }
?>
