<?php
  $cquery='SELECT COUNT(CASE_ID) AS "CASES" FROM CASES WHERE IF_NEW=1';
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
  }

  $irquery='SELECT COUNT(INCIDENT_REPORT_ID) AS "INCIDENT REPORTS" FROM INCIDENT_REPORTS WHERE IF_NEW=1';
  $irresult=mysqli_query($dbc,$irquery);
  if(!$irresult){
    echo mysqli_error($dbc);
  }
  else{
    $irrow=mysqli_fetch_array($irresult,MYSQLI_ASSOC);
  }
?>
