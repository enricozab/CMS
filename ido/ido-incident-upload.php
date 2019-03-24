<?php
  session_start();
  require_once('../mysql_connect.php');

  $updateQry = 'UPDATE INCIDENT_REPORTS
                   SET IF_UPLOADED = 1
                 WHERE INCIDENT_REPORT_ID = '.$_POST['irn'];

  $update = mysqli_query($dbc,$updateQry);
  if(!$update){
    echo mysqli_error($dbc);
  }
?>
