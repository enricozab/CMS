<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(IDO.CASE_ID) AS "CASES" 
            FROM IDO_CASES IDO
            LEFT JOIN CASES C ON IDO.CASE_ID = C.CASE_ID
            WHERE IDO.IF_NEW = 1 AND C.IF_NEW < 2 AND IDO.HANDLE = 1 AND IDO.USER_ID='.$_SESSION['user_id'];
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
