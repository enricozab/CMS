<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(AULC.CASE_ID) AS "CASES" 
            FROM AULC_CASES AULC
            LEFT JOIN CASES C ON AULC.CASE_ID = C.CASE_ID
            WHERE AULC.IF_NEW=1 AND C.IF_NEW < 2';
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
