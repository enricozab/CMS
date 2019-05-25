<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(CASE_ID) AS "CASES" FROM CDO_CASES WHERE IF_NEW=1';
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
