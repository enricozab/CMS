<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(FAC.CASE_ID) AS "CASES" 
            FROM FACULTY_CASES FAC
            LEFT JOIN CASES C ON FAC.CASE_ID = C.CASE_ID
            WHERE FAC.IF_NEW=1 AND C.IF_NEW < 2 AND FAC.USER_ID = '.$_SESSION['user_id'];
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
