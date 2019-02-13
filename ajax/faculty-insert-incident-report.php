<?php
  session_start();
  require_once('../mysql_connect.php');

  $date = "'".$_POST['date']." ".$_POST['time'].":00"."'";

  foreach ($_POST['studentID'] as $id) {
    $query="INSERT INTO INCIDENT_REPORTS (REPORTED_STUDENT_ID,LOCATION,DETAILS,DATE_INCIDENT,COMPLAINANT_ID)
              VALUES ($id,'{$_POST['location']}','{$_POST['details']}',$date,'{$_SESSION['user_id']}')";
    $result=mysqli_query($dbc,$query);
    if(!$result){
      echo mysqli_error($dbc);
    }
  }
?>
