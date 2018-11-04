<?php
  session_start();
  require_once('../php/mysql_connect.php');

  $query="INSERT INTO INCIDENT_REPORTS (REPORTED_STUDENT_ID,DETAILS,COMPLAINANT_ID)
            VALUES ('{$_POST['studentID']}','{$_POST['details']}','{$_SESSION['user_id']}')";
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo 'mysqli_error($dbc)';
  }
?>
