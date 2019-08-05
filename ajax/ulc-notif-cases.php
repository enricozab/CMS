<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(ULC.CASE_ID) AS "CASES" 
            FROM ULC_CASES ULC
            LEFT JOIN CASES C ON ULC.CASE_ID = C.CASE_ID
            WHERE ULC.IF_NEW=1 AND C.IF_NEW < 2';
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
