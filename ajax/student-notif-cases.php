<?php
  session_start();
  require_once('../mysql_connect.php');

  $cquery='SELECT COUNT(STUDENT.CASE_ID) AS "CASES" 
            FROM STUDENT_CASES STUDENT
            LEFT JOIN CASES C ON STUDENT.CASE_ID = C.CASE_ID
            WHERE STUDENT.IF_NEW=1 AND C.IF_NEW < 2 AND STUDENT.USER_ID='.$_SESSION['user_id'];
  $cresult=mysqli_query($dbc,$cquery);
  if(!$cresult){
    echo mysqli_error($dbc);
  }
  else{
    $crow=mysqli_fetch_array($cresult,MYSQLI_ASSOC);
    echo $crow['CASES'];
  }
?>
