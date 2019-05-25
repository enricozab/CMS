<?php
  session_start();
  require_once('../mysql_connect.php');

  $irquery='SELECT COUNT(INCIDENT_REPORT_ID) AS "INCIDENT REPORTS" FROM INCIDENT_REPORTS WHERE IF_NEW=1';
  $irresult=mysqli_query($dbc,$irquery);
  if(!$irresult){
    echo mysqli_error($dbc);
  }
  else{
    $irrow=mysqli_fetch_array($irresult,MYSQLI_ASSOC);
    echo $irrow['INCIDENT REPORTS'];
  }
?>
