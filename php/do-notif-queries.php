<?php
  $query='SELECT COUNT(INCIDENT_REPORT_ID) AS "INCIDENT REPORTS" FROM INCIDENT_REPORTS WHERE IF_NEW=1';
  $result=mysqli_query($dbc,$query);
  if(!$result){
    echo mysqli_error($dbc);
  }
  else{
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  }
?>
